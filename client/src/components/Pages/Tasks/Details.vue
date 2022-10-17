<template>
    <div>
        <HeaderComponent />

        <div class="mt-5 container-fluid custom-container">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-lg-8 col-sm-8 col-xs-8">
                        <h5><BIconCardHeading />&nbsp;&nbsp;{{ this.details.title }}</h5>
                        <span><BIconCalendarDate />&nbsp;&nbsp;</span><span class="text-muted small">ვადა: {{ this.details.end_date }}</span>
                        <hr>
                        <h5 class="btn btn-success"><b>აღწერა</b></h5>
                        <p v-html="this.details.description"></p>
                        <hr>
                        <h5 class="text-muted"><b>კომენტარები</b></h5>
                        <br>
                        <div class="container bg-white pt-4 pb-4">
                            <form method="post" @submit.prevent="addComment()" ref="commentForm">
                                <div class="mb-3">
                                    <textarea class="form-control" style="resize: none !important" placeholder="კომენტარი..." v-model="comment"></textarea>
                                    <br>
                                    <button type="submit" class="btn btn-primary float-lg-end">გაგზავნა&nbsp;&nbsp;<BIconSend /></button>
                                </div>
                            </form>

                            <br><br>

                            <div class="media" v-for="data in details.comments" :key="data.id">
                                <p class="text-muted"><span class="author">ავტორი:</span>&nbsp;&nbsp;{{ data.author_full_name }}&nbsp;&nbsp;<span class="date">თარიღი</span>&nbsp;&nbsp;{{ data.created_at }}</p>
                                <p class="comment">{{ data.comment }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import HeaderComponent from "../Layouts/Header.vue";
    import axios from "axios";

    export default {
        name : "TaskDetails",

        data() {
            return {
                details : [],
                comment : ""
            }
        },

        components : {
            HeaderComponent
        },

        async mounted() {
            this.$store.commit("setToken");

            const loaded_task = await axios.get("http://172.16.30.19/ticketing/server/public/api/task/get/" + this.$route.params.id, {
                headers : {
                    "Authorization" : `Bearer ${this.$store.state.token}`
                }
            });

            this.details = loaded_task.data;
        },

        methods : {
            async addComment() {
                try {
                    await axios.post("http://172.16.30.19/ticketing/server/public/api/task/add/comment", {
                        task_id : this.$route.params.id,
                        comment : this.comment
                    }, {
                        headers : {
                            "Authorization" : `Bearer ${this.$store.state.token}`
                        }
                    });

                    const loaded_task = await axios.get("http://172.16.30.19/ticketing/server/public/api/task/get/" + this.$route.params.id, {
                        headers : {
                            "Authorization" : `Bearer ${this.$store.state.token}`
                        }
                    });

                    this.details = loaded_task.data;

                    this.$refs.commentForm.reset();
                }catch(err) {
                    console.log(err);
                }
            }
        }
    }
</script>

<style scoped lang="scss">
    @import "../../../assets/css/variables.scss";

    .custom-container {
        padding: 20px;
        border-radius: 6px;
    }

    .media {
        padding: 10px;
        border-radius: 10px;
        background-color: #fbfbfb;
    }

    .author {
        padding: 5px;
        border-radius: 5px;
        background-color: lighten(#198754, 60%);
        color: #198754;
        font-size: 14px;
    }

    .date {
        padding: 5px;
        border-radius: 5px;
        background-color: lighten(#dc3545, 40%);
        color: #dc3545;
        font-size: 14px;
    }

    .comment {
        margin-left: 75px;
        padding: 10px;
        border-radius: 10px;
        background-color: #f7f7f7;
    }

    .text-muted {
        user-select: none;
    }
</style>