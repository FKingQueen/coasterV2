<template>
    <div class="p-2">
        <div class="m-5 border-t-2 bg-white shadow-inner shadow-lg rounded px-10 py-5">
            <div class="flex justify-center text-2xl">
                User Account
            </div>
            <div class="flex justify-center w-full">
                <div class="w-6/12 border">
                    <Form ref="formValidate" :model="formValidate" :rules="ruleValidate" :label-width="95" class="p-10">
                        <FormItem label="Name" prop="name">
                            <Input v-model="formValidate.name" placeholder="Enter your name"></Input>
                        </FormItem>
                        <FormItem label="E-mail" prop="email">
                            <Input v-model="formValidate.email" placeholder="Enter your e-mail"></Input>
                        </FormItem>
                        <FormItem>
                            <a-button type="primary" @click="showModal">Change Password</a-button>
                            <a-modal v-model:open="visible" title="New Password" @ok="changePassword('formValidate')">
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
                    // 对第二个密码框单独验证
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

        return {
            visible,
            showModal,
            formValidate: {
                name: '',
                email: '',
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
            await this.$refs[name].validate((valid) => {
                if (valid) {
                    axios.post(`/api/admin/updateUserAccount`, this.formValidate)
                        .then(function (response) {
                            notification.success({
                                message: 'Notification',
                                description: 'Your Account is Successfully Updated',
                            });

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
                    axios.post(`/api/admin/updateUserAccountPassword`, this.formValidate, { headers })
                        .then(function (response) {
                            notification.success({
                                message: 'Notification',
                                description: 'Your Password is Successfully Updated',
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
    async created() {
        let existingObj = this;
        const headers = {
            'Authorization': `Bearer ${localStorage.getItem('authToken')}`
        };
        await axios.get(`/api/admin/getUserAccount/`, { headers })
            .then(function (response) {
                console.log(response.data);
                existingObj.formValidate.name = response.data.name
                existingObj.formValidate.email = response.data.email
            })
            .catch(function (error) {
                console.log(error)
            });
    }

})

</script>