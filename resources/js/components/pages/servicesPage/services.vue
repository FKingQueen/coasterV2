<template>
    <div class="w-full flex md:flex justify-center pt-3">
        <div class="w-full sm:w-5/6">
            <Tabs type="card">
                <TabPane label="Water Level Sensor">
                    <div class="block sm:flex">
                        <div class="w-full sm:w-1/2 drop-shadow-lg p-1">
                            <div>
                                <WaterLevel class="w-full" :id="1" />
                                <div class="flex justify-end">
                                    <a-button type="link" @click="downloadRequest(1)">Data Request</a-button>
                                </div>
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
                                <WaterLevel class="w-full" :id="2" />
                                <div class="flex justify-end">
                                    <a-button type="link" @click="downloadRequest(2)">Data Request</a-button>
                                </div>
                            </div>
                            <div>
                                <p class="text-center font-thin text-sm">
                                    Sensor Location
                                </p>
                                <WaLevLocation class="w-full" :id="2" />
                                <p class="text-center font-thin text-xs">
                                    Santa, Ilocos Norte
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="py-3">
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
                <TabPane label="Buoy Sensor">
                    <div class="block sm:flex">
                        <div class="w-full sm:w-1/2  drop-shadow-lg p-1">
                            <div>
                                <Buoy class="w-full" :id="1" />
                                <div class="flex justify-end">
                                    <a-button type="link" @click="downloadRequest(3)">Data Request</a-button>
                                </div>
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
                        <div class="w-full sm:w-1/2  drop-shadow-lg p-1">
                            <div>
                                <Buoy class="w-full" :id="2" />
                                <div class="flex justify-end">
                                    <a-button type="link" @click="downloadRequest(4)">Data Request</a-button>
                                </div>
                            </div>
                            <div>
                                <p class="text-center font-thin text-sm">
                                    Sensor Location
                                </p>
                                <buoyLocation class="w-full" :id="2" />
                                <p class="text-center font-thin text-xs">
                                    Santa, Ilocos Sur
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="py-3">
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
                                collects real-time data on tide height, water
                                temperature,air temperature, wave period, and significant wave height.
                            </p>
                        </div>
                    </div>
                </TabPane>
                <TabPane label="Hazard Maps">
                    <div class="block sm:flex">
                        <hazardMap class="w-full" />
                    </div>
                    <div class="py-3">
                        <p class="text-justify px-5 md:px-0">
                            <span class="font-semibold">Data Details:</span> The data presented here is based on
                            research and analysis conducted by the CoastEr Program. It may not conform to the standards
                            or quality control procedures associated with official government or industry data sources.
                        </p>
                    </div>
                </TabPane>
            </Tabs>
        </div>
    </div>

    <Modal v-model="downloadsModal" width="700" :mask-closable="false" @on-cancel="cancelModal()">
        <template #header>
            <p style="text-align:center">
                <span>Download Request Form</span>
            </p>
        </template>
        <div class="w-full">
            <div>
                <Alert class="text-justify">The data acquisition will take 1-3 days, as the administrators will correct the raw data gathered
                    from
                    the sensors. Once corrected, they will email the data to the email address you provide below. Please
                    fill
                    out the input boxes. Thank you!</Alert>
            </div>
            <Downloads class="w-full p-3" :id="routeID" />
        </div>
        <template #footer>
            <div class="w-full justify-start flex">

            </div>
        </template>
    </Modal>

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
import hazardMap from '../mapPage/map';
import Downloads from '../downloadPage/downloads.vue';
export default defineComponent({
    components: {
        WaterLevel,
        Places,
        Buoy,
        WaLevLocation,
        buoyLocation,
        hazardMap,
        Downloads
    },
    data() {
        return {
            downloadsModal: ref(false),
            routeID: null,
        };
    },
    async mounted() {

    },
    methods: {
        downloadRequest(id) {
            let thiss = this;
            thiss.downloadsModal = true;
            thiss.routeID = id;
        },
        cancelModal() {
            let thiss = this;
            thiss.routeID = null;
        }
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