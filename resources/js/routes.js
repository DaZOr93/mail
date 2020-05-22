import VueRouter from 'vue-router';
import Home from "./components/HomeComponent";
import Incoming from './components/MainContent/Incoming/IncomingComponent';
import Draft from './components/MainContent/Draft/DraftComponent';
import Spam from './components/MainContent/Spam/SpamComponent';
import Sent from './components/MainContent/Sent/SentComponent';
import Basket from './components/MainContent/Basket/BasketComponent';
import NewEmail from './components/MainContent/NewEmail/NewEmailComponent';
import NewFile from './components/MainContent/NewFile/NewFileComponent';
import PageNotFound from './components/Fails/404';
import MessagesOpen from './components/MainContent/Messages/MessagesOpenComponent';
import folder from './components/MainContent/File/FolderComponent'
import Setting from './components/MainContent/Setting/SettingComponent'

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
            path: '/spam',
            component: Spam,
            name: 'spam'
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
            path: '/messages/:uid',
            component: MessagesOpen,
            name: 'MessagesOpen'
        },
        {
            path: '/folder/:slug',
            component: folder,
            name: 'folder'
        },
        {
            path: '/setting',
            component: Setting,
            name: 'setting'
        },
        //404
        {
            path: "*",
            component: PageNotFound
        }

    ],
    mode: 'history'

})
