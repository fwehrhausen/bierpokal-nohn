<template>
    <div class="container h-100 padding absolute center middle">
        <div class="row">
            <div class="col-12 text-center">
                <div class="header">
                    <h1><i class="fa-solid fa-trophy"></i> Biermeter-Pokal Nohn 2023 </h1>
                </div>
            </div>
        </div>
        <swiper
            :spaceBetween="30"
            :centeredSlides="true"
            :autoplay="{
              delay: 9000,
              disableOnInteraction: false,
            }"

            :modules="modules"
            class="mySwiper"
        >
            <swiper-slide>
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
            </swiper-slide>


        </swiper>



    </div>
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
image.src = "/images/beer_vertical.jpg";

// function getData(){
//     var result = axios.get('/api/ranking').then(response => {
//         return result = response.data;
//     }).catch(({response: {data}}) => {
//         //alert(data.message);
//
//     });
//
//     return result;
// }


const beerImage = {
    id:"beerImage",
    beforeDraw(chart, args, options) {
        const {ctx,chartArea:{top,bottom,left,right,width,height},
            scales:{x,y}} = chart;

        ctx.save();

        // console.log("y3: " +y.getPixelForValue(3));
        // console.log("x3: " +x.getPixelForValue(3));
        // console.log("y2: " +y.getPixelForValue(2));
        // console.log("x2: " +x.getPixelForValue(2));
        // console.log("y1: " +y.getPixelForValue(1));
        // console.log("x1: " +x.getPixelForValue(1));
        // console.log("y0: " +y.getPixelForValue(0));
        // console.log("x0: " +x.getPixelForValue(0));
        // console.log(y);

        let imageHeight = 30;

        let data = chart.data.datasets[0].data;
        let total = data.length;
        let xFactor = x.maxWidth / x.max;
        let yFactor = y.maxHeight/total -y.paddingTop;

        console.log(y);
        for (let i = 0;i<total;i++) {
            console.log();
            ctx.drawImage(image, x.getPixelForValue(0), y.getPixelForValue(i)-(yFactor/2), (xFactor*(data[i])), yFactor)
        }
        // ctx.drawImage(image,x.getPixelForValue(0),y.getPixelForValue(2),600,imageHeight)
        // ctx.drawImage(image,x.getPixelForValue(0),y.getPixelForValue(1),800,imageHeight)
        // ctx.drawImage(image,x.getPixelForValue(0),y.getPixelForValue(0),1200,imageHeight)
    }
};

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, ChartDataLabels,beerImage)
ChartJS.defaults.font.size = 24;
ChartJS.defaults.font.weight = "bold";
ChartJS.defaults.color = "white";
ChartJS.defaults.borderColor = "#00000000";


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
                        align: "end",
                        padding: {
                            left: 0,
                            right: 20
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

#ranking {
    font-size: 20px;
}

.container {
    max-width: 1600px;

}

.header {
    align-content: center;
    align-items: center;
    text-align: center;
}

body {
    background-color: #61596e !important;
    color: white !important;
}

</style>
