<template>
    <div :class="{ 'h-screen': !isLoaded }">
        <div v-if="isLoaded" class="w-full flex justify-center space-x-7">
            <div class="lg:w-7/12 md:w-10/12 w-full lg:px-0 px-2 pt-10">
                <div class="w-full border-b-2 border-sky-300">
                    <p class="text-4xl text-left blur-none ">Search Result for "<span class="text-sky-800">{{
                        this.$route.params.search }}</span>"</p>
                </div>
                <div class="w-full pt-10">
                    <div class="w-full">
                        <div v-for="(searched, key) in this.searchArticleList"
                            class="flex block border-b-2 border-sky-900/60 pb-3 mb-5">
                            <img @click="gotoArticle(searched)"
                                class="cursor-pointer bg-sky-200 object-cover object-center blur-none w-24 h-24 "
                                :src="`/img/uploads/${searched.image}`">
                            <div class="block w-fit px-1 overflow-hidden">
                                <p @click="gotoArticle(searched)"
                                    class="cursor-pointer text-sm blur-none antialiased font-semibold text-sky-600  truncate">
                                    {{ searched.title }}</p>
                                <p class="text-xs blur-none"> {{ searched.type.name }} | {{ searched.date }}</p>
                                <p class="blur-none antialiased text-xs text-justify line-clamp-3 leading-relaxed">By {{
                                    searched.author }}, {{ searched.article }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-2/12 pt-10 hidden lg:block">
                <div>
                    <div class="bg-sky-600/60 border-b-2 border-sky-900 py-2">
                        <p class="text-xl text-center">
                            Latest <span class="text-sky-900">News</span>
                        </p>
                    </div>
                    <div class="border-b-2" v-for="(news, key) in this.newsArticle.slice(0, 5)">
                        <p @click="gotoArticle(news)" class="text-sm font-thin tracking-wide text-sky-700 cursor-pointer">{{
                            news.title }}</p>
                        <p class="text-xs font-thin tracking-wide">News | {{ news.date }}</p>
                    </div>
                    <p @click="gotoMoreArticle('News')" class="text-center text-lg p-5 cursor-pointer">
                        VIEW MORE
                    </p>
                </div>

                <div>
                    <div class="bg-sky-600/60 border-b-2 border-sky-900 py-2">
                        <p class="text-xl text-center">
                            Latest <span class="text-sky-900">Announcements</span>
                        </p>
                    </div>
                    <div class="border-b-2" v-for="(annoucements, key) in this.announcementsArticle.slice(0, 5)">
                        <p @click="gotoArticle(annoucements)"
                            class="text-sm font-thin tracking-wide text-sky-700 cursor-pointer">{{ annoucements.title }}</p>
                        <p class="text-xs font-thin tracking-wide">Announcements | {{ annoucements.date }}</p>
                    </div>
                    <p @click="gotoMoreArticle('Announcements')" class="text-center text-lg p-5 cursor-pointer">
                        VIEW MORE
                    </p>
                </div>

                <div>
                    <div class="bg-sky-600/60 border-b-2 border-sky-900 py-2">
                        <p class="text-xl text-center">
                            Latest <span class="text-sky-900">Events</span>
                        </p>
                    </div>
                    <div class="border-b-2" v-for="(events, key) in this.eventsArticle.slice(0, 5)">
                        <p @click="gotoArticle(events)" class="text-sm font-thin tracking-wide text-sky-700 cursor-pointer">
                            {{ events.title }}</p>
                        <p class="text-xs font-thin tracking-wide">Events | {{ events.date }}</p>
                    </div>
                    <p @click="gotoMoreArticle('Events')" class="text-center text-lg p-5 cursor-pointer">
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
import { defineComponent, ref, reactive, toRefs, watch } from 'vue';

export default defineComponent({
    data() {
        return {
            formSearch: {
                data: '',
            },
            isLoaded: ref(false),
            searchArticle: [],
            searchArticleList: [],
            newsArticle: [],
            announcementsArticle: [],
            eventsArticle: [],
            isShowScroll: ref(false),
            isShowScroll: ref(false),
        }
    },
    methods: {
        getSearchArticle() {
            let existingObj = this;
            const art = []
            if (existingObj.searchArticle.length > 10) {
                for (let i = 0; i < 10; i++) {
                    art.push(existingObj.searchArticle[i])
                }
                existingObj.searchArticle = existingObj.searchArticle.slice(9, existingObj.searchArticle.length);
                return art;
            } else if (existingObj.searchArticle.length < 10) {
                for (let i = 0; i < existingObj.searchArticle.length; i++) {
                    art.push(existingObj.searchArticle[i])
                }
                existingObj.searchArticle = existingObj.searchArticle.slice(existingObj.searchArticle.length);
                return art;
            } else if (existingObj.searchArticle.length == "") {
                return;
            }
            return;
        },
        handleScroll() {
            let existingObj = this;
            if (window.scrollY + window.innerHeight >= document.body.scrollHeight - 50) {
                const new_searchArticle = this.getSearchArticle()
                this.searchArticleList = [...this.searchArticleList, ...new_searchArticle]
            }
            if (window.scrollY >= 250) {
                this.isShowScroll = true
            } else {
                this.isShowScroll = false
            }
        },
        gotoArticle(article) {
            const id = article.id
            const title = article.type.name
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
        existingObj.formSearch.data = this.$route.params.search
        await axios.post('/api/searchArticle', existingObj.formSearch)
            .then(function (response) {
                existingObj.searchArticle = response.data.articles;
                existingObj.newsArticle = response.data.newsArticle;
                existingObj.announcementsArticle = response.data.announcementsArticle;
                existingObj.eventsArticle = response.data.eventsArticle;
                existingObj.isLoaded = true;

            })
            .catch(function (error) {

            });

        window.addEventListener('scroll', this.handleScroll);
        this.searchArticleList = this.getSearchArticle();
    }
})
</script>
<!-- searchedCurrent -->