<template>
    <div class="flex justify-center py-5">
        Location {{ isActiveLocation }}
    </div>
</template>

<script>
export default {
    props: ['isActiveLocation'],
    created() {
        console.log(this.isActiveLocation)
    }
}
</script>