<template>
    <div class="w100 new__email-inner">
        <div class="new__email-bar">
            <div class="email__arrows">
                <i @click="$router.go(-1)" class="material-icons">arrow_back</i>
            </div>
            <div class="email__actions">
                <div class="action_group">
                    <i class="material-icons">attach_file</i>
                    <input id="fileUpload" type="file" @click="draftTrigger" name="file" multiple=""
                           @change="fileInputChange">
                    <label title="Прикрепить" for="fileUpload" class="action_text"></label>
                </div>
                <div class="action_group">
                    <i title="Сохранить" @click="saveMessage" class="material-icons">archive</i>
                </div>
                <div class="action_group">
                    <i title="Подпись" class="material-icons">person_add</i>
                </div>
            </div>
            <div class="email__search-wrap w100">
                <div class="nav__mobile-open" @click="openNav"><i class="material-icons">dehaze</i></div>
                <div class="email__search">
                    <div class="input-field">
                        <label for="last_name">Поиск</label>
                        <input @input="mySearch(message.editorData)" id="last_name" type="text" v-model="search" class="validate">
                        <i class="material-icons">search</i>
                    </div>
                </div>
            </div>
            <div class="email-dop">
                <div>
                    <i title="Печать" @click="print" class="material-icons">local_printshop</i>
                </div>
                <div>
                    <i title="Настройки" class="material-icons">settings</i>
                </div>
            </div>
        </div>
        <div class="new__email-wrap">
            <div class="new__email-body">
                <div class="email__header-box">
                    <div class="email__to">
                        <span>Кому</span>
                        <div class="input-field">
                            <div class="email_to_list" v-if="message.emails.length > 0">
                                <b v-for="(email, index) in message.emails" :key="index">
                                    <
                                    <i
                                        @keydown.enter.prevent
                                        @keydown.space.prevent
                                        contenteditable @input="update(index, $event)">{{ email }}
                                    </i>
                                    >
                                </b>
                            </div>
                            <input
                                id="to"
                                @keydown.space.prevent="getEmails"
                                v-model="message.to"
                                type="text"
                                class="validate"
                                placeholder="Введите email"
                            >
                        </div>
                    </div>
                </div>
            </div>
            <div class="new__email-body">
                <div class="email__header-box">
                    <div class="email__subject">
                        <span>Тема</span>
                        <div class="input-field">
                            <input
                                id="subject"
                                placeholder="Введите Тему"
                                v-model="message.subject"
                                type="text"
                                class="validate"
                            >
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div id="editor" class="open__body">
                    <ckeditor :editor="editor" v-model="message.editorData" :config="editorConfig"></ckeditor>
                </div>
                <div class="messages__attachments" v-if="filesFinishData.length > 0">
                    <div class="progress" :style="{width: fileProgress + '%'}"></div>
                    <i class="material-icons">attachment</i>
                    <div>
                        <div class="attachments-tile">Вложения</div>
                        <ul>
                            <li v-for="(file , index) in filesFinishData" :key="index" @click="delAttach(index)">
                                <span class="attach-name">{{ file.name | shortName}}</span>
                                <VuePureLightbox
                                    v-if="imageVariable.indexOf( file.mime_type ) !== -1"
                                    :thumbnail="`/storage/app/${file.path}`"
                                    :images="[`/storage/app/${file.path}`]"
                                >
                                </VuePureLightbox>
                                <img
                                    v-else-if="fileVariable.indexOf( file.mime_type ) !== -1"
                                    class="attach_icon"
                                    :src="'/img/attach' + '-' + file.mime_type + '.png'"
                                    alt="attach">
                                <img v-else
                                     class="attach_icon"
                                     :src="'/img/no-file.png'"
                                     alt="attach">
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
    import VuePureLightbox from 'vue-pure-lightbox'
    import {eventBus} from "../../../app"

    export default {
        name: 'app',
        components: {VuePureLightbox},
        data() {
            return {
                editor: ClassicEditor,
                search: "",
                imageVariable: ['png', 'jpg', 'PNG', 'JPG', 'bmp'],
                fileVariable: ['txt', 'docx', 'xls', 'xlsx', 'zip', 'rar', 'doc', 'ppt', 'pdf'],
                message: {
                    'editorData': 'Введите сообщение',
                    'attach': [],
                    'attachBol': 0,
                    'subject': "",
                    'emails': []
                },
                editorConfig: {
                    toolbar: [
                        'bold',
                        'italic',
                        'link',
                        'BulletedList',
                        'NumberedList',
                        'Blockquote',
                    ]
                },
                emails: [],
                filesFinish: [],
                fileProgress: 0,
                filesFinishData: [],
                draft: false,
                draftId: 0
            }
        },
        methods: {
            openNav() {
                let nav = document.getElementById('nav_wrap');
                nav.classList.toggle("nav-wrap__open");
            },
            draftTrigger(event) {
                this.draft = true;
                if (this.filesFinishData.length > 4) {
                    event.preventDefault();
                    return this.toast('не более пяти файлов', 'warning');
                }
            },
            delAttach(index) {
                axios.delete('/api/delete/attachments/' + this.filesFinishData[index].path);
                this.message.attach.splice(index, 1);
                this.filesFinishData.splice(index, 1);
                this.filesFinish.splice(index, 1);
            },
            async fileInputChange(event) {
                let files = Array.from(event.target.files);
                for (let item of files) {
                    await this.uploadFiles(item);
                }
            },
            async uploadFiles(file) {
                if (this.filesFinishData.length > 4) return this.toast('не более пяти файлов', 'warning');
                this.draft = true;
                let form = new FormData();
                form.append('file', file);
                form.append('draftId', this.draftId);
                await axios.post('api/upload/attachments', form, {
                    onUploadProgress: (itemUpload) => {
                        this.fileProgress = Math.round((itemUpload.loaded / itemUpload.total) * 100);
                    }
                })
                    .then(r => {
                        this.fileProgress = 0;
                        this.filesFinishData.push(r.data);
                        this.message.attach.push(r.data);
                    })
                    .catch(error => {
                        this.toast('Недопустимый формат файла', 'warning')
                    })
            },
            print() {
                let windowForPrint = window.open("", "", "width=1000px,height=1000px");
                let message = this.message.editorData;
                windowForPrint.document.write(message);
                windowForPrint.print();
            },
            saveMessage() {
                if (this.draftId < 1) {
                    return this.toast('Нечего сохранять', 'warning')
                }
                axios.post('/api/updateDraft', {message: this.message, id: this.draftId});
                return this.toast('Cохранил', 'success')
            },
            getEmails() {
                let reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
                if (reg.test(this.message.to) === false) return;
                if (this.message.to.length > 1) this.message.emails.push(this.message.to);
                this.message.to = ""
            },
            update: function (index, event) {
                this.message.emails[index] = event.target.innerText.trim();
            },
            mySearch(html) {
                let pattern = '(<[^>]*>)|' + this.search.replace(/[-/\\^$*+?.()|[\]{}]/g, '\\$&');
                document.querySelectorAll('.open__body').forEach(function (n) {
                    if (!n.dataset.textOriginal) {
                        n.dataset.textOriginal = n.innerHTML;
                    }
                    n.innerHTML = n.dataset.textOriginal.replace(new RegExp(pattern, 'gi'), function (m0, m1) {
                        if (m1) return m0;
                        return '<span class="highlight">' + m0 + '</span>';
                    });
                });
                if (this.search.length === 0) {
                    this.message.editorData = '';
                    setTimeout(() => {
                        this.message.editorData = html;
                    }, 1)
                }
            },
            toast(msg, type) {
                Vue.$toast.open({
                    message: msg,
                    type: type,
                    position: 'top',
                    duration: 1000
                });
            }
        },
        watch: {
            message() {
                this.$store.state.newMessage = this.message
            },
            'message.editorData'() {
                this.draft = true;
                this.$store.state.newMessage = this.message
            },
            'message.subject'() {
                this.draft = true;
                this.$store.state.newMessage = this.message
            },
            'message.to'() {
                this.draft = true;
                this.$store.state.newMessage = this.message
            },
            draft() {
                if (this.message && this.draftId === 0) {
                    axios.post('/api/storeDraft', this.message)
                        .then(r => this.draftId = r.data)
                }
            },
            draftId() {
                this.message.letterId = this.draftId;
            },
        },
        filters: {
            shortName: function (value) {
                let mime_type = value.slice(value.lastIndexOf('.'));
                return value.slice(0, 4) + '...' + mime_type;
            },
        },
        beforeRouteLeave(to, from, next) {
            if (this.filesFinishData.length > 0) this.message.attachBol = 1;
            if (this.draft) {
                axios.post('/api/updateDraft', {message: this.message, id: this.draftId});
            }
            next();
        },
        created() {
            eventBus.$on('reset', () => {
                this.message = {
                    'editorData': 'Введите сообщение',
                    'attach': [],
                    'attachBol': 0,
                    'emails': []
                };
                this.filesFinish = [];
                this.filesFinishData = [];
                this.draft = false;
                this.draftId = 0;
            });
            if (this.$route.params.replayMessage) {
                this.message = {
                    'editorData': '<blockquote>' + this.$route.params.replayMessage.html + '/<blockquote>',
                    'to': this.$route.params.replayMessage.to,
                    'subject': 'Re:' + ' ' + this.$route.params.replayMessage.subject,
                    'deliveryRequest': true,
                    'attach': [],
                    'emails': [],
                    'attachBol': this.$route.params.replayMessage.attach
                };
                this.draft = true;
            }
            if (this.$route.params.draftMessage) {
                this.message = {
                    'editorData': this.$route.params.draftMessage.html,
                    'to': this.$route.params.draftMessage.to,
                    'subject': this.$route.params.draftMessage.subject,
                    'deliveryRequest': true,
                    'attach': [],
                    'emails': [],
                    'attachBol': this.$route.params.draftMessage.attach
                };
                this.message.attach = this.$route.params.draftMessage.attachments;
                this.draft = true;
                this.draftId = this.$route.params.draftMessage.id
                axios.get('/api/index/attachments/' + this.$route.params.draftMessage.id)
                    .then(r => this.filesFinishData = r.data)
            }
        }
    }
