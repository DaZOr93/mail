<template>
    <div class="w100">
        <div class="open__email-bar">
            <div class="email__arrows">
                <router-link tag="i" :to="{name: 'incoming'}" class="material-icons back">
                    arrow_back
                </router-link>
            </div>
            <div class="email__actions">
                <i @click="actions('spam')" class="material-icons">report</i>
                <i @click="deleteMess" class="material-icons">delete</i>
                <i @click="storeDraft" class="material-icons">archive</i>
                <router-link tag="i" :to="{name: 'newEmail', params: {replayMessage: message}}" class="material-icons">
                    call_missed_outgoing
                </router-link>
                <!--                <router-link tag="i" :to="{name: 'newEmail', params: {forwardMessage: message}}" class="material-icons">-->
                <!--                    repeat-->
                <!--                </router-link>-->
            </div>
            <div class="email__search w100">
                <div class="input-field">
                    <input v-model="search" @keyup="mySearch(message.html , 'html')" id="last_name" type="text"
                           class="validate">
                    <label for="last_name">Поиск</label>
                    <i class="material-icons">search</i>
                </div>
            </div>
            <div class="email-dop">
                <i @click="print" class="material-icons">local_printshop</i>
                <router-link to="/settings" tag="i" class="material-icons">
                   settings
                </router-link>
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
        <div class="mess__open-content" v-else>
            <div class="open__header" v-if="!$route.params.sent">
                От
                <div class="open__user-wrap">
                    <div class="open__user-photo">
                        {{ (!message.from_name[0] ) ? message.from_name[0]: message.from[0]}}
                    </div>
                    <div class="open__user-name">
                        {{ (!message.from_name[0]) ? message.from_name : message.from}}
                    </div>
                </div>
                <div class="open__subject">
                    Re: {{ message.subject}}
                </div>
                <div class="open__date">
                    {{ getDate(message.date_send) }} AM
                </div>
            </div>
            <div class="open__header" v-else>
                От
                <div class="open__user-wrap">
                    <div class="open__user-photo">
                        {{ message.to[0] }}
                    </div>
                    <div class="open__user-name">
                        {{ message.to }}
                    </div>
                </div>
                <div class="open__subject">
                    Re: {{ message.subject}}
                </div>
                <div class="open__date">
                    {{ getDate(message.date_send) }} AM
                </div>
            </div>
            <div id="rangeBody" class="open__body" v-html="message.html"></div>
            <div class="messages__attachments" v-if="message.attachments.length > 0">
                <i class="material-icons">attachment</i>
                <div>
                    <div class="attachments-tile">Вложения</div>
                    <ul>
                        <li v-for="attach in message.attachments">
                            <span class="attach-name">{{ attach.name | shortName}}</span>
                            <VuePureLightbox
                                v-if="imageVariable.indexOf( attach.mime_type ) !== -1"
                                :thumbnail="`/storage/${attach.path}`"
                                :images="[`/storage/${attach.path}`]"
                            >
                            </VuePureLightbox>
                            <img
                                v-else-if="fileVariable.indexOf( attach.mime_type ) !== -1"
                                class="attach_icon"
                                @click="downloads(attach.path , attach.name)"
                                :src="'/img/attach' + '-' + attach.mime_type + '.png'"
                                alt="attach">
                            <img  v-else
                                  class="attach_icon"
                                  @click="downloads(attach.path , attach.name)"
                                  :src="'/img/no-file.png'"
                                  alt="attach">
                        </li>
                    </ul>
                </div>
            </div>
            <div class="footer-border"></div>
        </div>
        <deleteModal @close="deleteModal = !deleteModal" :deleteModal="deleteModal" :message_id="message.message_id"
                     :uid="message.uid"></deleteModal>
        <spamModal @close="spamModal = !spamModal" :msgOpen="true" :modal_spam="spamModal"
                   :messages="[message]"></spamModal>
    </div>
</template>

<script>
    import VuePureLightbox from 'vue-pure-lightbox'
    import deleteModal from '../../Modal/DeleteModalComponent'
    import searchMixin from '../../../Mixins/Search'
    import spamModal from '../../../components/Modal/SpamModalComponent'

    export default {
        name: "MessagesOpenComponent",
        components: {deleteModal, VuePureLightbox, spamModal},
        mixins: [searchMixin],
        data() {
            return {
                uid: this.$route.params.uid,
                deleteModal: false,
                search: "",
                spamModal: false,
                imageVariable: ['png' , 'jpg' , 'PNG', 'JPG' , 'bmp'],
                fileVariable: ['txt' , 'docx' , 'xls', 'xlsx', 'zip' , 'rar' , 'doc' , 'ppt' , 'pdf'],
            }
        },
        computed: {
            message() {
                return this.$store.getters.message
            },
            preloader() {
                return this.$store.getters.preloader
            },
        },
        methods: {
            getDate(time) {
                let date = time.split(' ')[1];
                date = date.split(':');

                return date[0] + ':' + date[1]
            },
            deleteMess() {
                this.deleteModal = true;
            }
            ,
            downloads(path, name) {
                window.location = '/download?path=' + path.replace(/\\/g, "/") + '&name=' + name;
            },
            print() {
                let windowForPrint = window.open("", "", "width=1000px,height=1000px");
                let message = this.message.html;
                windowForPrint.document.write(message);
                windowForPrint.print();
            },
            storeDraft() {
                axios.post('/api/storeDraftIncoming', this.message);
                this.$store.dispatch('countMessages');
                Vue.$toast.open({
                    message: `Сохранил`,
                    type: 'success',
                    position: 'top',
                    duration: 2000
                });
            },
            actions() {
                this.spamModal = true;
            }
        },
        filters: {
            shortName: function (value) {
                let mime_type = value.slice(value.lastIndexOf('.'));

                return value.slice(0, 4) + '...' + mime_type;
            }
        },
        watch: {
            $route(to) {
                this.uid = to.params['uid']
            },
        },
        created() {
            this.$store.dispatch('getMessage', this.uid);
        }
    }
