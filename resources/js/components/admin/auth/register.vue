<template>
    <div>
        <div class="min-h-screen flex flex-col items-center justify-center bg-gray-300">
            <div class="flex flex-col bg-white shadow-md px-4 sm:px-6 md:px-8 lg:px-10 py-8 rounded-md w-full max-w-md">
                <div>
                    <a-form
                        ref="formRef"
                        :model="registerForm"
                        :rules="rules"
                        v-bind="layout"
                    >
                        <a-form-item name="name">
                            <span>Name</span>
                            <a-input v-model:value="registerForm.name" placeholder="Name" size="large">
                                <template #prefix><UserOutlined style="color: rgba(0, 0, 0, 0.25)" /></template>
                            </a-input>
                        </a-form-item>
                        <a-form-item name="email">
                            <span>Email</span>
                            <a-input v-model:value="registerForm.email" placeholder="Email" size="large">
                                <template #prefix><MailOutlined style="color: rgba(0, 0, 0, 0.25)" /></template>
                            </a-input>
                        </a-form-item>
                        <a-form-item has-feedback name="password">
                            <span>Password</span>
                            <a-input v-model:value="this.registerForm.password" type="password" autocomplete="off" placeholder="Password" size="large">
                                <template #prefix><LockOutlined style="color: rgba(0, 0, 0, 0.25)" /></template>
                            </a-input>
                        </a-form-item>
                        <a-form-item has-feedback name="checkPassword">
                            <span>Confirm Password</span>
                            <a-input v-model:value="this.registerForm.checkPassword" type="password" autocomplete="off" placeholder="Confirm Password" size="large">
                                <template #prefix><LockOutlined style="color: rgba(0, 0, 0, 0.25)" /></template>
                            </a-input>
                        </a-form-item>
                        <a-form-item >
                            <a-checkbox class="p-0">I agree to the</a-checkbox>
                            <a-button type="link" class="p-0 border">Terms of Service</a-button>
                            <span> and </span>
                            <a-button type="link"  class="p-0 border">Privacy Policy</a-button>
                        </a-form-item>
                        <a-form-item class="border">
                            <a-button @click="register()" class="flex items-center justify-center focus:outline-none text-white text-sm sm:text-base bg-blue-600 hover:bg-blue-700 rounded py-2 w-full transition duration-150 ease-in">
                                <span class="mr-2 uppercase">Register</span>
                                <span>
                                    <svg class="h-6 w-6" fill="none" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                        <path d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </span>
                            </a-button>
                        </a-form-item>
                        <div class="p-0">
                            <p>Already have an account? <a-button type="link"  class="p-0 border">Login</a-button></p>
                        </div>
                    </a-form>
                </div>
            </div>
        </div>
    </div>
</template>
  
<script>

import { LockOutlined, MailOutlined, UserOutlined } from '@ant-design/icons-vue';
import { defineComponent, ref } from 'vue';
import axios from 'axios';
const formRef = ref();
export default defineComponent({
    components: {
        LockOutlined,
        UserOutlined,
        MailOutlined
        // Other components...
    },
    data(){
        let existingObj = this;
        const validatePass = async (_rule, value) => {

            if (value === '') {
                return Promise.reject(`'password' is required`);
            } else {
                if (this.registerForm.checkPassword !== '') {
                    console.log(formRef.value);
                   formRef.value.validateFields('checkPassword');
                }
                return Promise.resolve();
                
            }
        };
        const validatePass2 = async (_rule, value) => {
            console.log(value);
            if (value === '') {
                return Promise.reject(`'confirm password' is required`);
            } else if (value !== this.registerForm.password) {
                return Promise.reject("Confirm Password Don't Match!");
            } else {
                return Promise.resolve();
            }
        };

        const rules = {
            name: [
                {
                required: true,
                },
            ],
            email: [
                {
                required: true,
                type: 'email'
                },
            ],
            password: [
                {
                required: true,
                validator: validatePass,
                trigger: 'change',
                },
            ],
            checkPassword: [
                {
                validator: validatePass2,
                trigger: 'change',
                },
            ],
        };

        return{
            registerForm: {
                name: '',
                email: '',
                password: '',
                checkPassword: '',
            },
            // formRef: ref(),
            rules
        }
    },
    methods: {
        register(){
            let existingObj = this;
            axios.post('api/register', existingObj.loginForm)
                .then(response => {
                    console.log(response.data);
                    
                    // this.$router.push({ path: '/admin/articlePlatform' })
                })
                .catch(function (error) {
                    console.error(error);
                });
        },
    }
});
</script>
  
<style scoped></style>
  