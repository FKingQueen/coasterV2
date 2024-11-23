<template>
    <div :class="{ 'h-screen': !isLoaded }" class="">
        <div v-if="isLoaded" class="w-full flex justify-center lg:space-x-6 space-x-0 py-10">
            <div class="lg:w-5/12 md:w-10/12 w-full lg:px-1 px-2 drop-shadow-md bg-white ">
                <div v-if="isLoaded" class="flex justify-center ">
                    <div class="w-full">
                        <p class="text-left text-3xl tracking-wide antialiased border-b-2 border-black/20 mt-4 blur-none">
                            Most Recent <span class="text-sky-800 ">{{ moreCurrent }}</span>
                        </p>
                        <swiper :spaceBetween="30" :loop="true" :pagination="{
                            clickable: true,
                        }" :modules="modules" class="mySwiper h-80 mt-2">
                            <swiper-slide v-slot="{ isActive }" v-for="(more, key) in this.moreArticle_list.slice(0, 5)">
                                <div class="h-full shadow-lg " :style="{ backgroundImage: `url(/img/uploads/${more.image})` }"
                                    style="background-repeat: no-repeat; background-size: cover; ">
                                    <Transition :duration="550" name="nested">
                                        <div v-if="isActive || key == 0" class="h-full w-full grid content-end  py-6">
                                            <div class="bg-black/50 p-3">
                                                <p
                                                    class="font-sans text-lg font-medium tracking-wide antialiased blur-none text-white">
                                                    {{ more.title }}
                                                </p>
                                                <p v-html="more.article"
                                                    class="indent-5 font-light text-white font-sans line-clamp-2 blur-none antialiased leading-relaxed">
                                                </p>
                                            </div>
                                        </div>
                                    </Transition>
                                </div>
                            </swiper-slide>
                        </swiper>
                    </div>
                </div>
                <div v-if="isLoaded" class="lg:flex lg:px-0 px-2 justify-center lg:space-x-6 space-x-0 py-10">
                    <div class=" w-full h-full ">
                        <p class="text-center text-2xl tracking-wide antialiased blur-none pb-4">
                            More <span class="text-sky-800 ">{{ moreCurrent }}</span>
                        </p>
                        <div v-for="(more, key) in this.moreArticle_list"
                            class="flex block border-b-2 border-sky-900/60 pb-3 mb-5">
                            <img @click="gotoArticle(more)"
                                class="cursor-pointer bg-sky-200 object-cover object-center blur-none w-24 h-24 "
                                :src="`/img/uploads/${more.image}`">
                            <div class="block w-fit px-1 overflow-hidden">
                                <p @click="gotoArticle(more)"
                                    class="cursor-pointer text-sm blur-none antialiased font-semibold text-sky-600  truncate">
                                    {{ more.title }}</p>
                                <p class="text-xs blur-none">{{ moreCurrent }} | {{ more.date }}</p>
                                <p v-html="more.article"
                                    class="blur-none antialiased text-xs text-justify line-clamp-3 leading-relaxed"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-2/12 pt-10 hidden lg:block">
                <div v-if="this.moreArticle1.length != 0">
                    <div class="bg-sky-600/60 border-b-2 border-sky-900 py-2">
                        <p class="text-xl text-center">
                            Latest <span class="text-sky-900">{{ this.moreCurrent1 }}</span>
                        </p>
                    </div>
                    <div class="border-b-2" v-for="(more, key) in this.moreArticle1.slice(0, 5)">
                        <p @click="gotoArticle(more)" class="text-sm font-thin tracking-wide text-sky-700 cursor-pointer">{{
                            more.title }}</p>
                        <p class="text-xs font-thin tracking-wide">{{ this.moreCurrent1 }} | {{ more.date }}</p>
                    </div>
                    <p @click="gotoMoreArticle(this.moreCurrent1)" class="text-center text-lg p-5 cursor-pointer">
                        VIEW MORE
                    </p>
                </div>

                <div v-if="this.moreArticle2.length != 0">
                    <div class="bg-sky-600/60 border-b-2 border-sky-900 py-2">
                        <p class="text-xl text-center">
                            Latest <span class="text-sky-900">{{ this.moreCurrent2 }}</span>
                        </p>
                    </div>
                    <div class="border-b-2" v-for="(more, key) in this.moreArticle2.slice(0, 5)">
                        <p @click="gotoArticle(more)" class="text-sm font-thin tracking-wide text-sky-700 cursor-pointer">{{
                            more.title }}</p>
                        <p class="text-xs font-thin tracking-wide">{{ this.moreCurrent2 }} | {{ more.date }}</p>
                    </div>
                    <p @click="gotoMoreArticle(this.moreCurrent2)" class="text-center text-lg p-5 cursor-pointer">
                        VIEW MORE
                    </p>
                </div>
            </div>
        </div>
        <button v-if="this.isShowScroll" @click="scrollToTop"
            class="fixed z-10 block p-3 bg-gray-100 rounded-full shadow-md bottom-10 right-10 animate-bounce">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 19.5v-15m0 0l-6.75 6.75M12 4.5l6.75 6.75" />
            </svg>
        </button>
    </div>
