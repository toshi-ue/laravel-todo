import Router from "vue-router";
import About from "./views/About";
import TaskAdd from "./views/TaskAdd";
import Home from "./views/Home";
import NotFound from "./views/NotFound";
import TaskList from "./views/TaskList";
import User from "./views/User";

// FIXME: ログインしていなくてもTODO一覧に入ることができる
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
            component: TaskAdd
        },
        {
            path: '/user',
            name: 'user',
            component: User
        },
    ]
})
