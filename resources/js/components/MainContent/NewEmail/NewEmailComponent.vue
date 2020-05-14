<template>
    <div class="w100">
        <div class="new__email-bar">
            <div class="email__arrows">
                <i  @click="$router.go(-1)" class="material-icons">arrow_back</i>
            </div>
            <div class="email__actions">
                <div class="action_group">
                    <i class="material-icons">attach_file</i>
                    <div class="action_text">Прикрепить</div>
                </div>
                <div class="action_group">
                    <i class="material-icons">archive</i>
                    <div class="action_text">Сохранить</div>
                </div>
                <div class="action_group">
                    <i class="material-icons">person_add</i>
                    <div class="action_text">Подпись</div>
                </div>
            </div>
            <div class="email__search-wrap">
                <div class="email__search">
                    <div class="input-field">
                        <label for="last_name">Поиск</label>
                        <input id="last_name" type="text" class="validate">
                        <i class="material-icons">search</i>
                    </div>
                </div>
            </div>
            <div class="email-dop">
                <div>
                    <i title="Печать" class="material-icons">local_printshop</i>
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
                            <input
                                id="to"
                                v-model="message.to"
                                type="text"
                                class="validate"
                                placeholder="Введите email"
                            >
                        </div>
                    </div>
                    <div class="switch new__email-switch">
                        <label>
                            <input type="checkbox">
                            <span class="lever"></span>
                            Запрос ответа
                        </label>
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
                    <div class="switch new__email-switch">
                        <label>
                            <input type="checkbox">
                            <span class="lever"></span>
                            Уведомить о доставке
                        </label>
                    </div>
                </div>
            </div>
            <div id="editor">
                <ckeditor :editor="editor"   v-model="message.editorData" :config="editorConfig"></ckeditor>
            </div>
        </div>
    </div>
</template>

<script>
    import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
    import {eventBus} from "../../../app"

    export default {
        name: 'app',
        data() {
            return {
                editor: ClassicEditor,
                message: {
                    'editorData': 'Введите сообщение'
                },
                editorConfig: {
                    toolbar: [
                        'bold',
                        'italic',
                        'link',
                        'imageUpload',
                        'BulletedList',
                        'NumberedList',
                        'Blockquote',
                    ]
                }
            }
        },
        watch: {
            message(){
               this.$store.state.newMessage = this.message
            },
            'message.editorData'(){
                this.$store.state.newMessage = this.message
            }
        },
        created() {
            eventBus.$on('reset', (notify) => {
                this.message = {}
            })
        }
    }
</script>

<style scoped>
    .new__email-body {
        margin-bottom: 10px;
    }

    .new__email-wrap {
        background: #fff;
        padding-top: 10px;
        min-height: 612px;
        position: relative
    }
    .input-field {
        margin: 0;
    }
    .email__header-box .input-field{
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
        font-size: 12px!important;
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
        padding: 20px 22px;
        text-align: center;
    }

    .email__search-wrap {
        padding: 6px 25px 6px 30px;
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
        width: 240px !important;
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

    .email__arrows, .action_group, .email-dop div {
        cursor: pointer;
    }

    .email__arrows:hover, .action_group:hover, .email-dop div:hover {
        background: rgba(24, 117, 240, 0.16);
    }


</style>
