<template>
    <div class="container h-100 padding absolute center middle">
        <div class="row">
            <div class="col-12 text-center">
                <div class="header d-flex justify-content-left align-items-center">
                    <!--<h1 class="text-left"><strong>BIERPOKAL</strong> Nohn 2023</h1>-->
                    <img src="/images/wooden_sign.png" class="wooden-sign" alt="Biermeter Pokal Nohn 2023">
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
    <div class="beer-bottle"></div>
    <div class="beer-trophy"></div>
</template>

<script>

import {Bar} from 'vue-chartjs'
import {Swiper, SwiperSlide} from 'swiper/vue';
import {Autoplay, Pagination, Navigation} from 'swiper';
import {Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale} from 'chart.js'
import ChartDataLabels from 'chartjs-plugin-datalabels';

// Import Swiper styles
import 'swiper/css';

import 'swiper/css/pagination';
import 'swiper/css/navigation';

//import './style.css';

const image = new Image();
image.src = "/images/beer_final.jpg";



const beerImage = {
    id:"beerImage",
    beforeDraw(chart, args, options) {
        const {ctx,chartArea:{top,bottom,left,right,width,height},
            scales:{x,y}} = chart;

        ctx.save();

        let data = chart.data.datasets[0].data;
        let total = data.length;
        let xFactor = x.maxWidth / x.max;
        let yFactor = y.maxHeight/total -y.paddingTop;

        for (let i = 0;i<total;i++) {
            ctx.drawImage(image, x.getPixelForValue(0), y.getPixelForValue(i)-(yFactor/2), (xFactor*(data[i])), yFactor)
        }
        // ctx.drawImage(image,x.getPixelForValue(0),y.getPixelForValue(2),600,imageHeight)
        // ctx.drawImage(image,x.getPixelForValue(0),y.getPixelForValue(1),800,imageHeight)
        // ctx.drawImage(image,x.getPixelForValue(0),y.getPixelForValue(0),1200,imageHeight)
    }
};

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, ChartDataLabels,beerImage)
ChartJS.defaults.font.size = 22;
ChartJS.defaults.font.weight = "bold";
ChartJS.defaults.color = "white";
ChartJS.defaults.borderColor = "#484848";


export default {
    name: "Ranking",
    components: {
        Bar,
        Swiper,
        SwiperSlide,
    },
    data() {
        return {
            modules: [Autoplay, Pagination, Navigation],
            data: null,
            clubs: [],
            loaded: false,
            processing: false,
            chartData: {
                labels: ['JGV Bierschlucker 3000', 'JGV Achim', 'JGV Kater'],
                datasets: [
                    {
                        label: "Meter-Bier",
                        // backgroundColor: bar => {
                        //     console.log(bar);
                        //     const image = new Image();
                        //     image.src = "/images/beer3.jpeg";
                        //     const ctx = document.getElementById('ranking').getContext('2d');
                        //     console.log("beer loaded")
                        //     return  ctx.createPattern(image,'repeat-x');
                        // },
                        backgroundColor: "#00000000",
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
                plugins: {
                    legend: {
                        display: false,
                        labels: {
                            font: {
                                size: 18,
                                weight: "bold",
                            }
                        }
                    },
                    datalabels: {
                        anchor: "end",
                        align: "center",
                        padding: {
                            left: 0,
                            right: 20
                        },
                        margin:{
                            left:-40
                        }

                    },
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
            // const result = getData();
            // this.chartData.labels = result.labels;
            // this.chartData.datasets[0].data = result.datasets;
        },

    },
    mounted() {
        this.getClubsRanking();
    },
    computed: {

        beerPattern(){
            const image = new Image();
            image.src = "/images/beer_vertical.jpg";
            const ctx = document.getElementById('ranking').getContext('2d');
            console.log("beer loaded")
            return ctx.createPattern(image,'repeat-x');
        },

    }
}
</script>

<style scoped>

#ranking{
    font-size: 20px;
}

.container{
    position: relative;
    max-width: 1600px;
    background: transparent;
    padding: 2em;
    border-radius: 0.5em;
    box-shadow: 0px 15px 15px -15px rgb(0 0 0 / 30%), 0px 20px 15px -10px rgb(0 0 0 / 30%);
    z-index: 1;
}
.container:before {
    content: "";
    position: absolute;
    top: -70px;
    left: -70px;
    height: calc(100% + 140px);
    width: calc(100% + 140px);
    background-color: transparent;
    background-image: url(/images/nohn_frame.png);
    background-size: 100%;
    background-position: center center;
    background-repeat: no-repeat;
    z-index: -1;
}
.header{
    margin-bottom: 1em;
    padding-bottom: 1em;
    align-content: center;
    align-items: center;
    text-align: center;
}

.header .wooden-sign {
    position: absolute;
    left: 50%;
    top: 0;
    width: 100%;
    max-width: 550px;
    -webkit-transform: translate(-50%,-50%);
       -moz-transform: translate(-50%,-50%);
            transform: translate(-50%, -125px);
    z-index: 2;
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

.beer-bottle, .beer-trophy {
    position: fixed;
    display: block;
    background-repeat: no-repeat;
    background-size: 100%; 
}

.beer-bottle {
    height: 660px;
    width: 280px;
    left: calc(50% - (1600px/ 2));
    bottom: 50px;
    background-image: url(/images/nohn_beer.png);
    z-index: -1;
    -webkit-transform: translateX(-75%);
       -moz-transform: translateX(-75%);
            transform: translateX(-75%);
}

.beer-bottle + .beer-bottle {
    left: calc(50% - 965px);
    bottom: 120px;
    z-index: -2;
}

.beer-trophy {
    height: 880px;
    width: 670px;
    left: 50%;
    bottom: 15px;
    background-image: url(/images/nohn_trophy.png);
    z-index: -1;
    -webkit-transform: translate(95%);
       -moz-transform: translate(95%);
            transform: translate(95%);
}

</style>