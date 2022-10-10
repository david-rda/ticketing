<template>
    <div>
        <HeaderComponent />

        <div class="container-fluid mt-5">
            <div class="row d-flex justify-content-center">
                <div class="card text-center bg-info text-white col-md-2 col-lg-2 col-sm-12 col-xs-12">
                    <div class="card-header">
                        <h5 class="card-title">შემოსული</h5>
                    </div>
                    <div class="card-body text-center">
                        <h1>120</h1>
                    </div>
                </div>

                <div class="card text-center bg-warning text-white col-md-2 col-lg-2 col-sm-12 col-xs-12">
                    <div class="card-header">
                        <h5 class="card-title">მიმდინარე</h5>
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

        <div class="modal fade" role="modal" id="addTaskModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">თასქის დამატება</h5>
                    </div>
                    <div class="modal-body">

                    </div>
                    <div class="modal-footer">
                        
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid bg-white mt-5">
            <table class="table table-hover">
                <thead class="text-center">
                    <tr>
                        <th>დასახელება</th>
                        <th>შემსრულებლები</th>
                        <th>ვადა</th>
                        <th>პრიორიტეტი</th>
                        <th>სტატუსი</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</template>

<script>
    import HeaderComponent from "./Layouts/Header.vue";

    export default {
        name : "HomeComponent",

        components : {
            HeaderComponent,
        },
    }
</script>

<style lang="scss" scoped>
    .card {
        margin-left: 50px !important;
    }
</style>