</script>

<style scoped>
    .email_to_list {
        display: flex;
        align-items: center;
        border-top: 2px solid #F5F5F5;
        border-bottom: 2px solid #F5F5F5;
        font-style: normal;
        font-size: 11px;
        color: #999999;
        padding-left: 35px;
    }

    .email_to_list b {
        display: flex;
        font-weight: 500;
        margin-right: 5px;
    }

    .email_to_list i {
        font-style: normal;
    }

    .email__to .input-field {
        display: flex;
    }

    .new__email-wrap .messages__attachments li {
        position: relative;
    }

    .new__email-inner {
        position: relative;
    }

    .new__email-wrap .messages__attachments li:hover::after,
    .new__email-wrap .messages__attachments li:hover::before {
        content: '';
        position: absolute;
        width: 44px;
        height: 4px;
        background: #ff5d5d;
        left: 50%;
        top: 50%;
        margin-top: 12px;
        margin-left: -27px;
        cursor: pointer;
    }

    .new__email-wrap .messages__attachments li:hover::before {
        transform: rotate(-45deg);
    }

    .new__email-wrap .messages__attachments li:hover::after {
        transform: rotate(45deg);
    }

    #fileUpload {
        display: none;
    }

    #fileUpload + label {
        display: block;
    }

    .progress {
        top: -12px;
        left: 3px;
        position: absolute;
    }

    .messages__attachments {
        top: 35%;
        width: 100%;
    }

    .new__email-body {
        margin-bottom: 10px;
    }

    .new__email-wrap {
        background: #fff;
        padding-top: 10px;
        height: 609px;
        position: relative
    }

    .input-field {
        margin: 0;
    }

    .email__header-box .input-field {
        max-width: 585px;
        width: 100%;
    }

    .email__header-box {
        display: flex;
        padding-right: 17px;
        padding-left: 31px;
    }

    .email__to, .email__subject {
        display: flex;
        max-width: 690px;
        width: 100%;
    }

    .email__to input, .email__subject input {
        margin: 0 !important;
        border: 2px solid #F5F5F5 !important;
        border-radius: 0px 4px 4px 0px !important;
        border-left: none !important;
        font-weight: bold;
        font-size: 12px !important;
        line-height: 40px;
        color: #999999;
        padding-left: 35px !important;
        max-width: 690px;
    }

    .new__email-switch {
        display: flex;
        align-items: center;
    }

    .switch label .lever {
        width: 40px;
        height: 25px;
        border: 2px solid #F0F0F0;
        background-color: transparent;
    }

    .switch label .lever:before, .switch label .lever:after {
        width: 15px;
        height: 15px;
        left: 5px;
        top: 2px;
    }

    .switch label input[type=checkbox]:checked + .lever {
        background-color: #1875F0;
    }

    .switch label input[type=checkbox]:checked + .lever:after {
        background-color: #FFFFFF
    }

    .switch label .lever:after {
        background-color: #E6E6E6;
    }

    .email__to input:focus, .email__subject input:focus {
        box-shadow: none !important;
    }

    .validate, .valid {
        box-shadow: none !important;
    }

    .email__to span, .email__subject span {
        font-style: normal;
        font-weight: 900;
        font-size: 10px;
        line-height: 45px;
        letter-spacing: 1.25px;
        padding: 0 17px;
        border: 2px solid #F5F5F5;
        border-radius: 4px 0px 0px 4px;
        color: #B3B3B3;
    }

    .new__email-bar {
        display: flex;
        align-items: center;
        background: #fff;
        border-bottom: 2px solid #F5F5F5;
        color: #D8D8D8;
        font-style: normal;
        font-weight: 500;
        font-size: 12px;
    }

    .new__email-bar i {
        width: 26px;
        height: 26px;
    }

    .email__actions {
        display: flex;
        border-right: 2px solid #F5F5F5;
    }

    .email__actions .action_group {
        padding: 30px 22px;
        text-align: center;
        display: flex;
    }

    .email__search-wrap {
        padding: 21px 25px 21px 30px;
        border-right: 2px solid #F5F5F5;
    }

    .email__search div {
        display: flex;
        align-items: center;
    }

    .email__search i {
        position: relative;
        z-index: 222;
        cursor: pointer;
    }

    .email__arrows {
        padding: 32px 30px 30px 32px;
        display: flex;
        border-right: 2px solid #F5F5F5;
    }

    .email__actions .action_text {
        color: #CCCCCC;
    }

    .new__email-bar input {
        border-bottom: none !important;
        margin-bottom: 0 !important;
    }

    .new__email-bar label.active {
        color: #D8D8D8 !important;
    }

    .new__email-bar input:focus {
        box-shadow: none !important
    }

    .email-dop {
        display: flex
    }

    .email-dop div {
        padding: 29px 15px;
    }

    .email__arrows i, .action_group i, .email-dop i {
        cursor: pointer
    }

    .email__arrows i:hover, .action_group i:hover, .action_group label:hover i, .email-dop i:hover {
        color: #837d7d;
    }

    .action_group label {
        width: 26px;
        height: 26px;
        position: absolute;
        cursor: pointer;
    }


</style>
