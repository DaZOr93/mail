<template>
    <div class="w100">
        <div class="open__email-bar">
            <div class="email__arrows">
                <i class="material-icons back">arrow_back</i>
                <i class="material-icons next">arrow_forward</i>
            </div>
            <div class="email__actions">
                <i class="material-icons">report</i>
                <i class="material-icons">delete</i>
                <i class="material-icons">archive</i>
                <i class="material-icons">call_missed_outgoing</i>
                <i class="material-icons">repeat</i>
            </div>
            <div class="email__search">
                <div class="input-field">
                    <input id="last_name" type="text" class="validate">
                    <label for="last_name">Поиск</label>
                    <i class="material-icons">search</i>
                </div>
            </div>
            <div class="email-dop">
                <i class="material-icons">local_printshop</i>
                <i class="material-icons">settings</i>
            </div>
        </div>
        <div class="mess__open-content">
            <div class="open__header">
                Кому
                <div class="open__user-wrap">
                    <div class="open__user-photo">
 <!-- {{ message.attr.recipient[0]["personal"][0]}} нужно добавить !!!!-->
                        {{ message.attr.sender[0]["personal"][0]}}
                    </div>
                    <div class="open__user-name">
 <!-- {{ message.attr.recipient[0]["personal"]}} нужно добавить !!!!-->
                        {{ message.attr.sender[0]["personal"]}}
                    </div>
                </div>
                <div class="open__subject">
                    Re:    {{ message.attr.subject}}
                </div>
                <div class="open__date">
                    {{ getDate(message.attr.date) }} AM
                </div>
            </div>
            <div class="open__body" v-html="message.messages.bodies.html.content">

            </div>
            <div class="footer-border"></div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "SentMessagesOpenComponent",
        data() {
            return {
                uid: this.$route.params.uid,
            }
        },
        computed: {
            message() {
                return this.$store.getters.message
            },
        },
        methods: {
            getDate(time) {
                let date = time.split('T')[1];
                date = date.split(':');

                return date[0] + ':' + date[1]
            }
        },
        watch: {
            $route(to) {
                this.uid = to.params['uid']
            }
        },
        created() {
            this.$store.dispatch('getMessageSending', this.uid);
        }
    }
</script>



<style>
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
        display:flex;
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
        position:absolute;
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
