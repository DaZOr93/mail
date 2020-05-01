import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        toggleBar: false,
        toggleUser: false
    },
    mutations: {
        toggleBar(state) {
            state.toggleBar = !state.toggleBar
        }
    },
    getters: {
        toggleBar(state){
            return state.toggleBar;
        },
        toggleUser(state) {
            return state.toggleUser;
        }

    }
})
