<template>
    <div class="container">
        <div
            class=" z-30 w-full flex justify-center bg-slate-800 border-b-2 drop-shadow-md border-cyan-900 min-h-[1rem]">
            <!-- <div class=" z-30 w-full flex justify-center bg-[#002B5B] border-y-4 border-cyan-900 min-h-[5rem]"> -->
            <div class="hidden lg:flex items-center justify-between w-full">
                <div class="justify-center flex space-x-3 text-white w-1/3">
                    <div class="flex items-center ">
                        <img src="/img/logo/COASTER.png"
                            class="blur-none antialiased cursor-pointer object-fill h-[4rem]" alt="#">
                    </div>
                    <div>
                        <div class="text-start grid text-neutral-200">
                            <div
                                class="font-serif w-full h-[5rem] text-xs blur-none antialiased text-neutral-200 flex items-center">
                                <div class="">
                                    <p class="laptop:text-lg monitor:text-xl">
                                        COASTER
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-end w-2/3">
                    <div class="flex justify-center  text-neutral-200 w-3/4">
                        <div class="flex space-x-1 w-full">
                            <router-link to="/admin/articlePlatform"
                                class="px-4 py-3  flex text-neutral-200 hover:bg-sky-800
                                    hover:rounded cursor-pointer blur-none tracking-wide antialiased font-roboto text-md ">
                                ARTICLE
                            </router-link>
                            <router-link to="/admin/buoyPlatform" class="px-4 py-3  flex text-neutral-200 hover:bg-sky-800 hover:rounded
                                    cursor-pointer blur-none tracking-wide antialiased font-roboto text-md block">
                                BUOY SYSTEM
                            </router-link>
                            <router-link to="/admin/waterlevelPlatform" class="px-4 py-3  flex text-neutral-200 hover:bg-sky-800 hover:rounded
                                    cursor-pointer blur-none tracking-wide antialiased font-roboto text-md">
                                WATER LEVEL SYSTEM
                            </router-link>
                            <router-link to="/admin/downloadPlatform" class="px-4 py-3  flex text-neutral-200 hover:bg-sky-800 hover:rounded
                                    cursor-pointer blur-none tracking-wide antialiased font-roboto text-md">
                                DOWNLOADS
                            </router-link>
                            <router-link to="/admin/userPlatform" class="px-4 py-3  flex text-neutral-200 hover:bg-sky-800 hover:rounded
                                    cursor-pointer blur-none tracking-wide antialiased font-roboto text-md">
                                USER MANAGEMENT
                            </router-link>
                        </div>
                    </div>
                    <div class="text-neutral-200 w-1/4 justify-end flex items-center mr-3">
                        <a-dropdown :placement="'bottom'" :trigger="['click']" :arrow="{ pointAtCenter: true }">
                            <div @click.prevent
                                class="flex items-center text-neutral-200 hover:text-sky-600 space-x-1 cursor-pointer">
                                <p>
                                    {{ userName }}
                                </p>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                </svg>
                            </div>
                            <template #overlay>
                                <a-menu>
                                    <a-menu-item key="0">
                                        <router-link to="/admin/userAccount">
                                            User Account
                                        </router-link>
                                    </a-menu-item>
                                    <a-menu-divider />
                                    <a-menu-item key="3">
                                        <a href="#" @click="logout()">Logout</a>
                                    </a-menu-item>
                                </a-menu>
                            </template>
                            <Modal v-model="modal" title="Common Modal dialog box title" @on-ok="ok"
                                @on-cancel="cancel">
                                <p>Content of dialog</p>
                                <p>Content of dialog</p>
                                <p>Content of dialog</p>
                            </Modal>
                        </a-dropdown>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-full">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>

import { defineComponent } from 'vue';
import { mapActions } from 'vuex';

export default defineComponent({
    data() {
        return {
            // Define any data properties you need here
            userName: '',
        };
    },
    methods: {
        ...mapActions(['logout']),
    },
    async created() {
        let thiss = this;
        const headers = {
            'Authorization': `Bearer ${localStorage.getItem('authToken')}`
        };
        await axios.get(`/api/admin/getUserAccount/`, { headers })
            .then(function (response) {
                console.log(response.data);
                thiss.userName = response.data.name;
            })
            .catch(function (error) {
                console.log(error)
            });
    }
})
</script>

<style scoped>
.router-link-exact-active {
    background-color: rgb(12 74 110 / var(--tw-bg-opacity, 1));
    color: rgb(240 249 255 / var(--tw-text-opacity, 1));
}

</style>
