import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        toggleBar: false,
        toggleUser: false,
        user: [],
        selectAll: false
    },

    actions: {
        getUser(cnt) {
            axios.get('/api/user')
                .then( r => cnt.commit('getUser' , r.data))
        },
    },

    mutations: {
        toggleBar(state) {
            state.toggleBar = !state.toggleBar
        },
        getUser(state, payload){
            state.user = payload;
        },
        selectAll(state , payload){
            state.selectAll = payload
        }
    },
    getters: {
        toggleBar(state) {
            return state.toggleBar;
        },
        toggleUser(state) {
            return state.toggleUser;
        },
        getUser(state) {
            return state.user;
        },
        selectAll(state) {
            return state.selectAll;
        }


    }
})
