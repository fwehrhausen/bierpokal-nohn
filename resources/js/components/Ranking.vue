<template>
    <div class="container h-100 padding absolute center middle">
        <div class="row">
            <div class="col-12 text-center">
                <div class="header d-flex justify-content-left align-items-center">
                    <h1 class="text-left"><strong>BIERPOKAL</strong> Nohn 2023</h1>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <Bar
                    id="ranking"
                    :options="chartOptions"
                    :data="chartData"
                    v-if="loaded"
                />
            </div>

        </div>
    </div>
    <div class="beer-bottle"></div>
</template>

<script>

import {Bar} from 'vue-chartjs'
import {Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale} from 'chart.js'
import ChartDataLabels from 'chartjs-plugin-datalabels';

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale,ChartDataLabels)
ChartJS.defaults.font.size = 16;
ChartJS.defaults.font.weight = "bold";
ChartJS.defaults.color = "black";
ChartJS.defaults.borderColor = "#00000000";

export default {
    name: "Ranking",
    components: {Bar},
    data() {
        return {
            data: null,
            clubs: [],
            loaded: false,
            processing: false,
            chartData: {
                labels: ['JGV Bierschlucker 3000', 'JGV Achim', 'JGV Kater'],
                datasets: [
                    {
                        label: "Meter-Bier",
                        backgroundColor: "#fed843",
                        data: [40, 20, 12]
                    }
                ],
            },
            chartOptions: {
                responsive: true,
                indexAxis: "y",
                legend: {
                    display: false,
                },
                plugins:{
                    legend:{
                        display:false,
                        labels:{
                            font:{
                                size: 18,
                                weight: "bold",
                            }
                        }
                    },
                    datalabels:{
                        anchor: "end",
                        align:"end",
                    }
                },
                //maintainAspectRatio: false,
            }
        }

    },
    methods: {
        getClubsRanking() {
            axios.get('/api/ranking').then(response => {
                this.chartData.labels = response.data.labels;
                this.chartData.datasets[0].data = response.data.datasets;
                this.loaded = true;
            }).catch(({response: {data}}) => {
                alert(data.message);

            }).finally(() => {
                this.processing = false;
            })
        },

    },
    mounted() {
        this.getClubsRanking();
    },
    computed: {
        //
    }
}
</script>

<style scoped>

#ranking{
    font-size: 20px;
}

.container{
    max-width: 1600px;
    background: #FFF;
    padding: 2em;
    border-radius: 0.5em;
    border: 5px solid #DDD;
    box-shadow: 0px 15px 15px -15px rgb(0 0 0 / 30%), 0px 20px 15px -10px rgb(0 0 0 / 30%);
}
.header{
    border-bottom: 2px dashed #DDD;
    margin-bottom: 1em;
    padding-bottom: 1em;
    align-content: center;
    align-items: center;
    text-align: center;
}

.header > .brand {
    display: block;
    position: relative;
    width: 150px;
    margin-right: 2em;
    padding: 22.5px;
    background-color: #FFF;
    border-radius: 50%;
    box-shadow: inset 0px 0px 0px 10px rgb(0 0 0 / 5%), 0px 25px 20px -20px rgb(0 0 0 / 50%);
}
.header > .brand > img {
    width: 100%
}

.beer-bottle {
    position: fixed;
    display: block;
    height: 660px;
    width: 280px;
    left: calc(50% - (1600px/ 2));
    bottom: 50px;
    background-image: url(images/nohn_beer.png);
    background-repeat: no-repeat;
    background-size: 100%;
    z-index: -1;
    -webkit-transform: translateX(-75%);
       -moz-transform: translateX(-75%);
            transform: translateX(-75%);
}

</style>
