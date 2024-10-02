<template>
    <div>
        <div>
            <!-- Top View -->
            <div ref="topElement" id="topView" class="w-full hidden lg:block p-0">
                <div class="flex justify-around bg-[#DDE6ED]">
                    <div class="md:flex py-1 ">
                        <div class="flex items-center space-x-2 w-full">
                            <img src="/img/logo/DOST.png" class="blur-none antialiased cursor-pointer object-fill h-16"
                                alt="#">
                            <img src="/img/logo/MMSU.png" class="blur-none antialiased cursor-pointer object-fill h-16"
                                alt="#">
                            <img src="/img/logo/COASTER.png"
                                class="blur-none antialiased cursor-pointer object-fill h-16" alt="#">
                        </div>

                        <div class="p-0 leading-normal pl-1">
                            <div class="text-center grid divide-[#002B5B]/75 divide-y-2 w-full">
                                <div>
                                    <p class="text-5xl font-serif font-semibold text-[#146C94] blur-none antialiased">
                                        COASTER
                                    </p>
                                </div>
                                <div class="text-center text-xs blur-none antialiased">
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
                    <div class="text-sm grid grid-cols-1 gap-1 content-center px-5 ">
                        <div class="text-right leading-loose flex drop-shadow-md">
                            <div class="grid grid-cols-1 gap-1 content-center bg-[#F1F6F9] pl-1 py-1 ">
                                <Icon size="50" type="ios-clock-outline" />
                            </div>
                            <div class=" bg-[#F1F6F9] py-1 pr-2 ">
                                <p class="blur-none antialiased text-4xl font-bold  text-center">{{
                                    this.digitalTime.hour
                                }}:{{ this.digitalTime.min }}:{{ this.digitalTime.sec }}</p>
                                <p class="blur-none antialiased text-sm font-bold text-center">{{ this.digitalTime.date
                                    }} :
                                    {{ this.digitalTime.day }} : {{ this.digitalTime.year }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <nav ref="navElement" style="transition: 0.6s;"
                class=" relative z-30 flex w-full bg-[#002B5B] lg:px-20 md:px-3 sm:px-1 border-y-4 border-cyan-900">
                <div class="px-5 xl:px-12  flex w-full justify-evenly">
                    <!-- Nav Links -->
                    <div class="lg:block hidden">
                        <div class=" lg:flex text-white font-normal font-heading w-full ">
                            <!-- About -->
                            <router-link to="/" class="py-4 px-4 flex text-white font-semibold hover:bg-sky-700 
                                    cursor-pointer blur-none tracking-wide antialiased">
                                HOME
                            </router-link>
                            <!-- /About -->
                            <!-- Weather -->
                            <!-- <a to="/" class="py-4 px-4 flex text-white font-semibold hover:bg-sky-700 
                                cursor-pointer  blur-none tracking-wide antialiased">
                                WEATHER
                            </a> -->
                            <!-- /Weather -->
                            <!-- Monitoring System -->
                            <!-- <router-link to="/MonitoringSystem" class="py-4 px-4 flex text-white font-semibold hover:bg-sky-700 
                                    cursor-pointer  blur-none tracking-wide antialiased">
                                MONITORING SYSTEM
                            </router-link> -->
                            <!-- /Monitoring System -->
                            <!-- Monitoring System -->
                            <router-link to="/services" class="py-4 px-4 flex text-white font-semibold hover:bg-sky-700 
                                    cursor-pointer  blur-none tracking-wide antialiased">
                                SERVICES
                            </router-link>
                            <!-- /Monitoring System -->

                            <!-- Swan -->
                            <router-link to="/Swan" class="py-4 px-4 flex text-white font-semibold hover:bg-sky-700 
                                    cursor-pointer  blur-none tracking-wide antialiased">
                                INTEGRATED MODEL
                            </router-link>
                            <!-- /Swan -->

                            <!-- Map -->
                            <!-- <router-link to="/Map" class="py-4 px-4 flex text-white font-semibold hover:bg-sky-700 
                                    cursor-pointer  blur-none tracking-wide antialiased">
                                HAZARD MAP
                            </router-link> -->
                            <!-- /Map -->

                            <!-- Project -->
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
                                        Coastal Design and Infrastructure Intervention through the Establishment of Wave
                                        Testing Facility</a>
                                </div>
                            </div>
                            <!-- /Project -->
                            <!-- Downloads -->
                            <button @click="downloadsModal = true" class="py-4 px-4 flex text-white font-semibold hover:bg-sky-700 
                                    cursor-pointer  blur-none tracking-wide antialiased">
                                DOWNLOADS
                            </button>
                            <Modal v-model="downloadsModal" width="700" :mask-closable="false">
                                <template #header>
                                    <p style="text-align:center">
                                        <span>Download Request Form</span>
                                    </p>
                                </template>
                                <div class="w-full">
                                    <Downloads class="w-full p-3" @id-selected="handleIdSelection" />
                                </div>
                                <template #footer>
                                    <div class="w-full justify-start flex">

                                    </div>
                                </template>
                            </Modal>
                            <!-- Downloads -->
                            <!-- About -->
                            <div class="dropdown z-40  px-4 flex text-white font-semibold hover:bg-sky-700 
                                    cursor-pointer transition-colors duration-300 " style="float:left;">
                                <button class="dropdown py-4  blur-none tracking-wide antialiased">ABOUT</button>
                                <div class="dropdown-content p-1 w-[17rem] font-normal " style="left:0;">
                                    <a @click="gotoAbout(1)"
                                        class="antialiased text-white text-justify  hover:shadow-[inset_17rem_0_0_0] hover:shadow-cyan-700 duration-[400ms,700ms] transition-[color,box-shadow]">ABOUT</a>
                                    <a @click="gotoAbout(2)"
                                        class="antialiased text-white text-justify  hover:shadow-[inset_17rem_0_0_0] hover:shadow-cyan-700 duration-[400ms,700ms] transition-[color,box-shadow]">DOCUMENTS</a>
                                    <a @click="gotoAbout(3)"
                                        class="antialiased text-white text-justify  hover:shadow-[inset_17rem_0_0_0] hover:shadow-cyan-700 duration-[400ms,700ms] transition-[color,box-shadow]">ORGANIZATION
                                        STRUCTURE</a>
                                    <a @click="gotoAbout(4)"
                                        class="antialiased text-white text-justify  hover:shadow-[inset_17rem_0_0_0] hover:shadow-cyan-700 duration-[400ms,700ms] transition-[color,box-shadow]">ACCOMPLISHMENT</a>
                                </div>
                            </div>
                            <!-- /About -->
                        </div>
                    </div>

                    <div class="flex justify-between w-full lg:hidden block">
                        <!-- Search Bar -->
                        <button @click="sideBarDrawer = true" type="button"
                            class="text-2xl text-white hover:text-gray-200 ">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            </svg>
                        </button>
                        <!-- /Search Bar -->
                        <Drawer placement="left" :closable="false" v-model="sideBarDrawer" :styles="{ padding: '0' }">
                            <div class="w-full border-b-4 flex p-2">
                                <img src="/img/top.png" @click="this.$router.push('/')"
                                    class="w-20 text-center duration-200 blur-none cursor-pointer object-fill mb-2 "
                                    alt="#">
                                <div class="p-0 leading-normal">
                                    <div class="text-center">
                                        <p class="text-2xl font-serif font-semibold text-sky-900 blur-none antialiased">
                                            COASTER
                                        </p>
                                        <div class="text-center text-xs blur-none antialiased">
                                            <p>
                                                Coastal Engineering, Management Research
                                            </p>
                                            <p>
                                                and Development Center
                                            </p>
                                        </div>
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
                                        Monitoring System
                                    </a-menu-item>
                                    <a-menu-item key="3">
                                        <template #icon>
                                            <Icon type="ios-cloud" />
                                        </template>
                                        Map
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
                                    <a-sub-menu key="sub2">
                                        <template #icon>
                                            <Icon type="ios-document" />
                                        </template>
                                        <template #title>About</template>
                                        <a-menu-item key="9">About</a-menu-item>
                                        <a-menu-item key="10">Documents</a-menu-item>
                                        <a-menu-item key="11">Organization Structure</a-menu-item>
                                        <a-menu-item key="12">Accomplishment</a-menu-item>
                                    </a-sub-menu>

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

                    <!-- Search Bar -->
                    <button type="button" @click="Search()"
                        class="lg:block hidden text-2xl text-white hover:text-gray-200 ">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6 focus:outline outline-offset-2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                    </button>
                    <!-- /Search Bar -->
                </div>
            </nav>

            <div v-if="isSearch" class="w-full flex justify-center absolute z-30 ">
                <div class="bg-gray-200 lg:w-3/4 w-full h-14 flex items-center justify-center border-x-2 border-b-2">
                    <div class="lg:w-3/4 w-full flex justify-center items-center">
                        <img src="/img/top.png"
                            class="blur-none antialiased duration-200 blur-none cursor-pointer object-fill h-10 mr-5"
                            alt="#">
                        <input ref="searchFocus" @keyup.enter="this.handleSubmitSearch($event.target.value)" required
                            class="bg-transparent w-full leading-tight focus:outline-none border-b-2 border-sky-800"
                            type="text" placeholder="Search News, Announcement, Events">
                        <button type="submit" class=" p-5">
                            <svg class="h-5 w-5 fill-current" xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px"
                                viewBox="0 0 56.966 56.966" style="enable-background:new 0 0 56.966 56.966;"
                                xml:space="preserve" width="512px" height="512px">
                                <path
                                    d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23  s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92  c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17  s-17-7.626-17-17S14.61,6,23.984,6z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <Transition>
                <nav v-if="isShowNav" class="fixed z-30 top-0 flex w-full bg-[#002B5B] border-y-4 border-cyan-900 ">
                    <div class="w-full">
                        <!-- Nav Links -->
                        <div class="lg:block hidden">
                            <div class="flex justify-center space-x-10 text-white font-normal font-heading w-full">
                                <div class="flex items-center">
                                    <!-- <img src="/img/top.png" class="blur-none antialiased duration-200 blur-none cursor-pointer object-fill h-12 mr-2" alt="#"> -->
                                    <p
                                        class="cursor-pointer text-5xl font-serif font-semibold text-[#146C94] tracking-wide blur-none antialiased">
                                        COASTER
                                    </p>
                                </div>
                                <div class="flex">
                                    <!-- Home -->
                                    <router-link to="/" class="py-4 px-4 flex text-white font-semibold hover:bg-sky-700 
                                        cursor-pointer  blur-none tracking-wide antialiased">
                                        HOME
                                    </router-link>
                                    <!-- Home -->
                                    <router-link to="/MonitoringSystem" class="py-4 px-4 flex text-white font-semibold hover:bg-sky-700 
                                        cursor-pointer  blur-none tracking-wide antialiased whitespace-nowrap">
                                        MONITORING SYSTEM
                                    </router-link>
                                    <!-- /Monitoring System -->


                                    <!-- Swan -->
                                    <router-link to="/Swan" class="py-4 px-4 flex text-white font-semibold hover:bg-sky-700 
                                    cursor-pointer  blur-none tracking-wide antialiased">
                                        INTEGRATED MODEL
                                    </router-link>
                                    <!-- /Swan -->

                                    <!-- Map -->
                                    <router-link to="/Map" class="py-4 px-4 flex text-white font-semibold hover:bg-sky-700 
                                    cursor-pointer  blur-none tracking-wide antialiased">
                                        HAZARD MAP
                                    </router-link>
                                    <!-- /Map -->


                                    <!-- Project -->
                                    <div :class="{ active: activeItem2 }" class="dropdown z-40  px-4 flex text-white font-semibold hover:bg-sky-700 
                                    cursor-pointer transition-colors duration-300 " style="float:left;">
                                        <button
                                            class="dropdown py-4  blur-none tracking-wide antialiased">PROJECT</button>
                                        <div class="dropdown-content p-1 w-[23rem] font-normal " style="left:0;">
                                            <a @click="this.$router.push('/projects/project1')"
                                                class="antialiased text-white text-justify  hover:shadow-[inset_23rem_0_0_0] hover:shadow-cyan-700 duration-[400ms,700ms] transition-[color,box-shadow]">Coastal
                                                Erosion Trends and Management Strategies for Region 1</a>
                                            <a @click="this.$router.push('/projects/project2')"
                                                class="antialiased text-white text-justify  hover:shadow-[inset_23rem_0_0_0] hover:shadow-cyan-700 duration-[400ms,700ms] transition-[color,box-shadow]">Assesment
                                                Monitoring, and Prediction of Coastal Flooding of Selected
                                                Municipalities in
                                                Region 1</a>
                                            <a @click="this.$router.push('/projects/project3')"
                                                class="antialiased text-white text-justify  hover:shadow-[inset_23rem_0_0_0] hover:shadow-cyan-700 duration-[400ms,700ms] transition-[color,box-shadow]">Development
                                                of Science-based Engineering Approach to Coastal Prediction in Region
                                                1</a>
                                            <a @click="this.$router.push('/projects/project4')"
                                                class="antialiased text-white text-justify  hover:shadow-[inset_23rem_0_0_0] hover:shadow-cyan-700 duration-[400ms,700ms] transition-[color,box-shadow]">Enhancing
                                                Coastal Design and Infrastructure Intervention through the Establishment
                                                of
                                                Wave
                                                Testing Facility</a>
                                        </div>
                                    </div>
                                    <!-- /Project -->
                                    <!-- Downloads -->
                                    <button @click="downloadsModal = true" class="py-4 px-4 flex text-white font-semibold hover:bg-sky-700 
                                    cursor-pointer  blur-none tracking-wide antialiased">
                                        DOWNLOADS
                                    </button>
                                    <Modal v-model="downloadsModal" width="700" :mask-closable="false">
                                        <template #header>
                                            <p style="text-align:center">
                                                <span>Download Request Form</span>
                                            </p>
                                        </template>
                                        <div class="w-full">
                                            <Downloads class="w-full p-3" @id-selected="handleIdSelection" />
                                        </div>
                                        <template #footer>
                                            <div class="w-full justify-start flex">

                                            </div>
                                        </template>
                                    </Modal>
                                    <!-- Downloads -->
                                    <!-- About -->
                                    <div class="dropdown z-40  px-4 flex text-white font-semibold hover:bg-sky-700 
                                    cursor-pointer transition-colors duration-300 " style="float:left;">
                                        <button
                                            class="dropdown py-4  blur-none tracking-wide antialiased">ABOUT</button>
                                        <div class="dropdown-content p-1 w-[17rem] font-normal " style="left:0;">
                                            <a @click="gotoAbout(1)"
                                                class="antialiased text-white text-justify  hover:shadow-[inset_17rem_0_0_0] hover:shadow-cyan-700 duration-[400ms,700ms] transition-[color,box-shadow]">ABOUT</a>
                                            <a @click="gotoAbout(2)"
                                                class="antialiased text-white text-justify  hover:shadow-[inset_17rem_0_0_0] hover:shadow-cyan-700 duration-[400ms,700ms] transition-[color,box-shadow]">DOCUMENTS</a>
                                            <a @click="gotoAbout(3)"
                                                class="antialiased text-white text-justify  hover:shadow-[inset_17rem_0_0_0] hover:shadow-cyan-700 duration-[400ms,700ms] transition-[color,box-shadow]">ORGANIZATION
                                                STRUCTURE</a>
                                            <a @click="gotoAbout(4)"
                                                class="antialiased text-white text-justify  hover:shadow-[inset_17rem_0_0_0] hover:shadow-cyan-700 duration-[400ms,700ms] transition-[color,box-shadow]">ACCOMPLISHMENT</a>
                                        </div>
                                    </div>
                                    <!-- /About -->
                                </div>
                                <div class="flex items-center">
                                    <!-- Search Bar -->
                                    <button @click="gotoTop()" type="button"
                                        class="lg:block hidden mr-60 text-2xl text-white hover:text-gray-200 ">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor"
                                            class="w-6 h-6 focus:outline outline-offset-2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                        </svg>
                                    </button>
                                    <!-- /Search Bar -->
                                </div>
                            </div>

                        </div>

                        <div class="flex justify-between w-full lg:hidden block px-5 xl:px-12  ">
                            <button @click="sideBarDrawer = true" type="button"
                                class="text-2xl text-white hover:text-gray-200">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                                </svg>
                            </button>
                            <Drawer placement="left" :closable="false" v-model="sideBarDrawer"
                                :styles="{ padding: '0' }">
                                <div class="w-full border-b-4 flex p-2">
                                    <img src="/img/top.png" @click="this.$router.push('/')"
                                        class="w-20 text-center duration-200 blur-none cursor-pointer object-fill mb-2 "
                                        alt="#">
                                    <div class="p-0 leading-normal">
                                        <div class="text-center">
                                            <p
                                                class="text-2xl font-serif font-semibold text-sky-900 blur-none antialiased">
                                                COASTER
                                            </p>
                                            <div class="text-center text-xs blur-none antialiased">
                                                <p>
                                                    Coastal Engineering, Management Research
                                                </p>
                                                <p>
                                                    and Development Center
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="">
                                    <a-menu v-model:openKeys="openKeys" v-model:selectedKeys="selectedKeys"
                                        mode="inline" @click="handleClick">
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
                                            Monitoring System
                                        </a-menu-item>
                                        <a-menu-item key="3">
                                            <template #icon>
                                                <Icon type="ios-cloud" />
                                            </template>
                                            Map
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
                                        <a-sub-menu key="sub2">
                                            <template #icon>
                                                <Icon type="ios-document" />
                                            </template>
                                            <template #title>About</template>
                                            <a-menu-item key="9">About</a-menu-item>
                                            <a-menu-item key="10">Documents</a-menu-item>
                                            <a-menu-item key="11">Organization Structure</a-menu-item>
                                            <a-menu-item key="12">Accomplishment</a-menu-item>
                                        </a-sub-menu>

                                    </a-menu>
                                </div>
                            </Drawer>
                            <img src="/img/logo/COASTER.png" @click="this.$router.push('/')"
                                class="duration-200 blur-none cursor-pointer object-fill h-14 py-1" alt="#">

                            <!-- Search Bar -->
                            <button @click="gotoTop()" type="button" class="text-2xl text-white hover:text-gray-200 ">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor"
                                    class="w-6 h-6 focus:outline outline-offset-2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                </svg>
                            </button>
                            <!-- /Search Bar -->
                        </div>
                    </div>
                </nav>

            </Transition>

            <router-view :key="$route.fullPath"></router-view>

            <!-- Footer -->
            <footer id="footer" style="" class="bg-white dark:bg-gray-800">
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
            digitalTime: {
                week: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
                month: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                year: '',
                currentMonth: '',
                date: '',
                day: '',
                hour: '',
                min: '',
                sec: '',
            },
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
                this.$router.push({ path: '/monitoringSystem' })
            }
            else if (event.key == 3) {
                this.$router.push({ path: '/map' })
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
                let id = 1
                this.$router.push({ name: 'about', params: { id } })
            }
            else if (event.key == 10) {
                let id = 2
                this.$router.push({ name: 'about', params: { id } })
            }
            else if (event.key == 11) {
                let id = 3
                this.$router.push({ name: 'about', params: { id } })
            }
            else if (event.key == 12) {
                let id = 4
                this.$router.push({ name: 'about', params: { id } })
            }
        },
        handleScroll() {
            const top = this.$refs.topElement
            const nav = this.$refs.navElement
            if (window.scrollY >= top.offsetHeight + nav.offsetHeight - 50) {
                this.isShowNav = true;
            } else {
                this.isShowNav = false;
            }


            if (this.isSearch == true) {
                if (window.scrollY) {
                    // this.isSearch = false;
                }
            }
        },
        Search() {
            if (this.isSearch == false) {
                this.isSearch = true;
                this.$nextTick(() => this.$refs.searchFocus.focus())
            } else {
                this.isSearch = false;
            }

        },
        gotoTop() {
            window.scrollTo({
                top: 0,
                behavior: "smooth"
            });
            this.$nextTick(() => this.$refs.searchFocus.focus())
            this.isSearch = true;
        },
        async handleSubmitSearch(search) {
            this.$router.push({ path: '/search/' + search })
            this.isSearch = false;
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
        gotoAbout(id) {
            this.$router.push({ name: 'about', params: { id } })
        },
        zeroPadding(num, digit) {
            var zero = '';
            for (var i = 0; i < digit; i++) {
                zero += '0';
            }
            return (zero + num).slice(-digit);
        },
        updateTime() {
            var cd = new Date();
            this.digitalTime.year = this.zeroPadding(cd.getYear(), 2);
            this.digitalTime.currentMonth = this.digitalTime.month[cd.getMonth()];
            this.digitalTime.day = this.zeroPadding(cd.getDate(), 2);
            this.digitalTime.date = this.digitalTime.week[cd.getDay()];
            this.digitalTime.hour = this.zeroPadding(cd.getHours(), 2);
            this.digitalTime.min = this.zeroPadding(cd.getMinutes(), 2);
            this.digitalTime.sec = this.zeroPadding(cd.getSeconds(), 2);
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
</style>