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
                        <input type="datetime-local" v-model="this.end_date" name="end_date" id="end_date" class="form-control">
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
                    <input type="file" multiple class="form-control" @change="handleFiles($event)"><br>
                    <table>
                        <tbody>
                            <tr v-for="files in this.task_files" :key="files.id">
                                <td>{{ files.file }}&nbsp;&nbsp;</td>
                                <td><button type="button" class="btn btn-danger" :data-file-id="files.id" @click="deleteFile($event)"><BIconTrash class="pointer" /></button></td>
                            </tr>
                        </tbody>
                    </table>
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
                        <form method="POST" class="mb-3">
                            <input type="text" placeholder="სახელი, გვარი" class="form-control" v-model="fullname" @keyup="user_search()">
                        </form>
                        <div class="text-center mb-3">
                            <span class="text-center user-select-none">{{ notfound }}</span>
                        </div>
                        <div class="list-unstyled" v-for="(user, index) in users" :key="index" v-show="this.showlist">
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
    import Editor from "@tinymce/tinymce-vue";
    import axios, { AxiosError } from "axios";
    import userSearch from "../../../helpers/userSearch";

    export default {
        name : "EditTask",

        data() {
            return {
                formData : new FormData(), // ამ ობიექტში შეინახება ვეებიდან შეყვანილი მონაცემები
                end_date : "", // ამ ცვლადში დავალების ვადის მნიშვნელობა
                priority : "", // ამ ცვლადში დავალების პრიორიტეტის მნიშვნელობა
                title : "", // ამ ცვლადში დავალების სათაურის მნიშვნელობა
                description : "", // ამ ცვლადში დავალების აღწერის მნიშვნელობა
                task_files : [], // აქ ჩაიყრება დავალებაზე მიმაგრებული დოკუმენტები

                priority_list : [],
                created : "",
                msg : "",
                users : [], // აქ ჩაიყრება ძებნისას ნაპოვნი იუზერები

                userids : [], // აქ ჩაიყრება დავალებაზე მიმაგრებული უზერების აიდები
                fullname : "",
                task_new_files : [], // აქ ჩაიყრება ის ფაილები, რომელსაც მომხმარებელი რედაქტირებისას მიუთითებს

                showlist : true // მოცემული ცვლადი განსაზღვრავს მომხმარებელთა სიის ხილვადობას ძებნის შედეგიდან გამომდინარე
            }
        },

        components : {
            HeaderComponent,
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
            this.task_files = task.documents;
        },

        methods : {
            handleFiles(e) {
                for(let i = 0; i < e.target.files.length; i++) {
                    this.task_new_files.push(e.target.files[i]);
                }
            },

            async edit_task() {
                this.formData.append("title", this.title);
                this.formData.append("description", this.description);
                this.formData.append("priority", this.priority);
                this.formData.append("end_date", this.end_date);

                for(let i = 0; i < this.task_new_files.length; i++) {
                    this.formData.append("files[]", this.task_new_files[i]);
                }

                for(let j = 0; j < this.userids.length; j++) {
                    this.formData.append("users[]", this.userids[j]);
                }

                try {
                    const create_task = await axios.post("http://172.16.30.19/ticketing/server/public/api/task/edit/" + this.$route.params.id, this.formData, {
                        headers : {
                            "Authorization" : `Bearer ${this.$store.state.token}`,
                            "Content-type" : "multipart/form-data"
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

            async user_search() {
                try {
                    const data = await userSearch(this.$store.state.token, this.fullname);
                    this.users = data.data;
                    this.notfound = "";
                    this.showlist = true;
                }catch(err) {
                    if(err instanceof AxiosError) {
                        this.notfound = "ვერ მოიძებნა";
                        this.showlist = false;
                        console.clear();
                    }
                }
            },

            async deleteFile(e) {
                let id = e.target.getAttribute("data-file-id");
                
                try {
                    const deleteFile = await axios.delete("http://172.16.30.19/ticketing/server/public/api/task/file/delete/" + id, {
                        headers : {
                            "Authorization" : `Bearer ${this.$store.state.token}`
                        }
                    });

                    window.alert(deleteFile.data.message)
                }catch(err) {
                    console.log(err);
                }
            }
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
        border-radius: 20px;
    }

    .modal-body {
        max-height: 600px;
        overflow-y: scroll;
    }
</style>