</template>

<script>
import { defineComponent, ref } from 'vue';
import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';
import 'swiper/css/pagination';
import { Pagination } from 'swiper';

export default defineComponent({
    components: {
        Swiper,
        SwiperSlide,
    },
    setup() {
        return {
            modules: [Pagination],
        };
    },
    data() {
        // show = ref(true)
        return {
            moreArticle: [],
            moreArticle1: [],
            moreArticle2: [],
            moreArticle_list: [],
            articles: [],
            moreCurrent: '',
            moreCurrent1: '',
            moreCurrent2: '',
            isLoaded: ref(false),
            isShowScroll: ref(false),
        }
    },
    methods: {
        getmoreArticle() {
            let existingObj = this;
            const art = []
            if (existingObj.moreArticle.length > 10) {
                for (let i = 0; i < 10; i++) {
                    art.push(existingObj.moreArticle[i])
                }
                existingObj.moreArticle = existingObj.moreArticle.slice(9, existingObj.moreArticle.length);
                return art;
            } else if (existingObj.moreArticle.length < 10) {
                for (let i = 0; i < existingObj.moreArticle.length; i++) {
                    art.push(existingObj.moreArticle[i])
                }
                existingObj.moreArticle = existingObj.moreArticle.slice(existingObj.moreArticle.length);
                return art;
            } else if (existingObj.moreArticle.length == "") {
                return;
            }
            return;
        },
        handleScroll() {
            let existingObj = this;
            if (window.scrollY + window.innerHeight >= document.body.scrollHeight - 50) {
                const new_moreArticle = this.getmoreArticle()
                this.moreArticle_list = [...this.moreArticle_list, ...new_moreArticle]
            }
            if (window.scrollY >= 250) {
                this.isShowScroll = true
            } else {
                this.isShowScroll = false
            }
        },
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
        scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: "smooth"
            });
        }

    },
    async mounted() {

        let existingObj = this;
        let articleName = this.$route.params.article
        let articleId = ''

        if (articleName == 'News') {
            articleId = 1;
            existingObj.moreCurrent = 'News'
            existingObj.moreCurrent1 = 'Announcements'
            existingObj.moreCurrent2 = 'Events'

        } else if (articleName == 'Announcements') {
            articleId = 2;
            existingObj.moreCurrent = 'Annoucements'
            existingObj.moreCurrent1 = 'News'
            existingObj.moreCurrent2 = 'Events'
        } else if (articleName == 'Events') {
            articleId = 3;
            existingObj.moreCurrent = 'Events'
            existingObj.moreCurrent1 = 'News'
            existingObj.moreCurrent2 = 'Annoucements'
        }

        await axios.get(`/api/getmoreArticle/${articleId}`)
            .then(function (response) {
                existingObj.moreArticle = response.data.moreArticle
                existingObj.moreArticle1 = response.data.moreArticle1
                existingObj.moreArticle2 = response.data.moreArticle2
                existingObj.articles = response.data.articles
                existingObj.isLoaded = true;
            })
            .catch(function (error) {
                console.log(error)
            });


        window.addEventListener('scroll', this.handleScroll);
        this.moreArticle_list = this.getmoreArticle();
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