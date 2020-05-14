import Vue from 'vue'
import Vuex from 'vuex'
import logger from "vuex/dist/logger";

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        toggleBar: false,
        toggleUser: false,
        user: [],
        messages: [],
        errors: [],
        newMessage: {
            subject: '',
            to: '',
            editorData: ''
        },
        pagination: {
            'current' : 0,
            'page': 1,
            'start': 0,
            'end': 0
        },
        message: {
            attr: {},
            messages: {
                bodies: {
                    text: ''
                },
            }
        },
        selectAll: false,
        preloader: false
    },

    actions: {
        getUser(cnt) {
            axios.get('/api/user')
                .then(r => cnt.commit('getUser', r.data))
        },
        async getMessages(cnt , payload) {
            cnt.commit('resetMess');
            cnt.commit('preloaderOn');
            await axios.get('/api/messages/' + payload)
                .then(r => cnt.commit('getMessages', r.data));
            cnt.commit('preloaderOff');
        },
        getMessage(cnt, payload) {
            axios.get('/api/message/' + payload)
                .then(r => cnt.commit('getMessage', r.data));
        },
        sendEmail(cnt, payload) {
            axios.post('/api/send-email' , payload)
                .catch(error => {
                     this.state.errors =  error.response.data.errors;
                });

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
            state.pagination['current'] = payload.pagination['current'];
            state.pagination['total'] = payload.pagination['total'];
            state.pagination['page'] = payload.pagination['page'];
            state.pagination['start'] = payload.pagination['start'];
            state.pagination['end'] = payload.pagination['end'];
        },
        getMessage(state, payload) {
            state.message = payload;
        },
        selectAll(state, payload) {
            state.selectAll = payload
        },
        preloaderOn(state) {
            state.preloader = true;
        },
        preloaderOff(state) {
            state.preloader = false;
        },
        resetMess(state){
            state.messages = []
        },
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
        message(state) {
            return state.message;
        },
        preloader(state) {
            return state.preloader;
        },
        pagination(state) {
            return state.pagination;
        },
        newMessage(state) {
            return state.newMessage;
        },
        getErrors(state) {
            return state.errors;
        }
    }
})
