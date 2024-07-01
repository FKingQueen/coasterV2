<template>
    <div :class="{ 'h-screen': !isLoaded }">
        <div v-if="isLoaded" class="w-full lg:flex justify-center lg:space-x-6 space-x-0 lg:py-10 py-5">
            <div class="lg:w-6/12  w-full lg:px-0 px-2">
                <div v-if="isLoaded" class="flex justify-center drop-shadow-md bg-white">
                    <div class="w-full">
                        <img src="/img/Project1/tp1.jpg" class="object-cover w-full" alt="#">
                        <div class="w-full grid lg:grid-cols-2 grid-cols-1 lg:divide-[#75aa40] lg:divide-x-4 py-3 px-1">
                            <div class=" lg:pl-5 grid place-items-center">
                                <p class="text-base">Project Leader: Dr. FERNANDO P. SIRINGAN</p>
                                <p class="lg:text-base text-medium">Email: fpsiringan@up.edu.ph</p>
                            </div>
                            <div class="flex gap-4 px-10 pt-3 justify-center">
                                <div class="shrink-0 block">
                                    <a href="https://www.dost.gov.ph/"><img src="/img/Project1/DOST.png"
                                            class="object-fill lg:w-[3vw] lg:h-[3vw] w-[9vw] h-[9vw]" alt="#"></a>
                                </div>
                                <div class="shrink-0">
                                    <a href="https://www.mmsu.edu.ph/"><img src="/img/Project1/PCIEERD.png"
                                            class="object-fill lg:w-[3vw] lg:h-[3vw] w-[9vw] h-[9vw]" alt="#"></a>
                                </div>
                                <div class="shrink-0">
                                    <a href="https://www.kyoto-u.ac.jp/en"><img src="/img/Project1/DILIMAN.png"
                                            class="object-fill lg:w-[3vw] lg:h-[3vw] w-[9vw] h-[9vw]" alt="#"></a>
                                </div>
                                <div class="shrink-0">
                                    <a href="https://up.edu.ph/"><img src="/img/Project1/MSI.png"
                                            class="object-fill lg:w-[3vw] lg:h-[3vw] w-[9vw] h-[9vw]" alt="#"></a>
                                </div>
                                <div class="shrink-0">
                                    <a href="https://www.dmmmsu.edu.ph/"><img src="/img/Project1/DMMMSU.png"
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
                                    This project seeks to address the lack of manpower on coastal erosion research in the country. With  Region 1 as the project site, this project aims to train researchers, faculty and students of select Higher Education Institutions (HEIs) in conducting coastal erosion work through online and              face-to-face training workshops. Techniques for   detecting shoreline changes and vulnerability       assessment will be imparted to them. In addition, this project seeks to (1) establish the trend and possible    causes of coastal erosion in the Ilocos Region; and (2) identify erosion hotspots and      recommend management  options that can be  considered by the concerned LGUs. The 708-km long discontinuous coastline of the Ilocos Region is   visited annually by six (6)    tropical cyclones, and thus, is highly vulnerable to erosion. Identifying  science-based interventions to address coastal   erosion will increase the resilience of the affected coastal areas in the region.
                                </p>
                            </div>

                            <div class="w-full drop-shadow-md ">
                                <div class="w-full flex justify-center py-3">
                                    <swiper 
                                    :pagination="true" 
                                    :modules="modules" 
                                    :loop="true"
                                    :autoplay="{
                                        delay: 2500,
                                        disableOnInteraction: false,
                                    }" 
                                    class="mySwiper h-96 lg:w-3/4">
                                        <swiper-slide>
                                            <img src="/img/Project1/rationale/rationale1.png" class="object-cover  " alt="#">
                                        </swiper-slide>
                                        <swiper-slide><img src="/img/Project1/rationale/rationale2.png" class="object-cover h-full w-full" alt="#"></swiper-slide>
                                        <swiper-slide><img src="/img/Project1/rationale/rationale3.png" class="object-cover h-full w-full" alt="#"></swiper-slide>
                                        <swiper-slide><img src="/img/Project1/rationale/rationale4.png" class="object-cover h-full w-full" alt="#"></swiper-slide>
                                    </swiper>
                                </div>
                            </div>

                            <div class="w-full ">
                                <p class="p-1 font-semibold mt-3 blur-none text-lg">Objectives</p>
                            </div>
                            <div class="w-full p-2 flex justify-center">
                                <div class="lg:w-3/4 w-full">
                                    <p class="font-semibold blur-none">
                                        General:
                                    </p>
                                    <div class="pl-5">
                                        <p class="w-full tracking-wide blur-none pt-2">
                                            1. Provide knowledge know-how to Region 1 HEI researchers on coastal erosion research.
                                        </p>
                                        <p class="w-full tracking-wide blur-none pt-2">
                                            2. Establish the trends and possible causes of erosion along the coasts of Region 1.
                                        </p>
                                        <p class="w-full tracking-wide blur-none pt-2">
                                            3. Identify hotspots of erosion and recommend management options that can be considered by the LGU.
                                        </p>
                                    </div>
                                    <p class="font-semibold blur-none">
                                        Specific:
                                    </p>
                                    <div class="pl-5">
                                        <p class="w-full tracking-wide blur-none pt-2">
                                            a. To map the hazard and risk of selected coastal municipalities.
                                        </p>
                                        <p class="w-full tracking-wide blur-none pt-2">
                                            b. To establish and map the trends of coastal erosion in selected municipalities of region.
                                        </p>
                                        <p class="w-full tracking-wide blur-none pt-2">
                                            c. To determine the average erosion rate and instantaneous magnitudes of erosion in region.
                                        </p>
                                        <p class="w-full tracking-wide blur-none pt-2">
                                            d. To determine the factors contributing to coastal erosion.
                                        </p>
                                        <p class="w-full tracking-wide blur-none pt-2">
                                            e. To develop coastal erosion management option for selected sites in region 1 
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="w-full ">
                                <p class="p-1 font-semibold mt-3 blur-none text-lg">Activities & Accomplishments</p>
                            </div>
                            <div class="w-full divide-y">
                                <div class="w-full p-2 block lg:flex lg:justify-center justify-around">
                                    <div class="lg:w-2/4 lg:p-2 lg:block flex items-center">
                                        <img src="/img/Project1/p1map1.png" class="object-cover w-full shadow-md" alt="#">
                                    </div>
                                    <div class="lg:w-2/4 place-content-center grid grid-cols-1">
                                        <div class="w-full p-2">
                                            <img src="/img/Project1/p1t1.png" class="object-cover w-full shadow-md" alt="#">
                                        </div>
                                        <div class="w-full">
                                            <p class="w-full tracking-wide blur-none indent-8 leading-loose text-justify">
                                                (Left) Net Shoreline Movement (NSM) from DSAS. Lines with shades of red represent total erosion in each
                                                transect within the time period (1977-2022), lines with shades of blue represent the total accretion for
                                                the same time period, while gray lines represent the most stable segment of the coast given an uncertainty value 
                                                of ±25 m. 
                                            </p>
                                            <p class="w-full tracking-wide blur-none indent-8 leading-loose text-justify">
                                                (Right) Calculated End Point Rate of the Ilocos Norte coast from DSAS. Red colors represent erosion rate per year, 
                                                shades of blue represent accretion rate per year, while gray represents segments of the coast with little to no change 
                                                considering the ±25 m uncertainty. 
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="w-full p-2 block lg:flex lg:justify-center justify-around lg:pt-0 pt-5">
                                    <div class="lg:w-2/4 place-content-center grid grid-cols-1 p-1">
                                        <div class="w-full lg:p-2 ">
                                            <img src="/img/Project1/p1t2.png" class="object-cover w-full shadow-md" alt="#">
                                        </div>
                                        <div class="w-full">
                                            <p class="w-full tracking-wide blur-none indent-8 leading-loose text-justify">
                                                The DSAS results for the entire coastline of La Union, where positive values of NSM (Left) and EPR (Right) 
                                                indicate shoreline movement toward the sea (accretion, blue lines), and negative values indicate shoreline 
                                                movement toward the land (erosion, red lines). Between 1977 and 2022, about 40% of 
                                                La Union’s coastline is stable, 32% is accreting and 28% is eroding.
                                            </p>
                                        </div>
                                    </div>
                                    <div class="lg:w-2/4 lg:p-2 lg:block flex items-center">
                                        <img src="/img/Project1/p1map2.png" class="object-cover w-full shadow-md" alt="#">
                                    </div>
                                </div>

                                <div class="w-full p-2 block lg:flex lg:justify-center justify-around lg:pt-0 pt-5">
                                    <div class="lg:w-2/4 lg:p-2 ">
                                        <img src="/img/Project1/p1map3.1.png" class="object-cover w-full shadow-md" alt="#">
                                        <img src="/img/Project1/p1map3.2.png" class="object-cover w-full shadow-md" alt="#">
                                    </div>
                                    <div class="lg:w-2/4 place-content-center grid grid-cols-1 p-1 ">
                                        <div class="w-full lg:p-2 lg:block ">
                                            <img src="/img/Project1/p1t3.png" class="object-cover w-full shadow-md" alt="#">
                                        </div>
                                        <div class="w-full">
                                            <p class="w-full tracking-wide blur-none indent-8 leading-loose text-justify">
                                                The DSAS results for the entire coastline of La Union, where positive values of NSM (Left) and EPR (Right) 
                                                indicate shoreline movement toward the sea (accretion, blue lines), and negative values indicate shoreline 
                                                movement toward the land (erosion, red lines). Between 1977 and 2022, about 40% of 
                                                La Union’s coastline is stable, 32% is accreting and 28% is eroding.
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="w-full p-2">
                                    <div class="w-full place-content-center grid grid-cols-1 p-1">
                                        <div class="w-full">
                                            <p class="w-full tracking-wide blur-none indent-8 leading-loose text-justify">
                                                Of the three (3) provinces, erosion is most prevalent in La Union, where 28% experienced shoreline retreat 
                                                between 1977 and 2022. Whereas, seventeen percent (17%) of the shoreline has eroded in Pangasinan and Ilocos Norte. 
                                                For the most part, the coastlines of these provinces have remained relatively    stable (40 to 65%) to accreting (17 to 38%) 
                                                during this period. In La Union, the southern flanks of the Bauang and Aringay rivers as well as the coast from Agoo to Sto. 
                                                Tomas can be considered as erosion hotspots. Large-magnitude shoreline movements were estimated at the delta flanks of Bauang and      Aringay rivers. More than 75% of the coastline of Agoo (86%) and Sto. Tomas (77%) has been eroding since 1977.

                                            </p>
                                        </div>
                                    </div>
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
            </div>
            <div class="lg:w-2/12 w-full lg:pt-10 pt-5 px-2">
                <p class="text-center text-2xl border-b-2 blur-none antialiased">
                    Other <span class="text-sky-800 ">Projects</span>
                </p>
                <div class="py-2 drop-shadow-2xl grid gap-4">
                    <div @click="this.$router.push('/projects/project2')"
                        class="drop-shadow-md cursor-pointer flex items-end w-full h-full">
                        <img src="/img/slides/Slide3.PNG" class="object-cover w-full" alt="#">
                    </div>
                    <div @click="this.$router.push('/projects/project3')"
                        class="drop-shadow-md cursor-pointer flex items-end w-full h-full">
                        <img src="/img/slides/Slide4.PNG" class="object-cover w-full" alt="#">
                    </div>
                    <div @click="this.$router.push('/projects/project4')"
                        class="drop-shadow-md cursor-pointer flex items-end w-full h-full">
                        <img src="/img/slides/Slide5.PNG" class="object-cover w-full" alt="#">
                    </div>
                </div>
                <p class="text-center text-2xl border-b-2 blur-none antialiased">
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
        await axios.get(`/api/getRelatedArticle/${1}`)
            .then(function (response) {
                console.log(response);
                for (let i = 0; i < response.data.length-1; i++) {
                    existingObj.relatedArticles.push(response.data[i].article);
                }
                console.log(existingObj.relatedArticles);
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