<template>
    <div>
        <HeaderComponent />

        <div class="mt-4 container-fluid">
            <div class="row g-4 gy-4">
                <!-- START შემოსული დავალებების სია -->
                <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
                    <div class="mb-3 status-title p-3">
                        <h5 style="font-size: 16px; color: #202020">Not started</h5>
                    </div>
                    <div class="card mb-3" v-for="data in notStarted" :key="data.task_id">
                        <div class="card-header d-inline-flex">
                            <h6 class="card-title">{{ data.title }}</h6>
                            <div class="dropdown">
                                <a href="#" data-bs-toggle="dropdown"><BIconThreeDots /></a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <router-link class="dropdown-item" :to="'/task/edit/' + data.task_id">რედაქტირება</router-link>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" class="dropdown-item" @click="deleteTask($event)" :data-task-id="data.task_id">წაშლა</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <p v-html="data.description"></p>
                        </div>
                        <div class="card-footer">
                            <router-link class="btn btn-info text-white" :to="'/task/details/' + data.task_id">დეტალურად</router-link>
                        </div>
                    </div>
                </div>
                <!-- END შემოსული დავალებების სია -->
                <!-- START მიმდინარე დავალებების სია -->
                <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
                    <div class="mb-3 status-title p-3">
                        <h5 style="font-size: 16px; color: #202020">In progress</h5>
                    </div>
                    <div class="card mb-3" v-for="data in inProgress" :key="data.task_id">
                        <div class="card-header d-inline-flex">
                            <h6 class="card-title">{{ data.title }}</h6>
                            <div class="dropdown">
                                <a href="#" data-bs-toggle="dropdown"><BIconThreeDots /></a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <router-link class="dropdown-item" :to="'/task/edit/' + data.task_id">რედაქტირება</router-link>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" class="dropdown-item" @click="deleteTask($event)" :data-task-id="data.task_id">წაშლა</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <p v-html="data.description"></p>
                        </div>
                        <div class="card-footer">
                            <router-link class="btn btn-info text-white" :to="'/task/details/' + data.task_id">დეტალურად</router-link>
                        </div>
                    </div>
                </div>
                <!-- END მიმდინარე დავალებების სია -->
                <!-- START განხილვის რეჟიმში მყოფი დავალებების სია -->
                <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
                    <div class="mb-3 status-title p-3">
                        <h5 style="font-size: 16px; color: #202020">Waiting</h5>
                    </div>
                    <div class="card mb-3" v-for="data in waiting" :key="data.task_id">
                        <div class="card-header d-inline-flex">
                            <h6 class="card-title">{{ data.title }}</h6>
                            <div class="dropdown">
                                <a href="#" data-bs-toggle="dropdown"><BIconThreeDots /></a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <router-link class="dropdown-item" :to="'/task/edit/' + data.task_id">რედაქტირება</router-link>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" class="dropdown-item" @click="deleteTask($event)" :data-task-id="data.task_id">წაშლა</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <p v-html="data.description"></p>
                        </div>
                        <div class="card-footer">
                            <router-link class="btn btn-info text-white" :to="'/task/details/' + data.task_id">დეტალურად</router-link>
                        </div>
                    </div>
                </div>
                <!-- END განხილვის რეჟიმში მყოფი დავალებების სია -->
                <!-- START შესრულებული დავალებების სია -->
                <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
                    <div class="mb-3 status-title p-3">
                        <h5 style="font-size: 16px; color: #202020">Done</h5>
                    </div>
                    <div class="card mb-3" v-for="data in done" :key="data.task_id">
                        <div class="card-header d-inline-flex">
                            <h6 class="card-title">{{ data.title }}</h6>
                            <div class="dropdown">
                                <a href="#" data-bs-toggle="dropdown"><BIconThreeDots /></a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <router-link class="dropdown-item" :to="'/task/edit/' + data.task_id">რედაქტირება</router-link>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" class="dropdown-item" @click="deleteTask($event)" :data-task-id="data.task_id">წაშლა</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <p v-html="data.description"></p>
                        </div>
                        <div class="card-footer">
                            <router-link class="btn btn-info text-white" :to="'/task/details/' + data.task_id">დეტალურად</router-link>
                        </div>
                    </div>
                </div>
                <!-- END შესრულებული დავალებების სია -->
            </div>
        </div>
    </div>
</template>

<script>
    import HeaderComponent from "../Layouts/Header.vue";
    import { tasks_by_status } from "../../../helpers/helper";
    import axios from "axios";

    export default {
        name : "TaskList",

        data() {
            return {
                notStarted : [],
                inProgress : [],
                waiting : [],
                done : []
            }
        },

        components : {
            HeaderComponent
        },

        methods : {
            async deleteTask(e) {
                let id = e.target.getAttribute("data-task-id");

                try {
                    await axios.delete("http://172.16.30.19/ticketing/server/public/api/task/delete/" + id, {
                        headers : {
                            "Authorization" : `Bearer ${this.$store.state.token}`
                        }
                    });
                }catch(err) {
                    console.log(err);
                }
            }
        },

        async mounted() {
            document.title = "ჩემი დავალებები";

            const not_started = await tasks_by_status(this.$store.state.token, 1); // ახლად შემოსული დავალებები
            const in_progress = await tasks_by_status(this.$store.state.token, 2); // მიმდინარე დავალებები
            const waiting = await tasks_by_status(this.$store.state.token, 3); // განხილვის რეჟიმში მყოფი დავალებები
            const done = await tasks_by_status(this.$store.state.token, 4); // შესრულებული დავალებები

            this.notStarted = not_started.data; 
            this.inProgress = in_progress.data; // მიმდინარე დავალებები
            this.waiting = waiting.data; // განხილვის რეჟიმში მყოფი დავალებები
            this.done = done.data; // შესრულებული დავალებ
        }
    }
</script>

<style scoped lang="scss">
    @import "../../../assets/css/variables.scss";

    .dropdown {
        position: absolute;
        right: 0;
        margin-right: 10px;
    }

    .status-title {
        border-radius: 10px;
        background-color: #fff;
    }
</style>