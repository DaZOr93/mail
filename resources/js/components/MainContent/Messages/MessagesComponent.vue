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
                    {{pagination['start']}}
                    -
                    {{pagination['end']}}
                    of
                    {{pagination['total']}}
                </div>
                <div class="paginate-arrows">
                    <i title="Назад"
                       @click="paginate('back')"
                       class="material-icons"
                       :class="{'pag_disabled': !paginatePrev}"
                    >
                        arrow_back
                    </i>
                    <i
                        title="Вперед"
                        @click="paginate('next')"
                        class="material-icons"
                        :class="{'pag_disabled': paginateNext === false}"
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
                :to="{name: 'MessagesOpen', params: {uid: message.uid}}"
                v-for="(message , index) in getMessages.attr"
                :key="index"
                :class="{new__massage__list:getMessages['messages'][`${message.message_id}`].flags.seen !== 1}"
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
                <td class="seen">
                    <div
                        :class="{'message__seen-dot' :getMessages['messages'][`${message.message_id}`].flags.seen !== 1}">
                    </div>
                </td>
                <td class="email__from-td">
                    <div class="email__from">
                        <div>
                            <div
                                class="email__name"
                                :class="'bg_' + randomBg(1 , 5)"
                            >
                                {{ ( message.sender[0].personal ) ? message.sender[0].personal[0] :
                                message.sender[0].mailbox[0]}}
                            </div>
                        </div>
                        <div class="email__driver">
                            {{ ( message.sender[0].personal ) ? message.sender[0].personal : message.sender[0].mailbox}}
                        </div>
                    </div>
                </td>
                <td>
                    <div class="email__title">
                        {{ (message.subject === "") ? "( Без темы )" : message.subject}}
                    </div>
                </td>
                <td>
                    <div class="email__attachments">

                        <i
                            v-if="getMessages['messages'][`${message.message_id}`].attachments.length != 0"
                            class="material-icons"
                        >
                            attachment
                        </i>
                    </div>
                </td>
                <td>
                    <div class="email_date">
                        {{ getDate( message.date) }} AM
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

    export default {
        name: "MessagesComponent",
        components: {folderModal},
        data() {
            return {
                selectMes: '',
                selectAllMes: false,
                checked: false,
                reload: false,
                modal: false,
                action: false,
                messages: []
            }
        },
        computed: {
            selectAll() {
                return this.$store.getters.selectAll
            },
            preloader() {
                return this.$store.getters.preloader
            },
            getMessages() {
                return this.$store.getters.getMessages
            },
            pagination() {
                return this.$store.getters.pagination
            },
            paginateNext() {
                if (!this.preloader) {
                    return this.getMessages['pagination']['current'] >= 10;
                }
            },
            paginatePrev() {
                if (!this.preloader) {
                    return this.getMessages['pagination']['page'] != 1;
                }
            }
        },
        methods: {
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
            paginate(way) {
                if (!this.preloader) {
                    if (way === 'next' && this.paginateNext) {
                        this.$store.dispatch('getMessages', +this.getMessages['pagination']['page'] + 1);
                    }
                    if (way === 'back' && this.paginatePrev) {
                        this.$store.dispatch('getMessages', +this.getMessages['pagination']['page'] - 1);
                    }
                }
            },
            reloadMess() {
                if (!this.preloader) {
                    this.$store.state.messages = [];
                    this.$store.dispatch('getMessages', 1);
                }
            },
            randomBg(min, max) {
                let rand = min - 0.5 + Math.random() * (max - min + 1);
                return Math.round(rand);
            },
            getDate(time) {
                let date = time.split('T')[1];
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
        }
        ,
        created() {
            this.$store.dispatch('getMessages', 1);
        },
        mounted() {
        }
        ,
    }
</script>

<style>
    .pag_disabled {
        cursor: default !important;
    }

    .pag_disabled:hover {
        color: #D8D8D8 !important;
    }
</style>
