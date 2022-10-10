<template>
    <div class="login_block">
        <form method="POST" @submit.prevent="login()">
            <table>
                <tbody>
                    <tr>
                        <td>
                            <div class="image-rda">
                                <img src="../../assets/images/RDA-Logo-Geo.png">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" placeholder="ელფოსტა" name="email" id="email" v-model="email">
                        </td>
                    </tr><br>
                    <tr>
                        <td>
                            <input type="password" placeholder="პაროლი" name="password" id="password" v-model="password">
                        </td>
                    </tr><br>
                    <tr>
                        <td>
                            <button type="submit">შესვლა</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
</template>

<script>
    import axios, { AxiosError } from "axios";

    export default {
        name : "LoginComponent",

        data() {
            return {
                email : "",
                password : ""
            }
        },

        mounted() {
            document.title = "შესვლა";

            if(window.localStorage.getItem("login")) {
                this.$router.push("/");
            }
        },

        methods : {
            async login() {
                try {
                    const login = await axios.post("http://localhost:8000/api/login", {
                        email : this.email,
                        password : this.password
                    });

                    window.localStorage.setItem("token", login.data.token);
                    window.localStorage.setItem("login", login.data.logged_in);
                    window.localStorage.setItem("role", login.data.user.role);

                    this.$store.commit("setRole");
                    this.$store.commit("setToken");

                    this.$router.push("/");
                }catch(err) {
                    if(err instanceof AxiosError) {
                        console.log("Error");
                    }
                }
                
            }
        }
    }
</script>

<style lang="scss" scoped>
    @import "../../assets/css/variables.scss"; // ფერების ცვლადები

    input {
        width: 400px;
        height: 55px;
        padding: 0 15px;
        color: $fgColor;
        background-color: #fff;
        border: 1px solid transparent;
        border-radius: 4px;
        outline: none;
        margin-top: 10px;
        font-family: "neue_bold";
    }

    .login_block {
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        padding-top: 10%;
    }

    button {
        width: 400px;
        height: 55px;
        padding: 0 15px;
        border: none;
        color: #005019;
        background-color: #82be00;
        text-transform: uppercase;
        font-weight: 900;
        cursor: pointer;
        border-radius: 4px;
        font-family: "neue_black";
        font-size: 20px;

        &:hover {
            background-color: $darkgreen;
            color: #fff;
        }
    }

    .image-rda {
        width: 400px;
        height: 90px;
        overflow: hidden;
        display: flex;
        justify-content: center;

        img {
            width: 220px;
        }
    }
</style>