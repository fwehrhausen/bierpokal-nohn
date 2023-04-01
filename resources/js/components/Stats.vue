<template>

    <div class="row">

        <div class="col-4">
            <div class="digital-clock">
                {{ dateTime.hours }}:{{ dateTime.minutes }}<small style="font-size: 38px">:{{
                    dateTime.seconds
                }}</small>
                <h3 class="effect-text"><i class="fa-solid fa-triangle-exclamation"></i> Experimentell</h3>
            </div>

            <div class="mt-5" style="margin-left: 20px;">
                <h3>Offene Bestellungen</h3>
                <table class="table table-responsive">
                    <tr v-for="open_order in open_orders">
                        <td>
                            <h4>{{ open_order.club.name }}</h4>
                            <p>bestellt um: {{ new Date(open_order.created_at).toLocaleTimeString() }}</p>
                        </td>
                    </tr>
                </table>
            </div>


        </div>
        <div class="col-7">
            <h1 class="headline effect-text">Biermeter-Prognose</h1>


            <div class="prognoses mt-5">

                <table class="table">
                    <tr style="background-color: gray; color: white">
                        <th><h4>Verein</h4></th>
                        <th><h4>nächster Meter</h4></th>
                    </tr>
                <tr v-for="next in next_meters">

                    <td><h4>{{ next.club }}</h4></td>
                    <td>
                        <h4>{{ next.next_string }}</h4>
                    </td>
                </tr>
                </table>
            </div>


        </div>


    </div>

</template>

<script>

const date = new Date();

export default {
    name: "Stats",
    data() {
        return {
            dateTime: {
                hours: date.getHours(),
                minutes: date.getMinutes(),
                seconds: date.getSeconds(),
            },
            timer: undefined,
            next_meters: [
                {
                    timestamp: "",
                }
            ],
            open_orders: [],
            ticker: undefined,
            beer_ticker: undefined,
        }
    },
    methods: {
        setDateTime() {
            const date = new Date();
            let calcSeconds = date.getSeconds()
            if (calcSeconds < 10) {
                calcSeconds = "0" + calcSeconds;
            }
            let calcH = date.getHours()
            if (calcH < 10) {
                calcH = "0" + calcH;
            }
            let calcM = date.getMinutes()
            if (calcM < 10) {
                calcM = "0" + calcM;
            }
            this.dateTime = {
                hours: calcH,
                minutes: calcM,
                seconds: calcSeconds,
            };
        },
        updatePrognostic() {
            axios.get('/api/meter-beer-prognosis').then(response => {
                this.next_meters = response.data.prog;
            }).catch(({response: {data}}) => {
                //alert(data.message);

            }).finally(() => {
                this.processing = false;
            })
        },
        getOpenMeters(){
            axios.get('/api/open-beer-meter').then(response => {
                this.open_orders = response.data;
            }).catch(({response: {data}}) => {
                //alert(data.message);

            }).finally(() => {
                this.processing = false;
            })
        }

    },
    beforeMount() {
        this.updatePrognostic();
        this.timer = setInterval(this.setDateTime, 1000);
        this.ticker = setInterval(this.updatePrognostic, 10000);
        this.beer_ticker = setInterval(this.getOpenMeters, 10000);
    },
    beforeUnmount() {
        clearInterval(this.timer);
        clearInterval(this.ticker);
        clearInterval(this.beer_ticker);
    },
}
</script>

<style scoped>

@import "https://fonts.googleapis.com/css?family=Share+Tech+Mono";

.digital-clock {
    font-family: 'Share Tech Mono', monospace;
    font-size: 80px;
    letter-spacing: 0.1em;
    color: #ffffff;
    text-align: center;
    color: #daf6ff;
    text-shadow: 0 0 20px rgba(10, 175, 230, 1), 0 0 20px rgba(10, 175, 230, 0);
}

.headline {

    font-size: 70px;

}

.effect-text {
    font-family: 'Share Tech Mono', monospace;
    letter-spacing: 0.1em;
    color: #ffffff;
    color: #daf6ff;
    text-shadow: 0 0 20px rgba(10, 175, 230, 1), 0 0 20px rgba(10, 175, 230, 0);
}

.prognoses{
    font-weight: bold;
}

.progress {
    height: 35px;
    font-size: 20px;
    font-weight: bold;
    background-color: white;
}

</style>
