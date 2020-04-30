require('./bootstrap');
import Vue from 'vue';
import App from './App.vue';
import VueRouter from 'vue-router';
import router from './routes';

//css
import 'materialize-css';
import 'materialize-css/dist/css/materialize.css';
import 'material-design-icons/iconfont/material-icons.css'


window.Vue = require('vue');
Vue.use(VueRouter);

const app = new Vue({
    el: '#app',
    router,
    render: h => h(App)
});
