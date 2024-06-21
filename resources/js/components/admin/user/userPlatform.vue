<template>
    <div class="p-2">
        <div class="m-5 border-t-2 bg-white shadow-inner shadow-lg rounded px-10 py-5">
            <div class="flex justify-center text-2xl">
                User Management
            </div>
            <a-button type="primary" @click="this.$router.push('/admin/userPlatform/addForm')" class="mb-4">New
                User</a-button>

            <a-table :data-source="users" :columns="columns" size="small" class="drop-shadow-md">
                <template #headerCell="{ column }">
                    <template v-if="column.key === 'name'">
                        <span style="color: #1890ff">Title</span>
                    </template>
                </template>
                <template #customFilterDropdown="{ setSelectedKeys, selectedKeys, confirm, clearFilters, column }">
                    <div style="padding: 8px">
                        <a-input ref="searchInput" :placeholder="`Search ${column.dataIndex}`" :value="selectedKeys[0]"
                            style="width: 188px; margin-bottom: 8px; display: block"
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
                            <mark v-if="fragment.toLowerCase() === searchText.toLowerCase()" :key="i" class="highlight">
                                {{ fragment }}
                            </mark>
                            <template v-else>{{ fragment }}</template>
                        </template>
                    </span>
                    <template v-else-if="column.key === 'action'">
                        <span>
                            <a @click="editForm(record.id)">Edit</a>

                            <a-divider type="vertical" />
                            <a-popconfirm v-if="users.length" title="Sure to delete?" @confirm="remove(index)">
                                <a class="hover:text-red-500">Delete</a>
                            </a-popconfirm>
                        </span>
                    </template>
                    <template v-else-if="column.key === 'userType'">
                        <span v-if="this.users[index].role_id == 1">
                            Admin
                        </span>
                        <span v-else>
                            Editor
                        </span>
                    </template>
                </template>

            </a-table>

        </div>
    </div>
</template>
<script>
import { notification } from 'ant-design-vue';
import { SearchOutlined } from '@ant-design/icons-vue';
import { defineComponent, reactive, onMounted, ref, toRefs } from 'vue';
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
            title: 'Name',
            dataIndex: 'name',
            key: 'name',
            customFilterDropdown: true,
            onFilter: (value, record) => record.name.toString().toLowerCase().includes(value.toLowerCase()),
            onFilterDropdownOpenChange: visible => {
                if (visible) {
                    setTimeout(() => {
                        searchInput.value.focus();
                    }, 100);
                }
            },
        }, {
            title: 'User Type',
            dataIndex: 'userType',
            key: 'userType',
        }, {
            title: 'Email',
            dataIndex: 'email',
            key: 'email',
            customFilterDropdown: true,
            onFilter: (value, record) => record.email.toString().toLowerCase().includes(value.toLowerCase()),
            onFilterDropdownOpenChange: visible => {
                if (visible) {
                    setTimeout(() => {
                        searchInput.value.focus();
                    }, 100);
                }
            },
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
    methods: {
        remove(key) {
            let id = this.users[key].id;
            this.users.splice(key, 1);

            axios.post(`/api/deleteUser/${id}`)
                .then(function (response) {
                    notification.success({
                        message: 'Notification',
                        description: 'The User is Successfully Deleted',
                    });
                })
                .catch(function (error) {

                    console.log(error);
                });
        },
        editForm(id) {
            // console.log(id);
            this.$router.push({ path: '/admin/userPlatform/editForm/' + id })
        },
    },
    data() {
        return {
            users: []
        }
    },
    async created() {
        let existingObj = this;
        const headers = {
            'Authorization': `Bearer ${localStorage.getItem('authToken')}`
        };
        await axios.get('/api/admin/getUser', { headers })
            .then(function (response) {
                existingObj.users = response.data
            })
            .catch(function (error) {
                if (error) {
                    this.formValidate.image = image
                }
            });
    },

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