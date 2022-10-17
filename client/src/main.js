import { createApp } from "vue";
import App from "./App.vue";
import { createRouter, createWebHistory } from "vue-router";
import { BIconPlus, BIconPlusCircleFill, BIconCheck2, BIconPencilSquare, BIconTrash, BIconThreeDots, BIconCardHeading, BIconCalendarDate, BIconSend } from "bootstrap-icons-vue";
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
app.component("BIconPencilSquare", BIconPencilSquare);
app.component("BIconTrash", BIconTrash);
app.component("BIconThreeDots", BIconThreeDots);
app.component("BIconCardHeading", BIconCardHeading);
app.component("BIconCalendarDate", BIconCalendarDate);
app.component("BIconSend", BIconSend);

app.use(store);
app.use(router);
app.mount("#app");