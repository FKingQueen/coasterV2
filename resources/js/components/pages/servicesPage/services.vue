<template>
    <div class="bg-gradient-to-b from-[#002B5B] w-full flex md:flex justify-center">
        <div class="bg-white  w-3/4">
            <p class="text-2xl">Services</p>
            <p class="text-lg">
                Mapping, Prototyping, Data Monitoring, Sensor Manufacturing, Training
            </p>
            <div class="flex gap-2 ">
                <div class="flex flex-col justify-center items-center font-bold text-4xl border-2 ">
                    <span v-for="(char, index) in text1" :key="index">
                        {{ char }}
                    </span>
                </div>
                <div class="flex flex-col justify-center items-center text-4xl border-2 p-0">
                    <span v-for="(char, index) in text2" :key="index">
                        {{ char }}
                    </span>
                </div>
            </div>
        </div>

    </div>
</template>

<script>

// Vue Libraries
import { defineComponent, reactive, ref, nextTick } from 'vue';
export default defineComponent({
    components: {
    },
    data() {
        return {
            text1: 'COASTER',
            text2: 'SERVICES'
        }
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