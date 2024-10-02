<template>
    <div class="w-full h-[68vh] overflow-auto">
        <div class="h-full">
            <div class="w-full flex justify-center">
                <div class="w-11/12  drop-shadow-md">
                    <Image :src="`/inventory/${dataMarker.image}`" class="object-cover  border" />
                </div>
            </div>
            <p class="w-full flex justify-center text-sm pt-2">
                Lat. {{ dataMarker.latitude }}, Lng {{ dataMarker.longitude }}
            </p>
            <div class="px-5 pb-5 divide-y">
                <p class="text-sm py-1"> <span class="font-semibold">Coastal Identification:</span> {{ dataMarker.coastalID }}</p>
                <p class="text-sm py-1"> <span class="font-semibold">Province:</span> {{ dataMarker.province }}</p>
                <p class="text-sm py-1"> <span class="font-semibold">Coastal Protection:</span> {{ dataMarker.coastalProtection }}</p>
                <p class="text-sm py-1"> <span class="font-semibold">Location Type:</span> {{ dataMarker.locationType }}</p>
                <p class="text-sm py-1"> <span class="font-semibold">Estimdated Yr. of Completed:</span> {{ dataMarker.yearCompleted }}</p> 
                <div class="py-1">
                    <p class="text-sm py-1"> <span class="font-semibold">Length (m):</span> {{ dataMarker.length}}</p>
                    <p class="text-sm py-1"> <span class="font-semibold">Height Range:</span> {{ dataMarker.heightRange }}</p>
                    <p class="text-sm py-1"> <span class="font-semibold">Primary Material:</span> {{ dataMarker.primaryMaterial }}</p>
                </div>
                <div class="py-1">
                    <p class="text-sm py-1"> <span class="font-semibold">Condition Rating:</span> {{ dataMarker.conditionRating }}</p>
                    <div class="text-sm py-1"> <span class="font-semibold">Description:</span> <p class="text-sm py-1" v-html="dataMarker.crDesc"></p> </div>
                </div>
                <div class="py-1">
                    <p class="text-sm py-1"> <span class="font-semibold">Priority Rating:</span> {{ dataMarker.priorityRating }}</p>
                    <div class="text-sm py-1"> <span class="font-semibold">Description:</span> <p class="text-sm py-1" v-html="dataMarker.prDesc"></p> </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { defineComponent, ref } from 'vue';
export default defineComponent({
    props: ['id'],
    data() {
        return {
            markers: '',
            dataMarker: ''
        }
    },
    async created() {
        let existingObj = this;
        console.log(this.id);
        await axios.get('/api/getHomeInventory')
            .then(response => {
                existingObj.markers = response.data
                console.log(response.data);
            })
            .catch(function (error) {
                console.error(error);
            });

        for (let i = 0; i < existingObj.markers.length; i++) {
            if (this.id == existingObj.markers[i].id) {
                existingObj.dataMarker = existingObj.markers[i]
            }
        }
        console.log(existingObj.dataMarker);
    }
})
</script>

