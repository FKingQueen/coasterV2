<template>
    <div class="laptop:p-5 p-1 space-y-5">
        <div>
            <div class="w-fit">
                <p class="text-2xl text-bold cursor-pointer hover:underline" @click="$router.push('/morearticle')">
                    Articles
                </p>
            </div>
            <div class="border-2 rounded drop-shadow-lg">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-1 ">
                    <a-list item-layout="vertical" size="large" :data-source="leftArticles" class="p-0">
                        <template #renderItem="{ item }" class="p-0">
                            <a-list-item :key="item.title">
                                <template #extra>
                                    <img :alt="item.title" :src="`/img/uploads/${item.image}`"
                                        class="object-cover laptop:flex hidden rounded-lg shadow-sm h-40 w-64" />
                                </template>
                                <a-list-item-meta>
                                    <template #title>
                                        <a @click="gotoArticle(item)"
                                            class="line-clamp-1 font-semibold hover:text-blue-600 transition-colors">
                                            {{ item.title }}
                                        </a>
                                    </template>
                                    <template #description>
                                        <span>{{ item.date }} </span>
                                    </template>
                                </a-list-item-meta>
                                <p class="line-clamp-4 text-gray-600" v-html="item.article"></p>
                            </a-list-item>
                        </template>
                    </a-list>
                    <a-list item-layout="vertical" size="large" :data-source="rightArticles" class="p-0">
                        <template #renderItem="{ item }" class="p-0">
                            <a-list-item :key="item.title">
                                <template #extra>
                                    <img :alt="item.title" :src="`/img/uploads/${item.image}`"
                                        class="object-cover laptop:flex hidden rounded-lg shadow-sm h-40 w-64" />
                                </template>
                                <a-list-item-meta :description="item.date">
                                    <template #title>
                                        <a class="line-clamp-1  font-semibold hover:text-blue-600 transition-colors">
                                            {{ item.title }}
                                        </a>
                                    </template>
                                </a-list-item-meta>
                                <p class="line-clamp-4 text-gray-600" v-html="item.article"></p>
                            </a-list-item>
                        </template>
                    </a-list>
                </div>
            </div>

        </div>
        <div class="w-full">
            <p class="text-2xl text-bold">Videos</p>
            <div class="sm:flex  justify-around lg:space-y-0 space-y-2 lg:space-x-2 space-x-0">
                <iframe :width="innerWidth" class="laptop:h-[360px] h-[250px] w-screen"
                    src="https://www.youtube.com/embed/C7ZEzkKpxZs?rel=0" title="MMSU COASTER" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
                </iframe>
                <iframe :width="innerWidth" class="laptop:h-[360px] h-[250px] w-screen"
                    src="https://www.youtube.com/embed/fre6VqZIYxk?rel=0"
                    title="Coastal Engineering and Management Research and Development Center - MMSU" frameborder="0"
                    allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
                </iframe>
            </div>
        </div>
    </div>
</template>

<script>
// import { ref, computed, onMounted } from 'vue';
// import axios from 'axios';

import { defineComponent, ref, reactive, toRefs, watch } from 'vue';

export default defineComponent({
    data() {
        return {
            leftArticles: [],
            rightArticles: [],
            moreArticles: [],
            innerWidth: window.innerWidth - 10,
        }
    },
    methods: {
        moreArticle() {
            this.$router.push({ name: 'moreArticle' })
        },
        gotoArticle(article) {
            const id = article.id
            const title = article.title
            this.$router.push({ name: 'article', params: { title, id } })
        },
    },
    async created() {
        const thiss = this
        await axios.get('/api/getArticles')
            .then(function (response) {
                thiss.moreArticles = response.data;
                thiss.leftArticles = thiss.moreArticles.slice(0, 3);
                thiss.moreArticles = response.data;
                thiss.rightArticles = thiss.moreArticles.slice(3, 6);
            })
            .catch(function (error) {
                console.log(error)
            });
    }
})

// // State
// const articles = ref([]);
// const isLoading = ref(false);
// const error = ref(null);

// // Computed property to split articles into two columns
// const splitArticles = computed(() => {
//     console.log('testing');
//     const midPoint = Math.ceil(articles.value.length / 2);
//     return [
//         articles.value.slice(0, midPoint),
//         articles.value.slice(midPoint)
//     ];
// });

// // Format article data
// const formatArticleData = (rawArticle) => ({
//     title: rawArticle.title,
//     description: `${rawArticle.type.name} | ${rawArticle.date}`,
//     content: rawArticle.article,
//     imgURL: rawArticle.image,
// });

// // Fetch articles
// const fetchArticles = async () => {
//     try {
//         isLoading.value = true;
//         const response = await axios.get('/api/getArticles');
//         articles.value = response.data.map(formatArticleData);
//     } catch (err) {
//         error.value = 'Failed to load articles';
//         console.error('Error fetching articles:', err);
//     } finally {
//         isLoading.value = false;
//     }
// };

// // Fetch data on component mount
// onMounted(() => {
//     fetchArticles();
// });
</script>

<style scoped>
.grid {
    --tw-space-x-reverse: 0;
    margin-right: calc(1.5rem * var(--tw-space-x-reverse));
    margin-left: calc(1.5rem * (1 - var(--tw-space-x-reverse)));
}

@media (max-width: 768px) {
    .grid {
        margin-right: 0;
        margin-left: 0;
    }
}
</style>
