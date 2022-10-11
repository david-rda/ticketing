import { createApp } from "vue";
import App from "./App.vue";
import { createRouter, createWebHistory } from "vue-router";
import { BIconPlus, BIconPlusCircleFill, BIconCheck2 } from "bootstrap-icons-vue";
import store from "./store";

import routes from "./routes/routes";

const router = createRouter({
    routes : routes,
    history : createWebHistory()
});

const app = createApp(App);

app.component("BIconPlus", BIconPlus);
app.component("BIconPlusCircleFill", BIconPlusCircleFill);
app.component("BIconCheck2", BIconCheck2);

app.use(store);
app.use(router);
app.mount("#app");