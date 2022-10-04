<template>
    <div>
        <HeaderComponent />

        <div class="container-fluid mt-5">
            <div class="row d-flex justify-content-center">
                <div class="card text-center bg-info text-white col-md-2 col-lg-2 col-sm-12 col-xs-12">
                    <div class="card-header">
                        <h5 class="card-title">შემოსული დავალებები</h5>
                    </div>
                    <div class="card-body text-center">
                        <h1>120</h1>
                    </div>
                </div>

                <div class="card text-center bg-warning text-white col-md-2 col-lg-2 col-sm-12 col-xs-12">
                    <div class="card-header">
                        <h5 class="card-title">მიმდინარე დავალებები</h5>
                    </div>
                    <div class="card-body text-center">
                        <h1>1220</h1>
                    </div>
                </div>

                <div class="card text-center bg-danger text-white col-md-2 col-lg-2 col-sm-12 col-xs-12">
                    <div class="card-header">
                        <h5 class="card-title">ვადაგადაცილებული</h5>
                    </div>
                    <div class="card-body text-center">
                        <h1>1120</h1>
                    </div>
                </div>

                <div class="card text-center bg-success text-white col-md-2 col-lg-2 col-sm-12 col-xs-12">
                    <div class="card-header">
                        <h5 class="card-title">დაარქივებული</h5>
                    </div>
                    <div class="card-body text-center">
                        <h1>1209</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import HeaderComponent from "./Layouts/Header.vue";
    //import { QuillEditor } from "@vueup/vue-quill";
    //import '@vueup/vue-quill/dist/vue-quill.snow.css';

    export default {
        name : "HomeComponent",

        components : {
            HeaderComponent,
            //QuillEditor
        }
    }
</script>

<style lang="scss" scoped>
    .card {
        margin-left: 50px !important;
    }
</style>