</script>


<style>
    .messages__attachments {
        position: absolute;
        max-width: 240px;
        right: 15px;
        top: 115px;
        z-index: 2;
        display: flex;
        background: #fff
    }

    .highlight {
        background-color: yellow;
    }

    .messages__attachments i {
        margin-right: 37px;
        color: #D8D8D8
    }

    span {
        font-weight: 500;
    }

    .attachments-tile {
        font-style: normal;
        font-weight: bold;
        font-size: 14px;
        line-height: 30px;
        color: #808080;
    }

    .messages__attachments li {
        margin-right: 10px;
        width: 79px;
    }

    .attach-name {
        font-style: normal;
        font-weight: bold;
        font-size: 14px;
        line-height: 30px;
        color: #999999;
    }

    .messages__attachments img {
        width: 70px !important;
        height: 60px;
        cursor: pointer
    }

    .lightbox__image {
        text-align: center;
    }

    .lightbox img {
        width: 40% !important;
        height: auto;
    }


    .messages__attachments ul {
        display: flex;
        max-width: 180px;
        flex-wrap: wrap;
    }


    .open__email-bar {
        display: flex;
        height: 88px;
        background: #fff;
        align-items: center;
    }

    .open__email-bar .input-field {
        display: flex;
        margin: 0 !important;
    }

    .open__email-bar i {
        color: #D8D8D8;
        width: 26px;
        height: 26px;
        cursor: pointer;
        position: relative;
        border-radius: 25px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .open__email-bar i:hover {
        color: #837d7d;
        background: #eee;
    }

    .open__email-bar input[type=text]:not(.browser-default):focus:not([readonly]) + label {
        color: #9e9e9e !important
    }

    .open__email-bar .email__arrows {
        padding: 0 30px;
        border-right: 2px solid #F5F5F5;
        height: 88px;
        display: flex;
        align-items: center;
        margin-right: 5px;
    }

    .open__email-bar .next {
        margin-left: 15px;
    }

    .open__email-bar .email__actions {
        display: flex;
        border-right: 2px solid #F5F5F5;
        height: 88px;
        align-items: center;
        padding-right: 23px;
        margin-right: 30px;
    }

    .open__email-bar .email__actions i:not(:last-child) {
        margin-right: 25px;
    }

    .open__email-bar .input-field {
        align-items: center;
        padding-right: 25px;
    }

    .open__email-bar .email__search input {
        border: none !important;
        margin: 0 !important;
        max-width: 837px !important;
    }

    .open__email-bar .email__search input:focus {
        border: none !important;
        box-shadow: none !important;
    }

    .open__email-bar .email-dop {
        padding: 31px 32px 31px 23px;
        border-left: 2px solid #F5F5F5;
    }

    .open__email-bar .email-dop i:first-child {
        margin-right: 30px;
    }

    .mess__open-content {
        padding-left: 30px;
        padding-top: 10px;
        background: #fff;
        font-weight: bold;
        font-size: 18px;
        color: #999999;
        border-top: 2px solid #F5F5F5;
        position: relative;
        height: 612px;
        overflow: auto;
    }

    .open__header {
        display: flex;
        align-items: center;
        padding-left: 10px;
        padding-bottom: 15px;
        border-bottom: 2px solid #F5F5F5;
        width: max-content;
    }

    .open__user-wrap {
        display: flex;
        align-items: center;
        margin-left: 36px;
        margin-right: 85px;
        font-weight: 500;
        font-size: 12px;
    }

    .open__user-photo {
        width: 40px;
        height: 40px;
        border-radius: 100px;
        background: orange;
        margin-right: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-transform: uppercase;
    }

    .open__subject {
        font-weight: 500;
        font-size: 12px;
        padding-right: 45px;
    }

    .open__date {
        font-weight: 500;
        font-size: 12px;
    }

    .open__body {
        padding-top: 30px;
        padding-bottom: 36px;
        font-style: normal;
        font-weight: 500;
        font-size: 13px;
        line-height: 30px;
        color: #808080;
        max-width: 900px
    }

    .footer-border {
        position: absolute;
        height: 2px;
        width: 100%;
        background: #F5F5F5;
        left: 0;
    }

    .open__body li {
        padding-left: 35px;
        position: relative;
    }

    .open__body ul li:before {
        content: ".";
        width: 9px;
        height: 9px;
        position: absolute;
        font-size: 46px;
        color: #D8D8D8;
        left: 0;
        top: -13px;
    }

    .open__body ol {
        padding-left: 15px;
    }

    .open__body ol li {
        padding-left: 20px;
        list-style: inherit;
    }
</style>
