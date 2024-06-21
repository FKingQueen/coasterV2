<template>
    <div class="flex justify-center py-10 pb-20">
        <div class="w-full">
            <div>
                <p class="text-center text-5xl font-serif font-semibold text-[#146C94] blur-none antialiased">
                    DOWNLOADS
                </p>
            </div>
            <div class="pb-5">
                <p class="text-center">
                    Download Link(s) will expire on {{ this.expireDate }} (Philippine Time)
                </p>
            </div>
            <div class="w-full flex justify-center ">
                <div class="w-1/2">        
                    <Table border :columns="columns" :data="data">
                    <template #id="{ index }">
                        <strong>{{ index }}</strong>
                    </template>
                    <template #action="{ row, index }">
                        <Button type="primary" size="small" style="margin-right: 5px" @click="show(index)">Download</Button>
                    </template>
                </Table>
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
            data: [],
            expireDate: '',
            isExpired: '',
            columns: 
            [
                {
                    title: '#',
                    slot: 'id',
                    resizable: true,
                    width: 45
                },
                {
                    title: 'Coastal Hazard Map',
                    key: 'name',
                    resizable: true,
                },
                {
                    title: '',
                    slot: 'action',
                    resizable: true,
                    width: 113
                }
            ],
        };
    },
    methods: {
        // expireDate(){

        // },
        checkDate() {
            let existingObj = this;
            let givenDate = new Date(existingObj.data[0].created_at);
            let currentDate = new Date();
            let timeDifference = currentDate - givenDate;
            let daysDifference = timeDifference / (1000 * 60 * 60 * 24);
            // console.log(daysDifference);

            if (daysDifference >= 7) {
                existingObj.isExpired = true;

            } else {
                existingObj.isExpired = false;

                givenDate.setDate(givenDate.getDate() + 7);
                const options = { year: 'numeric', month: 'long', day: 'numeric' };
                existingObj.expireDate = givenDate.toLocaleString('en-US', options);

                console.log(existingObj.expireDate)
            }


        }
    },
    async created() {
        let existingObj = this;
        let id = this.$route.params.id
        await axios.get(`/api/getDownloads/${id}`)
            .then(function (response) {
                existingObj.data = response.data[0].download_info
                // console.log(existingObj.data    );
                existingObj.checkDate();
            })
            .catch(function (error) {

            });
        console.log(existingObj.data[0].download_info);
    }
});
</script>
