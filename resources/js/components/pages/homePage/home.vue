<template>
    <div>
        <div class="w-full">
            <swiper :pagination="true" :loop="true" :autoplay="{
                delay: 5000,
                disableOnInteraction: false,
            }" :mousewheel="false" :modules="modules" class="mySwiper">
                <swiper-slide>
                    <img v-if="this.visibleSlides" src="/img/slides/Slide1Mobile.png" alt="#">
                    <img v-if="!this.visibleSlides" src="/img/slides/Slide1.PNG" class="object-cover w-full" alt="#">
                </swiper-slide>
                <swiper-slide>
                    <img v-if="this.visibleSlides" src="/img/slides/Slide2Mobile.png" alt="#">
                    <img v-if="!this.visibleSlides" src="/img/slides/Slide2.PNG" class="object-cover w-full" alt="#">
                </swiper-slide>
                <swiper-slide>
                    <img v-if="this.visibleSlides" src="/img/slides/Slide3Mobile.png" alt="#">
                    <img v-if="!this.visibleSlides" src="/img/slides/Slide3.PNG" class="object-cover w-full" alt="#">
                </swiper-slide>
                <swiper-slide>
                    <img v-if="this.visibleSlides" src="/img/slides/Slide4Mobile.png" alt="#">
                    <img v-if="!this.visibleSlides" src="/img/slides/Slide4.PNG" class="object-cover w-full" alt="#">
                </swiper-slide>
                <swiper-slide>
                    <img v-if="this.visibleSlides" src="/img/slides/Slide5Mobile.png" alt="#">
                    <img v-if="!this.visibleSlides" src="/img/slides/Slide5.PNG" class="object-cover w-full" alt="#">
                </swiper-slide>
            </swiper>
        </div>
        <div class="w-full lg:flex lg:justify-center lg:space-x-20 lg:pt-14 lg:px-0 px-5 lg:pb-14 pb-5">

            <!-- <div v-if="this.news.length != 0" class=" lg:w-3/12 w-full  bg-white drop-shadow-md border-t lg:mt-0 mt-3 "> -->
            <div class=" lg:w-3/12 w-full  bg-white drop-shadow-md border-t lg:mt-0 mt-3 ">
                <p class="text-sky-800 text-2xl text-center blur-none ">News</p>
                <div class="h-4/5 border-t-2 border-sky-800 p-2">
                    <a-skeleton :loading="articleLoading">
                        <div v-for="(news, key, index) in this.news.slice(0, 3)" class="flex block border-b pb-1 mb-3">
                            <img @click="gotoArticle(news)"
                                class="cursor-pointer bg-sky-200 object-cover object-center blur-none w-20 h-20 "
                                :src="`/img/uploads/${news.image}`">
                            <div class="block w-fit px-1 overflow-hidden">
                                <p @click="gotoArticle(news)"
                                    class="cursor-pointer text-sm blur-none font-semibold text-sky-600  truncate">{{
                                        news.title
                                    }}</p>
                                <p class="text-xs blur-none">News | {{ news.date }}</p>
                                <p class="text-xs blur-none text-justify line-clamp-3" v-html="news.article"> </p>
                            </div>
                        </div>
                    </a-skeleton>

                </div>
                <div @click="moreArticle('News')"
                    class="bg-white cursor-pointer border-t grid h-12 text-center place-content-center text-lg blur-none ">
                    View More
                </div>
            </div>

            <!-- <div v-if="this.announcements.length != 0" class=" lg:w-3/12 w-full  bg-white drop-shadow-md border-t lg:mt-0 mt-10"> -->
            <div class=" lg:w-3/12 w-full  bg-white drop-shadow-md border-t lg:mt-0 mt-10">
                <p class="text-sky-800 text-2xl text-center blur-none">Announcements</p>
                <div class="h-4/5 border-t-2 border-sky-800 p-2">
                    <a-skeleton :loading="articleLoading">
                        <div v-for="(announcement, key, index) in this.announcements.slice(0, 3)"
                            class="flex block border-b pb-1 mb-3">
                            <img @click="gotoArticle(announcement)"
                                class="cursor-pointer bg-sky-200 object-cover object-center blur-none w-20 h-20 "
                                :src="`/img/uploads/${announcement.image}`">
                            <div class="block w-fit px-1 overflow-hidden">
                                <p @click="gotoArticle(announcement)"
                                    class="cursor-pointer text-sm blur-none font-semibold text-sky-600  truncate">{{
                                        announcement.title }}</p>
                                <p class="text-xs blur-none">Announcements | {{ announcement.date }}</p>
                                <p class="text-xs blur-none text-justify line-clamp-3" v-html="announcement.article">
                                </p>
                            </div>
                        </div>
                    </a-skeleton>

                </div>
                <div @click="moreArticle('Announcements')"
                    class="bg-white cursor-pointer border-t grid h-12 text-center place-content-center text-lg blur-none ">
                    View More
                </div>
            </div>

            <!-- <div v-if="this.events.length != 0" class=" lg:w-3/12 w-full  bg-white drop-shadow-md border-t lg:mt-0 mt-10"> -->
            <div class=" lg:w-3/12 w-full  bg-white drop-shadow-md border-t lg:mt-0 mt-10">
                <p class="text-sky-800 text-2xl text-center blur-none">Events</p>
                <div class="h-4/5 border-t-2 border-sky-800 p-2">
                    <a-skeleton :loading="articleLoading">
                        <div v-for="(event, key, index) in this.events.slice(0, 3)"
                            class="flex block border-b pb-1 mb-3">
                            <img @click="gotoArticle(event)"
                                class="cursor-pointer bg-sky-200 object-cover object-center blur-none w-20 h-20 "
                                :src="`/img/uploads/${event.image}`">
                            <div class="block w-fit px-1 overflow-hidden">
                                <p @click="gotoArticle(event)"
                                    class="cursor-pointer text-sm blur-none font-semibold text-sky-600  truncate">{{
                                        event.title
                                    }}</p>
                                <p class="text-xs blur-none">Events | {{ event.date }}</p>
                                <p class="text-xs blur-none text-justify line-clamp-3" v-html="event.article"></p>
                            </div>
                        </div>
                    </a-skeleton>

                </div>
                <div @click="moreArticle('Events')"
                    class="bg-white cursor-pointer border-t grid h-12 text-center place-content-center text-lg blur-none ">
                    View More
                </div>
            </div>

        </div>
        <!-- Project -->
        <div class="grid gap-2 place-content-center">
            <div class="text-center">
                <h1 class="font-medium leading-tight lg:text-3xl text-2xl text-sky-600">PROJECT OBJECTIVES</h1>
                <hr class="">
            </div>
        </div>

        <div class="w-full flex justify-center mt-4">
            <div class="lg:w-3/4 w-full place-content-center grid lg:grid-cols-2 lg:gap-4">
                <div class="w-full ">
                    <img @click="this.$router.push('/projects/project1')" alt="ecommerce"
                        class="lg:p-4 p-2 cursor-pointer transition drop-shadow-lg ease-in-out delay-75  hover:-translate-y-1 hover:scale-103 duration-300"
                        src="/img/Project1/P1.png" />
                    <div class="mt-4 flex justify-center">
                        <h3 class="title-font mb-1 text-xs tracking-widest text-gray-500">PROJECT 1</h3>
                    </div>
                </div>
                <div class="w-full">
                    <img @click="this.$router.push('/projects/project2')" alt="ecommerce"
                        class="lg:p-4 p-2 cursor-pointer transition drop-shadow-lg ease-in-out delay-75  hover:-translate-y-1 hover:scale-103 duration-300"
                        src="/img/Project2/P2.png" />
                    <div class="mt-4 flex justify-center">
                        <h3 class="title-font mb-1 text-xs tracking-widest text-gray-500">PROJECT 2</h3>
                    </div>
                </div>
                <div class="w-full">
                    <img @click="this.$router.push('/projects/project3')" alt="ecommerce"
                        class="lg:p-4 p-2 cursor-pointer transition drop-shadow-lg ease-in-out delay-75  hover:-translate-y-1 hover:scale-103 duration-300"
                        src="/img/Project3/P3.png" />
                    <div class="mt-4 flex justify-center">
                        <h3 class="title-font mb-1 text-xs tracking-widest text-gray-500">PROJECT 3</h3>
                    </div>
                </div>
                <div class="w-full">
                    <img @click="this.$router.push('/projects/project4')" alt="ecommerce"
                        class="lg:p-4 p-2 cursor-pointer transition drop-shadow-lg ease-in-out delay-75  hover:-translate-y-1 hover:scale-103 duration-300"
                        src="/img/Project4/P4.png" />
                    <div class="mt-4 flex justify-center">
                        <h3 class="title-font mb-1 text-xs tracking-widest text-gray-500">PROJECT 4</h3>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Project -->
        <!-- About Us -->
        <div class="lg:pt-14">
            <div class="flex justify-center w-full  lg:py-2 py-3">
                <div class="lg:w-10/12 w-full px-1 flex justify-center">
                    <div class="hidden lg:flex items-center w-2/12 justify-center">
                        <img class="w-3/4" src="/img/top.png" alt="">
                    </div>
                    <div class="lg:w-3/4 w-full">
                        <Collapse simple>
                            <Panel name="1" class="lg:text-2xl text-xl py-5 font-semibold text-sky-600 ">
                                WHO WE ARE
                                <template #content>
                                    <p class="text-base text-justify indent-8 px-5 font-normal">
                                        The Coastal Engineering Research Center or CoastER Center is the country’s first
                                        coastal engineering and management research and development center and
                                        the hub of innovations for coastal resiliency. This facility will spur the
                                        development of innovations that address coastal erosion, development
                                        construction
                                        materials for coastal protection, policies, and guidelines intended to protect
                                        resources from coastal flooding and improve the lives of people in coastal
                                        communities. It will also bolster the capability of Filipino engineers towards
                                        coastal engineering leading to the development of a master’s degree for coastal
                                        engineering.
                                        <a @click="clickOS()" class="underline">Organization Structure</a>
                                    </p>
                                </template>
                            </Panel>
                            <Panel name="2" class="lg:text-2xl text-xl py-5 font-semibold text-sky-600">
                                WHAT WE DO
                                <template #content>
                                    <p class="text-base text-justify indent-8 px-5 font-normal">
                                        The COASTER aims to spearhead the development of technologies and innovation to
                                        mitigate and manage coastal disasters and risks. The overall goal of the
                                        center is to take the lead in coastal science and engineering studies to better
                                        undertand the magniture of certain process and hazards and their impacts
                                        on the maritime environment including tidal deltas and low-lying lands.
                                    </p>
                                    <!-- <div class="w-full lg:flex justify-center lg:space-x-4 ">
                                        <iframe class="w-full py-5 lg:h-96 h-64 lg:py-1" src="https://www.youtube.com/embed/C7ZEzkKpxZs"
                                            title="YouTube video player" frameborder="0"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                            allowfullscreen></iframe>
                                        <iframe class="w-full lg:h-96 h-64" src="https://www.youtube.com/embed/fre6VqZIYxk"
                                            title="YouTube video player" frameborder="0"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                            allowfullscreen></iframe>
                                    </div> -->
                                </template>
                            </Panel>
                            <Panel name="3" class="lg:text-2xl text-xl py-5 font-semibold text-sky-600">
                                WHERE WE ARE
                                <template #content>
                                    <p class="text-base text-justify indent-8 px-5 font-normal">
                                        The Coastal Engineering Research Center or CoastER Center is located in #16
                                        Quiling
                                        Sur, City of Batac 2906 Ilocos Norte, within the Mariano Marcos State
                                        University, in
                                        front of College of Engineering (COE).
                                        <a @click="showModal" class="underline">Location</a>
                                        <!-- <a-modal ref="modalRef" v-model:visible="visible"
                                            :wrap-style="{ overflow: 'hidden' }" @ok="handleOk" :ok-text="false"
                                            :closable="false" width="1000px" cancel-text="Close">
                                            <div class="w-full h-96">
                                                <GMapMap :center="{ lat: 18.059881, lng: 120.548642 }" :zoom="16"
                                                    map-type-id="roadmap" ref="gmap" :options="{
                                                        zoomControl: false,
                                                        mapTypeControl: false,
                                                        scaleControl: false,
                                                        streetViewControl: false,
                                                        rotateControl: false,
                                                        fullscreenControl: false,
                                                    }" class="w-full h-full">
                                                    <GMapMarker :icon="bouyMarker"
                                                        :position="{ lat: 18.059249, lng: 120.544146 }" :clickable="true">
                                                    </GMapMarker>
                                                </GMapMap>
                                            </div>
                                            <template #title>
                                                <div ref="modalTitleRef" style="width: 100%; cursor: move">Coaster Location
                                                </div>
                                            </template>
    <template #modalRender="{ originVNode }">
                                                <div :style="transformStyle">
                                                    <component :is="originVNode" />
                                                </div>
                                            </template>
    </a-modal> -->
                                    <div>
                                        <img src="/img/location/building_location.jpg" />
                                    </div>
                                    </p>
                                </template>
                            </Panel>
                        </Collapse>
                    </div>
                </div>
            </div>
        </div>
        <!-- /About Us -->
        <!-- Coop Agencies -->
        <div class="grid gap-2 place-content-center mb-10">
            <div class="grid gap-2 place-content-center lg:pt-14 mt-2">
                <div class="text-center">
                    <h1 class="font-medium leading-tight lg:text-3xl text-2xl text-sky-600">COOPERATING AGENCIES</h1>
                    <hr class="">
                </div>
            </div>
            <div class="flex justify-center  gap lg:gap-4 gap-2 px-10">
                <div class="shrink-0">
                    <a href="https://www.dost.gov.ph/"><img src="img/logo/DOST.png"
                            class="object-fill lg:w-[4vw] lg:h-[4vw] w-[11vw] h-[11vw]" alt="#"></a>
                </div>
                <div class="shrink-0">
                    <a href="https://www.mmsu.edu.ph/"><img src="img/logo/MMSU.png"
                            class="object-fill lg:w-[4vw] lg:h-[4vw] w-[11vw] h-[11vw]" alt="#"></a>
                </div>
                <div class="shrink-0">
                    <a href="https://www.kyoto-u.ac.jp/en"><img src="img/logo/KYOTO.png"
                            class="object-fill lg:w-[4vw] lg:h-[4vw] w-[11vw] h-[11vw]" alt="#"></a>
                </div>
                <div class="shrink-0">
                    <a href="https://up.edu.ph/"><img src="img/logo/DILIMAN.png"
                            class="object-fill lg:w-[4vw] lg:h-[4vw] w-[11vw] h-[11vw]" alt="#"></a>
                </div>
                <div class="shrink-0">
                    <a href="https://www.dmmmsu.edu.ph/"><img src="img/logo/DMMMSU.png"
                            class="object-fill lg:w-[4vw] lg:h-[4vw] w-[11vw] h-[11vw]" alt="#"></a>
                </div>
                <div class="shrink-0">
                    <a href="https://www.mmsu.edu.ph/"><img src="img/logo/CIVIL.png"
                            class="object-fill lg:w-[4vw] lg:h-[4vw] w-[11vw] h-[11vw]" alt="#"></a>
                </div>
                <div class="shrink-0">
                    <a href="https://www.mmsu.edu.ph/"><img src="img/logo/DPWH.png"
                            class="object-fill lg:w-[4vw] lg:h-[4vw] w-[11vw] h-[11vw]" alt="#"></a>
                </div>
            </div>
        </div>
        <!-- /Coop Agencies -->
    </div>
