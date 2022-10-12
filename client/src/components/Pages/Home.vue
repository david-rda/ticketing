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
                        <h1>{{ new_tasks_count }}</h1>
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

        <div class="container-fluid mt-5 bg-white" style="width: 95% !important">
            <table class="table table-hover">
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
                    <tr v-for="data in tasks.tasks" :key="data.task_id" v-bind:class="data.status_id == 4 ? 'table-success' : '' ">
                        <td>
                            <button type="button" v-bind:class="data.status_id == 4 ? 'btn btn-success' : 'btn btn-outline-secondary' " @click="markAs($event)" ref="mark" :data-task-id="data.task_id"><BIconCheck2 class="pointer" /></button>
                            <span>&nbsp;&nbsp;&nbsp;{{ data.title }}</span>
                        </td>
                        <td>
                            <span v-html="data.description"></span>
                        </td>
                        <td>
                            {{ data.end_date }}
                        </td>
                        <td class="text-center">
                            {{ data.priority_id }}
                        </td>
                        <td class="text-center"></td>
                        <td>
                            <router-link :to="'/task/edit/' + data.task_id" class="btn btn-primary" title="რედაქტირება">
                                <BIconPencilSquare class="pointer" />
                            </router-link>
                        </td>
                        <td>
                            <button type="button" @click="deleteTask($event)" :data-task-id="data.task_id" class="btn btn-danger" title="წაშლა">
                                <BIconTrash class="pointer" />
                            </button>
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

            const load_tasks = await axios.get("http://localhost/ticketing/server/public/api/task/list", {
                headers : {
                    "Authorization" : `Bearer ${this.$store.state.token}`
                }
            });

            this.tasks = load_tasks.data;
            this.new_tasks_count = load_tasks.data.count;
        },

        methods : {
            async markAs(e) {
                let id = e.target.getAttribute("data-task-id");

                await axios.put("http://localhost/ticketing/server/public/api/task/mark/" + id, {}, {
                    headers : {
                        "Authorization" : `Bearer ${this.$store.state.token}`
                    }
                });

                const load_tasks = await axios.get("http://localhost/ticketing/server/public/api/task/list", {
                    headers : {
                        "Authorization" : `Bearer ${this.$store.state.token}`
                    }
                });

                this.tasks = load_tasks.data;
            },

            async deleteTask(e) {
                let id = e.target.getAttribute("data-task-id");

                await axios.delete("http://localhost/ticketing/server/public/api/task/delete/" + id, {
                    headers : {
                        "Authorization" : `Bearer ${this.$store.state.token}`
                    }
                });

                const load_tasks = await axios.get("http://localhost/ticketing/server/public/api/task/list", {
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
        font-family: "neue_bold" !important;
    }

    table {
        font-size: 14px;

        thead {
            tr {
                th {
                    border: none;
                    font-family: "neue_bold" !important;
                }
            }
        }

        tbody {
            tr {
                td {
                    font-family: "neue_regular" !important;
                }
            }
        }
    }

    .btn {
        border-radius: 100%;
        width: 35px;
        height: 35px;
        display: inline-flex;
        justify-content: center;
        align-items: center;

        .pointer {
            pointer-events: none;
        }
    }

    .container-fluid {
        border-radius: 4px;
        padding: 0;
    }
</style>