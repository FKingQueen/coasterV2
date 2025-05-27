<template>
    <div class="m-5">
        <div class="flex justify-center text-2xl pb-2">
            EDIT USER FORM
        </div>
        <div class="border-t-2 bg-white drop-shadow-md rounded px-10 py-5">
            <Breadcrumb separator=">">
                <BreadcrumbItem to="/admin/userPlatform">User Management</BreadcrumbItem>
                <BreadcrumbItem>Edit User Form</BreadcrumbItem>
            </Breadcrumb>
            <a-button @click="this.$router.push('/admin/userPlatform')" class="my-3">Back</a-button>
            <Form ref="formValidate" :model="formValidate" :rules="ruleValidate" :label-width="95" class="px-10">
                <FormItem label="Name" prop="name">
                    <Input v-model="formValidate.name" placeholder="Enter your name"></Input>
                </FormItem>
                <FormItem label="E-mail" prop="email">
                    <Input v-model="formValidate.email" placeholder="Enter your e-mail"></Input>
                </FormItem>
                <FormItem label="User Type" prop="userType">
                    <a-select v-model:value="formValidate.userType" style="width: 100%"
                        placeholder="Select your User Type" :options="userTypeOptions"></a-select>
                </FormItem>
                <FormItem>
                    <a-button type="primary" @click="showModal">Change Password</a-button>
                    <a-modal v-model:open="visible" title="Updating Password" @ok="changePassword('formValidate')">
                        <div class="ivu-form ivu-form-label-right">
                            <FormItem label="Password" prop="passwd">
                                <Input type="password" v-model="formValidate.passwd"></Input>
                            </FormItem>
                            <FormItem label="Confirm" prop="passwdCheck">
                                <Input type="password" v-model="formValidate.passwdCheck"></Input>
                            </FormItem>
                        </div>
                    </a-modal>
                </FormItem>

                <div class="flex justify-end">
                    <a-button key="submit" type="primary" @click="handleSubmit('formValidate')">Submit</a-button>
                </div>
            </Form>
        </div>
    </div>
</template>

<script>
import { UploadOutlined } from '@ant-design/icons-vue';
import { defineComponent, ref } from 'vue';
import { notification } from 'ant-design-vue';
import { useRoute, useRouter } from 'vue-router';
export default defineComponent({
    data() {
        const visible = ref(false);

        const showModal = () => {
            visible.value = true;
        };
        const validatePass = (rule, value, callback) => {
            if (value === '') {
                callback(new Error('Please enter your password'));
            } else {
                if (this.formValidate.passwdCheck !== '') {
                    this.$refs.formValidate.validateField('passwdCheck');
                }
                callback();
            }
        };
        const validatePassCheck = (rule, value, callback) => {
            if (value === '') {
                callback(new Error('Please enter your password again'));
            } else if (value !== this.formValidate.passwd) {
                callback(new Error('The two input passwords do not match!'));
            } else {
                callback();
            }
        };

        const userTypeOptions = ref([{
            value: '1',
            label: 'Admin',
        }, {
            value: '2',
            label: 'Editor',
        }
        ]);

        return {
            visible,
            showModal,
            userTypeOptions,
            formValidate: {
                id: '',
                name: '',
                email: '',
                userType: '',
                passwd: '',
                passwdCheck: ''
            },
            ruleValidate: {
                name: [
                    { required: true, message: 'The name cannot be empty', trigger: 'blur' }
                ],
                email: [
                    { required: true, message: 'Mailbox cannot be empty', trigger: 'blur' },
                    { type: 'email', message: 'Incorrect email format', trigger: 'blur' }
                ],
                userType: [
                    { required: true, message: 'Please select the userType', trigger: 'change' }
                ],
                passwd: [
                    { validator: validatePass, trigger: 'blur' }
                ],
                passwdCheck: [
                    { validator: validatePassCheck, trigger: 'blur' }
                ]
            },
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
                    axios.post(`/api/admin/updateUser`, this.formValidate, { headers })
                        .then(function (response) {
                            notification.success({
                                message: 'Notification',
                                description: 'User Info is Successfully Updated',
                            });
                            existingObj.$router.push('/admin/userPlatform');
                        })
                        .catch(function (error) {
                            if (error.response.data.errors.email) {
                                console.log(error.response.data.errors);
                                notification.error({
                                    message: 'Notification',
                                    description: error.response.data.errors.email,
                                });
                            }
                        });

                } else {
                }
            })
        },
        changePassword(name) {
            let existingObj = this;
            const headers = {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${localStorage.getItem('authToken')}`
            };
            this.$refs[name].validate((valid) => {
                if (valid) {
                    // Post
                    axios.post(`/api/admin/updatePassword`, this.formValidate, { headers })
                        .then(function (response) {
                            console.log(response);
                            notification.success({
                                message: 'Notification',
                                description: 'Users Password is Successfully Updated',
                            });
                            existingObj.visible = false;
                            existingObj.formValidate.passwd = '';
                            existingObj.formValidate.passwdCheck = '';

                        })
                        .catch(function (error) {
                            if (error.response.data.errors.passwd) {
                                console.log(error.response.data.errors);
                                notification.error({
                                    message: 'Notification',
                                    description: error.response.data.errors.passwd,
                                });
                            }
                        });
                } else {
                }
            })
        }
    },
    async mounted() {
        let id = this.$route.params.id
        let existingObj = this;
        const headers = {
            'Authorization': `Bearer ${localStorage.getItem('authToken')}`
        };
        await axios.get(`/api/admin/getUserEdit/${id}`, { headers })
            .then(function (response) {
                existingObj.formValidate.userType = String(response.data.role_id)
                existingObj.formValidate.id = response.data.id
                existingObj.formValidate.name = response.data.name
                existingObj.formValidate.email = response.data.email
            })
            .catch(function (error) {
                console.log(error)
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
</style>
