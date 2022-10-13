<template>
    <div>
        <HeaderComponent />

        <div class="mt-5 container-fluid">
            <div class="row">
                <div class="col-3">
                    <div class="mb-3">
                        <h5>Not started</h5>
                    </div>
                    <hr>
                    <!-- START შემოსული დავალებების სია -->
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

                        </div>
                    </div>
                    <!-- START შემოსული დავალებების სია -->
                </div>
                <div class="col-3">
                    <div class="mb-3">
                        <h5>In progress</h5>
                    </div>
                    <hr>
                    <!-- START შემოსული დავალებების სია -->
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

                        </div>
                    </div>
                    <!-- START შემოსული დავალებების სია -->
                </div>
                <div class="col-3">
                    <div class="mb-3">
                        <h5>Waiting</h5>
                    </div>
                    <hr>
                    <!-- START შემოსული დავალებების სია -->
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

                        </div>
                    </div>
                    <!-- START შემოსული დავალებების სია -->
                </div>
                <div class="col-3">
                    <div class="mb-3">
                        <h5>Done</h5>
                    </div>
                    <hr>
                    <!-- START შემოსული დავალებების სია -->
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

                        </div>
                    </div>
                    <!-- START შემოსული დავალებების სია -->
                </div>
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

                    window.location.reload()
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

            this.notStarted = not_started.data; // ახლად შემოსული დავალებები
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
</style>