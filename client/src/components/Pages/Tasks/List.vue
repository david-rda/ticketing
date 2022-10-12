<template>
    <div>
        <HeaderComponent />
    </div>
</template>

<script>
    import HeaderComponent from "../Layouts/Header.vue";

    export default {
        name : "TaskList",

        components : {
            HeaderComponent
        },

        mounted() {
            document.title = "ჩემი დავალებები"
        }
    }
</script>

<style scoped lang="scss">
    @import "../../../assets/css/variables.scss";
</style>