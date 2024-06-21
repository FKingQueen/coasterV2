<template>
    <div class="flex justify-center py-5">Test API</div>
</template>

<script>
export default {
    async created() {
        let existingObj = this;
        await axios.get('/api/getMsg')
            .then(function (response) {
                console.log('get: ',response);
            })
            .catch(function (error) {
            });

        // axios.post(`/postApi`, { msg: 'message' })
        //     .then(function (response) {
        //         console.log('post: ',response.data)
        //     })
        //     .catch(function (error) {
        //     });
    },
};
</script>
