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



                <swiper
                    v-if="sponsors"
                    :spaceBetween="30"
                    :centeredSlides="true"
                    :autoplay="{
                      delay: 10000,
                      disableOnInteraction: false,
                    }"
                    :pagination="{
                      clickable: false,
                    }"
                    :navigation="false"
                    :modules="modules"
                    class="h-100"
                >
                    <swiper-slide class="d-flex justify-content-center align-items-center w-100 h-100 position-relative" v-for="sponsor in sponsors">

                        <div class=" d-flex justify-content-center align-items-center h-100 sponsor-image-wrapper">
                            <img :src="sponsor.image_url" :alt="sponsor.name" class="h-100 sponsor-image">
                        </div>

                    </swiper-slide>

                </swiper>
            </div>

        </div>
    </div>
    <div class="beer-bottle"></div>
    <div class="beer-bottle"></div>
    <div class="beer-trophy"></div>
</template>

<script>

import {Swiper, SwiperSlide} from 'swiper/vue';
import {Autoplay, Pagination, Navigation} from 'swiper';


// Import Swiper styles
import 'swiper/css';

import 'swiper/css/pagination';
import 'swiper/css/navigation';

//import './style.css';


export default {
    name: "Ranking",
    components: {
        Swiper,
        SwiperSlide,
    },
    data() {
        return {
            modules: [Autoplay, Pagination, Navigation],
            data: null,
            clubs: [],
            sponsors: [{
                name: "",
                image_url: "",
            }],
            ticker: undefined,
            loaded: false,
            processing: false,
            ranking: [],
        }

    },
    methods: {
        getSponsors() {
            axios.get('/api/sponsors-only').then(response => {
                this.sponsors = response.data;
            }).catch(({response: {data}}) => {

            }).finally(() => {
                this.processing = false;
            })
        }

    },
    mounted() {
        this.getSponsors();
    },
    beforeMount() {

    },
    beforeUnmount() {
    },
    computed: {}
}
</script>

<style scoped>
.chalck-font {
    color: white;
    font-family: "chalck-v2";
}

.count-list {

    font-size: 25px;
    margin-top: -65px;
}

.other-list {
    margin: -5px 40px 25px 20px;
}

.ranking-table {
    margin-left: 20px;
    color: white;
}

.other {
    font-size: 18px;
}

ol {
    height: 40px;
}

ol li {
    color: white;
    display: inline-block;
    height: 33px;
    border: 2px solid #ffffff;
    margin-right: 10px;
}

ol li:nth-child(5n) {
    transform: rotate(600deg);
    height: 66px;
    position: relative;
    left: -35px;
    top: 16px;
    margin-right: 0.4em;
}

.table-label {
    padding-left: 10px;
    padding-right: 40px;
}

.top-headline {
    margin-top: 22px;
    margin-left: 20px;
}

.count {
    margin-top: -30px;
}

.club-label {
}

.count-label {
    margin-top: -10px;
}


#ranking {
    font-size: 20px;
}

.container {
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
    top: -99px;
    left: -70px;
    height: calc(100% + 170px);
    width: calc(100% + 95px);
    background-color: transparent;
    background-image: url(/images/nohn_frame.png);
    background-size: 100%;
    background-position: center center;
    background-repeat: no-repeat;
    z-index: -1;
}

.header {
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
    max-width: 900px;
    -webkit-transform: translate(-50%, -50%);
    -moz-transform: translate(-50%, -50%);
    transform: translate(-50%, -110px); /*modify last param to control height */
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
    left: calc(50% - (1600px / 2));
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

.sponsor-image {
    max-width: 85%; /* or any custom size */
    max-height: 85%;
    object-fit: contain;
    margin: -20px;
}

.sponsor-image-wrapper {

}


</style>
