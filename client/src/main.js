import { createApp } from "vue";
import App from "./App.vue";
import { createRouter, createWebHistory } from "vue-router";

// === კომპონენტები ===
import LoginComponent from "./components/Auth/Login.vue";
import HomeComponent from "./components/Pages/Home.vue";
// === კომპონენტები ===

/*========= მარშუტები ==========*/
const routes = [
    {
        path : "/",
        component : HomeComponent
    },
    {
        path : "/login",
        component : LoginComponent
    }
];
/*========= მარშუტები ==========*/

const router = createRouter({
    routes : routes,
    history : createWebHistory()
});

const app = createApp(App);

app.use(router);
app.mount("#app");