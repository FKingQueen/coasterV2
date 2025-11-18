<template>
    <div class="w-full flex md:flex justify-center pt-3 bg-gradient-to-b from-[#002B5B]">
        <div class="w-full sm:w-11/12">
            <Tabs type="card" >
                <TabPane label="Water Level Sensor" class="bg-white">
                    <div class="block sm:flex">
                        <div class="w-full sm:w-1/2 drop-shadow-lg p-1">
                            <div>
                                <WaterLevel class="w-full p-3" :id="1" />
                            </div>
                            <div>
                                <p class="text-center font-thin text-sm">
                                    Sensor Location
                                </p>
                                <WaLevLocation class="w-full" :id="1" />
                                <p class="text-center font-thin text-xs">
                                    Laoag City, Ilocos Norte
                                </p>
                            </div>
                        </div>
                        <div class="w-full sm:w-1/2 drop-shadow-lg p-1">
                            <div>
                                <WaterLevel class="w-full p-3" :id="2" />
                            </div>
                            <div>
                                <p class="text-center font-thin text-sm">
                                    Sensor Location
                                </p>
                                <WaLevLocation class="w-full" :id="2" />
                                <p class="text-center font-thin text-xs">
                                    Santa, Ilocos Sur
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="p-3">
                        <p class="text-justify px-5 md:px-0">
                            <span class="font-semibold">Data Details:</span> The data presented here is based on
                            research and analysis conducted by the CoastEr Program. It may not conform to the standards
                            or quality control procedures associated with official government or industry data sources.
                        </p>
                        <div class="px-10 flex pt-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                            </svg>
                            <p class="text-justify">
                                The water level monitoring system in Laoag City, Ilocos Norte, and Santa, Ilocos Sur,
                                collects real-time data on water levels, humidity, and temperature of the river.
                            </p>
                        </div>
                    </div>
                </TabPane>
                <TabPane label="Buoy Sensor"  class="bg-white">
                    <!-- <div class="block sm:flex"> -->
                    <div class="flex justify-center">
                        <!-- <div class="w-full sm:w-1/2  drop-shadow-lg p-1"> -->
                        <div class="w-full drop-shadow-lg p-1">
                            <div>
                                <Buoy class="w-full p-3" :id="1" />
                            </div>
                            <div>
                                <p class="text-center font-thin text-sm">
                                    Sensor Location
                                </p>
                                <buoyLocation class="w-full" :id="1" />
                                <p class="text-center font-thin text-xs">
                                    Laoag City, Ilocos Norte
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="p-3">
                        <p class="text-justify px-5 md:px-0">
                            <span class="font-semibold">Data Details:</span> The data presented here is based on
                            research and analysis conducted by the CoastEr Program. It may not conform to the standards
                            or quality control procedures associated with official government or industry data sources.
                        </p>
                        <div class="px-10 flex pt-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                            </svg>
                            <p class="text-justify">
                                The Buoy monitoring system in Laoag City, Ilocos Norte, and Santa, Ilocos Sur,
                                collects real-time data on water height, tide height, wave period, wave power, wave temperature and air temperature.
                            </p>
                        </div>
                    </div>
                </TabPane>
            </Tabs>
        </div>
    </div>
</template>

<script>

// Vue Libraries
import { defineComponent, reactive, ref, nextTick } from 'vue';
// Components
import Places from './components/places';
import WaterLevel from './components/waterLevel';
import Buoy from './components/buoy';
import WaLevLocation from './components/walevLocation';
import buoyLocation from './components/buoyLocation';
export default defineComponent({
    components: {
        WaterLevel,
        Places,
        Buoy,
        WaLevLocation,
        buoyLocation,
    },
    data() {
        return {

        };
    },
    async mounted() {

    },
    methods: {
    }
});
</script>

<style></style>

<style scoped>
.active {
    /* color: rgb(31 41 55); */
    background-color: #cee53a;
    color: white;
}
</style>
