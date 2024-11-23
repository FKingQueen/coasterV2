<template>
    <div class="absolute w-full min-h-[800px] bg-gradient-to-b from-[#002B5B]"></div>
    <div class="w-full  pt-8 min-h-[800px]">
        <div class="w-full justify-center flex pb-5">
            <div class=" w-3/4 text-center">
                <p class="text-2xl text-semibold text-white">Article</p>
            </div>
        </div>
        <div class="w-full justify-center flex">
            <div class="w-3/5">
                <Input v-model="searchValue" search enter-button placeholder="Keyword for title..." size="large" @on-search="searchArticle()"/>
            </div>
        </div>
        <div class="w-full justify-center flex my-5">
            <div class="w-3/4">
                <div class="border-2 drop-shadow-lg">
                    <a-list item-layout="vertical" size="small" :pagination="pagination" :data-source="moreArticles"
                        class="pt-3 pb-5 px-3 bg-white">
                        <template #renderItem="{ item }" class="p-0">
                            <a-list-item :key="item.title">
                                <template #extra>
                                    <img :alt="item.title" :src="`/img/uploads/${item.image}`"
                                        class="object-cover rounded-lg shadow-sm h-40 w-64" />
                                </template>
                                <a-list-item-meta :description="item.description">
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
</template>

<script>
import { defineComponent } from 'vue';

export default defineComponent({
    components: {
    },
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
        await axios.get('/api/getArticles')
            .then(function (response) {
                thiss.moreArticles = response.data;
                console.log(thiss.moreArticles);
            })
            .catch(function (error) {
                console.log(error)
            });
    }
})
</script>

<style scoped></style>