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
        sendMessages: [],
        getFolderMessages: [],
        errors: [],
        newMessage: {
            subject: '',
            to: '',
            editorData: ''
        },
        pagination: {
            'current': 0,
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
        getFolders: [],
        selectAll: false,
        preloader: false
    },

    actions: {
        getUser(cnt) {
            axios.get('/api/user')
                .then(r => cnt.commit('getUser', r.data))
        },
        async getMessages(cnt, payload) {
            cnt.commit('resetMess');
            cnt.commit('preloaderOn');
            await axios.get('/api/messages/' + payload)
                .then(r => {
                    cnt.commit('getMessages', r.data);
                    cnt.commit('pagination', r.data.pagination);
                })
            cnt.commit('preloaderOff');
        },
        getMessage(cnt, payload) {
            axios.get('/api/message/' + payload)
                .then(r => {cnt.commit('getMessage', r.data)});
        },
        getMessageSending(cnt , payload) {
            axios.get('/api/sentMessage/sending/' + payload)
                .then(r => {cnt.commit('getMessage', r.data)});
        },
        sendEmail(cnt, payload) {
            axios.post('/api/send-email', payload)
                .catch(error => {
                    this.state.errors = error.response.data.errors;
                });

        },
        async getMessagesFilter(cnt, payload) {
            this.state.sendMessages = [];
            cnt.commit('preloaderOn');
            await axios.get('/api/messages/' + payload.filter + '/' + payload.offset)
                .then(r => {
                    cnt.commit('sendMessages', r.data);
                    cnt.commit('pagination', r.data.pagination);
                });
            cnt.commit('preloaderOff');
        },
        userFolders(cnt) {
            axios.get('/api/user/folders')
                .then( r =>  cnt.commit('userFolders' , r.data))
        },
       async getFolderMessages(cnt , payload){
            cnt.commit('getFolderMessagesReset');
            axios.get(`/api/user/${payload}/messages`)
                .then( r =>  cnt.commit('getFolderMessages' , r.data))
        },
        store_folder(cnt, payload) {
            axios.post('/api/user/folders/store' , {
                body: payload
            })
        },

    },

    mutations: {
        getFolderMessagesReset(state) {
            state.getFolderMessages = []
        },
        getFolderMessages(state , payload){
            state.getFolderMessages = payload
        },
        toggleBar(state) {
            state.toggleBar = !state.toggleBar
        },
        getUser(state, payload) {
            state.user = payload;
        },
        pagination(state, payload) {
            state.pagination = {};
            state.pagination['current'] = payload['current'];
            state.pagination['total'] = payload['total'];
            state.pagination['page'] = payload['page'];
            state.pagination['start'] = payload['start'];
            state.pagination['end'] = payload['end'];
        },
        getMessages(state, payload) {
            state.messages = payload;
        },
        getMessage(state, payload) {
            state.message = payload;
        },
        sendMessages(state, payload) {
            state.sendMessages = payload;
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
        resetMess(state) {
            state.messages = []
        },
        userFolders(state, payload){
            state.getFolders = payload
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
        },
        sendMessages(state) {
            return state.sendMessages
        },
        getFolders(state) {
            return state.getFolders
        },
        getFolderMessages(state){
            return state.getFolderMessages
        }
    }
})
