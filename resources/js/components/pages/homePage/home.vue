<template>
    <div class="">
        <div class="w-full lg:flex justify-center lg:space-x-2  space-x-0 bg-gradient-to-b from-[#002B5B] pt-2 text-white">
            <div class="lg:w-2/4 w-full">
                <Forecast class="w-full" />
            </div>
            <div class="lg:w-1/4 w-full lg:p-0 p-3 flex items-center">
                <Station class="w-full" />
            </div>
        </div>
        <div class="mt-5 w-full bg-gradient-to-l from-sky-950  flex justify-center py-4">
            <div class="lg:w-3/4 w-full lg:pl-0 pl-1">
                <p class="text-2xl text-semibold">Hazard Maps</p>
            </div>
        </div>
        <div class="w-full flex justify-center space-x-2">
            <div class="lg:w-3/4 w-full">
                <HazardMaps class="w-full" />
            </div>
        </div>
        <div class="mt-5 w-full bg-gradient-to-l from-sky-950  flex justify-center py-4">
            <div class=" lg:w-3/4 w-full lg:pl-0 pl-1">
                <p class="text-2xl text-semibold">News & Media</p>
            </div>
        </div>
        <div class="w-full flex justify-center space-x-2">
            <div class="lg:w-3/4 w-full">
                <Article class="w-full" />
            </div>
        </div>

    </div>
</template>
<script>


import Forecast from './homeComponents/forecast.vue'
import Station from './homeComponents/station.vue'
import Article from './homeComponents/article.vue'
import HazardMaps from './homeComponents/hazardMaps.vue'

import { defineComponent, ref, computed, watch, watchEffect } from 'vue';
export default defineComponent({
    components: {
        Forecast,
        Station,
        Article,
        HazardMaps,
    },
    setup() {
        return {
        };
    },
    data() {
        return {
        }
    },
    methods: {
    },
    async created() {
    },
    mounted() {
    },
});
</script>

<style scoped></style>
