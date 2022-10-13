<template>
    <div>
        <HeaderComponent />

        <div class="mt-5 container-fluid">
            <div class="row">
                <div class="col-3">
                    <div class="mb-3">
                        <h5>Not started</h5>
                    </div>
                    <!-- START შემოსული დავალებების სია -->
                    <div class="card mb-3" v-for="data in notStarted" :key="data.task_id">
                        <div class="card-header">
                            <h5 class="card-title">{{ data.title }}</h5>
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
                    <!-- START შემოსული დავალებების სია -->
                    <div class="card mb-3" v-for="data in inProgress" :key="data.task_id">
                        <div class="card-header">
                            <h5 class="card-title">{{ data.title }}</h5>
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
                    <!-- START შემოსული დავალებების სია -->
                    <div class="card mb-3" v-for="data in waiting" :key="data.task_id">
                        <div class="card-header">
                            <h5 class="card-title">{{ data.title }}</h5>
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
                    <!-- START შემოსული დავალებების სია -->
                    <div class="card mb-3" v-for="data in done" :key="data.task_id">
                        <div class="card-header">
                            <h5 class="card-title">{{ data.title }}</h5>
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

        async mounted() {
            document.title = "ჩემი დავალებები";

            const not_started = await tasks_by_status(this.$store.state.token, 1); // ახლად შემოსული დავალებები
            const in_progress = await tasks_by_status(this.$store.state.token, 2); // მიმდინარე დავალებები
            const waiting = await tasks_by_status(this.$store.state.token, 3); // განხილვის რეჟიმში მყოფი დავალებები
            const done = await tasks_by_status(this.$store.state.token, 4); // შესრულებული დავალებები

            this.notStarted = not_started.data;
            this.inProgress = in_progress.data;
            this.waiting = waiting.data;
            this.done = done.data;
        }
    }
</script>

<style scoped lang="scss">
    @import "../../../assets/css/variables.scss";
</style>