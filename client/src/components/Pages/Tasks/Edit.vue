<template>
    <div>
        <HeaderComponent />

        <div class="container mt-5 custom-container bg-white">
            <form method="POST" @submit.prevent="edit_task()">
                <div class="mb-3">
                    <label for="title">სათაური</label>
                    <input type="text" id="title" name="title" v-model="title" class="form-control" placeholder="სათაური">
                    <br>
                </div>         
                <div class="row">
                    <div class="mb-3 col-lg-6 col-md-6">
                        <label for="end_date">დასრულების ვადა</label>
                        <Datepicker v-model="end_date" />
                    </div>
                    <div class="mb-3 col-lg-6 col-md-6">
                        <label for="priority">პრიორიტეტი</label>
                        <select class="form-select" v-model="priority" id="priority" name="priority">
                            <option selected disabled value="">აირჩიეთ პრიორიტეტი</option>
                            <option :value="data.id" v-for="(data, index) in priority_list" v-bind:key="index">{{ data.name }}</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="description">აღწერა</label>
                    <editor :init="{resize: false}" v-model="description"></editor>
                </div>
                <div class="mb-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal"><BIconPlusCircleFill />&nbsp;პასუხისმგებელი</button>
                </div>
                <div class="mb-3 d-grid">
                    <button type="submit" class="btn btn-success">რედაქტირება</button>

                    <div v-if="created">
                        <br>
                        <div class="alert alert-success text-center">
                            <span>{{ this.msg }}</span>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="modal fade" id="modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title">პასუხისმგებელ პირზე მიმაგრება</h6>
                    </div>
                    <div class="modal-body">
                        <div class="list-unstyled" v-for="(user, index) in users" :key="index">
                            <li>
                                <label><input type="checkbox" v-model="userids" class="form-check-input" :value="user.id">&nbsp;&nbsp;&nbsp;<span>{{ user.name }}</span></label>
                            </li>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">დახურვა</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import HeaderComponent from "../Layouts/Header.vue";
    import Datepicker from '@vuepic/vue-datepicker';
    import '@vuepic/vue-datepicker/dist/main.css';
    import Editor from "@tinymce/tinymce-vue";
    import axios, { AxiosError } from "axios";

    export default {
        name : "EditTask",

        data() {
            return {
                end_date : new Date(),
                priority : "",
                title : "",
                description : "",

                priority_list : [],
                created : "",
                msg : "",
                users : [],

                userids : [],
            }
        },

        components : {
            HeaderComponent,
            Datepicker,
            Editor
        },

        async mounted() {
            document.title = "დავალების რედაქტირება";
            this.$store.commit("setToken");
            
            const data = await axios.get("http://172.16.30.19/ticketing/server/public/api/priority/list", {
                headers : {
                    "Authorization" : `Bearer ${this.$store.state.token}`
                }
            });

            this.priority_list = data.data;

            const users_list = await axios.get("http://172.16.30.19/ticketing/server/public/api/user/list", {
                headers : {
                    "Authorization" : `Bearer ${this.$store.state.token}`
                }
            });

            this.users = users_list.data;

            const loaded_task = await axios.get("http://172.16.30.19/ticketing/server/public/api/task/get/" + this.$route.params.id, {
                headers : {
                    "Authorization" : `Bearer ${this.$store.state.token}`
                }
            });

            let task = loaded_task.data;

            this.end_date = task.end_date;
            this.title = task.title;
            this.description = task.description;
            this.priority = task.priority_id;
            this.userids = task.performers;
        },

        methods : {
            async edit_task() {
                try {
                    const create_task = await axios.put("http://172.16.30.19/ticketing/server/public/api/task/edit/" + this.$route.params.id, {
                        title : this.title,
                        description : this.description,
                        priority : this.priority,
                        end_date : this.end_date,
                        users : this.userids
                    }, {
                        headers : {
                            "Authorization" : `Bearer ${this.$store.state.token}`
                        }
                    });

                    this.created = true;
                    this.msg = create_task.data.message;
                }catch(err) {
                    if(err instanceof AxiosError) {
                        console.log("err");
                    }
                }
            },
        }
    }
</script>

<style scoped lang="scss">
    @import "../../../assets/css/variables.scss";

    label, button, input {
        font-size: 14px !important;
    }

    .custom-container {
        padding: 20px;
        border-radius: 6px;
    }

    .modal-body {
        max-height: 600px;
        overflow-y: scroll;
    }
</style>