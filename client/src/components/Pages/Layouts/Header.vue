<template>
    <ul>
        <li>
            <router-link to="/"><img src="../../../assets/images/RDA-Logo-Geo.png"></router-link>
        </li>
        <li>
            <router-link to="/task/add">დავალების დამატება</router-link>
        </li>
        <li style="float: right">
            <a><router-link to="#" @click.prevent="logout()"><img src="../../../assets/icons/logout.svg" class="icon-header"></router-link></a>
        </li>
    </ul>
</template>

<script>
    import axios, { AxiosError } from "axios";

    export default {
        name : "HeaderComponent",

        mounted() {
            if(window.localStorage.getItem("login") == null) {
                this.$router.push("/login");
            }
        },

        methods : {
            async logout() {
                try {
                    await axios.post("http://localhost:8000/api/logout");

                    window.localStorage.clear(); // სესიების გასუფთავება

                    this.$router.push("/login");
                }catch(err) {
                    if(err instanceof AxiosError) {
                        console.log(err.response);
                    }
                }
            }
        }
    }
</script>

<style scoped lang="scss">
    ul {
        list-style-type: none;
        background-color: #fff;
        margin: 0;
        padding: 0px 20px;
        box-shadow: 0px 0px 14px #d4d3d3;
        overflow: hidden;

        li {
            float: left;
            margin: 0px 10px;

            a {
                display: block;
                padding: 10px;
                text-decoration: none;
                height: 100% !important;

                &:last-child:hover {
                    background-color: lightgray;
                }
                
                .icon-header {
                    height: 30px;
                    width: 20px;
                }
            }
        }

        img {
            width: 120px;
            display: block;
        }
    }
</style>