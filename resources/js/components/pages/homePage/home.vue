<template>
    <div class="">
        <div class="w-full flex justify-center space-x-2 bg-gradient-to-b from-[#002B5B] pt-2 text-white">
            <div class="sm:w-2/4 w-full">
                <Forecast class="w-full" />
            </div>
            <div class="sm:w-1/4 w-full items-center flex drop-shadow-lg">
                <Station class="w-full" />
            </div>
        </div>
        <!-- <div class="w-full flex justify-center space-x-2">
            <div class="font-norwester w-3/4  p-3">
                <p class="text-2xl font-black">Hazard Maps</p>
            </div>
        </div> -->
        <div class="mt-5 w-full bg-gradient-to-l from-sky-950  flex justify-center py-4">
            <div class=" w-3/4">
                <p class="text-2xl text-semibold">Hazard Maps</p>
            </div>
        </div>
        <div class="w-full flex justify-center space-x-2">
            <div class="w-3/4">
                <HazardMaps class="w-full" />
            </div>
        </div>
        <div class="mt-5 w-full bg-gradient-to-l from-sky-950  flex justify-center py-4">
            <div class=" w-3/4">
                <p class="text-2xl text-semibold">News & Media</p>
            </div>
        </div>
        <div class="w-full flex justify-center space-x-2">
            <div class="w-3/4">
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