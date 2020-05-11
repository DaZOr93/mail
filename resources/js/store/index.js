import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        toggleBar: false,
        toggleUser: false,
        user: [],
        messages: [],
        selectAll: false,
        preloader: false
    },

    actions: {
        getUser(cnt) {
            axios.get('/api/user')
                .then(r => cnt.commit('getUser', r.data))
        },
        async getMessages(cnt) {
            if (this.state.messages.length < 1) {
                cnt.commit('preloaderOn');
            }
            await axios.get('/api/messages')
                .then(r => cnt.commit('getMessages', r.data));
            cnt.commit('preloaderOff');
        }
    },

    mutations: {
        toggleBar(state) {
            state.toggleBar = !state.toggleBar
        },
        getUser(state, payload) {
            state.user = payload;
        },
        getMessages(state, payload) {
            state.messages = payload;
        },
        selectAll(state, payload) {
            state.selectAll = payload
        },
        preloaderOn(state) {
            state.preloader = true;
        },
        preloaderOff(state) {
            state.preloader = false;
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
        },
        getMessages(state) {
            return state.messages;
        },
        preloader(state) {
            return state.preloader;
        }
    }
})
