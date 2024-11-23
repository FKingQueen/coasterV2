<template>
    <div>
        <div class="p-2">
            <div class="m-5 border-t-2 bg-white shadow-inner shadow-lg rounded px-10 py-5">
                <div class="flex justify-center text-2xl">
                    Inventory
                </div>
                <div class="mb-2 flex justify-start gap-1">
                    <a-button type="primary" @click="this.$router.push('/admin/inventoryPlatform/addForm')" class="mb-2">New
                        Inventory</a-button>
                    <a-button  @click="showImportModal = !showImportModal">
                        Import File
                    </a-button>
                    <a-modal v-model:open="showImportModal" title="Import File" @ok="handleOk()" :closable="false">
                        <template #footer>
                            <a-button key="back" @click="showImportModal = !showImportModal, handleRemove()">Cancel</a-button>
                            <a-button key="submit" type="primary" 
                            :disabled="fileList.length === 0"
                            :loading="uploading"
                            style="margin-top: 16px"
                            @click="handleUpload()"
                            >{{ uploading ? 'Uploading' : 'Upload' }}</a-button>
                        </template>


                        <a-upload-dragger :file-list="this.fileList" :before-upload="beforeUpload" @remove="handleRemove">
                            <p class="ant-upload-drag-icon">
                            <inbox-outlined></inbox-outlined>
                            </p>
                            <p class="ant-upload-text">Click or drag file to this area to upload</p>
                            <p class="ant-upload-hint p-5">
                                This upload is restricted to specific file extensions. Please ensure that the accepted file extensions are limited to XLSX, CSV, and XLS formats.
                            </p>
                        </a-upload-dragger>

                    </a-modal>


                </div>


                <a-table :data-source="inventories" :columns="columns" size="small" class="drop-shadow-md">

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
                                <a @click="openModal(index)">Details</a>
                                <Modal v-model="modal" :closable="false" :mask-closable="false" :footer-hide="true"
                                    title="Article" width="1000">
                                    <template #header>
                                        <div class="text-center">
                                            <h2>Inventory Details</h2>
                                        </div>
                                    </template>
                                    <div class="flex justify-center">
                                        <Image :src="`/inventory/${modalData.image}`" class="object-fit  border" />
                                    </div>

                                    <div class="py-5">

                                        <p class="text-base"> <span class="font-bold">Coastal Identification:</span> {{
                                            modalData.coastalID }}
                                        </p>
                                        <p class="text-base"> <span class="font-bold">Location:</span> {{ modalData.province
                                        }}</p>
                                        <p class="text-base"> <span class="font-bold">Coastal Protection:</span> {{
                                            modalData.coastalProtection }}</p>
                                        <p class="text-base"> <span class="font-bold">Location:</span> Lat. {{
                                            modalData.latitude }}, Lng {{
                                         modalData.longitude }}</p>
                                        <p class="text-base"> <span class="font-bold">Location Type:</span> {{
                                            modalData.locationType }}</p>
                                        <p class="text-base"> <span class="font-bold">Estimated Yr. of Completed:</span> {{
                                            modalData.yearCompleted }}</p>

                                        <p class="text-base"> <span class="font-bold">Length (m):</span> {{ modalData.length
                                        }}</p>
                                        <p class="text-base"> <span class="font-bold">Height Range (m):</span> {{
                                            modalData.heightRange }}</p>
                                        <p class="text-base"> <span class="font-bold">Primary Material:</span> {{
                                            modalData.primaryMaterial }}
                                        </p>

                                        <p class="text-base"> <span class="font-bold">Condition Rating:</span> {{
                                            modalData.conditionRating }}
                                        </p>
                                        <p class="text-base" v-html="modalData.crDesc"></p>
                                        <p class="text-base"> <span class="font-bold">Priority Rating:</span> {{
                                            modalData.priorityRating }}
                                        </p>
                                        <p class="text-base" v-html="modalData.prDesc"></p>
                                    </div>
                                    <div class="space-x-2 text-right">
                                        <a @click="editForm(modalData.id)">Edit</a>
                                        <a-divider type="vertical" />
                                        <a @click="removeModal()">Done</a>
                                    </div>
                                </Modal>
                                <a-divider type="vertical" />
                                <a-popconfirm v-if="inventories.length" title="Sure to delete?" @confirm="remove(index)">
                                    <a class="hover:text-red-500">Delete</a>
                                </a-popconfirm>
                            </span>
                        </template>

                        <template v-else-if="column.key === 'image'">
                            <a-image style="height: 35px" :src="`/inventory/${record.image}`" :preview="{
                                src: `/inventory/${record.image}`,
                            }" />
                        </template>
                    </template>

                </a-table>

            </div>
        </div>
    </div>
