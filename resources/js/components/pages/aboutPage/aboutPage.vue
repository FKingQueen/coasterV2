<template>
    <div class="absolute w-full min-h-[800px] bg-gradient-to-b from-[#002B5B] z-0 opacity-90">
        <img src="/img/background/building_location.jpg" class="object-cover w-full " alt="#">
    </div>
    <div class="w-full laptop:min-h-[700px] monitor:min-h-[900px] ">
        <div class="z-40 relative w-full flex justify-center pt-5">
            <img src="/img/logo/COASTER.png" class="w-44 h-44 " alt="#">
        </div>
        <div class="w-full flex justify-center py-5">
            <div class="w-3/4 bg-white drop-shadow-lg text-black p-5 rounded"
                style="background: rgba(255, 255, 255, 0.50); backdrop-filter: blur(3px);">
                <div>
                    <div class="flex justify-center">
                        <div class="w-2/4 text-center grid divide-[#C49A6C]/75 divide-y-4">
                            <div>
                                <p class="text-5xl  font-serif font-semibold blur-none antialiased ">
                                    COASTER
                                </p>
                            </div>
                            <div class="text-center font-sans text-base blur-none antialiased">
                                <p>
                                    Coastal Engineering and Management
                                </p>
                                <p>
                                    Research and Development Center
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="p-10">
                        <h1
                            class="text-4xl w-fit font-sans font-semibold bg-gradient-to-r from-[#002B5B] to-[#C49A6C] text-transparent bg-clip-text">
                            WHO WE ARE
                        </h1>
                        <div class="">
                            <p>
                                The Coastal Engineering Research Center or CoastER Center is the country’s first coastal
                                engineering and management research and development center and the hub of innovations
                                for
                                coastal resiliency. This facility will spur the development of innovations that address
                                coastal erosion, development construction materials for coastal protection, policies,
                                and
                                guidelines intended to protect resources from coastal flooding and improve the lives of
                                people in coastal communities. It will also bolster the capability of Filipino engineers
                                towards coastal engineering leading to the development of a master’s degree for coastal
                                engineering. <a @click="clickOS()" class="underline">Organization Structure</a>
                            </p>
                        </div>
                    </div>
                    <div class="">
                        <p>
                            WHAT WE DO
                        </p>
                        <p>
                            The COASTER aims to spearhead the development of technologies and innovation to mitigate and
                            manage coastal disasters and risks. The overall goal of the center is to take the lead in
                            coastal science and engineering studies to better undertand the magniture of certain process
                            and hazards and their impacts on the maritime environment including tidal deltas and
                            low-lying lands.
                        </p>
                    </div>
                    <div class="">
                        <p>
                            WHERE WE ARE
                        </p>
                        <p>
                            The Coastal Engineering Research Center or CoastER Center is located in #16 Quiling Sur,
                            City of Batac 2906 Ilocos Norte, within the Mariano Marcos State University, in front of
                            College of Engineering (COE)
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { defineComponent, ref } from "vue";
export default defineComponent({
    data() {
        return {
        };
    },
    methods: {

    },
    async created() {
    }
});
</script>
