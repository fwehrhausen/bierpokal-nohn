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

                <div v-for="next in next_meters">

                    <div class="float-end">
                        nächster in: {{ next.next_string }}
                    </div>
                    <div class="progress mb-3">
                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning"
                             role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"
                             style="width: 100%">{{ next.club }}
                        </div>
                    </div>

                </div>
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
                this.open_orders = response.data.open_orders;
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
    },
    beforeUnmount() {
        clearInterval(this.timer);
        clearInterval(this.ticker);
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

.progress {
    height: 35px;
    font-size: 20px;
    font-weight: bold;
    background-color: white;
}

</style>
