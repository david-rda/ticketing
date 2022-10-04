import { createApp } from "vue";
import App from "./App.vue";
import { createRouter, createWebHistory } from "vue-router";

// === კომპონენტები ===
import LoginComponent from "./components/Auth/Login.vue";
import HomeComponent from "./components/Pages/Home.vue";
import AddTask from "./components/Pages/Tasks/Add.vue";
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
    },
    {
        path : "/task/add",
        component : AddTask
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