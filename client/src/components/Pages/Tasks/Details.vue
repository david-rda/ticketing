<template>
    <div>
        <HeaderComponent />

        <div class="mt-5 container-fluid bg-white">

        </div>
    </div>
</template>

<script>
    import HeaderComponent from "../Layouts/Header.vue";
    import axios from "axios";

    export default {
        name : "TaskDetails",

        data() {
            return {

            }
        },

        components : {
            HeaderComponent
        },

        async mounted() {
            this.$store.commit("setToken");

            const loaded_task = await axios.get("http://172.16.30.19/ticketing/server/public/api/task/get/" + this.$route.params.id, {
                headers : {
                    "Authorization" : `Bearer ${this.$store.state.token}`
                }
            });

            console.log(loaded_task);
        },

        methods : {

        }
    }
</script>

<style scoped lang="scss">
    @import "../../../assets/css/variables.scss";

    .custom-container {
        padding: 20px;
        border-radius: 6px;
    }

</style>