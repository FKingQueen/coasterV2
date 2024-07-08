// store/index.js

import { createStore } from 'vuex';
import router from '../router';
import { notification } from 'ant-design-vue';

const store = createStore({
    state() {
        return {
            token: localStorage.getItem('authToken') || '',
            userRole: localStorage.getItem('userRole') || null,
            tokenExpiration: localStorage.getItem('authTokenExpiration') || null,
        };
    },
    mutations: {
        login(state, { token, userRole }) {
            state.token = token;
            state.userRole = userRole;
            const expirationTime = new Date().getTime() + 60 * 60 * 1000; // 1 hour
            state.tokenExpiration = expirationTime;
            localStorage.setItem('authToken', token);
            localStorage.setItem('authTokenExpiration', expirationTime);
            localStorage.setItem('userRole', userRole);
            
        },
        logout(state) {
            state.token = '';
            state.userRole = null;
            state.tokenExpiration = null;
            localStorage.removeItem('userRole');
            localStorage.removeItem('authToken');
            localStorage.removeItem('authTokenExpiration');
        }
    },
    actions: {
        async login({ commit }, credentials) {
            try {
                await axios.get('/sanctum/csrf-cookie').then(response => {
                    axios.post('api/login', credentials.formLogin)
                        .then(response => {
                            const token = response.data.token;
                            const userRole = response.data.user.role_id;
                            commit('login', { token, userRole });
                           router.push({ path: '/admin/articlePlatform' })
                        })
                        .catch(function (error) {
                            // console.log(error.response.data.message);
                            notification.error({
                                message: 'Error',
                                description: error.response.data.errors.error[0],
                            });
                        });
                })

            } catch (error) {
                console.error('Login error:', error);
                throw error; // Propagate the error for component handling
            }
        },
        logout({ commit }) {
            commit('logout');
        }
    },
    getters: {
        isAuthenticated: state => {
            const expirationTime = state.tokenExpiration;
            const currentTime = new Date().getTime();
            if (expirationTime && currentTime > expirationTime) {
                return false;
            }
            return !!state.token;
        },
        getToken: state => state.token,
        getRole: state => state.userRole,
    }
});

export default store;