</template>

<script>
import { notification } from 'ant-design-vue';
import { message } from 'ant-design-vue';
import { ImportOutlined, InboxOutlined, SearchOutlined } from '@ant-design/icons-vue';
import { defineComponent, reactive, ref, toRefs } from 'vue';

export default defineComponent({
    components: {
        ImportOutlined,
        InboxOutlined,
        SearchOutlined
    },
    setup() {
        const state = reactive({
            searchText: '',
            searchedColumn: '',
        });
        const searchInput = ref();
        const columns = [
            {
                title: 'Coastal ID',
                dataIndex: 'coastalID',
                key: 'coastalID',
                customFilterDropdown: true,
                onFilter: (value, record) => record.coastalID.toString().toLowerCase().includes(value.toLowerCase()),
                onFilterDropdownOpenChange: visible => {
                    if (visible) {
                        setTimeout(() => {
                            searchInput.value.focus();
                        }, 100);
                    }
                },
            }, {
                title: 'Province',
                dataIndex: 'province',
                key: 'province',
                customFilterDropdown: true,
                onFilter: (value, record) => record.province.toString().toLowerCase().includes(value.toLowerCase()),
                onFilterDropdownOpenChange: visible => {
                    if (visible) {
                        setTimeout(() => {
                            searchInput.value.focus();
                        }, 100);
                    }
                },
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

        //uploads 
        const fileList = ref([]);
        const uploading = ref(false);

        const handleRemove = (file) => {
            const index = fileList.value.indexOf(file);
            const newFileList = fileList.value.slice();
            newFileList.splice(index, 1);
            fileList.value = newFileList;
        }

        const beforeUpload = (file) => {
            // console.log(this.fileList);
            const fL = fileList
            fileList.value = [...fL.value, file];
            return false;
        }

        const handleUpload = () => {
            let existingObj = this;
            console.log("handleUpload");
            const formData = new FormData();
                formData.append('file', fileList.value[0]);
                console.log(fileList.value[0]);
            uploading.value = true;
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.post('/api/admin/importInventory', formData)
                .then(response => {
                    uploading.value = false;
                    message.success(
                        'Good Job!, you successfully imported!',
                        3,
                    );
                    // console.log(showImportModal);
                })
                .catch(error => {
                    console.error('Error uploading file:', error);
                });
            });


        }

        return {
            columns,
            handleSearch,
            handleReset,
            searchInput,
            ...toRefs(state),
            handleRemove,
            beforeUpload,
            handleUpload,
            fileList,
            uploading,
            showImportModal: ref(false),
        }
    },
    data() {
        return {
            modalData: '',
            modal: false,
            inventories: [],
        }
    },
    methods: {
        remove(key) {
            const thiss = this;
            const headers = {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${localStorage.getItem('authToken')}`
            };
            axios.post(`/api/admin/deleteInventory`, { id: thiss.inventories[key].id }, { headers })
                .then(function (response) {
                    thiss.inventories.splice(key, 1);
                    notification.success({
                        message: 'Notification',
                        description: 'The Data is Successfully Deleted',
                    });
                })
                .catch(function (error) {

                    console.log(error);
                });
        },
        async openModal(index) {
            let existingObj = this;
            existingObj.modalData = existingObj.inventories[index]
            this.modal = true;
        },
        editForm(id) {
            this.modal = false;
            this.$router.push({ path: '/admin/inventoryPlatform/editForm/' + id })
        },
        removeModal() {
            this.modal = false;
        },
        // async handleSuccess(res, file) {
        //     let existingObj = this;
        //     axios.get('/api/admin/getInventory')
        //         .then(function (response) {
        //             existingObj.inventories = response.data
        //             notification.success({
        //                 message: 'Notification',
        //                 description: 'New Inventories are Successfully Imported',
        //             });
        //         })
        //         .catch(function (error) {
        //         });


        // },
        handleError(res, file) {
            notification.warning({
                message: 'Notification',
                description: 'Something is wrong, kindly validate the imported Excel file',
            });
        },
        handleFormatError(file) {
            notification.warning({
                message: 'The file format is incorrect',
                description: 'File format of ' + file.name + ' is incorrect, please select jpg or png.'
            });
        },
    },
    async created() {
        let existingObj = this;
        const headers = {
            'Authorization': `Bearer ${localStorage.getItem('authToken')}`
        };
        await axios.get('/api/admin/getInventory', { headers })
            .then(function (response) {
                existingObj.inventories = response.data
            })
            .catch(function (error) {
            });
    }
})
</script>