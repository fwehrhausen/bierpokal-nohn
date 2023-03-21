<template>
    <div class="container h-100 padding absolute center middle">
        <div class="row">
            <div class="col-12 text-center">
                <div class="header">
                <h1><i class="fa-solid fa-trophy"></i> Biermeter-Pokal Nohn 2023 </h1>
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
</template>

<script>

import {Bar} from 'vue-chartjs'
import {Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale} from 'chart.js'
import ChartDataLabels from 'chartjs-plugin-datalabels';

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale,ChartDataLabels)
ChartJS.defaults.font.size = 24;
ChartJS.defaults.font.weight = "bold";
ChartJS.defaults.color = "white";
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

}
.header{
    align-content: center;
    align-items: center;
    text-align: center;
}

body{
    background-color: #61596e !important;
    color: white !important;
}

</style>
