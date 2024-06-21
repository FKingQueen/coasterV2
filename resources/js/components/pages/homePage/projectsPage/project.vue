<template>
    <div :class="{ 'h-screen': !isLoaded }">
        <div v-if="isLoaded" class="w-full lg:flex justify-center lg:space-x-6 space-x-0 lg:py-10 py-5">
            <div class="lg:w-6/12  w-full lg:px-0 px-2">
                <div v-if="isLoaded" class="flex justify-center drop-shadow-md bg-white">
                    <div class="w-full">
                        <img v-if="this.projectId == 1" src="/img/Project1/tp1.jpg" class="object-cover w-full" alt="#">
                        <img v-if="this.projectId == 2" src="/img/Project2/tp2.png" class="object-cover w-full" alt="#">
                        <img v-if="this.projectId == 3" src="/img/Project3/tp3.jpg" class="object-cover w-full" alt="#">
                        <img v-if="this.projectId == 4" src="/img/Project4/tp4.jpg" class="object-cover w-full" alt="#">
                        <div>
                            Hello
                        </div>
                    </div>
                </div>


                <!-- <div v-if="isLoaded" class="flex justify-center drop-shadow-md bg-white">
                    <div class="w-full">
                        <div class=" flex justify-center items-center">
                            <p
                                class="text-center text-4xl tracking-wide antialiased border-b lg:py-5 py-2 px-2 border-sky-800/50 blur-none text-sky-900">
                                {{ this.project.title }}</p>
                        </div>
                        <div class="">
                            <p class="px-3 text-left text-2xl tracking-wide antialiased mt-2 blur-none text-sky-800/90">
                                Highlights of the Activity</p>
                            <swiper :spaceBetween="30" :loop="true" :autoplay="{
                                delay: 2500,
                                disableOnInteraction: false,
                            }" :pagination="{
                                clickable: true,
                            }" :modules="modules" class="mySwiper h-80 mt-2">
                                <swiper-slide v-slot="{ isActive }" v-for="(project, key) in this.projectImages">
                                    <div class="h-full shadow-lg "
                                        :style="{ backgroundImage: `url(/img/Project${project.project_type_id}/${project.name})` }"
                                        style="background-repeat: no-repeat; background-size: cover; ">
                                        <Transition :duration="550" name="nested">
                                            <div v-if="isActive || key == 0" class="h-full w-full grid content-end  py-6">
                                                <div class="bg-black/50 p-3">
                                                    <p
                                                        class="font-sans text-lg font-medium tracking-wide antialiased blur-none text-white">
                                                        {{ project.details }}
                                                    </p>
                                                </div>
                                            </div>
                                        </Transition>
                                    </div>
                                </swiper-slide>
                            </swiper>

                        </div>
                        <div class="px-3">
                            <div>
                                <p class="text-left text-2xl tracking-wide antialiased mt-4 blur-none text-sky-800/90">
                                    Objective</p>
                                <p v-for="(project, key) in this.projectObjectives"
                                    class="text-justify indent-8 text-sm tracking-wide antialiased mt-4 blur-none">
                                    {{ key + 1 }}. {{ project.objective }}
                                </p>
                            </div>
                            <div>
                                <p class="text-left text-2xl tracking-wide antialiased mt-4 blur-none text-sky-800/90">About
                                </p>
                                <p
                                    class="text-justify indent-8 text-sm tracking-wide antialiased mt-4 blur-none leading-loose">
                                    {{ this.project.about }}
                                </p>
                            </div>
                            <div class="grid grid-cols-1 divide-y divide-sky-400 pt-10">
                                <div>

                                </div>
                                <div>

                                </div>
                            </div>
                            <div>
                                <p class="text-left text-2xl tracking-wide antialiased mt-4 blur-none text-sky-800/90">
                                    Gallery</p>
                                <div class="py-5">
                                    <a-image-preview-group>
                                        <a-image class="px-5" v-for="(project, key) in this.projectImages" :width="100"
                                            style="height: 70px"
                                            :src="`/img/Project${project.project_type_id}/${project.name}`" :preview="{
                                                src: `/img/Project${project.project_type_id}/${project.name}`,
                                            }" />
                                    </a-image-preview-group>

                                </div>
                            </div>
                        </div>

                    </div>
                </div> -->
            </div>
            <div class="lg:w-2/12 w-full lg:pt-10 pt-5 px-2">
                <p class="text-center text-2xl border-b-2 blur-none antialiased">
                    Other <span class="text-sky-800 ">Projects</span>
                </p>
                <div class="py-2 drop-shadow-2xl grid gap-4">
                    <div @click="gotoProject(1)" v-if="this.$route.params.id != 1"
                        class="drop-shadow-md cursor-pointer flex items-end w-full h-full">
                        <img src="/img/slides/slide2.PNG" class="object-cover w-full" alt="#">
                    </div>
                    <div @click="gotoProject(2)" v-if="this.$route.params.id != 2"
                        class="drop-shadow-md cursor-pointer flex items-end w-full h-full">
                        <img src="/img/slides/slide3.PNG" class="object-cover w-full" alt="#">
                    </div>
                    <div @click="gotoProject(3)" v-if="this.$route.params.id != 3"
                        class="drop-shadow-md cursor-pointer flex items-end w-full h-full">
                        <img src="/img/slides/slide4.PNG" class="object-cover w-full" alt="#">
                    </div>
                    <div @click="gotoProject(4)" v-if="this.$route.params.id != 4"
                        class="drop-shadow-md cursor-pointer flex items-end w-full h-full">
                        <img src="/img/slides/slide5.PNG" class="object-cover w-full" alt="#">
                    </div>
                </div>
                <p class="text-center text-2xl border-b-2 blur-none antialiased">
                    Related <span class="text-sky-800 ">Activities</span>
                </p>
                <div v-for="(relatedArticle, key) in this.relatedArticles.slice(0, 5)" class="py-2 drop-shadow-2xl">
                    <div class="h-36 shadow-lg" :style="{ backgroundImage: `url(/uploads/low/${relatedArticle.image})` }"
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
            projectImages: [],
            projectObjectives: [],
            project: [],
            newsArticles: [],
            announcementsArticles: [],
            eventsArticles: [],
            relatedArticles: [],
            isLoaded: ref(false),
            projectId: '',
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
        gotoProject(id) {
            let existingObj = this;
            if (id == 1) {
                existingObj.selectedProject = 'Coastal Erosion Trends and Management Strategies for Region 1'
            } else if (id == 2) {
                existingObj.selectedProject = 'Assesment Monitoring, and Prediction of Coastal Flooding of Selected Municipalities in Region 1'
            } else if (id == 3) {
                existingObj.selectedProject = 'Development of Science-based Engineering Approach to Coastal Prediction in Region 1'
            } else if (id == 4) {
                existingObj.selectedProject = 'Enhancing Coastal Design and Infrastructure Intervention through the Establishment of Wave Testing Facility'
            }
            const project = existingObj.selectedProject
            this.$router.push({ name: 'projects', params: { project, id } })
        }
    },
    async mounted() {
        let existingObj = this;
        existingObj.projectId = this.$route.params.id
        await axios.get(`/api/getProject/${existingObj.projectId}`)
            .then(function (response) {
                existingObj.projectImages = response.data.project[0].project_image;
                existingObj.projectObjectives = response.data.project[0].project_objective;
                existingObj.project = response.data.project[0];
                for (let i = 0; i < response.data.newsArticles.length; i++) {
                    if (response.data.newsArticles[i].type.id == 1) {
                        existingObj.newsArticles.push(response.data.newsArticles[i]);
                    }
                }
                for (let i = 0; i < response.data.announcementsArticles.length; i++) {
                    if (response.data.announcementsArticles[i].type.id == 2) {
                        existingObj.announcementsArticles.push(response.data.announcementsArticles[i]);
                    }
                }
                for (let i = 0; i < response.data.eventsArticles.length; i++) {
                    if (response.data.eventsArticles[i].type.id == 3) {
                        existingObj.eventsArticles.push(response.data.eventsArticles[i]);
                    }
                }
                existingObj.isLoaded = true;
            })
            .catch(function (error) {
                console.log(error)
            });

        await axios.get(`/api/getRelatedArticle`)
            .then(function (response) {
                for (let i = 0; i < response.data.length; i++) {
                    for (let k = 0; k < response.data[i].projects.length; k++) {
                        if (existingObj.projectId == response.data[i].projects[k].project_type_id) {
                            existingObj.relatedArticles.push(response.data[i]);
                            break;
                        }
                    }
                }
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