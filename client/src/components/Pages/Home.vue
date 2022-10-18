<template>
    <div>
        <HeaderComponent />

        <div class="container mt-5">
            <div class="row gx-5 gy-3">
                <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
                    <div class="card text-center bg-info text-white">
                        <div class="card-header">
                            <h5 class="card-title">შემოსული</h5>
                        </div>
                        <div class="card-body text-center">
                            <h1>{{ new_tasks_count }}</h1>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
                    <div class="card text-center bg-warning text-white">
                        <div class="card-header">
                            <h5 class="card-title">მიმდინარე</h5>
                        </div>
                        <div class="card-body text-center">
                            <h1>{{ 0 }}</h1>
                        </div>
                    </div>
                </div>

                <div class=" col-md-3 col-lg-3 col-sm-12 col-xs-12">
                    <div class="card text-center bg-danger text-white">
                        <div class="card-header">
                            <h5 class="card-title">ვადაგადაცილებული</h5>
                        </div>
                        <div class="card-body text-center">
                            <h1>{{ 0 }}</h1>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
                    <div class="card text-center bg-success text-white">
                        <div class="card-header">
                            <h5 class="card-title">დაარქივებული</h5>
                        </div>
                        <div class="card-body text-center">
                            <h1>{{ 0 }}</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import HeaderComponent from "./Layouts/Header.vue";
    import { load_tasks } from "../../helpers/helper";

    export default {
        name : "HomeComponent",

        data() {
            return {
                tasks : [],
                new_tasks_count : 0
            }
        },

        components : {
            HeaderComponent,
        },

        async mounted() {
            document.title = "მთავარი";
            this.$store.commit("setToken");

            const tasks = await load_tasks(this.$store.state.token); // კონკრეტული იუზერის დავალების ჩატვირთვის ფუნქცია

            this.tasks = tasks.data;
            this.new_tasks_count = tasks.data.count; // დაითვლება შემოსული დავალებების რაოდენობა
        },
    }
</script>

<style lang="scss" scoped>

</style>