</template>
<script>
// Import Swiper Vue.js components
import { Swiper, SwiperSlide } from "swiper/vue";

// Import Swiper styles
import "swiper/css";
import "swiper/css/pagination";
import "swiper/css/navigation";


// import required modules
import { Mousewheel, Autoplay, Pagination, Navigation } from "swiper";
// import Location from './homeComponents/location.vue'

import { defineComponent, ref, computed, watch, watchEffect } from 'vue';
export default defineComponent({
    components: {
        Swiper,
        SwiperSlide,
        Location,
    },
    setup() {
        const visibleSlides = ref(false);
        return {
            visibleSlides,
            modules: [Mousewheel, Autoplay, Pagination, Navigation],
        };
    },
    data() {
        return {
            articles: '',
            events: [],
            news: [],
            announcements: [],
            selectedProject: '',
            articleLoading: true,
        }
    },
    methods: {
        gotoArticle(article) {
            const id = article.id
            const title = article.title
            if (article.type_id == 1) {
                article = 'news'
            } else if (article.type_id == 2) {
                article = 'announcements'
            } else if (article.type_id == 3) {
                article = 'events'
            }
            // this.$router.push({path: article + '/' + title + '/' +id})
            this.$router.push({ name: 'article', params: { article, title, id } })
        },
        moreArticle(article) {
            this.$router.push({ name: 'moreArticle', params: { article } })
        },
        clickOS() {
            let id = 1
            this.$router.push({ name: 'about', params: { id } })
        },
        onResize() {
            if (680 > window.innerWidth) {
                this.visibleSlides = true;
            } else if (680 < window.innerWidth) {
                this.visibleSlides = false;
            }
        }
    },
    async created() {
        let existingObj = this;
        await axios.get('/api/getArticles')
            .then(function (response) {
                existingObj.articles = response.data
                for (let i = 0; i < existingObj.articles.length; i++) {
                    if (existingObj.articles[i].type_id == 1) {
                        existingObj.news.push(existingObj.articles[i]);
                    }
                    if (existingObj.articles[i].type_id == 2) {
                        existingObj.announcements.push(existingObj.articles[i]);
                    }
                    if (existingObj.articles[i].type_id == 3) {
                        existingObj.events.push(existingObj.articles[i]);
                    }
                }
                existingObj.articleLoading = false;
            })
            .catch(function (error) {
            });
    },
    mounted() {
        this.$nextTick(() => {
            window.addEventListener('resize', this.onResize);
        })
        if (680 > window.innerWidth) {
            this.visibleSlides = true;
        } else if (680 < window.innerWidth) {
            this.visibleSlides = false;
        }
    },
    beforeDestroy() {
        window.removeEventListener('resize', this.onResize);
    },
});
</script>

