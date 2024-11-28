<template>
    <div class="absolute w-full bg-gradient-to-b from-[#002B5B]"></div>
    <div class="w-full py-5">
        <div class="w-full flex justify-center">
            <div class="laptop:w-3/5  w-11/12 space-y-5">
                <div class="border-2 drop-shadow-lg bg-white p-5">
                    <img class="object-cover w-full" :src="`/img/uploads/${this.article.image}`">
                    <div class=" grid grid-cols-1 divide-y divide-sky-400">
                        <div>
                            <div class="flex justify-end pb-3">
                                <div v-for="project in this.article.projects">
                                    <a-tag @click="gotoProject(project.project_id)" class="cursor-pointer"
                                        color="blue">Project {{ project.project_id }}</a-tag>
                                </div>

                            </div>
                            <p class="text-left lg:text-4xl text-3xl blur-none text-black/80 antialiased block">
                                {{ this.article.title }}
                            </p>
                            <p class="text-left blur-none text-xl mb-5 font-thin text-black/70 antialiased">
                                {{ this.article.date }}
                            </p>
                            <p v-if="this.article.author != null"
                                class="text-justify blur-none mb-5 font-medium tracking-wide antialiased">
                                {{ this.article.author }}
                            </p>
                            <p v-html="this.article.article"
                                class="text-justify blur-none font-medium indent-4 leading-loose tracking-wide antialiased">
                            </p>
                        </div>
                        <div class="mt-5">
                            <p class="text-xl mt-3 blur-none text-black/80 antialiased">
                                Gallery
                            </p>
                            <a-image style="height: 70px" :src="`/img/uploads/${this.article.image}`" :preview="{
                                src: `/img/uploads/${this.article.image}`,
                            }" />
                        </div>
                    </div>
                </div>
                <div class="border-2 drop-shadow-lg bg-white p-5">
                    <p class="font-bold text-2xl">
                        More Article
                    </p>
                    <div class="py-2">
                        <Input v-model="searchValue" search enter-button placeholder="Keyword for title..."
                            @on-search="searchArticle()" />
                    </div>
                    <div class="border-t">
                        <a-list item-layout="vertical" size="small" :pagination="pagination" :data-source="moreArticles"
                            class=" bg-white">
                            <template #renderItem="{ item }" class="p-0">
                                <a-list-item :key="item.title">
                                    <template #extra>
                                        <img :alt="item.title" :src="`/img/uploads/${item.image}`"
                                            class="object-cover rounded-lg shadow-sm h-40 w-64" />
                                    </template>
                                    <a-list-item-meta :description="item.date">
                                        <template #title>
                                            <a @click="gotoArticle(item)" class="line-clamp-1 font-semibold hover:text-blue-600 transition-colors">
                                                {{ item.title }}
                                            </a>
                                        </template>
                                    </a-list-item-meta>
                                    <p class="line-clamp-5 text-gray-600" v-html="item.article"></p>
                                </a-list-item>
                            </template>
                        </a-list>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { defineComponent, ref } from 'vue';
export default defineComponent({
    setup() {
        const pagination = {
            onChange: page => {
                console.log(page);
            },
            pageSize: 3,
        };
        return {
            pagination,
        }
    },
    data() {
        return {
            article: {
                id: '',
                title: '',
                image: '',
                date: '',
                author: '',
                article: '',
                projects: '',
                type: ''
            },
            articles: [],
            projects: [],
            isLoaded: ref(false),
            formSearch: {
                data: '',
            },
            moreArticles: [],
            searchValue: null,
        }
    },
    methods: {
        async searchArticle() {
            const thiss = this;
            thiss.moreArticles = [];
            thiss.formSearch.data = thiss.searchValue
            await axios.post('/api/searchArticle', thiss.formSearch)
                .then(function (response) {
                    thiss.moreArticles = response.data.articles
                    console.log(response.data);
                })
                .catch(function (error) {

                });
        },
        gotoArticle(article) {
            console.log('article: ', article);
            const id = article.id
            const title = article.title
            this.$router.push({ name: 'article', params: { title, id } })
        },
    },
    async created() {
        const thiss = this;
        let id = this.$route.params.id
        await axios.get(`/api/getArticle/${id}`)
            .then(function (response) {
                console.log('article: ', response.data);
                // thiss.projects = response.data.article[0];
                thiss.moreArticles = response.data.articles
                thiss.article.id = response.data.article[0].id
                thiss.article.title = response.data.article[0].title
                thiss.article.image = response.data.article[0].image
                thiss.article.date = response.data.article[0].date
                thiss.article.author = response.data.article[0].author
                thiss.article.article = response.data.article[0].article
                thiss.article.projects = response.data.article[0].articleprojects
                thiss.article.type = response.data.article[0].type
                thiss.isLoaded = true;
            })
            .catch(function (error) {
                console.log(error)
            });
    }
});
</script>

<style scoped>
.sh {
    height: 100%;
}
</style>
