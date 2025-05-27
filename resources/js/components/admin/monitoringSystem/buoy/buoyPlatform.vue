<template>
    <div class="m-5">
        <div class="flex justify-center lg:text-2xl text-lg pb-2">
            BUOY MONITORING SYSTEM
        </div>
        <div class=" border-t-2 bg-white drop-shadow-md rounded lg:px-10 py-5">
            <div class="w-full flex justify-around ">
                <div class="w-1/2 p-5">
                    <div class="w-full border">
                        <Buoy class="w-full p-3" :id="1" />
                    </div>
                </div>
                <div class="w-1/2 p-5">
                    <div class="w-full border">
                        <Buoy class="w-full p-3" :id="2" />
                    </div>
                </div>
            </div>

            <a-table :data-source="this.buoyData" :columns="columns" size="small" class="drop-shadow-md">

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
                            <a-popconfirm title="Sure to delete?" @confirm="remove(index)">
                                <a class="hover:text-red-500">Delete</a>
                            </a-popconfirm>
                        </span>
                    </template>
                </template>

            </a-table>

        </div>
    </div>
</template>
modal
<script>
import Buoy from './buoy';
import { notification } from 'ant-design-vue';
import { SearchOutlined } from '@ant-design/icons-vue';
import { defineComponent, reactive, ref, toRefs } from 'vue';

export default defineComponent({
    components: {
        SearchOutlined,
        Buoy
    },
    setup() {
        const state = reactive({
            searchText: '',
            searchedColumn: '',
        });
        const searchInput = ref();
        const columns = [
            {
                title: 'Buoy ID',
                dataIndex: 'buoy_id',
                key: 'buoy_id',
                customFilterDropdown: true,
                onFilter: (value, record) => record.buoy_id.toString().toLowerCase().includes(value.toLowerCase()),
                onFilterDropdownOpenChange: visible => {
                    if (visible) {
                        setTimeout(() => {
                            searchInput.value.focus();
                        }, 100);
                    }
                },
            }, {
                title: 'Wave Height',
                dataIndex: 'wave_height',
                key: 'wave_height',
                customFilterDropdown: true,
                onFilter: (value, record) => record.wave_height.toString().toLowerCase().includes(value.toLowerCase()),
                onFilterDropdownOpenChange: visible => {
                    if (visible) {
                        setTimeout(() => {
                            searchInput.value.focus();
                        }, 100);
                    }
                },
            }, {
                title: 'Tide Height',
                dataIndex: 'tide_height',
                key: 'tide_height',
                customFilterDropdown: true,
                onFilter: (value, record) => record.tide_height.toString().toLowerCase().includes(value.toLowerCase()),
                onFilterDropdownOpenChange: visible => {
                    if (visible) {
                        setTimeout(() => {
                            searchInput.value.focus();
                        }, 100);
                    }
                },
            }, {
                title: 'Wave Period',
                dataIndex: 'wave_period',
                key: 'wave_period',
                customFilterDropdown: true,
                onFilter: (value, record) => record.wave_period.toString().toLowerCase().includes(value.toLowerCase()),
                onFilterDropdownOpenChange: visible => {
                    if (visible) {
                        setTimeout(() => {
                            searchInput.value.focus();
                        }, 100);
                    }
                },
            }, {
                title: 'Wave Power',
                dataIndex: 'wave_power',
                key: 'wave_power',
                customFilterDropdown: true,
                onFilter: (value, record) => record.wave_power.toString().toLowerCase().includes(value.toLowerCase()),
                onFilterDropdownOpenChange: visible => {
                    if (visible) {
                        setTimeout(() => {
                            searchInput.value.focus();
                        }, 100);
                    }
                },
            }, {
                title: 'Wave Temperature',
                dataIndex: 'wave_temperature',
                key: 'wave_temperature',
                customFilterDropdown: true,
                onFilter: (value, record) => record.wave_temperature.toString().toLowerCase().includes(value.toLowerCase()),
                onFilterDropdownOpenChange: visible => {
                    if (visible) {
                        setTimeout(() => {
                            searchInput.value.focus();
                        }, 100);
                    }
                },
            }, {
                title: 'Air Temperature',
                dataIndex: 'air_temperature',
                key: 'air_temperature',
                customFilterDropdown: true,
                onFilter: (value, record) => record.air_temperature.toString().toLowerCase().includes(value.toLowerCase()),
                onFilterDropdownOpenChange: visible => {
                    if (visible) {
                        setTimeout(() => {
                            searchInput.value.focus();
                        }, 100);
                    }
                },
            }, {
                title: 'Date',
                dataIndex: 'date',
                key: 'date',
                customFilterDropdown: true,
                onFilter: (value, record) => record.date.toString().toLowerCase().includes(value.toLowerCase()),
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
                width: 150,
            }
        ];

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
            ...toRefs(state)
        }
    },
    methods: {
        remove(key) {
            const thiss = this
            const headers = {
                'Authorization': `Bearer ${localStorage.getItem('authToken')}`
            };
            axios.post(`/api/admin/deleteBMSData`, { id: thiss.buoyData[key].id }, { headers })
                .then(function (response) {
                    thiss.buoyData.splice(key, 1);
                    notification.success({
                        message: 'Notification',
                        description: 'The Data is Successfully Deleted',
                    });
                })
                .catch(function (error) {

                    console.log(error);
                });
        },
    },

    data() {
        return {
            token: '',
            buoyData: []
        }
    },
    async mounted() {
        let existingObj = this;
        const headers = {
            'Authorization': `Bearer ${localStorage.getItem('authToken')}`
        };
        await axios.get('/api/admin/getBMSData', { headers })
            .then(function (response) {
                // console.log(response.data);
                existingObj.buoyData = response.data
            })
            .catch(function (error) {
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
