<template>
    <div class="nav-wrap" id="nav_wrap">
        <div class="nav__mobile-close" @click="closeNav"><i class="material-icons">dehaze</i></div>
        <div class="write_letter">
            <a
                href="#"
                class="waves-effect waves-light"
                v-if="$route.path === '/newEmail'"
                @click.prevent="send"
                >
                Отправить
            </a>
            <router-link
                tag="a"
                class="waves-effect waves-light"
                to="/newEmail"
                v-else
            >
                Новое письмо
            </router-link>

        </div>
        <div class="nav-menu">
            <ul>
                <li>
                    <router-link tag="a" exact active-class="active" to="/">Входящие</router-link>
                    <span>5</span>
                </li>
                <li>
                    <router-link tag="a" active-class="active" to="/draft">Черновик</router-link>
                    <span>5</span>
                </li>
                <li>
                    <router-link tag="a" active-class="active" to="/sent">Отправленные</router-link>
                    <span>5</span>
                </li>
                <li>
                    <router-link tag="a" active-class="active" to="/basket">Корзина</router-link>
                    <span>5</span>
                </li>
            </ul>
        </div>
        <div class="work-labels">
            <ul>
                <li v-for="folder in getFolders" :style="{'color':folder.color}">
                    <router-link    :to="{name: 'folder', params: {slug: folder.slug}}"  tag="a">
                        {{folder.name }}
                    </router-link>
                </li>
            </ul>
        </div>
        <div class="new-file">
            <div class="write_letter">
                <a class="waves-effect waves-light modal-trigger" href="#modal">новая папка</a>
            </div>
        </div>
        <NewFile id="modal" class="modal"></NewFile>
    </div>
</template>

<script>
    import {eventBus} from "../../../app"
    import NewFile from "../NewFile/NewFileComponent";
    export default {
        components: {NewFile},
        name: "NavBarComponent",
        computed: {
            newMessage(){
                return this.$store.getters.newMessage
            },
            getErrors() {
                return this.$store.getters.getErrors
            },
            getFolders(){
                return this.$store.getters.getFolders
            }
        },
        methods: {
            closeNav() {
                let nav = document.getElementById('nav_wrap');
                nav.classList.toggle("nav-wrap__open");
            },
            send(){
                this.$store.dispatch('sendEmail' ,this.newMessage );
                setTimeout( () => {
                    if(Object.keys(this.getErrors).length > 0) {
                        for (let key in this.getErrors) {
                            Vue.$toast.open({
                                message: `${this.getErrors[key]}`,
                                type: 'error',
                                position: 'top',
                                duration: 2000
                            });
                        }
                        this.$store.state.errors = {}
                    }else {
                        Vue.$toast.open({
                            message: `Отправлено`,
                            type: 'success',
                            position: 'top',
                            duration: 2000
                        });
                        eventBus.$emit('reset')
                    }
                },500)
            }
        },
        created(){
            this.$store.dispatch('userFolders');
        },
        mounted() {
            document.addEventListener("DOMContentLoaded", function () {
                var elems = document.querySelectorAll(".modal");
                var instances = M.Modal.init(elems, {
                    opacity: 0.1,
                    inDuration: 600,
                    outDuration: 600
                });
            });
        }
    };
</script>

<style>
    .nav-menu li {
        position: relative;
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
</style>
