<template>
    <div>
        <div class=" z-30 w-full flex justify-center bg-[#002B5B] border-y-4 border-cyan-900 min-h-[5rem]">
            <div class="hidden lg:flex items-center justify-between w-full">
                <div class="w-1/4 justify-center flex space-x-3 ">
                    <div class="flex items-center ">
                        <img @click="this.$router.push('/')" src="/img/logo/COASTER.png"
                            class="blur-none antialiased cursor-pointer object-fill h-[4rem]" alt="#">
                    </div>
                    <div>
                        <div class="text-start grid text-white">
                            <!-- <div>
                                <p class="text-2xl text-blue-50 font-serif font-semibold blur-none antialiased ">
                                    COASTER
                                </p>
                            </div> -->
                            <div
                                class="font-serif w-full h-[5rem] text-xs blur-none antialiased text-blue-50 flex items-center">
                                <div class="">
                                    <p class="laptop:text-lg monitor:text-xl">
                                        Coastal Engineering and Management
                                    </p>
                                    <p class="laptop:text-lg monitor:text-xl">
                                        Research and Development Center
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-center w-2/4">
                    <div class="flex space-x-1">
                        <router-link to="/"
                            class="px-4 py-3  flex text-blue-50 font-semibold hover:bg-sky-700
                                    hover:rounded cursor-pointer blur-none tracking-wide antialiased font-roboto text-sm ">
                            HOME
                        </router-link>
                        <!-- <router-link to="/services" class="px-4 py-3  flex text-blue-50 font-semibold hover:bg-sky-700 hover:rounded
                                    cursor-pointer blur-none tracking-wide antialiased font-roboto text-sm">
                            SERVICES
                        </router-link> -->
                        <router-link to="/monitoringSystem" class="px-4 py-3  flex text-blue-50 font-semibold hover:bg-sky-700 hover:rounded
                                    cursor-pointer blur-none tracking-wide antialiased font-roboto text-sm">
                            MONITORING SYSTEM
                        </router-link>
                        <router-link to="/coastalfloodadvisory" class="px-4 py-3  flex text-blue-50 font-semibold hover:bg-sky-700 hover:rounded
                                    cursor-pointer blur-none tracking-wide antialiased font-roboto text-sm">
                            COASTAL FLOOD ADVISORY
                        </router-link>
                        <div class="dropdown z-40  px-4 py-[11px]  flex text-blue-50 font-semibold hover:bg-sky-700 hover:rounded
                                cursor-pointer transition-colors duration-300 " style="float:left;">
                            <button class="dropdown  blur-none tracking-wide antialiased">PROJECT</button>
                            <div class="dropdown-content p-1 w-[23rem] font-normal z-40" style="left:0;">
                                <a @click="this.$router.push('/projects/project1')"
                                    class="antialiased text-blue-50 text-justify  hover:shadow-[inset_23rem_0_0_0] hover:shadow-cyan-700 duration-[400ms,700ms] transition-[color,box-shadow]">Coastal
                                    Erosion Trends and Management Strategies for Region 1</a>
                                <a @click="this.$router.push('/projects/project2')"
                                    class="antialiased text-blue-50 text-justify  hover:shadow-[inset_23rem_0_0_0] hover:shadow-cyan-700 duration-[400ms,700ms] transition-[color,box-shadow]">Assesment
                                    Monitoring, and Prediction of Coastal Flooding of Selected Municipalities in
                                    Region
                                    1</a>
                                <a @click="this.$router.push('/projects/project3')"
                                    class="antialiased text-blue-50 text-justify  hover:shadow-[inset_23rem_0_0_0] hover:shadow-cyan-700 duration-[400ms,700ms] transition-[color,box-shadow]">Development
                                    of Science-based Engineering Approach to Coastal Prediction in Region 1</a>
                                <a @click="this.$router.push('/projects/project4')"
                                    class="antialiased text-blue-50 text-justify  hover:shadow-[inset_23rem_0_0_0] hover:shadow-cyan-700 duration-[400ms,700ms] transition-[color,box-shadow]">Enhancing
                                    Coastal Design and Infrastructure Intervention through the Establishment of
                                    Wave
                                    Testing Facility</a>
                            </div>
                        </div>
                        <router-link to="/about" class="px-4 py-3  flex text-blue-50 font-semibold hover:bg-sky-700 hover:rounded
                                    cursor-pointer blur-none tracking-wide antialiased font-roboto text-sm">
                            ABOUT
                        </router-link>
                    </div>
                </div>
                <div class="w-1/4">
                    <div class="w-full flex justify-end ">
                        <div class=" w-fit border border-[#C49A6C] border-4 h-full text-center px-2 mr-5 text-blue-100">
                            <p class="font-semibold">
                                Philippine Standard Time (PST)
                            </p>
                            <p>{{
                                this.time
                            }}
                            </p>
                            <p>
                                {{ this.date }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mobile View -->
            <div class="flex justify-between items-center w-full lg:hidden block px-5">
                <!-- Search Bar -->
                <button @click="sideBarDrawer = true" type="button" class="text-2xl text-white hover:text-gray-200 ">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>
                <!-- /Search Bar -->
                <Drawer placement="left" :closable="false" v-model="sideBarDrawer" :styles="{ padding: '0' }">
                    <div class="flex justify-center pb-5">
                        <div class="text-center grid divide-[#C49A6C]/75 divide-y-4">
                            <div>
                                <p
                                    class="text-3xl font-serif font-semibold bg-gradient-to-r from-[#002B5B] to-[#C49A6C] text-transparent bg-clip-text">
                                    COASTER
                                </p>
                            </div>
                            <div
                                class="text-center font-sans text-sm blur-none antialiased text-slate-600">
                                <p>
                                    Coastal Engineering and Management
                                    Research and Development Center
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <a-menu v-model:openKeys="openKeys" v-model:selectedKeys="selectedKeys" mode="inline"
                            @click="handleClick">
                            <a-menu-item key="1">
                                <template #icon>
                                    <Icon type="ios-home" />
                                </template>
                                Home
                            </a-menu-item>
                            <a-menu-item key="2">
                                <template #icon>
                                    <Icon type="ios-water" />
                                </template>
                                Services
                            </a-menu-item>
                            <a-menu-item key="3">
                                <template #icon>
                                    <Icon type="ios-water" />
                                </template>
                                Monitoring System
                            </a-menu-item>
                            <a-sub-menu key="sub1">
                                <template #icon>
                                    <Icon type="ios-document" />
                                </template>
                                <template #title>Project</template>
                                <a-menu-item key="5">Project 1</a-menu-item>
                                <a-menu-item key="6">Project 2</a-menu-item>
                                <a-menu-item key="7">Project 3</a-menu-item>
                                <a-menu-item key="8">Project 4</a-menu-item>
                            </a-sub-menu>
                            <a-menu-item key="9">
                                <template #icon>
                                    <Icon type="ios-document" />
                                </template>
                                About
                            </a-menu-item>

                        </a-menu>
                    </div>
                </Drawer>
                <!-- /Search Bar -->
                <img src="/img/logo/COASTER.png" @click="this.$router.push('/')"
                    class="duration-200 blur-none cursor-pointer object-fill h-14 py-1" alt="#">
                <!-- Search Bar -->
                <button type="button" @click="Search()" class="text-2xl text-white hover:text-gray-200 ">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6 focus:outline outline-offset-2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                </button>
                <!-- /Search Bar -->
            </div>

        </div>



        <!-- <div class="w-full flex">
            <div class="w-3/12 h-[6rem] p-1 bg-[#002B5B] border-b-4 border-cyan-900 border-r-1">
                <div class="w-full  flex items-center h-full space-x-2 justify-center">
                    <div class="flex items-center ">
                        <img src="/img/logo/COASTER.png" class="blur-none antialiased cursor-pointer object-fill h-20 "
                            alt="#">
                    </div>
                    <div>
                        <div class="text-center grid divide-[#C49A6C]/75 divide-y-2 text-white">
                            <div>
                                <p class="text-3xl  font-serif font-semibold blur-none antialiased ">
                                    COASTER
                                </p>
                            </div>
                            <div class="text-center font-sans text-xs blur-none antialiased">
                                <p>
                                    Coastal Engineering and Management
                                </p>
                                <p>
                                    Research and Development Center
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-full">
                <div class="h-[2rem] flex items-center justify-between w-full ">
                    <div class="flex justify-start w-8/12">
                        <div class="overflow-hidden  w-full">
                            <div class="animate-scroll hover:animate-paused w-full max-w-md mx-auto ">
                                <span>
                                    The COASTER STAFF will participate in the ICCIARD 2024... For more info. <a
                                        href="">Click Here!!!</a>
                                    The COASTER STAFF will participate in the ICCIARD 2024... For more info.
                                    The COASTER STAFF will participate in the ICCIARD 2024... For more info.
                                    The COASTER STAFF will participate in the ICCIARD 2024... For more info.
                                    The COASTER STAFF will participate in the ICCIARD 2024... For more info.
                                    The COASTER STAFF will participate in the ICCIARD 2024... For more info.
                                    The COASTER STAFF will participate in the ICCIARD 2024... For more info.
                                    The COASTER STAFF will participate in the ICCIARD 2024... For more info.
                                    The COASTER STAFF will participate in the ICCIARD 2024... For more info.
                                    The COASTER STAFF will participate in the ICCIARD 2024... For more info.
                                    The COASTER STAFF will participate in the ICCIARD 2024... For more info.
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <div class="flex space-x-2 bg-[#FFD700] px-2 py-3 text-white">
                            <p class="font-semibold">
                                Official DateTime:
                            </p>
                            <p>{{
                                this.digitalTime.hour
                            }}:{{ this.digitalTime.min }}:{{ this.digitalTime.sec }}</p>
                            <p>{{ this.digitalTime.date
                                }} /
                                {{ this.digitalTime.day }} / 20{{ this.digitalTime.year }}</p>
                        </div>
                    </div>
                </div>
                <div class="w-full flex items-end  h-[4rem]">
                    <div class="z-30 flex justify-between w-full bg-[#002B5B] border-y-4 border-cyan-900 ">
                        <div class="flex">
                            <router-link to="/" class="py-4 px-4 ml-2 flex text-white font-semibold hover:bg-sky-700
                                    cursor-pointer blur-none tracking-wide antialiased font-roboto text-sm ">
                                HOME
                            </router-link>
                            <router-link to="/services" class="py-4 px-4 flex text-white font-semibold hover:bg-sky-700
                                    cursor-pointer blur-none tracking-wide antialiased font-roboto text-sm">
                                    SERVICES
                                </router-link>
                            <router-link to="/monitoringSystem" class="py-4 px-4 flex text-white font-semibold hover:bg-sky-700
                                    cursor-pointer blur-none tracking-wide antialiased font-roboto text-sm">
                                MONITORING SYSTEM
                            </router-link>
                            <router-link to="/coastalfloodadvisory" class="py-4 px-4 flex text-white font-semibold hover:bg-sky-700
                                    cursor-pointer blur-none tracking-wide antialiased font-roboto text-sm">
                                COASTAL FLOOD ADVISORY
                            </router-link>
                            <div class="dropdown z-40  px-4 flex text-white font-semibold hover:bg-sky-700
                                cursor-pointer transition-colors duration-300 " style="float:left;">
                                <button class="dropdown py-4  blur-none tracking-wide antialiased">PROJECT</button>
                                <div class="dropdown-content p-1 w-[23rem] font-normal " style="left:0;">
                                    <a @click="this.$router.push('/projects/project1')"
                                        class="antialiased text-white text-justify  hover:shadow-[inset_23rem_0_0_0] hover:shadow-cyan-700 duration-[400ms,700ms] transition-[color,box-shadow]">Coastal
                                        Erosion Trends and Management Strategies for Region 1</a>
                                    <a @click="this.$router.push('/projects/project2')"
                                        class="antialiased text-white text-justify  hover:shadow-[inset_23rem_0_0_0] hover:shadow-cyan-700 duration-[400ms,700ms] transition-[color,box-shadow]">Assesment
                                        Monitoring, and Prediction of Coastal Flooding of Selected Municipalities in
                                        Region
                                        1</a>
                                    <a @click="this.$router.push('/projects/project3')"
                                        class="antialiased text-white text-justify  hover:shadow-[inset_23rem_0_0_0] hover:shadow-cyan-700 duration-[400ms,700ms] transition-[color,box-shadow]">Development
                                        of Science-based Engineering Approach to Coastal Prediction in Region 1</a>
                                    <a @click="this.$router.push('/projects/project4')"
                                        class="antialiased text-white text-justify  hover:shadow-[inset_23rem_0_0_0] hover:shadow-cyan-700 duration-[400ms,700ms] transition-[color,box-shadow]">Enhancing
                                        Coastal Design and Infrastructure Intervention through the Establishment of
                                        Wave
                                        Testing Facility</a>
                                </div>
                            </div>
                            <router-link to="/about" class="py-4 px-4 flex text-white font-semibold hover:bg-sky-700
                                    cursor-pointer blur-none tracking-wide antialiased font-roboto text-sm">
                                ABOUT
                            </router-link>
                        </div>
                        <div class="flex items-center w-3/12 px-3 space-x-2 justify-around">
                            <input ref="searchFocus" @keyup.enter="this.handleSubmitSearch($event.target.value)"
                                required
                                class="bg-transparent w-full leading-tight focus:outline-none text-white border-b-2 border-sky-800"
                                type="text" placeholder="Search News, Announcement, Events">
                            <button type="button" @click="Search()"
                                class="lg:block hidden text-2xl text-white hover:text-gray-200 ">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor"
                                    class="w-6 h-6 focus:outline outline-offset-2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div> -->



        <router-view :key="$route.fullPath"></router-view>

        <!-- Footer -->
        <footer class="bg-white dark:bg-gray-800">
            <div id="contact" class="max-w-screen-xl mx-auto lg:py-5 md:p-8 lg:p-10">
                <div class="lg:flex lg:justify-between items-center ">
                    <div class="lg:w-4/12">
                        <h3 class="lg:pb-4 py-4 text-base text-gray-400 w-full text-center block">ABOUT US</h3>
                        <p class="px-4 lg:px-1 text-gray-400 text-justify">
                            The COASTER aims to spearhead the development of technologies and innovation to mitigate
                            and
                            manage coastal disasters and risks in the Philippines. This project is funded by
                            DOST-PCIEERD.
                        </p>
                    </div>
                    <div class="">
                        <h3 class="lg:pb-4 py-3 text-base text-gray-400  text-center block">CONNECT WITH US</h3>
                        <ul class="text-gray-500 dark:text-gray-400 pl-5 lg:pl-0  justify-end">
                            <li class="mb-4">
                                <div class="flex block">
                                    <Icon size="20" type="md-flag" />
                                    Quiling Sur, Batac City, Ilocos Norte, Philippines
                                </div>
                            </li>
                            <li class="mb-4">
                                <div class="flex block">
                                    <Icon size="20" type="logo-google" />
                                    <a class="text-gray-500 dark:text-gray-400 "
                                        href="mailto:coaster@mmsu.edu.ph">coaster@mmsu.edu.ph</a>
                                </div>
                            </li>
                            <li class="mb-4">
                                <div class="flex block">
                                    <Icon size="20" type="logo-facebook" />
                                    <a class="text-gray-500 dark:text-gray-400 "
                                        href="https://www.facebook.com/people/MMSU-Coaster/100088362841925/">www.facebook.com/people/MMSU-Coaster</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="">
                        <h3 class="lg:pb-4 py-3 text-center text-base text-gray-400  block">QUICK LINK</h3>
                        <ul class="text-gray-500 dark:text-gray-400 pl-5 lg:pl-0 justify-end">
                            <li class="lg:mb-4 mb-2">
                                <div class="flex block">
                                    <a href="https://www.dost.gov.ph/">DOST</a>
                                </div>
                            </li>
                            <li class="lg:mb-4 mb-2">
                                <div class="flex block">
                                    <a href="https://pcieerd.dost.gov.ph/">DOST-PCIEERD</a>
                                </div>
                            </li>
                            <li class="lg:mb-4 mb-2">
                                <div class="flex block">
                                    <a href="https://www.mmsu.edu.ph/">MMSU</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-1">
                <div class="text-center">
                    <span class="block text-sm text-center text-gray-500 dark:text-gray-400">© 2022-2023 COASTER.
                        All
                        Rights Reserved.
                    </span>
                </div>
            </div>
        </footer>
        <!-- /Footer -->

    </div>
</template>

<script>
import Downloads from './pages/downloadPage/downloads.vue';
import { defineComponent, ref, reactive, toRefs, watch } from 'vue';
import { MailOutlined, AppstoreOutlined, SettingOutlined } from '@ant-design/icons-vue';

export default defineComponent({
    components: {
        MailOutlined,
        AppstoreOutlined,
        SettingOutlined,
        Downloads
    },
    data() {
        const activeItem1 = ref(false);
        const activeItem2 = ref(false);

        return {
            time: '',
            date: '',
            sideBarDrawer: false,
            activeItem1,
            activeItem2,
            isShowNav: ref(false),
            isSearch: ref(false),
            downloadsModal: ref(false),

        };
    },
    setup() {
        const selectedKeys = ref(['1']);
        const openKeys = ref([]);
        return {
            selectedKeys,
            openKeys,
        };
    },
    watch: {
        $route(to, from) {
            let existingObj = this;
            if (to.path == "/Map" || to.path == "/waterLevel") {
                existingObj.activeItem1 = true;
            } else {
                existingObj.activeItem1 = false;
            }
            if (to.path == "/Map" || to.path == "/waterLevel") {
                existingObj.activeItem2 = true;
            } else {
                existingObj.activeItem2 = false;
            }
        }
    },
    methods: {
        handleIdSelection(id) {
            // Handle the received id in the parent component
            let existingObj = this;
            existingObj.downloadsModal = id;
        },
        handleClick(event) {
            let existingObj = this;
            if (event.key == 1) {
                this.$router.push({ path: '/' })
            }
            else if (event.key == 2) {
                this.$router.push({ path: '/services' })
            }
            else if (event.key == 3) {
                this.$router.push({ path: '/monitoringSystem' })
            }
            else if (event.key == 5) {
                this.$router.push({ path: '/projects/project1' })
            }
            else if (event.key == 6) {
                this.$router.push({ path: '/projects/project2' })
            }
            else if (event.key == 7) {
                this.$router.push({ path: '/projects/project3' })
            }
            else if (event.key == 8) {
                this.$router.push({ path: '/projects/project4' })
            }
            else if (event.key == 9) {
                this.$router.push({ path: '/about' })
            }
        },
        gotoProject(id) {
            let existingObj = this;
            if (id == 1) {
                existingObj.selectedProject = 'Coastal Erosion Trends and Management Strategies for Region 1'
            } else if (id == 2) {
                existingObj.selectedProject = 'Assesment Monitoring, and Prediction of Coastal Flooding of Selected Municipalities in Region 1'
            } else if (id == 3) {
                existingObj.selectedProject = 'Development of Science-based Engineering Approach to Coastal Prediction in Region 1'
            } else if (id == 4) {
                existingObj.selectedProject = 'Enhancing Coastal Design and Infrastructure Intervention through the Establishment of Wave Testing Facility'
            }
            const project = existingObj.selectedProject
            this.$router.push({ name: 'projects', params: { project, id } })
        },
        // zeroPadding(num, digit) {
        //     var zero = '';
        //     for (var i = 0; i < digit; i++) {
        //         zero += '0';
        //     }
        //     return (zero + num).slice(-digit);
        // },
        // updateTime() {
        //     var cd = new Date();
        //     this.digitalTime.year = this.zeroPadding(cd.getYear(), 2);
        //     this.digitalTime.currentMonth = this.digitalTime.month[cd.getMonth()];
        //     this.digitalTime.day = this.zeroPadding(cd.getDate(), 2);
        //     this.digitalTime.date = this.digitalTime.week[cd.getDay()];
        //     this.digitalTime.hour = this.zeroPadding(cd.getHours(), 2);
        //     this.digitalTime.min = this.zeroPadding(cd.getMinutes(), 2);
        //     this.digitalTime.sec = this.zeroPadding(cd.getSeconds(), 2);
        // }
        updateTime() {
            const cd = new Date();

            // Format time
            const hours = cd.getHours();
            const minutes = this.zeroPadding(cd.getMinutes(), 2);
            const seconds = this.zeroPadding(cd.getSeconds(), 2);
            const ampm = hours >= 12 ? 'PM' : 'AM';
            const formattedHour = this.zeroPadding(hours % 12 || 12, 2); // Convert 24-hour to 12-hour format

            this.time = `${formattedHour}:${minutes}:${seconds} ${ampm}`;

            // Format date
            const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
            const formattedDate = `${monthNames[cd.getMonth()]} ${cd.getDate()}, ${cd.getFullYear()}`;

            this.date = formattedDate;
        },
        zeroPadding(number, length) {
            return String(number).padStart(length, '0');
        }
    },
    mounted() {
        window.addEventListener('scroll', this.handleScroll);
        setInterval(() => {
            return this.updateTime();
        }, 1000);
        this.updateTime()
    }
});
</script>


<style scoped>
.router-link-exact-active {
    background-color: rgb(33, 59, 104);
}

.active {
    background-color: rgb(33, 59, 104);
}

.dropdown {
    position: relative;
    display: inline-block;
}

.dropdown-content {
    display: none;
    position: absolute;
    right: 0;
    background-color: rgb(13, 34, 71, .8);
    box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
}

.dropdown-content a {
    padding: 12px 16px;
    text-decoration: none;
    display: block;
}

.dropdown:hover .dropdown-content {
    display: block;
}

.v-enter-active,
.v-leave-active {
    transition: opacity 0.15s ease;
}

.v-enter-from,
.v-leave-to {
    opacity: 0;
}

.slide-fade-enter-active {
    transition: all 0.3s ease-out;
}

.slide-fade-leave-active {
    transition: all 0.1s cubic-bezier(1, 0.5, 0.8, 1);
}

.slide-fade-enter-from,
.slide-fade-leave-to {
    transform: translateX(20px);
    opacity: 0;
}

@keyframes scrollLeft {
    0% {
        transform: translateX(100%);
    }

    100% {
        transform: translateX(-100%);
    }
}

.animate-scroll {
    display: inline-block;
    white-space: nowrap;
    animation: scrollLeft 15s linear infinite;
}

.hover\:animate-paused:hover {
    animation-play-state: paused;
}
</style>
