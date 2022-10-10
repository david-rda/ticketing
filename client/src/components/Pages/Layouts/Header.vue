<template>
    <nav class="navbar navbar-expand-lg bg-white">
        <div class="container">
            <router-link to="/" class="navbar-brand"><img src="../../../assets/images/RDA-Logo-Geo.png" class="brand"></router-link>

            <div class="collapse navbar-collapse" id="mynav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <router-link class="nav-link" to="/task/add">დავალების დამატება</router-link>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <router-link class="nav-link" to="#" @click.prevent="logout()" title="სისტემიდან გასვლა">
                            <img src="../../../assets/icons/logout.svg" class="icon-header">
                        </router-link>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
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
    .brand {
        width: 120px;
    }

    .nav-link {
        color: #202020 !important;

        &:hover {
            color: lighten(#202020, 30%) !important;
        }
    }

    .icon-header {
        width: 20px;
        height: 20px;
    }
</style>