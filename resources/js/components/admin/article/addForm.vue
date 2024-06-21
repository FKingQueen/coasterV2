<template>
    <div>
        <div class="p-2">
            <div class="m-5 border-t-2 bg-white shadow-inner shadow-lg rounded px-10 py-5">
                <div class=" ml-2 flex justify-start gap-1">
                    <Breadcrumb separator=">">
                        <BreadcrumbItem to="/admin/articlePlatform">Article Management</BreadcrumbItem>
                        <BreadcrumbItem>New Article Form</BreadcrumbItem>
                    </Breadcrumb>
                </div>
                <div class="mb-2 flex justify-start gap-1">
                    <a-button @click="this.$router.push('/admin/articlePlatform')" class="my-3">Back</a-button>
                </div>

                <Form ref="formValidate" :model="formValidate" :rules="ruleValidate" label-position="top" class="">
                    <div class="w-full bg-[#abdcff]/80 lg:pb-0 pb-1 px-1 lg:px-0 pt-5">
                        <div class=" w-full lg:flex gap-5 px-10">
                            <FormItem label="Project" class="w-full lg:w-2/4">
                                <Select v-model="formValidate.projectValue" multiple style="width: 100%"
                                    placeholder="Select Project">
                                    <Option v-for="item in projectOptions" :value="item.value" :key="item.value">{{
                                        item.label }}
                                    </Option>
                                </Select>
                            </FormItem>
                            <FormItem label="Article Type" prop="typeValue" class="w-full lg:w-2/4">
                                <Select :on-change="onChangeArticleType()" v-model="formValidate.typeValue"
                                    style="width:100%" placeholder="Article Type">
                                    <Option v-for="item in typeOptions" :value="item.value" :key="item.value">{{
                                        item.label }}</Option>
                                </Select>
                            </FormItem>
                        </div>
                    </div>

                    <div class="w-full px-10">
                        <FormItem label="Title" prop="title" class="pt-5">
                            <Input v-model="formValidate.title" placeholder="Enter Title"></Input>
                        </FormItem>

                        <FormItem v-if="isShowAuthor" label="Author" prop="author">
                            <Input v-model="formValidate.author" placeholder="Enter Author"></Input>
                        </FormItem>

                        <FormItem label="Image" prop="image">
                            <Upload type="drag" ref="uploads" :headers="{ 'Authorization': `Bearer ${token}` }"
                                :on-success="handleSuccess" :on-error="handleError" :format="['jpg', 'jpeg', 'png']"
                                :on-format-error="handleFormatError" action="/api/admin/upload">
                                <div style="padding: 20px 0">
                                    <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
                                    <p>Click or drag files here to upload</p>
                                </div>
                            </Upload>
                            <ImagePreview v-model="visiblePreview"
                                :preview-list="[`/img/uploads/${formValidate.image}`]" />
                            <div v-if="formValidate.image" class="demo-upload-list">
                                <Image :src="`/img/uploads/${formValidate.image}`" fit="cover" width="100%"
                                    height="100%" />
                                <div class="demo-upload-list-cover">
                                    <Icon type="ios-eye-outline" @click="handleView()"></Icon>
                                    <Icon type="ios-trash-outline" @click="deleteImage"></Icon>
                                </div>
                            </div>
                        </FormItem>

                        <FormItem label="Content" prop="article">
                            <ckeditor :editor="editor" v-model="formValidate.article" :config="editorConfig"
                                placeholder="Write Article"></ckeditor>
                        </FormItem>
                    </div>

                    <div class="flex justify-end px-20">
                        <a-button key="submit" type="primary" @click="handleSubmit('formValidate')">Submit</a-button>
                    </div>
                </Form>
            </div>
        </div>
    </div>
</template>

<script>
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import { defineComponent, ref, watch } from 'vue';
import { notification } from 'ant-design-vue';

export default defineComponent({
    setup() {
        const projectOptions = ref([{
            value: '1',
            label: 'Project 1 : Coastal Erosion Trends and Management Strategies for Region 1',
        }, {
            value: '2',
            label: 'Project 2 : Assesment Monitoring, and Prediction of Coastal Flooding of Selected Municipalities in Region 1',
        }, {
            value: '3',
            label: 'Project 3 : Development of Science-based Engineering Approach to Coastal Prediction in Region 1',
        }, {
            value: '4',
            label: 'Project 4 : Enhancing Coastal Design and Infrastructure Intervention through the Establishment of Wave Testing Facility',
        }]);

        const typeOptions = ref([{
            value: '1',
            label: 'News',
        }, {
            value: '2',
            label: 'Announcement',
        }, {
            value: '3',
            label: 'Event',
        }]);

        const filterOption = (input, option) => {
            return option.value.toLowerCase().indexOf(input.toLowerCase()) >= 0;
        };

        return {
            projectOptions,
            filterOption,
            typeOptions,
            isShowAuthor: ref(false),
        };
    },

    data() {
        return {
            token: '',
            visiblePreview: false,
            formValidate: {
                image: '',
                projectValue: '',
                typeValue: '',
                title: '',
                author: '',
                article: ''
            },
            ruleValidate: {
                image: [
                    { required: true, message: 'The image cannot be empty', trigger: 'blur' }
                ],
                typeValue: [
                    { required: true, message: 'The type cannot be empty', trigger: 'blur' }
                ],
                title: [
                    { required: true, message: 'The title cannot be empty', trigger: 'blur' }
                ],
                author: [
                    { required: true, message: 'The author section cannot be empty', trigger: 'blur' }
                ],
                article: [
                    { required: true, message: 'The article section cannot be empty', trigger: 'blur' },
                ]
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
        async handleSubmit(name) {
            let existingObj = this;
            const headers = {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${localStorage.getItem('authToken')}`
            };
            this.$refs[name].validate((valid) => {
                if (valid) {
                    axios.post(`/api/admin/storeArticle`, this.formValidate, { headers })
                        .then(function (response) {
                            console.log(response.data);
                            notification.success({
                                message: 'Notification',
                                description: 'New Article is Successfully Created',
                            });
                            existingObj.$router.push('/admin/articlePlatform');
                        })
                        .catch(function (error) {

                        });

                } else {
                }
            })

        },
        deleteImage() {
            let image = this.formValidate.image
            this.formValidate.image = ''
            this.$refs.uploads.clearFiles()
            const headers = {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${localStorage.getItem('authToken')}`
            };
            axios.post(`/api/admin/deleteImage`, { imageName: image }, { headers })
                .then(function (response) {
                })
                .catch(function (error) {
                    if (error) {
                        this.formValidate.image = image
                    }
                });
        },
        handleSuccess(res, file) {
            this.formValidate.image = res
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
        onChangeArticleType() {
            let existingObj = this;
            if (existingObj.formValidate.typeValue == 1) {
                existingObj.isShowAuthor = true;
            } else {
                existingObj.isShowAuthor = false;
            }
        },
        handleView() {
            this.visiblePreview = true;
        },
    },
    created() {
        this.token = localStorage.getItem('authToken')
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
</style>