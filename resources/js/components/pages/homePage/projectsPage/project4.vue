<template>
    <div :class="{ 'h-screen': !isLoaded }">
        <div class="absolute w-full min-h-[800px] bg-gradient-to-b from-[#002B5B]"></div>
        <div v-if="isLoaded" class="w-full lg:flex justify-center lg:space-x-6 space-x-0 lg:py-10 py-5">
            <div class="lg:w-6/12  w-full lg:px-0 px-2">
                <div v-if="isLoaded" class="flex justify-center drop-shadow-md bg-white">
                    <div class="w-full">
                        <img src="/img/Project4/tp4.jpg" class="object-cover w-full" alt="#">
                        <div class="w-full grid lg:grid-cols-2 grid-cols-1 lg:divide-[#75aa40] lg:divide-x-4 py-3 px-1">
                            <div class="lg:pl-5 grid place-items-center">
                                <p class="text-base">Project Leader: ENGR. VASCO VIC G. VALDEZ</p>
                                <p class="lg:text-base text-medium">Email: vgvaldez@dmmmsu.edu.ph</p>
                            </div>
                            <div class="flex gap-4 px-10 pt-3 justify-center">
                                <div class="shrink-0 block">
                                    <a href="https://www.dost.gov.ph/"><img src="/img/Project4/DOST.png"
                                            class="object-fill lg:w-[3vw] lg:h-[3vw] w-[9vw] h-[9vw]" alt="#"></a>
                                </div>
                                <div class="shrink-0">
                                    <a href="https://www.mmsu.edu.ph/"><img src="/img/Project4/PCIEERD.png"
                                            class="object-fill lg:w-[3vw] lg:h-[3vw] w-[9vw] h-[9vw]" alt="#"></a>
                                </div>
                                <div class="shrink-0">
                                    <a href="https://www.dmmmsu.edu.ph/"><img src="/img/Project4/MMSU.png"
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
                                    The project aims to establish a more rigorous and comprehensive evaluation and analysis to address the
                                    problem of coastal erosion and shoreline retreat and provide a baseline in the conduct of design and 
                                    other pre-construction activities for coastal infrastructure projects. Decision-support framework will 
                                    be created to guide LGUs in selecting the type of structure, design (structural, geometry), orientation, 
                                    and materials to be used in construction. Site-specific designs will be recommended to concerned LGUs. 
                                    SMSS coupling model will be used for the coastal flooding and surge simulations. The models are coupled 
                                    by including wave radiation stress terms based on the SWAN calculations into the CH3D model and by passing 
                                    the water level and currents from CH3D to SWAN. On the other hand, HEC-HMS and GeoHECRAS will be used for 
                                    the flood routing to model flood due to river swelling. The boundary conditions will be extracted from the 
                                    flood model and will be interacted with SMSS to create a novel model of ocean-river flood inundation interaction. 
                                </p>
                            </div>
                        </div>
                        <div class="w-full drop-shadow-md flex justify-center">
                            <div class="lg:w-2/4 flex justify-center py-3">
                                <img src="/img/Project4/rationale/rationale1.png" class=" w-3/4" alt="#">
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
                                <div class="pl-5">
                                    <p class="w-full tracking-wide blur-none pt-2 text-justify">
                                        To develop a science-based decision support system for coastal flood information and risk management.
                                    </p>
                                </div>
                                <p class="font-semibold blur-none">
                                    Specific:
                                </p>
                                <div class="pl-5">
                                    <p class="w-full tracking-wide blur-none pt-2 text-justify">
                                        a. conduct inventory and assess existing coastal flood control infrastructures in region I; 
                                    </p>

                                    <p class="w-full tracking-wide blur-none pt-2 text-justify">
                                        b. establish a coastal engineering laboratory; and develop, test, and evaluate coastal flood infrastructure design that could be recommended to the LGU. 
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="w-full ">
                            <p class="p-1 font-semibold mt-3 blur-none text-lg">Activities & Accomplishments</p>
                        </div>

                        <div class="w-full ">
                            <div class="w-full lg:flex p-2">
                                <div class=" flex justify-center">
                                    <img src="/img/Project4/rationale/rationale2.png" class="object-cover w-full shadow-md" alt="#">
                                </div>
                                <div class="lg:w-2/5 flex justify-start items-center">
                                    <p class="w-full tracking-wide blur-none indent-8 leading-loose text-justify px-5">
                                        Selection of the study sites were based on the vulnerability of the study sites to storm surge and rivers swelling, 
                                        the number of people and properties that will be affected, the availability of data needed, and the proximity of the 
                                        area to the project base station. For the past years, storm surge and river swelling caused by tropical storms and 
                                        typhoons had caused severe flooding affecting 220,000 people that live within the coastal municipalities of the Laoag 
                                        River basin including Laoag City, Bacarra, and Paoay, Ilocos Norte. These resulted in millions worth of flood control 
                                        damages within the Laoag River basin. On the other hand, heavy downpour caused the Abra River to swell and caused flooding 
                                        in low-lying areas of Ilocos Sur. Areas that are frequently affected include Vigan City, Caoayan, Bantay, and Santa, Ilocos Sur. 
                                    </p>
                                </div>
                            </div>
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
                                class="mySwiper w-full"
                            >
                                <swiper-slide>
                                    <div class="flex w-full justify-center">
                                        <div class="lg:w-7/12">
                                            <div class="border">
                                                <img src="/img/Project4/rationale/rationale3.png" class="object-cover h-full" alt="#">
                                            </div>
                                        </div>
                                    </div>
                                </swiper-slide>
                                <swiper-slide>
                                    <div class="flex w-full justify-center">
                                        <div class="lg:w-7/12">
                                            <div class="border">
                                                <img src="/img/Project4/rationale/rationale4.png" class="object-cover h-full" alt="#">
                                            </div>
                                        </div>
                                    </div>
                                </swiper-slide>
                                <swiper-slide>
                                    <div class="flex w-full justify-center">
                                        <div class="lg:w-7/12">
                                            <div class="border">
                                                <img src="/img/Project4/rationale/rationale5.png" class="object-cover h-full" alt="#">
                                            </div>
                                        </div>
                                    </div>
                                </swiper-slide>
                                <swiper-slide>
                                    <div class="flex w-full justify-center">
                                        <div class="lg:w-7/12">
                                            <div class="border">
                                                <img src="/img/Project4/rationale/rationale6.png" class="object-cover h-full" alt="#">
                                            </div>
                                        </div>
                                    </div>
                                </swiper-slide>
                            </swiper>
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
                                        <div class="">
                                            <div class="border">
                                                <img src="/img/Project4/rationale/rationale7.png" class="object-cover h-full w-full" alt="#">
                                            </div>
                                        </div>
                                    </div>
                                </swiper-slide>
                                <swiper-slide>
                                    <div class="flex  justify-center">
                                        <div class="">
                                            <div class="border">
                                                <img src="/img/Project4/rationale/rationale8.png" class="object-cover h-full w-full" alt="#">
                                            </div>
                                        </div>
                                    </div>
                                </swiper-slide>
                                <swiper-slide>
                                    <div class="flex  justify-center">
                                        <div class="">
                                            <div class="border">
                                                <img src="/img/Project4/rationale/rationale9.png" class="object-cover h-full w-full" alt="#">
                                            </div>
                                        </div>
                                    </div>
                                </swiper-slide>
                                <swiper-slide>
                                    <div class="flex  justify-center">
                                        <div class="">
                                            <div class="border">
                                                <img src="/img/Project4/rationale/rationale10.png" class="object-cover h-full w-full" alt="#">
                                            </div>
                                        </div>
                                    </div>
                                </swiper-slide>
                                <swiper-slide>
                                    <div class="flex  justify-center">
                                        <div class="">
                                            <div class="border">
                                                <img src="/img/Project4/rationale/rationale11.png" class="object-cover h-full w-full" alt="#">
                                            </div>
                                        </div>
                                    </div>
                                </swiper-slide>
                                <swiper-slide>
                                    <div class="flex  justify-center">
                                        <div class="">
                                            <div class="border">
                                                <img src="/img/Project4/rationale/rationale12.png" class="object-cover h-full w-full" alt="#">
                                            </div>
                                        </div>
                                    </div>
                                </swiper-slide>
                            </swiper>
                            <div>
                                <p class="w-full text-center font-light blur-none">
                                    Project staff assessed the different structures recording physical properties and some notable features present in the
                                    structures. Photos show documentation of assessment and field validation by the    project staff and some notable features
                                    on the structures to be further analyzed. 
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
                                        <div class="lg:w-2/4">
                                            <div class="border">
                                                <img src="/img/Project4/rationale/rationale13.png" class="object-cover h-full w-full" alt="#">
                                            </div>
                                        </div>
                                    </div>
                                </swiper-slide>
                                <swiper-slide>
                                    <div class="flex  justify-center">
                                        <div class="lg:w-2/4">
                                            <div class="border">
                                                <img src="/img/Project4/rationale/rationale14.png" class="object-cover h-full w-full" alt="#">
                                            </div>
                                        </div>
                                    </div>
                                </swiper-slide>
                                <swiper-slide>
                                    <div class="flex  justify-center">
                                        <div class="lg:w-2/4">
                                            <div class="border">
                                                <img src="/img/Project4/rationale/rationale15.png" class="object-cover h-full w-full" alt="#">
                                            </div>
                                        </div>
                                    </div>
                                </swiper-slide>
                            </swiper>
                            <div>
                                <p class="w-full text-center font-light blur-none">
                                    Project staff assessed the different structures recording physical properties and some notable features present in the
                                    structures. Photos show documentation of assessment and field validation by the    project staff and some notable features
                                    on the structures to be further analyzed. 
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
            <div class="lg:w-2/12 w-full lg:pt-10 pt-5 px-2 z-40">
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
                    <div @click="this.$router.push('/projects/project3')"
                        class="drop-shadow-md cursor-pointer flex items-end w-full h-full">
                        <img src="/img/slides/Slide4.PNG" class="object-cover w-full" alt="#">
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
        await axios.get(`/api/getRelatedArticle/${4}`)
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