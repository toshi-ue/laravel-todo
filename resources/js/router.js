import Router from "vue-router";
import About from "./views/About.vue";
import Home from "./views/Home.vue";
import NotFound from "./views/NotFound.vue";
import TaskList from "./views/TaskList";
import User from "./views/User.vue";

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
            path: '/user',
            name: 'user',
            component: User
        },
    ]
})
