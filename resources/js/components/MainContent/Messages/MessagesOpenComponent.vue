<template>
    <div class="w100">
        <div class="open__email-bar">
            <div class="email__arrows">
                <i class="material-icons back">arrow_back</i>
                <i class="material-icons next">arrow_forward</i>
            </div>
            <div class="email__actions">
                <i class="material-icons">report</i>
                <i @click="deleteMess" class="material-icons">delete</i>
                <i class="material-icons">archive</i>
               <router-link tag="i" :to="{name: 'newEmail', params: {replayMessage: message}}" class="material-icons">call_missed_outgoing</router-link>
                <i class="material-icons">repeat</i>
            </div>
            <div class="email__search w100">
                <div class="input-field">
                    <input  v-model="search" @keyup="mySearch(message.html)" id="last_name" type="text" class="validate">
                    <label for="last_name">Поиск</label>
                    <i class="material-icons">search</i>
                </div>
            </div>
            <div class="email-dop">
                <i class="material-icons">local_printshop</i>
                <i class="material-icons">settings</i>
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
            <div class="open__header">
                От
                <div class="open__user-wrap">
                    <div class="open__user-photo">
                        {{ (message.from_name[0]) ? message.from_name[0]: message.from[0]}}
                    </div>
                    <div class="open__user-name">
                        {{ (message.from_name[0]) ? message.from_name : message.from}}
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
                                v-if="attach.imageSrc !== null"
                                :thumbnail="`/storage/${attach.name}`"
                                :images="[`/storage/${attach.name}`]"
                            >
                            </VuePureLightbox>
                            <img
                                v-else
                                class="attach_icon"
                                @click="download(attach.path)"
                                :src="'/img/attach' + '-' + attach.mime_type + '.png'"
                                alt="attach">
                        </li>
                    </ul>
                </div>
            </div>
            <div class="footer-border"></div>
        </div>
        <deleteModal @close="modal = !modal" :modal="modal" :message_id="message.message_id"
                     :uid="message.uid"></deleteModal>
    </div>
</template>

<script>
    import VuePureLightbox from 'vue-pure-lightbox'
    import deleteModal from '../../Modal/DeleteModalComponent'

    export default {
        name: "MessagesOpenComponent",
        components: {deleteModal, VuePureLightbox},
        data() {
            return {
                uid: this.$route.params.uid,
                modal: false,
                search: ""
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
                this.modal = true;
            }
            ,
            download(path) {
                window.location = '/download?path=' + path
            },
            mySearch(html){
                let pattern = '(<[^>]*>)|' + this.search.replace(/[-/\\^$*+?.()|[\]{}]/g, '\\$&');
                document.querySelectorAll('.open__body').forEach(function(n) {
                    if (!n.dataset.textOriginal) {
                        n.dataset.textOriginal = html;
                        console.log( n.dataset.textOriginal)
                    }

                    n.innerHTML = n.dataset.textOriginal.replace(new RegExp(pattern, 'gi'), function (m0, m1) {
                        if (m1) return m0;
                        return '<span class="highlight">' + m0 + '</span>';
                    });
                });
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
            search() {

            }
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
        right: 13px;
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
        color: #9e9e9e!important
    }
    .open__email-bar .email__arrows {
        padding: 0px 7px;
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
