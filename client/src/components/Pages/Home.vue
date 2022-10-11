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
            <table class="table">
                <thead>
                    <tr>
                        <th>დასახელება</th>
                        <th>აღწერა</th>
                        <th>ვადა</th>
                        <th>პრიორიტეტი</th>
                        <th>სტატუსი</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="data in tasks" :key="data.task_id">
                        <td>
                            <button type="button" v-bind:class="data.status_id == 4 ? 'btn btn-success' : 'btn btn-secondary' " @click="markAs($event)" ref="mark" :data-task-id="data.task_id"><BIconCheckCircleFill class="pointer" /></button>
                            <span>&nbsp;&nbsp;&nbsp;{{ data.title }}</span>
                        </td>
                        <td class="desc">
                            <span v-html="data.description"></span>
                        </td>
                        <td>
                            {{ data.end_date }}
                        </td>
                        <td>
                            {{ data.priority_id }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    import HeaderComponent from "./Layouts/Header.vue";
    import axios from "axios";

    export default {
        name : "HomeComponent",

        data() {
            return {
                tasks : []
            }
        },

        components : {
            HeaderComponent,
        },

        async mounted() {
            document.title = "მთავარი";
            this.$store.commit("setToken");

            const load_tasks = await axios.get("http://localhost:8000/api/task/list", {
                headers : {
                    "Authorization" : `Bearer ${this.$store.state.token}`
                }
            });

            this.tasks = load_tasks.data;
        },

        methods : {
            async markAs(e) {
                let id = e.target.getAttribute("data-task-id");

                await axios.put("http://localhost:8000/api/task/mark/" + id, {}, {
                    headers : {
                        "Authorization" : `Bearer ${this.$store.state.token}`
                    }
                });

                const load_tasks = await axios.get("http://localhost:8000/api/task/list", {
                    headers : {
                        "Authorization" : `Bearer ${this.$store.state.token}`
                    }
                });

                this.tasks = load_tasks.data;
            }
        }
    }
</script>

<style lang="scss" scoped>
    .card {
        margin-left: 50px !important;
        border-radius: 10px;
    }

    .bg-info {
        background-color: lighten(#0dcaf0, 35%) !important;
        color: #0dcaf0 !important;
        border: none;
    }

    .bg-warning {
        background-color: lighten(#ffc107, 35%) !important;
        color: #ffc107 !important;
        border: none;
    }

    .bg-danger {
        background-color: lighten(#dc3545, 35%) !important;
        color: #dc3545 !important;
        border: none;
    }

    .bg-success {
        background-color: lighten(#198754, 35%) !important;
        color: #198754 !important;
        border: none;
    }

    .card-header {
        border: none;
        background-color: rgba(#fff, .0);
    }

    table {
        font-size: 14px;
    }

    .pointer {
        pointer-events: none;
    }

    .desc {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>