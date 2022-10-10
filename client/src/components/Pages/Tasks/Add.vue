<template>
    <div>
        <HeaderComponent />

        <div class="container mt-5 custom-container">
            <form method="POST" @submit.prevent="add_task()">
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
                        <select class="form-select" v-model="priority">
                            <option selected disabled value="">აირჩიეთ პრიორიტეტი</option>
                                <option :value="data.id" v-for="(data, index) in priority_list" v-bind:key="index">{{ data.name }}</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="description">აღწერა</label>
                    <editor api-key="no-api-key" :init="{resize: false}" v-model="description"></editor>
                </div>
                <div class="mb-3 d-grid">
                    <button type="submit" class="btn btn-success">დამატება</button>

                    <div v-if="created">
                        <br>
                        <div class="alert alert-success text-center">
                            <span>{{ this.msg }}</span>
                        </div>
                    </div>
                </div>
            </form>
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
        name : "AddTask",

        data() {
            return {
                end_date : new Date(),
                priority : "",
                title : "",
                description : "",

                priority_list : [],
                created : "",
                msg : ""
            }
        },

        components : {
            HeaderComponent,
            Datepicker,
            Editor
        },

        mounted() {
            document.title = "თასქის დამატება";
            this.$store.commit("setToken");
            
            axios.get("http://localhost:8000/api/priority/list", {
                headers : {
                    "Authorization" : `Bearer ${this.$store.state.token}`
                }
            }).then((response) => {
                this.priority_list = response.data;
            });
        },

        methods : {
            async add_task() {
                try {
                    const create_task = await axios.post("http://localhost:8000/api/task/add", {
                        title : this.title,
                        description : this.description,
                        priority : this.priority,
                        end_date : this.end_date
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
            }
        }
    }
</script>

<style scoped lang="scss">
    @import "../../../assets/css/variables.scss";

    * {
        font-family: "neue_regular" !important;
    }

    label, button, input {
        font-size: 14px;
    }

    .custom-container {
        background-color: #fff;
        padding: 20px;
        border-radius: 6px;
    }
</style>