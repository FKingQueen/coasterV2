<template>
    <div>
        <div class="p-2">
            <div class="m-5 border-t-2 bg-white shadow-inner shadow-lg rounded px-10 py-5">
                <div class="flex justify-center text-2xl">
                    Article
                </div>
                <div class="mb-4 flex justify-start gap-1">
                    <a-button type="primary" @click="this.$router.push('/admin/articlePlatform/addForm')">New
                        Article</a-button>
                </div>

                <a-table :data-source="articles" :loading="false" :columns="columns" size="small"
                    class="drop-shadow-md">
                    <template #headerCell="{ column }">
                        <template v-if="column.key === 'title'">
                            <span style="color: #1890ff">Title</span>
                        </template>

                    </template>
                    <template #customFilterDropdown="{ setSelectedKeys, selectedKeys, confirm, clearFilters, column }">
                        <div style="padding: 8px">
                            <a-input ref="searchInput" :placeholder="`Search ${column.dataIndex}`"
                                :value="selectedKeys[0]" style="width: 188px; margin-bottom: 8px; display: block"
                                @change="e => setSelectedKeys(e.target.value ? [e.target.value] : [])"
                                @pressEnter="handleSearch(selectedKeys, confirm, column.dataIndex)" />
                            <a-button type="primary" size="small" style="width: 90px; margin-right: 8px"
                                @click="handleSearch(selectedKeys, confirm, column.dataIndex)">
                                <template #icon>
                                    <SearchOutlined />
                                </template>
                                Search
                            </a-button>
                            <a-button size="small" style="width: 90px" @click="handleReset(clearFilters)">
                                Reset
                            </a-button>
                        </div>
                    </template>
                    <template #customFilterIcon="{ filtered }">
                        <search-outlined :style="{ color: filtered ? '#108ee9' : undefined }" />
                    </template>
                    <template #bodyCell="{ text, column, record, index }">
                        <span v-if="searchText && searchedColumn === column.dataIndex">
                            <template v-for="(fragment, i) in text
                                .toString()
                                .split(new RegExp(`(?<=${searchText})|(?=${searchText})`, 'i'))">
                                <mark v-if="fragment.toLowerCase() === searchText.toLowerCase()" :key="i"
                                    class="highlight">
                                    {{ fragment }}
                                </mark>
                                <template v-else>{{ fragment }}</template>
                            </template>
                        </span>
                        <template v-else-if="column.key === 'action'">
                            <span>
                                <a @click="openModal(index)">Details</a>
                                <Modal v-model="modal" :closable="false" :mask-closable="false" :footer-hide="true"
                                    title="Article" width="1000">
                                    <template #header>
                                        <div class="text-center">
                                            <h2>Article Details</h2>
                                        </div>
                                    </template>
                                    <div class="flex justify-center">
                                        <Image :src="`/img/uploads/${modalData.image}`" class="object-cover  border" />
                                    </div>

                                    <div>
                                        <div class="w-full text-right mt-4">
                                            <a-tag v-for="project in articles[index].articleprojects" color="blue">Project
                                                {{ project.project_id }}</a-tag>
                                        </div>
                                        <p class="text-xl mt-2 font-semibold">{{ this.modalData.title }}</p>
                                        <p class="text-sm">{{ this.modalData.date }}</p>
                                        <p class=" mt-2" v-if="this.modalData.author != null">By <span class="italic">{{
                                            this.modalData.author }}</span></p>
                                        <p class="indent-8 mt-4 text-justify" v-html="this.modalData.article"></p>
                                    </div>
                                    <div class="space-x-2 text-right">
                                        <a @click="editForm(this.modalData.id)">Edit</a>
                                        <a-divider type="vertical" />
                                        <a @click="removeModal()">Done</a>
                                    </div>
                                </Modal>
                                <a-divider type="vertical" />
                                <a-popconfirm v-if="articles.length" title="Sure to delete?" @confirm="remove(index)">
                                    <a class="hover:text-red-500">Delete</a>
                                </a-popconfirm>
                            </span>
                        </template>
                        <template v-else-if="column.key === 'project'">
                            <a-tag v-for="project in articles[index].articleprojects" color="blue">Project {{
                                project.project_id
                                }}</a-tag>
                        </template>
                        <template v-else-if="column.key === 'typ'">
                            <a-tag color="green">{{ articles[index].type.name }}</a-tag>
                        </template>
                        <template v-else-if="column.key === 'author'">
                            <a-tag v-if="this.articles[index].author == null" color="red">Unavailable</a-tag>
                            <p v-else>{{ articles[index].author }}</p>
                        </template>
                        <template v-else-if="column.key === 'image'">
                            <a-image style="height: 35px" :src="`/img/uploads/${record.image}`"  />
                        </template>
                    </template>

                </a-table>
            </div>
        </div>
    </div>
