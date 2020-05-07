<template>
    <div class="massage__list ">
        <div class="messages_wrap">
            <div class="messages_action">
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
            <tr v-for="item in 10">
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
                                G
                            </div>
                        </div>
                        <div class="email__driver">
                            Google Inc
                        </div>
                    </div>
                </td>
                <td>
                    <div class="email__tiel">
                        Adwords Keyword Research For Beginners
                    </div>
                </td>
                <td>
                    <div class="email__attachments">
                        <i class="material-icons">attachment</i>
                    </div>
                </td>
                <td>
                    <div class="email_date">
                        07:24 AM
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        name: "MessagesComponent",
        data() {
            return {
                selectMes: '',
                selectAllMes: false,
                checked: false
            }
        },
        computed: {
            selectAll() {
                return this.$store.getters.selectAll
            },
        },
        methods: {
            favorite(event){
                let state = event.target.innerHTML;

                if(state === 'star_border') {
                    event.target.innerHTML = 'star';
                    event.target.style.color = '#F9AD3D';
                } else {
                    event.target.innerHTML = 'star_border';
                    event.target.style.color = '#D8D8D8';
                }
            },
            setBg(event){
                let element = event.target.parentElement.parentElement.parentElement.parentElement;
                ( !element.classList.contains('trSelect')) ? element.classList.add("trSelect") : element.classList.remove("trSelect");

            }
        },
        watch: {
            selectAllMes() {
                let ArrayMess = this.$refs.selectMes;
                this.checked = (this.checked === false);
                let trAll = document.getElementsByTagName('tr');
                if(this.checked) {
                   for (let i = 0; i < trAll.length; i++) {
                       trAll[i].classList.add("trSelect")
                   }
                }else {
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

<style >
.trSelect {
    background: #f9f9f9!important;
}
</style>
