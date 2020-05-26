<template>
    <div class="nav-wrap" id="nav_wrap">
        <div class="nav__mobile-close" @click="closeNav">
            <i class="material-icons">dehaze</i>
        </div>
        <div class="write_letter">
            <a
                href="#"
                class="waves-effect waves-light"
                v-if="$route.path === '/newEmail'"
                @click.prevent="send"
            >Отправить</a>
            <router-link tag="a" class="waves-effect waves-light" to="/newEmail" v-else>Новое письмо</router-link>
        </div>
        <div class="nav-menu">
            <ul>
                <li>
                    <router-link tag="a" exact active-class="active" to="/">Входящие</router-link>
                    <span v-if="countMessages.inbox !== 0">{{ countMessages.inbox }}</span>
                </li>
                <li>
                    <router-link tag="a" active-class="active" to="/draft">Черновик</router-link>
                    <span v-if="countMessages.draft !== 0">{{ countMessages.draft }}</span>
                </li>
                <li>
                    <router-link tag="a" active-class="active" to="/sent">Отправленные</router-link>
                    <span v-if="countMessages.sending !== 0">{{ countMessages.sending }}</span>
                </li>
                <li>
                    <router-link tag="a" active-class="active" to="/basket">Корзина</router-link>
                    <span v-if="countMessages.deleted !== 0">{{ countMessages.deleted }}</span>
                </li>
                <li>
                    <router-link tag="a" active-class="active" to="/spam">Спам</router-link>
                    <span v-if="countMessages.spam !== 0">{{ countMessages.spam }}</span>
                </li>
            </ul>
        </div>
        <div class="work-labels">
            <ul>
                <li v-for="(folder, index) in getFolders" :key="index" :style="{'color':folder.color}">
                    <router-link active-class="folder_active" :to="{name: 'folder', params: {slug: folder.slug}}"
                                 tag="a">{{folder.name }}
                    </router-link>
                    <span v-if="countFolderMessages[index] !== 0">{{ countFolderMessages[index]}}</span>
                </li>
            </ul>
        </div>
        <div class="new-file">
            <div class="write_letter">
                <a @click="create_folder" class="waves-effect waves-light modal-trigger">новая папка</a>
            </div>
        </div>
        <NewFolder @close="modal = !modal" :modal="modal"></NewFolder>
    </div>
</template>

<script>
    import {eventBus} from "../../../app";
    import NewFolder from "../../Modal/NewFolder/NewFolderComponent";

    export default {
        components: {NewFolder},
        name: "NavBarComponent",
        data() {
            return {
                modal: false,
            };
        },
        computed: {
            newMessage() {
                return this.$store.getters.newMessage;
            },
            getErrors() {
                return this.$store.getters.getErrors;
            },
            getFolders() {
                return this.$store.getters.getFolders;
            },
            countMessages() {
                return this.$store.getters.countMessages;
            },
            countFolderMessages() {
                return this.$store.getters.countFolderMessages
            }
        },
        methods: {
            closeNav() {
                let nav = document.getElementById("nav_wrap");
                nav.classList.toggle("nav-wrap__open");
            },
            send() {
                let reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
                if(this.newMessage.emails.length < 1 && this.newMessage.to.length < 1) {
                    return  Vue.$toast.open({
                        message: `Введите получателя`,
                        type: "error",
                        position: "top",
                        duration: 2000
                    });
                }else if(this.newMessage.emails.length < 1 && reg.test(this.newMessage.to) === false) {
                    return  Vue.$toast.open({
                        message: `Не коректный Email`,
                        type: "error",
                        position: "top",
                        duration: 2000
                    });
                }
                this.$store.dispatch("sendEmail", this.newMessage);
                setTimeout(() => {
                    if (Object.keys(this.getErrors).length > 0) {
                        for (let key in this.getErrors) {
                            Vue.$toast.open({
                                message: `${this.getErrors[key]}`,
                                type: "error",
                                position: "top",
                                duration: 2000
                            });
                        }
                        this.$store.state.errors = {};
                    } else {
                        Vue.$toast.open({
                            message: `Отправлено`,
                            type: "success",
                            position: "top",
                            duration: 2000
                        });
                        eventBus.$emit("reset");
                    }
                }, 500);
                this.$store.dispatch("countMessages");
            },
            create_folder() {
                this.modal = true;
            }
        },
        created() {
            this.$store.dispatch("userFolders");
            this.$store.dispatch("countMessages");
            this.$store.dispatch("countFolderMessages");
        }
    };
</script>

<style>
    .nav-menu li {
        position: relative;
    }

    a.folder_active {
        color: #000;
        font-weight: 800;
    }

    .nav-menu span {
        font-weight: 900;
        font-size: 9px;
        letter-spacing: 1.125px;
        text-transform: uppercase;
        color: #b3b3b3;
        position: absolute;
        margin-top: -10px;
        top: 50%;
        right: 10px;
        width: 20px;
        height: 20px;
        display: flex;
        background: #f7f7f7;
        border-radius: 4px;
        justify-content: center;
        align-items: center;
    }

    .modal-overlay {
        position: fixed;
        z-index: 999;
        top: -25%;
        left: 0;
        bottom: 0;
        right: 0;
        height: 125%;
        width: 100%;
        background: #000;
        display: none;
        will-change: opacity;
    }

    .modal {
        display: none;
        position: fixed;
        left: 0;
        right: 0;
        background-color: transparent;
        padding: 0;
        height: 550px;
        width: 350px;
        margin: auto;
        overflow-y: visible;
        border-radius: 2px;
        will-change: top, opacity;
    }

    .modal .modal-content {
        padding: 0px;
    }

    .work-labels::-webkit-scrollbar {
        width: 5px;
    }

    .work-labels::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
        border-radius: 10px;
    }

    .nav-wrap .work-labels li {
        position: relative;
    }

    .nav-wrap .work-labels li span {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        right: 20px;
        background: #f7f7f7;
        width: 20px;
        height: 20px;
        display: flex;
        justify-content: center;
        font-size: 9px;
        align-items: center;
        color: #b5b3b3;
    }


    .work-labels::-webkit-scrollbar-thumb {
        border-radius: 10px;
        -webkit-box-shadow: inset 0 0 5px rgba(137, 137, 137, 0.5);
    }

    .work-labels {
        max-height: 120px;
        overflow: auto;
    }
</style>