</template>
modal
<script>
import { notification } from 'ant-design-vue';
import { SearchOutlined } from '@ant-design/icons-vue';
import { defineComponent, reactive, ref, toRefs } from 'vue';

export default defineComponent({
    components: {
        SearchOutlined,
    },
    setup() {
        const state = reactive({
            searchText: '',
            searchedColumn: '',
        });
        const searchInput = ref();
        const columns = [{
            title: 'Title',
            dataIndex: 'title',
            key: 'title',
            customFilterDropdown: true,
            onFilter: (value, record) => record.title.toString().toLowerCase().includes(value.toLowerCase()),
            onFilterDropdownOpenChange: visible => {
                if (visible) {
                    setTimeout(() => {
                        searchInput.value.focus();
                    }, 100);
                }
            },
        }, {
            title: 'Author',
            dataIndex: 'author',
            key: 'author',
            customFilterDropdown: true,
            onFilter: (value, record) => record.author.toString().toLowerCase().includes(value.toLowerCase()),
            onFilterDropdownOpenChange: visible => {
                if (visible) {
                    setTimeout(() => {
                        searchInput.value.focus();
                    }, 100);
                }
            },
        }, {
            title: 'Project Type',
            dataIndex: 'project',
            key: 'project',
            width: 350,
        }, {
            title: 'Article Type',
            dataIndex: 'typ',
            key: 'typ',
            width: 100,
        }, {
            title: 'Image',
            dataIndex: 'image',
            key: 'image',
            width: 200,
        }, {
            title: 'Action',
            key: 'action',
            width: 200,
        }];
        const handleSearch = (selectedKeys, confirm, dataIndex) => {
            confirm();
            state.searchText = selectedKeys[0];
            state.searchedColumn = dataIndex;
        };
        const handleReset = clearFilters => {
            clearFilters({
                confirm: true,
            });
            state.searchText = '';
        };
        return {
            columns,
            handleSearch,
            handleReset,
            searchInput,
            ...toRefs(state),
        }
    },
    data() {
        return {
            modalData: {
                id: '',
                image: '',
                title: '',
                author: '',
                article: ''
            },
            modal: false,
            articles: [],
            token: '',
        }
    },
    methods: {
        remove(key) {
            const thiss = this
            console.log(this.articles);
            const headers = {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${localStorage.getItem('authToken')}`
            };
            axios.post(`/api/admin/deleteArticle`, { id: this.articles[key].id }, { headers })
                .then(function (response) {
                    thiss.articles.splice(key, 1);
                    notification.success({
                        message: 'Notification',
                        description: 'The Article is Successfully Deleted',
                    });
                })
                .catch(function (error) {

                    console.log(error);
                });
        },
        async openModal(index) {
            this.modalData.id = this.articles[index].id;
            this.modalData.title = this.articles[index].title;
            this.modalData.author = this.articles[index].author;
            this.modalData.image = this.articles[index].image;
            this.modalData.article = this.articles[index].article;
            this.modalData.date = this.articles[index].date;
            this.modal = true;
        },
        editForm(id) {
            this.modal = false;
            this.$router.push({ path: '/admin/articlePlatform/editForm/' + id })
        },
        removeModal() {
            this.modal = false;
        }
    },

    async mounted() {
        let existingObj = this;
        const headers = {
            'Authorization': `Bearer ${localStorage.getItem('authToken')}`
        };
        await axios.get('/api/admin/getArticle', { headers })
            .then(function (response) {
                // console.log(response);
                existingObj.articles = response.data

            })
            .catch(function (error) {
                if (error) {
                    this.formValidate.image = image
                }
            });
    }

})

</script>
<style>
.demo-upload-list {
    display: inline-block;
    width: 60px;
    height: 60px;
    text-align: center;
    line-height: 60px;
    border: 1px solid transparent;
    border-radius: 4px;
    overflow: hidden;
    background: #fff;
    position: relative;
    box-shadow: 0 1px 1px rgba(0, 0, 0, .2);
    margin-right: 4px;
}

.demo-upload-list img {
    width: 100%;
    height: 100%;
}

.demo-upload-list-cover {
    display: none;
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(0, 0, 0, .6);
}

.demo-upload-list:hover .demo-upload-list-cover {
    display: block;
}

.demo-upload-list-cover i {
    color: #fff;
    font-size: 20px;
    cursor: pointer;
    margin: 0 2px;
}

img.ant-image-preview-img {
    display: inline-block;
}
</style>