<style scoped>
article {
    --img-scale: 1.001;
    --title-color: black;
    --link-icon-translate: -20px;
    --link-icon-opacity: 0;
    position: relative;
    border-radius: 16px;
    box-shadow: none;
    background: #fff;
    transform-origin: center;
    transition: all 0.4s ease-in-out;
    overflow: hidden;
    margin: 5px;
}

article a::after {
    position: absolute;
    inset-block: 0;
    inset-inline: 0;
    cursor: pointer;
    content: "";
}

/* basic article elements styling */
article h2 {
    /* font-family: "Bebas Neue", cursive; */
    font-size: 1.4rem;
    letter-spacing: 0.06em;
    color: var(--title-color);
    transition: color 0.3s ease-out;
}

figure {
    margin: 0;
    padding: 0;
    aspect-ratio: 18 / 9;
    overflow: hidden;
}

article img {
    max-width: 100%;
    transform-origin: center;
    transform: scale(var(--img-scale));
    transition: transform 0.4s ease-in-out;
}

article a {
    display: inline-flex;
    align-items: center;
    text-decoration: none;
    color: #28666e;
}

article a:focus {
    outline: 1px dotted #28666e;
}

article a .icon {
    min-width: 24px;
    width: 24px;
    height: 24px;
    margin-left: 5px;
    transform: translateX(var(--link-icon-translate));
    opacity: var(--link-icon-opacity);
    transition: all 0.3s;
}

