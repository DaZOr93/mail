<template>
    <div class="massage__list ">
        <div class="messages_wrap">
            <div class="messages_action disabled" id="ToolBars">
                <div class="action__group">
                    <label>
                        <input type="checkbox" class="filled-in" v-model="selectAllMes"/>
                        <span></span>
                    </label>
                </div>
                <div class="action__group">
                    <i @click="reloadMess" title="обновить" class="reloadMess material-icons ">refresh</i>
                </div>
                <div class="action__group">
                    <i title="В спам!" class="material-icons">report</i>
                </div>

                <div class="action__group">
                    <i title="Прочитано/Не прочитано" class="material-icons">fiber_manual_record</i>
                </div>

                <div class="action__group">
                    <i @click="store_folder" title="В папку" class="material-icons">folder</i>
                </div>
                <div class="action__group">
                    <i
                        title="Удалить"
                        data-target="delMes"
                        class="waves-effect waves-light modal-trigger material-icons"
                    >
                        delete
                    </i>
                </div>
            </div>
            <div class="email__search">
                <div class="nav__mobile-open" @click="openNav"><i class="material-icons">dehaze</i></div>
                <div class="input-field">
                    <input id="last_name" type="text" class="validate">
                    <label for="last_name">Поиск</label>
                    <i title="Поиск" class="material-icons">search</i>
                </div>
            </div>
            <div class="email_simple-paginate">
                <div class="paginate-numbers">

                    {{ getMessages.from}}
                    -
                    {{ getMessages.to}}
                    of
                    {{ getMessages.total}}
                </div>
                <div class="paginate-arrows">
                   <i
                       @click="paginate(getMessages.prev_page_url)"
                       :class="{'pag_disabled': !getMessages.prev_page_url}"
                       title="Назад" class="material-icons"
                   >
                       arrow_back
                   </i>
                   <i
                       @click="paginate(getMessages.next_page_url)"
                       :class="{'pag_disabled': !getMessages.next_page_url}"
                       title="Вперед"
                       class="material-icons"
                   >
                       arrow_forward
                   </i>
                </div>
            </div>
            <div class="email-dop">
                <div>
                    <i title="настройки" class="material-icons">settings</i>
                </div>
            </div>
        </div>

        <div class="preloader-wrapper big active " v-if="preloader">
            <div class="spinner-layer spinner-blue-only">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="gap-patch">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>
        </div>
        <table>
            <tbody>
            <router-link
                tag="tr"
                v-for="(message , index) in getMessages.data"
                :to="{name: 'MessagesOpen', params: {uid: message.message_id}}"
                :key="index"
                :class="{new__massage__list: message.seen != 0}"
            >
                <td>
                    <div class="message__select">
                        <label @click.prevent="setBg">
                            <input :data-mess="index" ref="selectMes" type="checkbox" class="filled-in"/>
                            <span></span>
                        </label>
                    </div>
                </td>
                <td>
                    <div class="message__favorite">
                        <i @click.prevent="favorite" class="material-icons">
                            star_border
                        </i>
                    </div>
                </td>
                <td class="seen" v-if="$route.path === '/' ||  $route.path === '/draft'">
                    <div
                        :class="{'message__seen-dot' :message.seen != 0}">
                    </div>
                </td>
                <td class="email__from-td" v-if="$route.path === '/'">
                    <div class="email__from">
                        <div>
                            <div
                                class="email__name"
                                :class="'bg_' + randomBg(1 , 5)"
                            >
                                {{ ( message.from_name === "0" ) ? message.from[0] : message.from_name[0]}}
                            </div>
                        </div>
                        <div class="email__driver">
                            {{ ( message.from_name === "0" ) ? message.from : message.from_name}}
                        </div>
                    </div>
                </td>
                <td v-else-if="$route.path === '/sent'" class="email__to-td">
                    <div class="email__to">
                        <div>
                            <div
                                class="email__name"
                                :class="'bg_' + randomBg(1 , 5)"
                            >
                                {{ ( message.to_name === "0" ) ? message.to[0] : message.to_name[0]}}
                            </div>
                        </div>
                        <div class="email__driver">
                            {{ ( message.to_name === "0" ) ? message.to : message.to_name}}
                        </div>
                    </div>
                </td>
                <td class="td__subject">
                    <div class="email__title">
                        {{ (message.subject === "") ? "( Без темы )" : message.subject}}
                    </div>
                </td>
                <td>
                    <div class="email__attachments">

                        <i
                            v-if="message.attach !== 0"
                            class="material-icons"
                        >
                            attachment
                        </i>
                    </div>
                </td>
                <td>
                    <div class="email_date">
                        {{ getDate(message.date_send)}} AM
                    </div>
                </td>
            </router-link>
            </tbody>
        </table>
        <folderModal @close="modal = !modal" :modal="modal" :messages="messages"></folderModal>
    </div>
</template>

<script>
    import folderModal from '../../Modal/FolderModalComponent'
    import {eventBus} from "../../../app"

    export default {
        name: "MessagesComponent",
        components: {folderModal},
        props: ['getMessages'],
        data() {
            return {
                selectMes: '',
                selectAllMes: false,
                checked: false,
                reload: false,
                modal: false,
                action: false,
                MessagesData: {},
                messages: [],
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
            paginate(page){
                if(page) eventBus.$emit('paginate' , page)
            },
            favorite(event) {
                let state = event.target.innerHTML;
                if (state === 'star_border') {
                    event.target.innerHTML = 'star';
                    event.target.style.color = '#F9AD3D';
                } else {
                    event.target.innerHTML = 'star_border';
                    event.target.style.color = '#D8D8D8';
                }
            },
            openNav() {
                let nav = document.getElementById('nav_wrap');
                nav.classList.toggle("nav-wrap__open");
            },
            reloadMess() {
                if (!this.preloader) {
                    this.$store.state.messages = [];
                    this.$store.dispatch('getMessagesRefresh');
                }
            },
            randomBg(min, max) {
                let rand = min - 0.5 + Math.random() * (max - min + 1);
                return Math.round(rand);
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
                        break;
                    } else {
                        toolbars.classList.add("disabled");
                        this.action = false;
                    }
                }
                let element = event.target.parentElement.parentElement.parentElement.parentElement;
                (!element.classList.contains('trSelect')) ? element.classList.add("trSelect") : element.classList.remove("trSelect");
            },
            store_folder() {
                this.modal = true;
                this.messages = [];
                let checked = this.$refs.selectMes.filter(mes => mes.checked === true);

                for (let key in checked) {
                    this.messages.push(this.getMessages.attr[key])
                }
            }
        }
        ,
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
                ArrayMess.map((mess) => {
                    mess.checked = this.checked;
                });
            }
        },

    }
</script>

<style>
    .pag_disabled {
        cursor: default !important;
    }

    .pag_disabled:hover {
        color: #D8D8D8 !important;
    }

    .td__subject {
        width: 50%;
    }
</style>
