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
                    <i title="обновить" class="material-icons">refresh</i>
                </div>
                <div class="action__group">
                    <i title="В спам!" class="material-icons">report</i>
                </div>

                <!-- <div class="action__group">
                    <i title="Прочитано/Не прочитано" class="material-icons">fiber_manual_record</i>
                </div> -->

                <div class="action__group">
                    <i title="В папку" class="material-icons">folder</i>
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
                <div class="input-field">
                    <input id="last_name" type="text" class="validate">
                    <label for="last_name">Поиск</label>
                    <i title="Поиск" class="material-icons">search</i>
                </div>
            </div>
            <div class="email_simple-paginate">
                <div class="paginate-numbers">
                    1-10 of 100
                </div>
                <div class="paginate-arrows">
                    <i title="Назад" class="material-icons">arrow_back</i>
                    <i title="Вперед" class="material-icons">arrow_forward</i>
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

<!-- :to="{name: 'SentMessagesOpen', params: {uid: message.uid}}" -- навыходе 404 -->
<!-- !!!!!!!!!!!!!!!!!--разобраться--!!!!!!!!!!!!!!!! -->

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
                            <input ref="selectMes" type="checkbox" class="filled-in"/>
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
                <!-- <td>
                    <div
                        :class="{'message__seen-dot' :getMessages['messages'][`${message.message_id}`].flags.seen !== 1}"></div>
                </td> -->
                <td class="email__to-td">
                    <div class="email__to">
                        <div>
                            <div
                                class="email__name"
                                :class="'bg_' + randomBg(1 , 5)"
                            >
<!-- {{ message.recipient[0].personal[0] }} нужно добавить !!!!-->                            
                                {{ message.sender[0].personal[0] }}
                            </div>
                        </div>
                        <div class="email__driver">
 <!-- {{ message.recipient[0].personal}} нужно добавить !!!!-->
                            {{ message.sender[0].personal}}
                        </div>
                    </div>
                </td>
                <td>
                    <div class="email__title">
                        {{ message.subject}}
                    </div>
                </td>
                <td>
                    <div class="email__attachments">
                        <i class="material-icons">attachment</i>
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
    </div>
</template>

<script>

    export default {
        name: "SentMessagesComponent",
        data() {
            return {
                selectMes: '',
                selectAllMes: false,
                checked: false,
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

                let toolbars = document.getElementById('ToolBars');
                for (let i = 0; i < this.$refs.selectMes.length; i++) {
                    if (this.$refs.selectMes[i].checked === true) {
                        toolbars.classList.remove("disabled");
                        break;
                    } else {
                        toolbars.classList.add("disabled");
                    }
                }

                let element = event.target.parentElement.parentElement.parentElement.parentElement;
                (!element.classList.contains('trSelect')) ? element.classList.add("trSelect") : element.classList.remove("trSelect");
            }
        },
        watch: {
            selectAllMes() {
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
                        trAll[i].classList.remove("trSelect")
                    }
                }

                ArrayMess.map((mess) => {
                    mess.checked = this.checked;
                });
            }
        },
        created() {
            this.$store.dispatch('getMessages');
        }
    }
</script>

<style>

</style>
