<template>
    <div>
        <div class="p-2">
            <div class="m-5 border-t-2 bg-white shadow-inner shadow-lg rounded px-10 py-5">
                <div class="ml-2 flex justify-start gap-1">
                    <Breadcrumb separator=">">
                        <BreadcrumbItem to="/admin/inventoryPlatform">Inventory Management</BreadcrumbItem>
                        <BreadcrumbItem>Edit Inventory Form</BreadcrumbItem>
                    </Breadcrumb>
                </div>
                <div class="mb-2 flex justify-start gap-1">
                    <a-button @click="this.$router.push('/admin/inventoryPlatform')" class="my-3">Back</a-button>
                </div>
                <Form ref="formValidate" :model="formValidate" :rules="ruleValidate" label-position="top" class="px-10">
                    <FormItem label="Image (atleast 1)" prop="image">
                        <Upload type="drag" ref="uploads"
                            :headers="{ 'x-csrf-token': token, 'X-Requested-With': 'XMLHttpRequest' }"
                            :on-success="handleSuccess" :on-error="handleError" :format="['jpg', 'jpeg', 'png']"
                            :on-format-error="handleFormatError" action="/api/admin/uploadInventory">
                            <div style="padding: 3px 0">
                                <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
                                <p>Click or drag files here to upload</p>
                            </div>
                        </Upload>
                        <ImagePreview v-model="visiblePreview" :preview-list="[`/inventory/${formValidate.image}`]" />
                        <div v-if="formValidate.image" class="demo-upload-list">
                            <Image :src="`/inventory/${formValidate.image}`" fit="cover" width="100%" height="100%" />
                            <div class="demo-upload-list-cover">
                                <Icon type="ios-eye-outline" @click="handleView()"></Icon>
                                <Icon type="ios-trash-outline" @click="deleteImage()"></Icon>
                            </div>
                        </div>
                    </FormItem>

                    <div class="w-full border flex justify-center bg-[#abdcff]/80 py-1 mb-2">
                        <p class="">Hard Coastal Structure</p>
                    </div>

                    <FormItem label="CoastalID" prop="coastalID">
                        <Input v-model="formValidate.coastalID" placeholder="Input Coastal Identification"></Input>
                    </FormItem>
                    <FormItem label="Province" prop="province">
                        <Input v-model="formValidate.province" placeholder="Input Province"></Input>
                    </FormItem>
                    <FormItem label="Coastal Protection" prop="coastalProtection">
                        <Input v-model="formValidate.coastalProtection" placeholder="Input Coastal Protection"></Input>
                    </FormItem>
                    <FormItem label="Latitude" prop="latitude">
                        <Input v-model="formValidate.latitude" placeholder="Input Latitude"></Input>
                    </FormItem>
                    <FormItem label="Longitude" prop="longitude">
                        <Input v-model="formValidate.longitude" placeholder="Input Longitude"></Input>
                    </FormItem>
                    <FormItem label="Location Type" prop="locationType">
                        <Input v-model="formValidate.locationType" placeholder="Input Location Type"></Input>
                    </FormItem>
                    <FormItem label="Estimated Yr. of Completed" prop="yearCompleted">
                        <Input v-model="formValidate.yearCompleted"
                            placeholder="Input Estimated Yr. of Completed"></Input>
                    </FormItem>

                    <div class="w-full border flex justify-center bg-[#abdcff]/80 py-1 mb-2">
                        <p class="">Structure Details</p>
                    </div>

                    <FormItem label="Length (m)" prop="length">
                        <Input v-model="formValidate.length" placeholder="Input Length (m)"></Input>
                    </FormItem>
                    <FormItem label="Height Range" prop="heightRange">
                        <Input v-model="formValidate.heightRange" placeholder="Input Height Range"></Input>
                    </FormItem>
                    <FormItem label="Primary Material" prop="primaryMaterial">
                        <Input v-model="formValidate.primaryMaterial" placeholder="Input Primary Material"></Input>
                    </FormItem>

                    <div class="w-full border flex justify-center bg-[#abdcff]/80 py-1 mb-2">
                        <p class="">Asset Condition</p>
                    </div>

                    <FormItem label="Condition Rating" prop="conditionRating">
                        <Input v-model="formValidate.conditionRating" placeholder="Input Condition Rating"></Input>
                    </FormItem>

                    <FormItem label="Condition Rating Description" prop="crDesc">
                        <ckeditor :editor="editor" v-model="formValidate.crDesc" :config="editorConfig"
                            placeholder="Condition Rating Description Here"></ckeditor>
                    </FormItem>

                    <FormItem label="Priority Rating" prop="priorityRating">
                        <Input v-model="formValidate.priorityRating" placeholder="Input Priority Rating"></Input>
                    </FormItem>

                    <FormItem label="Priority Rating Description" prop="prDesc">
                        <ckeditor :editor="editor" v-model="formValidate.prDesc" :config="editorConfig"
                            placeholder="Priority Rating Description Here"></ckeditor>
                    </FormItem>

                    <div class="flex justify-end">
                        <a-button key="submit" type="primary" @click="handleSubmit('formValidate')">Submit</a-button>
                    </div>
                </Form>
            </div>
        </div>
    </div>
