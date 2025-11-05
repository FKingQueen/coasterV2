<template>
    <div class="w-full h-full">
        <iframe 
            src="https://coaster.mmsu.edu.ph/coastervisualize/" 
            :style="minHeightStyle"
            class="w-full"
            >
        </iframe>
    </div>
</template>

<script>
export default {
    data() {
        return {
            screenHeight: window.innerHeight-100
        };
    },
    computed: {
        minHeightStyle() {
            console.log(this.screenHeight);
            return {
                minHeight: `${this.screenHeight+11}px`
            }
        }
    }
};
</script>

<style>
/* Include any additional styles you need here */
</style>
