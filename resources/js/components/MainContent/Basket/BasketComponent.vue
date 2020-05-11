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
                    <i class="material-icons">refresh</i>
                </div>
                <div class="action__group">
                    <i class="material-icons">report</i>
                </div>

                <div class="action__group">
                    <i class="material-icons">fiber_manual_record</i>
                </div>

                <div class="action__group">
                    <i class="material-icons">folder</i>
                </div>
                <div class="action__group">
                    <i class="material-icons">delete</i>
                </div>
            </div>
            <div class="email__search">
                <div class="input-field">
                    <input id="last_name" type="text" class="validate">
                    <label for="last_name">Поиск</label>
                    <i class="material-icons">search</i>
                </div>
            </div>
            <div class="email_simple-paginate">
                <div class="paginate-numbers">
                    1-10 of 100
                </div>
                <div class="paginate-arrows">
                    <i class="material-icons">arrow_back</i>
                    <i class="material-icons">arrow_forward</i>
                </div>
            </div>
            <div class="email-dop">
                <div>
                    <i class="material-icons">settings</i>
                </div>
            </div>
        </div>

        <table>
            <tbody>
            <tr v-for="(mail, index) in mails">
                <td>
                    <div class="message__select">
                        <label>
                            <input @click="setBg" ref="selectMes" type="checkbox" class="filled-in"/>
                            <span></span>
                        </label>
                    </div>
                </td>
                <td>
                    <div class="message__favorite">
                        <i @click="favorite" class="material-icons">star_border</i>
                    </div>
                </td>
                <td>
                    <div class="message__seen-dot"></div>
                </td>
                <td class="email__from-td">
                    <div class="email__from">
                        <div>
                            <div class="email__name">
                                {{ mail.sender[0] }}
                            </div>
                        </div>
                        <div class="email__driver">
                            {{ mail.sender }}
                        </div>
                    </div>
                </td>
                <td>
                    <div class="email__tiel">
                        {{ mail.subject }}
                    </div>
                </td>
                <td>
                    <div class="email__attachments">
                        <i class="material-icons">attachment</i>
                    </div>
                </td>
                <td>
                    <div class="email_date">
                        {{ mail.date }}
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        name: "BasketComponent",
        data() {
            return {
                selectMes: '',
                selectAllMes: false,
                checked: false,
                mails: [],
            }
        },
        computed: {
            selectAll() {
                return this.$store.getters.selectAll
            },
        },
        methods: {
            getMails() {
                axios.get('/api/basket')
                    .then(r=>this.mails = r.data)
            },
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
            setBg(event) {
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
        created() {
            this.getMails()
        },
        watch: {
            selectAllMes() {
                let toolbars = document.getElementById('ToolBars');
                let trAll = document.getElementsByTagName('tr');

                let ArrayMess = this.$refs.selectMes;
                this.checked = (this.checked === false);

                ( this.checked ) ? toolbars.classList.remove("disabled") :  toolbars.classList.add("disabled");

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
    }
</script>

<style>
    .action__group i:hover {
        color: #837d7d
    }
    .disabled i:hover {
        cursor: default!important;
        color: #D8D8D8;
    }
    .disabled i {
        cursor: default!important;
    }
    .trSelect {
        background: #f9f9f9 !important;
    }
</style>
