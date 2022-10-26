import Router from "vue-router";
import About from "./views/About";
import AddTask from "./views/AddTask";
import Home from "./views/Home";
import NotFound from "./views/NotFound";
import TaskList from "./views/TaskList";
import User from "./views/User";

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
            path: '/tasks/create',
            name: 'task.new',
            component: AddTask
        },
        {
            path: '/user',
            name: 'user',
            component: User
        },
    ]
})
