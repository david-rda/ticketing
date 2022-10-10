// === კომპონენტები ===
import LoginComponent from "../components/Auth/Login.vue";
import HomeComponent from "../components/Pages/Home.vue";
import AddTask from "../components/Pages/Tasks/Add.vue";
import TaskList from "../components/Pages/Tasks/List.vue";
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
    },
    {
        path : "/task/list",
        component : TaskList
    }
];
/*========= მარშუტები ==========*/

export default routes;