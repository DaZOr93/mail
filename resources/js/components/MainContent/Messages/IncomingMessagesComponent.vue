<template>
    <div class="massage__list">
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
                    <i @click="update_messages" title="В папку" class="material-icons">folder</i>
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
            <div class="email__search w100">
                <div class="nav__mobile-open" @click="openNav"><i class="material-icons">dehaze</i></div>
                <div class="input-field">
                    <input id="last_name" @keyup="searchMessages" v-model="search" type="text" class="validate">
                    <label for="last_name">Поиск</label>
                    <i title="Поиск" class="material-icons">search</i>
                </div>
                <div id="search_range" class="search-items" v-if="messagesSearch.length > 0">
                    <div class="search-item"
                         v-for="message in messagesSearch"
                         @click="getQueryMess(queryFilter(message.subject, message.text))">
                        {{queryFilter(message.subject, message.text) }}
                        <i title="Поиск" class="material-icons">search</i>
                    </div>
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
                        <i @click.prevent="favorite(message.message_id, message.uid, $event)"
                           v-if="message.favorite === 1" style="color: rgb(249, 173, 61)" class="material-icons">
                            star
                        </i>
                        <i @click.prevent="favorite(message.message_id, message.uid, $event)" v-else
                           style="color: rgb(216, 216, 216);" class="material-icons">
                            star_border
                        </i>
                    </div>
                </td>
                <td class="seen" v-if="$route.path !== '/sent' ||  $route.path === '/draft'">
                    <div
                        :class="{'message__seen-dot' :message.seen != 0}">
                    </div>
                </td>
                <td class="email__from-td" v-if="$route.path !== '/sent'">
                    <div class="email__from">
                        <div>
                            <div
                                class="email__name"
                                :class="'bg_' + index"
                            >
                                {{ ( message.from_name === "0" ) ? message.from[0] : message.from_name[0]}}
                            </div>
                        </div>
                        <div class="email__driver">
                            {{ ( message.from_name === "0" ) ? message.from : message.from_name}}
                        </div>
                    </div>
                </td>
                <td v-else class="email__to-td">
                    <div class="email__to">
                        <div>
                            <div
                                class="email__name"
                                :class="'bg_' + index"
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
import MessagesMixin from  '../../../Mixins/Messages'
    export default {
        name: "MessagesComponent",
        mixins: [MessagesMixin]
    }
</script>

<style>
    .search-items {
        position: absolute;
        background: #ffffff;
        left: 0;
        width: 100%;
    }

    .massage__list .email__search {
        position: relative;
    }

    .massage__list .email__search .search-items {
        display: block;
        color: #666666
    }

    .email__search .search-item {
        padding: 30px;
        cursor: pointer;
        border-bottom: 1px solid rgba(0, 0, 0, 0.12);
        border-top: 1px solid rgba(0, 0, 0, 0.12);
        font-weight: 700;
        justify-content: space-between;
    }

    .email__search .search-item:hover {
        background: #f6f6f6;
    }

    .email__search .search-item {
        display: inline-block;
    }

    .email__search .search-item .title {
        width: 55%;
    }

    .valid {
        box-shadow: none !important
    }

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
