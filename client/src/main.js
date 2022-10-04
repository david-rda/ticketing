import { createApp } from "vue";
import App from "./App.vue";
import { createRouter, createWebHistory } from "vue-router";

// === კომპონენტები ===
import LoginComponent from "./components/Auth/Login.vue";
import HomeComponent from "./components/Pages/Home.vue";
import AddTask from "./components/Pages/Tasks/Add.vue";
// === კომპონენტები ===

import routes from "./routes/routes";

const router = createRouter({
    routes : routes,
    history : createWebHistory()
});

const app = createApp(App);

app.use(router);
app.mount("#app");