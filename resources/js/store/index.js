import Vue from 'vue'
import Vuex from 'vuex'

import rect from './modules/rect'

Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        rect
    }
})
