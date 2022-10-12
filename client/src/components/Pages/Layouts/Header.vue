<template>
    <nav class="navbar navbar-expand-lg bg-white">
        <div class="container">
            <router-link to="/" class="navbar-brand"><img src="../../../assets/images/RDA-Logo-Geo.png" class="brand"></router-link>

            <div class="collapse navbar-collapse" id="mynav">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a href="#" class="dropdown-toggle" role="button" style="text-decoration: none !important" data-bs-toggle="dropdown">დავალებები</a>

                        <ul class="dropdown-menu">
                            <li><router-link to="/task/list" class="dropdown-item">ყველა დავალება</router-link></li>
                            <li><router-link to="/task/add" class="dropdown-item">დავალების დამატება</router-link></li>
                        </ul>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a href="#" class="dropdown-toggle" role="button" style="text-decoration: none !important" data-bs-toggle="dropdown">{{ this.full_name }}</a>

                        <ul class="dropdown-menu">
                            <li>
                                <router-link class="nav-link" to="/profile/manage">
                                    <span>პარამეტრები&nbsp;&nbsp;<BIconGear /></span>
                                </router-link>
                            </li>
                            <li>
                                <router-link class="nav-link" to="#" @click.prevent="logout()" title="სისტემიდან გასვლა">
                                    <span>გასვლა&nbsp;&nbsp;<BIconBoxArrowRight /></span>
                                </router-link>
                            </li>
                        </ul>
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

        data() {
            return {
                full_name : ""
            }
        },

        async mounted() {
            this.$store.commit("setToken");

            if(window.localStorage.getItem("login") == null) {
                this.$router.push("/login");
            }

            const user = await axios.get("http://localhost/ticketing/server/public/api/user/get/" + window.localStorage.getItem("uid"), {
                headers : {
                    "Authorization" : `Bearer ${this.$store.state.token}`
                }
            });

            this.full_name = user.data.name;
        },

        methods : {
            async logout() {
                try {
                    await axios.post("http://localhost/ticketing/server/public/api/logout");

                    window.localStorage.clear(); // სთორიჯის გასუფთავება

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

    .link {
        color: #202020;
        text-decoration: none;
        margin-left: 20px;

        &:hover {
            color: gray;
        }
    }

    .dropdown-toggle {
        color: #202020;

        &:hover {
            color: gray;
        }
    }

    * {
        font-family: "neue_bold" !important;
    }
</style>