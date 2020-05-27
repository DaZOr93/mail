import folderModal from '../components/Modal/FolderModalComponent'
import spamModal from '../components/Modal/SpamModalComponent'
import deleteModal from '../components/Modal/DeleteModalComponent'
import {eventBus} from "../app"
import _ from 'lodash'

export default {
    components: {folderModal, spamModal , deleteModal},
    props: ['getMessages' , 'slug'],
    data() {
        return {
            selectMes: '',
            selectAllMes: false,
            checked: false,
            reload: false,
            modal: {
                'spam': false,
                'deleted': false,
                'folder': false,
            },
            action: false,
            MessagesData: {},
            search: "",
            messages: [],
            messagesSearch: []
        }
    },
    computed: {
        selectAll() {
            return this.$store.getters.selectAll
        },
        preloader() {
            return this.$store.getters.preloader
        },
    },
    methods: {
        paginate(page) {
            if (page) eventBus.$emit('paginate', page)
        },
        searchMessages: _.debounce(function (event) {
            if (!event.target.value) {
                this.messagesSearch = [];
            } else {
                axios.get('/api/search/messages/' + event.target.value).then(r => {
                    this.messagesSearch = r.data;
                })
            }
        }, 200),
        favorite(message, uid, event) {
            let state = event.target.innerHTML.trim();
            if (state === 'star_border') {
                event.target.innerHTML = 'star';
                event.target.style.color = '#F9AD3D';
                axios.get('/api/favorite/add/' + message + '/' + uid);
            } else {
                event.target.innerHTML = 'star_border';
                event.target.style.color = '#D8D8D8';
                axios.get('/api/favorite/remove/' + message + '/' + uid);
            }
        },
        openNav() {
            let nav = document.getElementById('nav_wrap');
            nav.classList.toggle("nav-wrap__open");
        },
        reloadMess(slug = 'main') {
            if (!this.preloader) {
                this.$store.state.messages = [];
                this.$store.dispatch('getMessagesRefresh' , slug);
            }
        },
        getDate(time) {
            let date = time.split(' ')[1];
            date = date.split(':');
            return date[0] + ':' + date[1]
        },
        setBg(event) {
            event.target.previousElementSibling.checked = !event.target.previousElementSibling.checked;
            this.action = true;
            let toolbars = document.getElementById('ToolBars');
            for (let i = 0; i < this.$refs.selectMes.length; i++) {
                if (this.$refs.selectMes[i].checked === true) {
                    toolbars.classList.remove("disabled");
                    this.action = true;
                    break;
                } else {
                    toolbars.classList.add("disabled");
                    this.action = false;
                }
            }
            let element = event.target.parentElement.parentElement.parentElement.parentElement;
            (!element.classList.contains('trSelect')) ? element.classList.add("trSelect") : element.classList.remove("trSelect");
        },
        actions(action) {
            if (this.action === true) {
                this.modal[action] = true;
                this.messages = [];
                let checked = this.$refs.selectMes.filter(mes => mes.checked === true);
                for (let key in checked) {
                    let message = checked[key].getAttribute('data-mess');
                    this.messages.push(this.getMessages.data[message])
                }

                if (action === 'seen') {
                    this.$store.dispatch('update_messages', {
                        action: 'seen',
                        messages: this.messages
                    });

                    return window.location.reload();
                }
            }
        }
    },
    filters: {
        shortText(txt , limit ,val){
            if(txt == 0) return ' '

            return txt.slice(0 , limit) + val
        }
    },
    watch: {
        selectAllMes() {
            this.action = true;
            let toolbars = document.getElementById('ToolBars');
            let trAll = document.getElementsByTagName('tr');
            let ArrayMess = this.$refs.selectMes;
            this.checked = (this.checked === false);
            (this.checked) ? toolbars.classList.remove("disabled") : toolbars.classList.add("disabled");
            if (this.checked) {
                for (let i = 0; i < trAll.length; i++) {
                    trAll[i].classList.add("trSelect")
                }
            } else {
                for (let i = 0; i < trAll.length; i++) {
                    trAll[i].classList.remove("trSelect");
                    this.action = false;
                }
            }
            if(ArrayMess) {
                ArrayMess.map((mess) => {
                    mess.checked = this.checked;
                });
            }
        },
    },

}
