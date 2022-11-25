import Vue from "vue";
import Vuex from "vuex";

import toast from "./toast";

Vue.use(Vuex);

const store = new Vuex.Store({
    modules: {
        toast
    }
})

export default store
