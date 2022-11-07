import Router from "vue-router";
import About from "./views/About";
import Home from "./views/Home";
import NotFound from "./views/NotFound";
import TaskAdd from "./views/TaskAdd";
import TaskEdit from "./views/TaskEdit";
import TaskDetail from "./views/TaskDetail";
import TaskList from "./views/TaskList";
import User from "./views/User";
import VueRouter from "vue-router";

// QUESTION ここに記述すればapp.jsの以下の記述は削除できる?
// Vue.use(Router);

export default new Router({
    mode: "history",
    routes: [
        {
            path: '*',
            component: NotFound
        },
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/about',
            name: 'about',
            component: About
        },
        {
            path: '/tasks',
            name: 'tasks',
            component: TaskList
        },
        {
            path: '/tasks/:taskId',
            name: 'task.show',
            component: TaskDetail,
            props: true
        },
        {
            path: '/tasks/:taskId/edit',
            name: 'task.edit',
            component: TaskEdit,
            props: true
        },
        {
            path: '/tasks/create',
            name: 'task.new',
            component: TaskAdd
        },
        {
            path: '/user',
            name: 'user',
            component: User
        },
    ]
})
