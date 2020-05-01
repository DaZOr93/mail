require('./bootstrap');
import Vue from 'vue';
import App from './App.vue';
import VueRouter from 'vue-router';
import router from './routes';
import store from './store'

//css
import 'materialize-css';
import 'materialize-css/dist/css/materialize.css';
import 'material-design-icons/iconfont/material-icons.css'


window.Vue = require('vue');
Vue.use(VueRouter);

const app = new Vue({
    el: '#app',
    router,
    store,
    render: h => h(App)
});
