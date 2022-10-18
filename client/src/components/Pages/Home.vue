<template>
    <div>
        <HeaderComponent />

        <div class="container mt-5">
            <div class="row gx-5 gy-3">
                <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
                    <div class="mb-3 text-center card-custom p-3" style="background-color:#F8EEE6">
                        <p><b class="heading">შემოსული</b></p>
                        <p><b>{{ new_tasks_count }}</b></p>
                    </div>
                </div>

                <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
                    <div class="mb-3 text-center card-custom p-3" style="background-color:#EDDBDA">
                        <p><b class="heading">მიმდინარე</b></p>
                        <p><b>{{ 0 }}</b></p>
                    </div>
                </div>

                <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
                    <div class="mb-3 text-center card-custom p-3" style="background-color:#E4DDEF">
                        <p><b class="heading">ვადაგადაცილებული</b></p>
                        <p><b>{{ 0 }}</b></p>
                    </div>
                </div>

                <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
                    <div class="mb-3 text-center card-custom p-3" style="background-color:#BEDCDB">
                        <p><b class="heading">დაარქივებული</b></p>
                        <p><b>{{ 0 }}</b></p>
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
    .card-custom {
        border-radius: 10px;
    }
</style>