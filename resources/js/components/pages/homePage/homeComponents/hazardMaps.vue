<template>
    <div class="laptop:p-5 p-0 space-y-5 w-full">
        <div class="w-full">
            <div class="border-2 rounded drop-shadow-lg w-full">
                <div class="p-3 w-full border lg:flex laptop:space-x-2">
                    <div class="lg:w-2/4 w-full">
                        <!-- <img src="/gif/flood_hazard.gif" alt="" class="w-full"> -->
                        <transition name="fade" mode="out-in">
                            <img :key="currentImage" :src="currentImage" />
                        </transition>
                        <div class="border drop-shadow-lg flex items-center border w-full p-2 justify-center">
                            <p class="">
                                {{ gifHazardName }} at Ilocos Norte, Padsan River
                            </p>
                        </div>
                    </div>
                    <div class="lg:w-2/4 w-full">
                        <div class="flex items-center justify-center">
                            <div class="columns-3 gap-3 ">
                                <div>
                                    <a-image class="w-36" :src="`/gif/soil_classification.png`" :preview="{
                                        src: `/gif/soil_classification.png`,
                                    }" />
                                </div>

                                <div>
                                    <a-image class="w-36" :src="`/gif/without_tidal.png`" :preview="{
                                        src: `/gif/without_tidal.png`,
                                    }" />
                                </div>

                                <div>
                                    <a-image class="w-36" :src="`/gif/Tide vs Without Tide.png`" :preview="{
                                        src: `/gif/Tide vs Without Tide.png`,
                                    }" />
                                </div>

                                <div>
                                    <a-image class="w-36" :src="`/gif/TIDE without.png`" :preview="{
                                        src: `/gif/TIDE without.png`,
                                    }" />
                                </div>

                                <div>
                                    <a-image class="w-36" :src="`/gif/Typhoon_without_tidal.png`" :preview="{
                                        src: `/gif/Typhoon_without_tidal.png`,
                                    }" />
                                </div>

                                <div>
                                    <a-image class="w-36" :src="`/gif/With Tidal Depth.png`" :preview="{
                                        src: `/gif/With Tidal Depth.png`,
                                    }" />
                                </div>

                                <div>
                                    <a-image class="w-36" :src="`/gif/with_tidal.png`" :preview="{
                                        src: `/gif/with_tidal.png`,
                                    }" />
                                </div>

                                <div>
                                    <a-image class="w-36" :src="`/gif/Without Tidal Depth.png`" :preview="{
                                        src: `/gif/Without Tidal Depth.png`,
                                    }" />
                                </div>

                                <div>
                                    <a-image class="w-36" :src="`/gif/FD_with_tidal.png`" :preview="{
                                        src: `/gif/FD_with_tidal.png`,
                                    }" />
                                </div>
                            </div>
                        </div>
                        <div class="w-full flex justify-end">
                                <a-button @click="$router.push('/hazardmaps')" type="primary">Open Hazard Map</a-button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { defineComponent, ref, reactive, toRefs, watch } from 'vue';
export default defineComponent({
    data() {
        return {
            isFirstImage: true,
            // Replace these URLs with your actual image URLs
            intervalId: null,
            gifHazardName: 'Flood Hazard Map',
            currentImage: '/gif/hazard.gif',
        }
    },
    mounted() {
        // Start the interval when component is mounted
        this.startImageToggle()
    },
    beforeDestroy() {
        // Clean up interval when component is destroyed
        this.stopImageToggle()
    },
    methods: {
        startImageToggle() {
            this.intervalId = setInterval(() => {
                this.isFirstImage = !this.isFirstImage
                if (this.isFirstImage == true) {
                    this.gifHazardName = 'Flood Hazard Map'
                }
                if (this.isFirstImage == false) {
                    this.gifHazardName = 'Flood Depth Map'
                }
            }, 6000) // 6 seconds
        },
        stopImageToggle() {
            if (this.intervalId) {
                clearInterval(this.intervalId)
            }
        }
    }
});
</script>
<style scoped>
.image-container {
    width: 100%;
    max-width: 500px;
    margin: 0 auto;
}

/* Fade transition effects */
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.1s;
}

.fade-enter,
.fade-leave-to {
    opacity: 5;
}
</style>