/* using the has() relational pseudo selector to update our custom properties */
article:has(:hover, :focus) {
    --img-scale: 1.1;
    --title-color: #28666e;
    --link-icon-translate: 0;
    --link-icon-opacity: 1;
    box-shadow: rgba(0, 0, 0, 0.16) 0px 10px 36px 0px, rgba(0, 0, 0, 0.06) 0px 0px 0px 1px;
}


/************************ 
    Generic layout (demo looks)
    **************************/

*,
*::before,
*::after {
    box-sizing: border-box;
}

body {
    margin: 0;
    padding: 48px 0;
    /* font-family: "Figtree", sans-serif; */
    font-size: 1.2rem;
    line-height: 1.6rem;
    background-image: linear-gradient(45deg, #7c9885, #b5b682);
    min-height: 100vh;
}

.articles {
    display: grid;
    max-width: 1200px;
    margin-inline: auto;
    padding-inline: 24px;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 24px;
}

@media screen and (max-width: 960px) {
    article {
        container: card/inline-size;
    }

    .article-body p {
        display: none;
    }
}

@container card (min-width: 380px) {
    .article-wrapper {
        display: grid;
        grid-template-columns: 100px 1fr;
        gap: 16px;
    }

    .article-body {
        padding-left: 0;
    }

    figure {
        width: 100%;
        height: 100%;
        overflow: hidden;
    }

    figure img {
        height: 100%;
        aspect-ratio: 1;
        object-fit: scale-down;
    }
}

.sr-only:not(:focus):not(:active) {
    clip: rect(0 0 0 0);
    clip-path: inset(50%);
    height: 1px;
    overflow: hidden;
    position: absolute;
    white-space: nowrap;
    width: 1px;
}
</style>