<template>
    <div>
        <div class="min-h-screen flex flex-col flex-auto flex-shrink-0 antialiased "
            style="background-color: rgb(245 247 249);">
            <div>
                <!-- Header -->
                <div class="fixed w-full flex items-center justify-between h-14 text z-10">
                    <div
                        class="flex items-center justify-start md:justify-center w-14 md:w-64 h-14 bg-gray-300 border-none">
                        <img class="w-7 h-7 md:w-10 md:h-10 mr-2 rounded-md overflow-hidden bg-gray-300"
                            src="/img/logo/COASTER.png" />
                        <span class="hidden md:block ">COASTER</span>
                    </div>
                    <div class="flex justify-between items-center h-14 bg-gray-300 header-right">
                        <ul class="justify-end flex w-full">
                            <li>
                                <a @click="logout()" href="#"
                                    class="flex items-center mr-4 text-black hover:text-gray-400 hidden lg:block">
                                    <div class="flex">
                                        <div>
                                            <svg class="w-7 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                                </path>
                                            </svg>
                                        </div>
                                        <div>
                                            Logout
                                        </div>
                                    </div>
                                </a>


                            </li>
                        </ul>
                    </div>
                </div>
                <!-- ./Header -->

                <!-- Sidebar -->
                <div
                    class="fixed flex flex-col top-14 left-0 w-14 hover:w-64 md:w-64 bg-gray-900 h-full text-white transition-all duration-300 border-none z-10 sidebar">
                    <div class="overflow-y-auto overflow-x-hidden flex flex-col justify-between flex-grow">
                        <ul class="flex flex-col py-4 space-y-1">
                            <li class="px-5 hidden md:block">
                                <div class="flex flex-row items-center h-8">
                                    <div class="text-sm font-light tracking-wide text-gray-400 uppercase">Main</div>
                                </div>
                            </li>
                            <li>
                                <router-link to="/admin/articlePlatform"
                                    class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-gray-800 text-white hover:text-slate-300 border-l-4 border-transparent hover:border-blue-500 pr-6">
                                    <span class="inline-flex justify-center items-center ml-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 01-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 011.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 00-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 01-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5a3.375 3.375 0 00-3.375-3.375H9.75" />
                                        </svg>
                                    </span>
                                    <span class="ml-2 text-sm tracking-wide truncate">Article</span>
                                </router-link>
                                 <router-link to="/admin/inventoryPlatform"
                                    class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-gray-800 text-white hover:text-slate-300 border-l-4 border-transparent hover:border-blue-500 pr-6">
                                    <span class="inline-flex justify-center items-center ml-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
                                        </svg>
                                    </span>
                                    <span class="ml-2 text-sm tracking-wide truncate">Inventory</span>
                                </router-link>
                                <router-link v-if="isAdminVisible" to="/admin/buoyPlatform"
                                    class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-gray-800 text-white hover:text-slate-300 border-l-4 border-transparent hover:border-blue-500 pr-6">
                                    <span class="inline-flex justify-center items-center ml-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 01-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 011.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 00-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 01-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5a3.375 3.375 0 00-3.375-3.375H9.75" />
                                        </svg>
                                    </span>
                                    <span class="ml-2 text-sm tracking-wide truncate">Bouy</span>
                                </router-link>
                                <router-link v-if="isAdminVisible" to="/admin/waterlevelPlatform"
                                    class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-gray-800 text-white hover:text-slate-300 border-l-4 border-transparent hover:border-blue-500 pr-6">
                                    <span class="inline-flex justify-center items-center ml-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 01-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 011.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 00-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 01-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5a3.375 3.375 0 00-3.375-3.375H9.75" />
                                        </svg>
                                    </span>
                                    <span class="ml-2 text-sm tracking-wide truncate">Water Level</span>
                                </router-link>
                                <router-link v-if="isAdminVisible" to="/admin/userPlatform"
                                    class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-gray-800 text-white hover:text-slate-300 border-l-4 border-transparent hover:border-blue-500 pr-6">
                                    <span class="inline-flex justify-center items-center ml-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                        </svg>
                                    </span>
                                    <span class="ml-2 text-sm tracking-wide truncate">User Management</span>
                                </router-link>
                            </li>
                            <li class="px-5 hidden md:block">
                                <div class="flex flex-row items-center mt-5 h-8">
                                    <div class="text-sm font-light tracking-wide text-gray-400 uppercase">Settings</div>
                                </div>
                            </li>
                            <li>
                                <router-link to="/admin/userAccount"
                                    class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-gray-800 text-white hover:text-slate-300 border-l-4 border-transparent hover:border-blue-500 pr-6">
                                    <span class="inline-flex justify-center items-center ml-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </span>
                                    <span class="ml-2 text-sm tracking-wide truncate">User Account</span>
                                </router-link>
                            </li>
                            <li>
                                <a href="#" @click="logout()"
                                    class="block lg:hidden relative flex flex-row items-center h-11 focus:outline-none hover:bg-gray-800 text-white   hover:text-white-800 border-l-4 border-transparent hover:border-blue-500 pr-6">
                                    <span class="inline-flex justify-center items-center ml-4">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                            </path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </span>
                                    <span class="ml-2 text-sm tracking-wide truncate" >Logout</span>
                                </a>
                            </li>
                        </ul>
                        <p class="mb-14 px-5 py-3 hidden md:block text-center text-xs">Copyright @2023</p>
                    </div>
                </div>
                <!-- ./Sidebar -->
            </div>
            <div class="h-full ml-14 mt-14 mb-10 md:ml-64 bg">
                <router-view></router-view>
            </div>
        </div>
    </div>
</template>

<script>

import { defineComponent, reactive, computed } from 'vue';
import { mapActions } from 'vuex';

export default defineComponent({
    data() {
        return {
            isEditorVisible: false,
            isAdminVisible: false,
        }
    },
    watch: {

    },
    methods: {
        ...mapActions(['logout']),
    },
    created() {
        const thiss = this;
        if (localStorage.getItem('userRole') == 1) {
            thiss.isAdminVisible = true;
        }
        if (localStorage.getItem('userRole') == 2) {
            thiss.isEditorVisible = true;
        }
    }
})
</script>

<style scoped>
.router-link-exact-active {
    background-color: rgb(31 41 55);
    border-left: 4px solid rgb(59 130 246);
    color: rgb(203 213 225);
}

.router-link-active {
    background-color: rgb(31 41 55);
    border-left: 4px solid rgb(59 130 246);
    color: rgb(203 213 225);
}
.sidebar:hover {
    width: 16rem;
}

@media only screen and (min-width: 768px) {
    .header-right {
        width: calc(100% - 16rem);
    }
}


