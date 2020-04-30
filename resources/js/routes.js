import VueRouter from 'vue-router';
import Home from "./components/HomeComponent";



export default new VueRouter({
    routes: [
        {
            path: '/',
            component: Home,
            name: 'Home'
        },

    ],
    mode: 'history'

})
