<template>
    <div :class="{ 'h-screen': !isLoaded }">
        <div v-if="isLoaded" class="lg:flex lg:px-0 px-2 justify-center lg:space-x-6 space-x-0 lg:py-10 py-3">
            <div class="lg:w-7/12 sm:w-full h-full drop-shadow-md bg-white">
                <img class="object-cover w-full" :src="`/img/uploads/${this.article.image}`" >
                <div class="lg:p-10 p-5 grid grid-cols-1 divide-y divide-sky-400">
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
                            By {{ this.article.author }}
                        </p>
                        <p v-html="this.article.article"
                            class="text-justify blur-none font-medium indent-8 leading-loose tracking-wide antialiased">
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
            <div class="lg:w-2/12 h-full lg:mt-0 mt-5">
                <p class="text-center text-2xl border-b-2 blur-none antialiased">
                    Other <span class="text-sky-800 ">{{ otherCurrent }}</span>
                </p>
                <div v-for="(other, key) in this.others.slice(0, 5)" class="py-2 drop-shadow-2xl">
                    <div class="h-36 shadow-lg" :style="{ backgroundImage: `url(/img/uploads/${other.image})` }"
                        style="background-repeat: no-repeat; background-size: cover; ">
                        <div @click="gotoArticle(other)"
                            class="cursor-pointer flex items-end w-full h-full bg-[#0d2247]/60">
                            <div class="px-2 w-full">
                                <p class="text-white text-sm p-0 font-thin blur-none antialiased  ">
                                    {{ other.date }}
                                </p>
                                <p class="text-white p-0 font-thin blur-none antialiased ">
                                    {{ other.title }}
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
export default defineComponent({
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
            articles: '',
            projects: [],
            events: [],
            news: [],
            announcements: [],
            others: [],
            otherCurrent: '',
            isLoaded: ref(false)
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
        gotoProject(id) {
            let existingObj = this;
            if (id == 1) {
                this.$router.push('/projects/project1')
            } else if (id == 2) {
                this.$router.push('/projects/project2')
            } else if (id == 3) {
                this.$router.push('/projects/project3')
            } else if (id == 4) {
                this.$router.push('/projects/project4')
            }
        }
    },
    async created() {
        let id = this.$route.params.id
        let existingObj = this;
        await axios.get(`/api/getArticle/${id}`)    
            .then(function (response) {
                existingObj.projects = response.data.article[0];
                existingObj.articles = response.data.articles
                existingObj.article.id = response.data.article[0].id
                existingObj.article.title = response.data.article[0].title
                existingObj.article.image = response.data.article[0].image
                existingObj.article.date = response.data.article[0].date
                existingObj.article.author = response.data.article[0].author
                existingObj.article.article = response.data.article[0].article
                existingObj.article.projects = response.data.article[0].articleprojects
                existingObj.article.type = response.data.article[0].type
                for (let k = 1; k <= 3; k++) {
                    if (existingObj.article.type.id == k) {
                        for (let i = 0; i < existingObj.articles.length; i++) {
                            if (existingObj.articles[i].type_id == k && existingObj.article.id != existingObj.articles[i].id) {
                                existingObj.others.push(existingObj.articles[i]);
                            }
                        }
                    }
                }

                if (existingObj.article.type.id == 1) {
                    existingObj.otherCurrent = 'News'
                } else if (existingObj.article.type.id == 2) {
                    existingObj.otherCurrent = 'Announcements'
                } else if (existingObj.article.type.id == 3) {
                    existingObj.otherCurrent = 'Events'
                }
                existingObj.isLoaded = true;
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
