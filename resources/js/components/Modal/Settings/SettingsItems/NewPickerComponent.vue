<template>
    <!-- telegtam-modal -->
    <div class="m_modal_wrap" :class="{'m_modal_show' : modal}" id="modalAS">
        <div class="m_modal_bg"></div>
        <div class="m_modal">
            <div class="close" @click="close"></div>
            <div class="content">
                <div class="integration-modal">
                    <div class="row mailbox_groupe">
                        <div class="col s12 m5 input-field email_input-groupe">
                            <input autocomplete="off" placeholder="Email" id="email"
                                   v-model="picker.email" type="text" class="validate valign-wrapper"/>
                        </div>
                        <div class="col s12 m6 input-field password_input-groupe">
                            <input v-model="picker.password"
                                placeholder="Пароль" id="password" type="password" class="validate valign-wrapper"/>
                        </div>
                        <div class="col s12 m5 input-field protocol_input-groupe">
                            <!-- добавить кнопку <i class="material-icons">expand_more</i>-->
                            <select class="browser-default" v-model="picker.driver">
                                <option value="" selected>Протокол</option>
                                <option value="IMAP">IMAP</option>
                                <option value="POP3">POP3</option>
                            </select>
                            <!--  -->
                        </div>
                        <div class="col s6 m2 input-field email_input-groupe">
                            <input
                                v-model="picker.port"
                                placeholder="Порт" id="port" type="text" class="validate valign-wrapper"/>
                        </div>
                        <div class="col underline"></div>
                    </div>
                    <div class="modal__buttons">
                        <button type="button" @click="store" class="btn_modal">Создать</button>
                        <button type="button" @click="close" class="btn_modal">Отменить</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- telegram-modal -->
</template>

<script>
    export default {
        props: ['modal'],
        name: "newPicker",
        data(){
            return {
                picker: {}
            }
        },
        methods: {
            store(){
                let reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
                if (reg.test(this.picker.email)) {
                    axios.post('/api/pickers/store' , this.picker);
                    this.$emit('saved');
                    this.picker = {};
                } else {
                    alert('Не корректынй email');
                }
            },
            close() {
                this.$emit('close')
            },
        }
    }
</script>

<style scoped>
    .m_modal_wrap {
        position: absolute;
        z-index: 2222;
    }
    .m_modal {
        width: 670px;
        top: -218px;
    }
</style>
