<template>
    <div :class="{ 'h-screen': !isLoaded }">
        <div class="absolute w-full min-h-[800px] bg-gradient-to-b from-[#002B5B]"></div>
        <div v-if="isLoaded" class="w-full lg:flex justify-center lg:space-x-6 space-x-0 lg:py-10 py-5">
            <div class="lg:w-6/12  w-full lg:px-0 px-2">
                <div v-if="isLoaded" class="flex justify-center drop-shadow-md bg-white">
                    <div class="w-full">
                        <img src="/img/Project3/tp3.jpg" class="object-cover w-full" alt="#">
                        <div class="w-full grid lg:grid-cols-2 grid-cols-1 lg:divide-[#75aa40] lg:divide-x-4 py-3 px-1">
                            <div class="lg:pl-5 grid place-items-center">
                                <p class="text-base">Project Leader: ENGR. DEAN ALDRENE O. BADUA</p>
                                <p class="lg:text-base text-medium">Email: dbadua@dmmmsu.edu.ph</p>
                            </div>
                            <div class=" flex gap-4 px-10 pt-3 justify-center">
                                <div class="shrink-0 block">
                                    <a href="https://www.dost.gov.ph/"><img src="/img/Project3/DOST.png"
                                            class="object-fill lg:w-[3vw] lg:h-[3vw] w-[9vw] h-[9vw]" alt="#"></a>
                                </div>
                                <div class="shrink-0">
                                    <a href="https://www.mmsu.edu.ph/"><img src="/img/Project3/PCIEERD.png"
                                            class="object-fill lg:w-[3vw] lg:h-[3vw] w-[9vw] h-[9vw]" alt="#"></a>
                                </div>
                                <div class="shrink-0">
                                    <a href="https://www.dmmmsu.edu.ph/"><img src="/img/Project3/DMMMSU.png"
                                            class="object-fill lg:w-[3vw] lg:h-[3vw] w-[9vw] h-[9vw]" alt="#"></a>
                                </div>
                            </div>
                        </div>
                        <div class="w-full">
                            <div class="w-full ">
                                <p class="p-1 font-semibold blur-none text-lg">Rationale</p>
                            </div>
                            <div class="w-full p-2">
                                <p class="w-full tracking-wide blur-none indent-8 leading-loose text-justify">
                                    Many coastal protection structures fail either because they were not properly designed or the materials used for
                                    construction were not suitable for coastal conditions, or both. There is a need to improve the properties of
                                    concrete to withstand the harsh conditions along the coastline. One of the most important mechanical properties
                                    of concrete, aside from compressive strength, is durability. Durability is important especially when concrete
                                    structures are subjected to harsh environments such as seas and oceans. In this proposed project, concrete materials
                                    with bio-based additives formed in different artificial reef designs and breakwaters will be observed for their
                                    biological, physical and mechanical performance on the natural coastal parameters and constraints such as
                                    fluctuation on moisture, salinity, biological and cultural activities, waves, and undercurrents.
                                </p>
                            </div>
                        </div>
                        <div class="w-full drop-shadow-md flex justify-center">
                            <div class="lg:w-2/4 flex justify-center py-3">
                                <img src="/img/Project3/rationale/rationale1.png" class=" w-3/4" alt="#">
                            </div>
                        </div>

                        <div class="w-full ">
                            <p class="p-1 font-semibold mt-3 blur-none text-lg">Objectives</p>
                        </div>
                        <div class="w-full p-2 flex justify-center">
                            <div class="lg:w-3/4">
                                <p class="font-semibold blur-none">
                                    General:
                                </p>
                                <div class="lg:pl-5">
                                    <p class="w-full tracking-wide blur-none pt-2 text-justify">
                                        This study aims to establish strategies for coastal protection and climate change mitigation using science-based engineering solutions.
                                    </p>
                                </div>
                                <p class="font-semibold blur-none">
                                    Specific:
                                </p>
                                <div class="lg:pl-5">
                                    <p class="w-full tracking-wide blur-none pt-2 text-justify">
                                        a. integrate appropriate bio-engineering and “sustainable” smart concrete technology for coastal protection structures considering the following criteria:
                                    </p>
                                        <div class="pl-5">
                                            <p class="w-full tracking-wide blur-none pt-2 text-justify">
                                                1. Strength
                                            </p>
                                            <p class="w-full tracking-wide blur-none pt-2 text-justify">
                                                2. Durability
                                            </p>
                                            <p class="w-full tracking-wide blur-none pt-2 text-justify">
                                                3. Permeability
                                            </p>
                                        </div>

                                    <p class="w-full tracking-wide blur-none pt-2 text-justify">
                                        b. develop bio-engineered artificial reef considering the following criteria:
                                    </p>
                                        <div class="pl-5">
                                            <p class="w-full tracking-wide blur-none pt-2 text-justify">
                                                1. Wave Reduction
                                            </p>
                                            <p class="w-full tracking-wide blur-none pt-2 text-justify">
                                                2. Structural Strength
                                            </p>
                                            <p class="w-full tracking-wide blur-none pt-2 text-justify">
                                                3. Biological and Environmental Function
                                            </p>
                                        </div>
                                </div>
                            </div>
                        </div>

                        <div class="w-full ">
                            <p class="p-1 font-semibold mt-3 blur-none text-lg">Activities & Accomplishments</p>
                        </div>

                        <div class="w-full drop-shadow-md flex justify-center">
                            <div class="lg:w-3/5 flex justify-center py-3">
                                <div class="w-3/4">
                                    <img src="/img/Project3/rationale/rationale2.png" class="object-cover " alt="#">
                                    <p class="text-center">Study pilot sites were as follows: DMMMSU—FRTI, Balaoan, Bacnotan, and Luna, La Union</p>
                                </div>
                            </div>
                        </div>

                        <div class="w-full p-2">
                            <div class="w-full flex justify-center">
                                <p class="font-semibold blur-none text-base">
                                    Raw Materials Collection and Characterization
                                </p>
                            </div>
                            <div class="flex justify-center pt-2">
                                <swiper
                                    :loop="true"
                                    :spaceBetween="30"
                                    :centeredSlides="true"
                                    :autoplay="{
                                    delay: 6000,
                                    disableOnInteraction: false,
                                    }"
                                    :pagination="{
                                    clickable: true,
                                    }"
                                    :modules="modules"
                                    class="mySwiper"
                                >
                                    <swiper-slide>
                                        <div class="flex justify-center">
                                            <div class="lg:w-2/4 w-3/4">
                                                <div class="border">
                                                    <img src="/img/Project3/rationale/rationale3.png" class="object-cover h-full w-full" alt="#">
                                                </div>
                                                <div>
                                                    <p class=" text-center font-light blur-none">
                                                        Incineration of Rice Hull
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </swiper-slide>
                                    <swiper-slide>
                                        <div class="flex  justify-center">
                                            <div class="lg:w-10/12">
                                                <div class="border">
                                                    <img src="/img/Project3/rationale/rationale4.png" class="object-cover h-full w-full" alt="#">
                                                </div>
                                                <div>
                                                    <p class=" text-center font-light blur-none">
                                                        Collection of Fly Ash
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </swiper-slide>
                                    <swiper-slide>
                                        <div class="flex  justify-center">
                                            <div class="lg:w-10/12">
                                                <div class="border">
                                                    <img src="/img/Project3/rationale/rationale5.png" class="object-cover h-full w-full" alt="#">
                                                </div>
                                                <div>
                                                    <p class="w-full text-center font-light blur-none">
                                                        Collection of Oyster Shell at Dagupan City
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </swiper-slide>
                                    <swiper-slide>
                                        <div class="flex  justify-center">
                                            <div class="lg:w-2/4 w-3/4">
                                                <div class="border">
                                                    <img src="/img/Project3/rationale/rationale6.png" class="object-cover h-full w-full" alt="#">
                                                </div>
                                                <div>
                                                    <p class="w-full text-center font-light blur-none">
                                                        Collection of Rice Hull
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </swiper-slide>
                                </swiper>
                            </div>
                        </div>

                        <div class="p-4">
                            <swiper
                                :loop="true"
                                :spaceBetween="30"
                                :centeredSlides="true"
                                :autoplay="{
                                delay: 6000,
                                disableOnInteraction: false,
                                }"
                                :pagination="{
                                clickable: true,
                                }"
                                :modules="modules"
                                class="mySwiper"
                            >
                                <swiper-slide>
                                    <div class="flex justify-center">
                                        <div class="lg:w-7/12 w-9/12">
                                            <div class="border">
                                                <img src="/img/Project3/rationale/rationale7.png" class="object-cover h-full w-full" alt="#">
                                            </div>
                                        </div>
                                    </div>
                                </swiper-slide>
                                <swiper-slide>
                                    <div class="flex  justify-center">
                                        <div class="lg:w-2/4 w-3/4">
                                            <div class="border">
                                                <img src="/img/Project3/rationale/rationale8.png" class="object-cover h-full w-full" alt="#">
                                            </div>
                                        </div>
                                    </div>
                                </swiper-slide>
                                <swiper-slide>
                                    <div class="flex  justify-center">
                                        <div class="lg:w-2/4 w-3/4">
                                            <div class="border">
                                                <img src="/img/Project3/rationale/rationale9.png" class="object-cover h-full w-full" alt="#">
                                            </div>
                                        </div>
                                    </div>
                                </swiper-slide>
                            </swiper>
                            <div>
                                <p class="w-full text-center font-light blur-none">
                                    Testing of concrete cylinder samples for its compressive strength at EB Testing Inc. in Urdaneta City, Pangasinan.
                                </p>
                            </div>
                        </div>

                        <div class="p-4">
                            <swiper
                                :loop="true"
                                :spaceBetween="30"
                                :centeredSlides="true"
                                :autoplay="{
                                delay: 6000,
                                disableOnInteraction: false,
                                }"
                                :pagination="{
                                clickable: true,
                                }"
                                :modules="modules"
                                class="mySwiper"
                            >
                                <swiper-slide>
                                    <div class="flex justify-center">
                                        <div class="lg:w-7/12">
                                            <div class="border">
                                                <img src="/img/Project3/rationale/rationale10.png" class="object-cover h-full w-full" alt="#">
                                            </div>
                                        </div>
                                    </div>
                                </swiper-slide>
                                <swiper-slide>
                                    <div class="flex  justify-center">
                                        <div class="lg:w-2/4 ">
                                            <div class="border">
                                                <img src="/img/Project3/rationale/rationale11.png" class="object-cover h-full w-full" alt="#">
                                            </div>
                                        </div>
                                    </div>
                                </swiper-slide>
                                <swiper-slide>
                                    <div class="flex  justify-center">
                                        <div class="lg:w-2/4 ">
                                            <div class="border">
                                                <img src="/img/Project3/rationale/rationale12.png" class="object-cover h-full w-full" alt="#">
                                            </div>
                                        </div>
                                    </div>
                                </swiper-slide>
                            </swiper>
                            <div>
                                <p class="w-full text-center font-light blur-none">
                                    Designing Molders using AutoCAD & SketchUp for 3D Printing and Creation of Molders using Phenolic Boards
                                </p>
                            </div>
                        </div>

                        <div class="p-4">
                            <swiper
                                :loop="true"
                                :spaceBetween="30"
                                :centeredSlides="true"
                                :autoplay="{
                                delay: 6000,
                                disableOnInteraction: false,
                                }"
                                :pagination="{
                                clickable: true,
                                }"
                                :modules="modules"
                                class="mySwiper"
                            >
                                <swiper-slide>
                                    <div class="flex justify-center">
                                        <div class="lg:w-7/12 ">
                                            <div class="border">
                                                <img src="/img/Project3/rationale/rationale13.png" class="object-cover h-full w-full" alt="#">
                                            </div>
                                        </div>
                                    </div>
                                </swiper-slide>
                                <swiper-slide>
                                    <div class="flex  justify-center">
                                        <div class="lg:w-2/4">
                                            <div class="border">
                                                <img src="/img/Project3/rationale/rationale14.png" class="object-cover h-full w-full" alt="#">
                                            </div>
                                        </div>
                                    </div>
                                </swiper-slide>
                            </swiper>
                            <div>
                                <p class="w-full text-center font-light blur-none">
                                    Simulation of AR Designs using Ansys
                                </p>
                            </div>
                        </div>

                        <div class="p-4">
                            <div class="w-full ">
                                <div class=" flex justify-center space-x-4">
                                    <img src="/img/Project3/rationale/rationale15.png" class="object-cover w-2/5" alt="#">
                                    <img src="/img/Project3/rationale/rationale16.png" class="object-cover w-2/5" alt="#">
                                </div>
                            </div>
                            <div>
                                <p class="w-full text-center font-light blur-none">
                                    Simulation of AR Designs using Ansys
                                </p>
                            </div>
                        </div>

                        <div class="p-4">
                            <div class="w-full ">
                                <div class=" flex justify-center space-x-4">
                                    <img src="/img/Project3/rationale/rationale17.png" class="object-cover w-full" alt="#">
                                </div>
                            </div>
                            <div>
                                <p class="w-full text-center font-light blur-none">
                                    Paraoir Beach located at Brgy. Paraoir, Balaoan, La Union as one of the pilot site for the deployment of artificial reef.
                                </p>
                            </div>
                        </div>

                        <div class="p-4">
                            <swiper
                                :loop="true"
                                :spaceBetween="30"
                                :centeredSlides="true"
                                :autoplay="{
                                delay: 6000,
                                disableOnInteraction: false,
                                }"
                                :pagination="{
                                clickable: true,
                                }"
                                :modules="modules"
                                class="mySwiper"
                            >
                                <swiper-slide>
                                    <div class="flex justify-center">
                                        <div class="lg:w-7/12">
                                            <div class="border">
                                                <img src="/img/Project3/rationale/rationale18.png" class="object-cover h-full w-full" alt="#">
                                            </div>
                                        </div>
                                    </div>
                                </swiper-slide>
                                <swiper-slide>
                                    <div class="flex  justify-center">
                                        <div class="lg:w-2/4">
                                            <div class="border">
                                                <img src="/img/Project3/rationale/rationale19.png" class="object-cover h-full w-full" alt="#">
                                            </div>
                                        </div>
                                    </div>
                                </swiper-slide>
                            </swiper>
                            <div>
                                <p class="w-full text-center font-light blur-none">
                                    Deployed concrete cylinder samples with varying percentages of admixtures and type of cement.
                                </p>
                            </div>
                        </div>

                        <div class="w-full ">
                            <p class="p-1 font-semibold mt-3 blur-none text-lg">Acknowledgement</p>
                        </div>

                        <div class="w-full ">
                            <div class="w-full p-2">
                                <p class="w-full tracking-wide blur-none indent-8 leading-loose text-justify">
                                    Our utmost gratitude to the Department of Science and Technology (DOST) for generously funding the program entitled
                                    "Establishment of Coastal Engineering and Management Research and Development Center (COASTER)
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="lg:w-2/12 w-full lg:pt-10 pt-5 px-2 z-30">
                <p class="text-center text-2xl border-b-2 blur-none antialiased bg-white py-1">
                    Other <span class="text-sky-800 ">Projects</span>
                </p>
                <div class="py-2 drop-shadow-2xl grid gap-4">
                    <div @click="this.$router.push('/projects/project1')"
                        class="drop-shadow-md cursor-pointer flex items-end w-full h-full">
                        <img src="/img/slides/Slide2.PNG" class="object-cover w-full" alt="#">
                    </div>
                    <div @click="this.$router.push('/projects/project2')"
                        class="drop-shadow-md cursor-pointer flex items-end w-full h-full">
                        <img src="/img/slides/Slide3.PNG" class="object-cover w-full" alt="#">
                    </div>
                    <div @click="this.$router.push('/projects/project4')"
                        class="drop-shadow-md cursor-pointer flex items-end w-full h-full">
                        <img src="/img/slides/Slide5.PNG" class="object-cover w-full" alt="#">
                    </div>
                </div>
                <p class="text-center text-2xl border-b-2 blur-none antialiased bg-white py-1">
                    Related <span class="text-sky-800 ">Activities</span>
                </p>
                <div v-for="(relatedArticle, key) in this.relatedArticles.slice(0, 5)" class="py-2 drop-shadow-2xl">
                    <div class="h-36 shadow-lg" :style="{ backgroundImage: `url(/img/uploads/${relatedArticle.image})` }"
                        style="background-repeat: no-repeat; background-size: cover; ">
                        <div @click="gotoArticle(relatedArticle)"
                            class="cursor-pointer flex items-end w-full h-full bg-[#0d2247]/60">
                            <div class="px-2 w-full">
                                <p class="text-white text-sm p-0 font-thin blur-none antialiased  ">
                                    {{ relatedArticle.date }}
                                </p>
                                <p class="text-white p-0 font-thin blur-none antialiased ">
                                    {{ relatedArticle.title }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { defineComponent, ref } from 'vue';
import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';
import 'swiper/css/pagination';
import 'swiper/css/navigation';
import { Autoplay, Pagination, Navigation } from 'swiper';
export default defineComponent({
    components: {
        Swiper,
        SwiperSlide,
    },
    data() {
        return {
            relatedArticles: [],
            isLoaded: ref(false),
        }
    },
    setup() {
        return {
            modules: [Autoplay, Pagination, Navigation],
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
            this.$router.push({ name: 'article', params: { article, title, id } })
        },
        gotoMoreArticle(article) {
            this.$router.push({ name: 'moreArticle', params: { article } })
        },
    },
    async mounted() {
        let existingObj = this;
        await axios.get(`/api/getRelatedArticle/${3}`)
            .then(function (response) {
                for (let i = 0; i < response.data.length; i++) {
                    existingObj.relatedArticles.push(response.data[i].article);
                }
                existingObj.isLoaded = true;
            })
            .catch(function (error) {
                console.log(error)
            });
    }
})
</script>


<style  scoped>
.nested-enter-active,
.nested-leave-active {
    transition: all .6s ease-in-out;
}

/* delay leave of parent element */
.nested-leave-active {
    transition-delay: 0.25s;
}

.nested-enter-from,
.nested-leave-to {
    transform: translateY(30px);
    opacity: 0;
}

/* we can also transition nested elements using nested selectors */
.nested-enter-active .inner,
.nested-leave-active .inner {
    transition: all 0.3s ease-in-out;
}

/* delay enter of nested element */
.nested-enter-active .inner {
    transition-delay: 0.25s;
}

.nested-enter-from .inner,
.nested-leave-to .inner {
    transform: translateX(30px);
    /*
        Hack around a Chrome 96 bug in handling nested opacity transitions.
        This is not needed in  browsers or Chrome 99+ where the bug
        has been fixed.
    */
    opacity: 0.001;
}</style>
