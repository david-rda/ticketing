// === კომპონენტები ===
import LoginComponent from "../components/Auth/Login.vue";
import HomeComponent from "../components/Pages/Home.vue";
import AddTask from "../components/Pages/Tasks/Add.vue";
import TaskList from "../components/Pages/Tasks/List.vue";
import ManageProfile from "../components/Pages/Manage.vue";
import EditTask from "../components/Pages/Tasks/Edit.vue";
import TaskDetails from "../components/Pages/Tasks/Details.vue";

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
    },
    {
        path : "/profile/manage",
        component : ManageProfile
    },
    {
        path : "/task/edit/:id",
        component : EditTask
    },
    {
        path : "/task/details/:id",
        component : TaskDetails
    }
];
/*========= მარშუტები ==========*/

export default routes;