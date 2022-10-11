<template>
    <div>
        <header-component></header-component>

        <div class="container mt-5 col-md-6 d-flex bg-white">
            <div class="row col-md-6 offset-3">
                <form method="PUT" @submit.prevent="change_password()">
                    <div class="mb-4">
                        <label for="current_password">მიმდინარე პაროლი</label>
                        <input type="password" class="form-control" v-model="current_password" name="current_password" id="current_password">
                    </div>
                    <div class="mb-4">
                        <label for="new_password">ახალი პაროლი</label>
                        <input type="password" class="form-control" v-model="new_password" name="new_password" id="new_password">
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-success">პაროლის ცვლილება</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import HeaderComponent from "./Layouts/Header.vue";
    import axios, { AxiosError } from "axios";

    export default {
        name : "ManageProfile",

        data() {
            return {
                current_password : "",
                new_password : ""
            }
        },

        components : {
            HeaderComponent
        },

        mounted() {
            document.title = "პროფილის მართვა";
            this.$store.commit("setToken");
        },

        methods : {
            async change_password() {
                try {
                    await axios.put("http://localhost:8000/api/user/password/change", {
                        current_password : this.current_password,
                        new_password : this.new_password
                    }, {
                        headers : {
                            "Authorization" : `Bearer ${this.$store.state.token}`
                        }
                    });

                    this.current_password = "";
                    this.new_password = "";
                }catch(err) {
                    if(err instanceof AxiosError) {
                        console.log(err);
                    }
                }
            }
        }
    }
</script>

<style scoped lang="scss">
    .container {
        border-radius: 6px;
        padding: 20px;
    }

    * {
        font-family: "neue_regular" !important;
    }

    label, button, input {
        font-size: 14px !important;
    }
</style>
