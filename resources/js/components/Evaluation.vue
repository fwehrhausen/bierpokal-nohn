<template>

</template>

<script>
export default {
    name: "Evaluation",
    data() {
        return {
            data: null,
            processing: false,
        }
    },
    methods: {
        getBookedModules() {
            axios.get('/api/v1/...').then(({data}) => {
                this.data = data.data;
            }).catch(({response}) => {


            }).finally(() => {
                this.processing = false
            })
        },

    },
    mounted() {
        //
    },
    computed: {
        //
    }
}
</script>

<style scoped>

</style>
