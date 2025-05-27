<template>
    <div>
        <div class="m-5">
            <div class="flex justify-center lg:text-2xl text-lg pb-2">
                DOWNLOADS
            </div>
            <div class=" border-t-2 bg-white drop-shadow-md rounded lg:px-10 py-5">

                <a-table :data-source="download" :columns="columns" size="small" class="drop-shadow-md"
                    :expanded-row-keys="expandedRowKeys" @expand="onExpandRow">
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
                    <template #bodyCell="{ text, column, index }">
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
                                <a @click="openModal(index)">Email</a>
                                <Modal v-model="downloadModal" :closable="false" :mask-closable="false"
                                    :footer-hide="true" title="Article" width="1000">
                                    <template #header>
                                        <div class="text-center">
                                            <h2>Compose Email</h2>
                                        </div>
                                    </template>
                                    <div>
                                        <Form ref="formValidate" :model="formValidate" :rules="ruleValidate"
                                            label-position="top" class="space-y-5">
                                            <div class="w-full bg-gray-200 p-2 rounded-md ">
                                                <div class="justify-around flex">
                                                    <p>
                                                        <span class="text-bold">Name: </span>
                                                        {{ modalData.name }}
                                                    </p>
                                                    <p>
                                                        <span class="text-bold">To: </span>
                                                        {{ modalData.email }}
                                                    </p>
                                                </div>
                                            </div>
                                            <FormItem label="Subject" prop="subject">
                                                <Input v-model="formValidate.subject"
                                                    placeholder="Write Subject"></Input>
                                            </FormItem>
                                            <FormItem label="Body" prop="body">
                                                <ckeditor :editor="editor" v-model="formValidate.body"
                                                    :config="editorConfig" placeholder="Write Body">
                                                </ckeditor>
                                            </FormItem>
                                            <FormItem label="Attachments" prop="attachments">
                                                <Upload type="drag" ref="uploads"
                                                    :headers="{ 'Authorization': `Bearer ${token}` }"
                                                    :on-success="handleSuccess" :on-error="handleError"
                                                    :on-format-error="handleFormatError"
                                                    action="/api/admin/uploadDownload">
                                                    <div style="padding: 20px 0">
                                                        <Icon type="ios-cloud-upload" size="52" style="color: #3399ff">
                                                        </Icon>
                                                        <p>Click or drag files here to upload</p>
                                                    </div>
                                                </Upload>
                                            </FormItem>
                                            <div class="space-x-2 text-right">
                                                <div v-if="loading == false">
                                                    <a @click="cancelEmail()">Cancel</a>
                                                    <a-divider type="vertical" />
                                                    <a @click="handleSubmit('formValidate', modalKey)">Send</a>
                                                </div>
                                                <div v-else class="flex justify-end space-x-1">
                                                    <p>Sending...</p>
                                                    <a-spin />
                                                </div>
                                            </div>
                                        </Form>
                                    </div>

                                </Modal>
                                <a-divider type="vertical" />
                                <a-popconfirm v-if="download.length" title="Sure to delete?" @confirm="remove(index)">
                                    <a class="hover:text-red-500">Delete</a>
                                </a-popconfirm>
                            </span>
                        </template>
                    </template>
                    <template #expandedRowRender="{ record }">
                        <p style="margin: 0">
                            {{ record.purpose }}
                        </p>
                    </template>
                    <template #expandColumnTitle>
                        <span style="color: red">Purpose</span>
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
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

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
                title: 'Address',
                dataIndex: 'address',
                key: 'address',
                customFilterDropdown: true,
                onFilter: (value, record) => record.address.toString().toLowerCase().includes(value.toLowerCase()),
                onFilterDropdownOpenChange: visible => {
                    if (visible) {
                        setTimeout(() => {
                            searchInput.value.focus();
                        }, 100);
                    }
                },
            }, {
                title: 'Agency',
                dataIndex: 'agency',
                key: 'agency',
                customFilterDropdown: true,
                onFilter: (value, record) => record.agency.toString().toLowerCase().includes(value.toLowerCase()),
                onFilterDropdownOpenChange: visible => {
                    if (visible) {
                        setTimeout(() => {
                            searchInput.value.focus();
                        }, 100);
                    }
                },
            }, {
                title: 'Action',
                key: 'action'
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
            ...toRefs(state),

        }
    },
    data() {
        return {
            loading: false,
            download: [],
            expandedRowKeys: [], // Add this line
            uploadList: [],
            downloadModal: false,
            modalKey: null,
            token: '',
            modalData: '',
            formValidate: {
                id: null,
                recipient: '',
                subject: '',
                body: '',
                attachments: '',
            },
            ruleValidate: {
                subject: [
                    { required: true, message: 'The subject cannot be empty', trigger: 'blur' }
                ],
                body: [
                    { required: true, message: 'The body cannot be empty', trigger: 'blur' }
                ],
                attachments: [
                    { required: true, message: 'The attachments cannot be empty', trigger: 'blur' }
                ],
            },
            editor: ClassicEditor,
            editorConfig: {
                toolbar: {
                    items: [
                        'undo', 'redo',
                        '|', 'heading',
                        '|', 'bold', 'italic',
                        '|', 'link', 'blockQuote',
                        '|', 'bulletedList', 'numberedList', 'outdent', 'indent'
                    ]
                }
            }
        }
    },
    methods: {
        async handleSubmit(name, index) {
            let thiss = this;
            const headers = {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${localStorage.getItem('authToken')}`
            };
            this.$refs[name].validate((valid) => {
                if (valid) {
                    thiss.formValidate.attachments = thiss.uploadList;
                    thiss.loading = true;
                    axios.post(`/api/admin/sendEmail`, this.formValidate, { headers })
                        .then(function (response) {
                            if (response.status == 200) {
                                thiss.loading = false;
                                thiss.download.splice(index, 1);
                                thiss.downloadModal = false;
                                // Notification
                                notification.success({
                                    message: 'Notification',
                                    description: 'Transaction complete. Check your email for verification and further details regarding the transaction.',
                                });
                            }
                        })
                        .catch(function (error) {

                        });

                } else {
                }
            })

        },
        onExpandRow(expanded, record) {
            if (expanded) {
                this.expandedRowKeys = [record.key];
            } else {
                this.expandedRowKeys = [];
            }
        },
        openModal(index) {
            let thiss = this;
            thiss.downloadModal = true;
            thiss.modalData = this.download[index];
            thiss.modalKey = index
            thiss.formValidate.recipient = this.download[index].email;
            thiss.formValidate.id = this.download[index].id;
        },
        handleSuccess(res, file) {
            let thiss = this;
            thiss.uploadList.push(res)
            if (thiss.uploadList.length != 0) {
                thiss.formValidate.attachments = thiss.uploadList[0];
            }
        },
        handleError(res, file) {
            console.log('res', res);
        },
        handleFormatError(file) {
            notification.warning({
                message: 'The file format is incorrect',
                description: 'File format of ' + file.name + ' is incorrect, please select jpg or png.'
            });
        },
        cancelEmail() {
            let thiss = this;
            thiss.downloadModal = false;
            thiss.uploadList = [];
            this.$refs.uploads.clearFiles();
        }
    },
    async created() {
        let thiss = this;
        this.token = localStorage.getItem('authToken')
        const headers = {
            'Authorization': `Bearer ${localStorage.getItem('authToken')}`
        };
        await axios.get('/api/admin/getDownload', { headers })
            .then(function (response) {
                thiss.download = response.data.map((item, index) => ({
                    ...item,
                    key: index.toString(), // Add a unique key if not present
                }));
                console.log('data: ', response);
            })
            .catch(function (error) {
                // Handle error
            });
    }
})
</script>