</template>

<script>
import { defineComponent, ref, watch } from 'vue';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import { notification } from 'ant-design-vue';
export default defineComponent({
    data() {
        return {
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
            },
            token: '',
            visiblePreview: false,
            formValidate: [],
            ruleValidate: {
                image: [
                    { required: true, message: 'The image cannot be empty', trigger: 'blur' }
                ],
                coastalID: [
                    { required: true, message: 'The coastalID cannot be empty', trigger: 'blur' }
                ],
                province: [
                    { required: true, message: 'The province cannot be empty', trigger: 'blur' }
                ],
                coastalProtection: [
                    { required: true, message: 'The coastal protection cannot be empty', trigger: 'blur' }
                ],
                latitude: [
                    { required: true, message: 'The latitude cannot be empty', trigger: 'blur' }
                ],
                longitude: [
                    { required: true, message: 'The longitude cannot be empty', trigger: 'blur' }
                ],
                locationType: [
                    { required: true, message: 'The location type cannot be empty', trigger: 'blur' }
                ],
                yearCompleted: [
                    { required: true, message: 'The Estimated Yr. of Completed cannot be empty', trigger: 'blur' }
                ],
                length: [
                    { required: true, message: 'The length cannot be empty', trigger: 'blur' }
                ],
                heightRange: [
                    { required: true, message: 'The height range cannot be empty', trigger: 'blur' }
                ],
                primaryMaterial: [
                    { required: true, message: 'The primary material cannot be empty', trigger: 'blur' }
                ],
                conditionRating: [
                    { required: true, message: 'The condition rating cannot be empty', trigger: 'blur' }
                ],
                crDesc: [
                    { required: true, message: 'The codition rating description cannot be empty', trigger: 'blur' }
                ],
                priorityRating: [
                    { required: true, message: 'The priority rating cannot be empty', trigger: 'blur' }
                ],
                prDesc: [
                    { required: true, message: 'The priority rating description cannot be empty', trigger: 'blur' }
                ]
            },
        }
    },
    methods: {
        handleSubmit(name) {
            let existingObj = this;
            const headers = {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${localStorage.getItem('authToken')}`
            };
            this.$refs[name].validate((valid) => {
                if (valid) {
                    axios.post(`/api/admin/updateInventory`, this.formValidate, { headers })
                        .then(function (response) {
                            notification.success({
                                message: 'Notification',
                                description: 'Inventory is Successfully Update',
                            });
                            existingObj.$router.push('/admin/inventoryPlatform');
                        })
                        .catch(function (error) {

                        });
                    console.log(this.formValidate);

                } else {

                }
            })
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
        deleteImage() {
            let image = this.formValidate.image
            this.formValidate.image = ''
            this.$refs.uploads.clearFiles()
            const headers = {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${localStorage.getItem('authToken')}`
            };

            axios.post(`/api/admin/deleteImageInventory`, { imageName: image }, { headers })
                .then(function (response) {

                })
                .catch(function (error) {
                    if (error) {
                        this.formValidate.image = image
                    }
                });
        },
        handleView() {
            this.visiblePreview = true;
        },
    },
    async mounted() {
        this.token = localStorage.getItem('authToken'); // Replace with your actual API token
        const headers = {
            'Authorization': `Bearer ${localStorage.getItem('authToken')}`
        };
        let id = this.$route.params.id
        let existingObj = this;
        await axios.get(`/api/admin/getInventoryEdit/${id}`, { headers })
            .then(function (response) {
                existingObj.formValidate = response.data[0]
                existingObj.formValidate.latitude = String(response.data[0].latitude)
                existingObj.formValidate.longitude = String(response.data[0].longitude)
            })
            .catch(function (error) {
                console.log(error)
            });

    }
})
</script>