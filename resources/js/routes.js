import VueRouter from 'vue-router';
import Home from "./components/HomeComponent";
import Incoming from './components/MainContent/Incoming/IncomingComponent';
import Draft from './components/MainContent/Draft/DraftComponent';
import Sent from './components/MainContent/Sent/SentComponent';
import Basket from './components/MainContent/Basket/BasketComponent';
import NewEmail from './components/MainContent/NewEmail/NewEmailComponent';
import NewFile from './components/MainContent/NewFile/NewFileComponent';



export default new VueRouter({
    routes: [
        {
            path: '/it/home',
            component: Home,
            name: 'Home'
        },
        {
            path: '/it/incoming',
            component: Incoming,
            name: 'incoming'
        },
        {
            path: '/it/draft',
            component: Draft,
            name: 'draft'
        },
        {
            path: '/it/sent',
            component: Sent,
            name: 'sent'
        },
        {
            path: '/it/basket',
            component: Basket,
            name: 'basket'
        },
        {
            path: '/it/newEmail',
            component: NewEmail,
            name: 'newEmail'
        },
        {
            path: '/it/newFile',
            component: NewFile,
            name: 'newFile'
        },

    ],
    mode: 'history'

})
