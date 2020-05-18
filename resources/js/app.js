require('./bootstrap');
import Vue from 'vue';
import App from './App.vue';
import VueRouter from 'vue-router';
import router from './routes';
import store from './store'
import VueToast from 'vue-toast-notification';
import CKEditor from '@ckeditor/ckeditor5-vue';

Vue.use( CKEditor );

//css
import 'materialize-css';
import 'materialize-css/dist/css/materialize.css';
import 'material-design-icons/iconfont/material-icons.css'

//js
import 'materialize-css/dist/js/materialize.js';

//Vue.config.devtools = false;
//Vue.config.debug = false;
//Vue.config.silent = true;


//paginate
Vue.component('pagination', require('laravel-vue-pagination'));

import styles from 'vue-pure-lightbox/dist/VuePureLightbox.css'

//toaster
import 'vue-toast-notification/dist/theme-sugar.css';
Vue.use(VueToast);

//
export const eventBus = new Vue();

window.Vue = require('vue');
Vue.use(VueRouter);

const app = new Vue({
    el: '#app',
    router,
    store,
    render: h => h(App)
});
