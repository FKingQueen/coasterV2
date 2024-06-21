<template class="w-full">
    <div>
        <div>
            <svg class="svgClass" version="1.1" xmlns="http://www.w3.org/2000/svg"
                xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="100%" height="100%"
                viewBox="0 0 1600 900" preserveAspectRatio="xMidYMax slice">
                <defs>
                    <linearGradient id="bg">
                        <stop offset="0%" style="stop-color:rgba(130, 158, 249, 0.06)"></stop>
                        <stop offset="50%" style="stop-color:rgba(76, 190, 255, 0.6)"></stop>
                        <stop offset="100%" style="stop-color:rgba(115, 209, 72, 0.2)"></stop>
                    </linearGradient>
                    <path id="wave" fill="url(#bg)"
                        d="M-363.852,502.589c0,0,236.988-41.997,505.475,0 s371.981,38.998,575.971,0s293.985-39.278,505.474,5.859s493.475,48.368,716.963-4.995v560.106H-363.852V502.589z" />
                </defs>
                <g>
                    <use xlink:href='#wave' opacity=".3">
                        <animateTransform attributeName="transform" attributeType="XML" type="translate" dur="10s"
                            calcMode="spline" values="270 230; -334 180; 270 230" keyTimes="0; .5; 1"
                            keySplines="0.42, 0, 0.58, 1.0;0.42, 0, 0.58, 1.0" repeatCount="indefinite" />
                    </use>
                    <use xlink:href='#wave' opacity=".6">
                        <animateTransform attributeName="transform" attributeType="XML" type="translate" dur="8s"
                            calcMode="spline" values="-270 230;243 220;-270 230" keyTimes="0; .6; 1"
                            keySplines="0.42, 0, 0.58, 1.0;0.42, 0, 0.58, 1.0" repeatCount="indefinite" />
                    </use>
                    <use xlink:href='#wave' opacty=".9">
                        <animateTransform attributeName="transform" attributeType="XML" type="translate" dur="6s"
                            calcMode="spline" values="0 230;-140 200;0 230" keyTimes="0; .4; 1"
                            keySplines="0.42, 0, 0.58, 1.0;0.42, 0, 0.58, 1.0" repeatCount="indefinite" />
                    </use>
                </g>
            </svg>
        </div>
        <div class="flex justify-center  h-screen w-screen items-center">
            <div class=" w-full flex flex-col items-center">
                <div class="md:w-1/4 bg-white w-11/12 border px-4 md:px-2 pt-5  border shadow-lg rounded-lg">
                    <div>
                        <h1 class="text-center text-2xl font-bold text-gray-600 mb-6">COASTER WEB PORTAL</h1>
                    </div>
                    <a-form :model="formLogin" name="normal_login" class="login-form " @finish="login({ formLogin })"
                        :validate-messages="validateMessages">
                        <a-form-item label="Email" name="email" :rules="[{ type: 'email' }]">
                            <a-input v-model:value="formLogin.email">
                                <template #prefix>
                                    <UserOutlined class="site-form-item-icon" />
                                </template>
                            </a-input>
                        </a-form-item>

                        <a-form-item label="Password" name="password" :rules="[{ type: 'string', min: 8 }]">
                            <a-input-password v-model:value="formLogin.password">
                                <template #prefix>
                                    <LockOutlined class="site-form-item-icon" />
                                </template>
                            </a-input-password>
                        </a-form-item>

                        <a-form-item>
                            <a-form-item name="remember" no-style>
                                <a-checkbox v-model:checked="formLogin.remember">Remember me</a-checkbox>
                            </a-form-item>
                            <a class="login-form-forgot" href="">Forgot password</a>
                        </a-form-item>

                        <a-form-item>
                            <a-button :disabled="disabled" html-type="submit" class="w-full primary login-form-button">
                                Log in
                            </a-button>
                        </a-form-item>
                    </a-form>
                </div>
            </div>
        </div>
            <button @click="increment">Increment</button>
    </div>

</template>
<script>
import { defineComponent, reactive, computed } from 'vue';
import { UserOutlined, LockOutlined } from '@ant-design/icons-vue';

import { mapActions } from 'vuex';
// import axios from 'axios';
export default defineComponent({
    components: {
        UserOutlined,
        LockOutlined,
    },
    data() {
        const disabled = computed(() => {
            return !(this.formLogin.email && this.formLogin.password);
        });

        const validateMessages = {
            required: '${label} is required!',
            types: {
                email: '${label} is not a valid email!',
            },
            string: {
                range: '${label} must be between ${min} characters',
            },
        };

        return {
            formLogin: {
                email: '',
                password: '',
            },
            disabled,
            validateMessages
        };
    },
    methods: {
        ...mapActions(['login']),
    }
});
</script>

<style>
#components-form-demo-normal-login .login-form {
    max-width: 300px;
}

#components-form-demo-normal-login .login-form-forgot {
    float: right;
}

#components-form-demo-normal-login .login-form-button {
    width: 100%;
}

.svgClass {
    position: absolute;
    top: 0;
    left: 0;
    z-index: -1;
    width: 100%;
    height: 100%;
    box-sizing: border-box;
    display: block;
    /* background-color: #0e4166;
    background-image: linear-gradient(to bottom, rgba(14, 65, 102, 0.86), #0e4166); */
}
</style>
