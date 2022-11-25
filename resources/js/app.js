/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

// window.Vue = require('vue');

import Vue from "vue";
import VueRouter from "vue-router";
import VueScrollTo from 'vue-scrollto'
import Toasted from 'vue-toasted';
/* import the fontawesome core */
import { library } from '@fortawesome/fontawesome-svg-core'

/* import font awesome icon component */
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

/* import specific icons */
import { faPen, faTrash } from '@fortawesome/free-solid-svg-icons'

library.add(faPen, faTrash)
Vue.component('font-awesome-icon', FontAwesomeIcon)

import router from "./router";
import store from "./store";

window.Vue = Vue;
// QUESTION: ./route 側で設定すればこの記述はいらない?
// [LaravelにVuexを導入する方法 - ポッポプログラミング](https://poppotennis.com/posts/larave-vuex)
Vue.use(VueRouter);
Vue.use(VueScrollTo);
Vue.use(Toasted)

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router,
    store
});
