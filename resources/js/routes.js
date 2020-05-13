import VueRouter from 'vue-router';
import Home from "./components/HomeComponent";
import Incoming from './components/MainContent/Incoming/IncomingComponent';
import Draft from './components/MainContent/Draft/DraftComponent';
import Sent from './components/MainContent/Sent/SentComponent';
import Basket from './components/MainContent/Basket/BasketComponent';
import NewEmail from './components/MainContent/NewEmail/NewEmailComponent';
import NewFile from './components/MainContent/NewFile/NewFileComponent';
import PageNotFound from './components/fails/404';
import MessagesOpen from './components/MainContent/Messages/MessagesOpenComponent';
import SentMessagesOpen from './components/MainContent/Messages/SentMessagesOpenComponent'


export default new VueRouter({
    routes: [
        {
            path: '/home',
            component: Home,
            name: 'Home'
        },
        {
            path: '/',
            component: Incoming,
            name: 'incoming'
        },
        {
            path: '/draft',
            component: Draft,
            name: 'draft'
        },
        {
            path: '/sent',
            component: Sent,
            name: 'sent'
        },
        {
            path: '/basket',
            component: Basket,
            name: 'basket'
        },
        {
            path: '/newEmail',
            component: NewEmail,
            name: 'newEmail'
        },
        {
            path: '/newFile',
            component: NewFile,
            name: 'newFile'
        },

        {   
            path: '/sentMessages/:uid',
            component: SentMessagesOpen,
            name: 'SentMessagesOpen'
        },
      
        {
            path: '/messages/:uid',
            component: MessagesOpen,
            name: 'MessagesOpen'
        },
        //404
        {
            path: "*",
            component: PageNotFound
        }

    ],
    mode: 'history'

})
