<template>
    <div>
        <HeaderComponent />

    </div>
</template>

<script>
    import HeaderComponent from "../Layouts/Header.vue";

    export default {
        name : "AddTask",

        data() {
            return {
                end_date : new Date(),
                priority : "",
                title : "",
                performers : []
            }
        },

        components : {
            HeaderComponent,
        },

        mounted() {
            document.title = "თასქის დამატება";
        },
    }
</script>

<style scoped lang="scss">
    @import "../../../assets/css/variables.scss";
</style>