<template>
    <!-- telegtam-modal -->
    <div class="m_modal_wrap" :class="{'m_modal_show' : modal}" id="folder_modal">
        <div class="m_modal_bg"></div>
        <div class="m_modal">
            <div class="close" @click="close"></div>
            <div class="content">
                <div class="integration-modal">
                    <div class="form-group mb-0">
                        <div class="sup-title">Подпись</div>
                        <div v-for="(signature, index) in signatures" class="row signature">
                            <div class="col s5 name__signature">
                                <label>Наименование подписи</label>
                                <input
                                    type="text"
                                    class="browser-default"
                                    v-model=signature.name
                                >
                            </div>
                            <div class="col s7 text__signature">
                                <label>Текст подписи</label>
                                <input
                                    type="text"
                                    class="browser-default"
                                    v-model="signature.text"
                                >
                            </div>
                            <div class="col s6 default_signature">
                                <label>
                                    <input ref="signature"  class="with-gap" name="group1"
                                           type="radio"/>
                                    Подпись по умолчанию
                                </label>
                            </div>

                                <div class="col s6 delete_signature" v-on:click="del(index)">
                                    <i class="material-icons left">clear</i>
                                    <span>Удалить подпись</span>

                            </div>
                            <div class="col signature__line"></div>
                        </div>
                    </div>
                    <div class="nav__buttons">
                        <button type="button" @click="add" class="btn_modal">НОВАЯ ПОДПИСЬ</button>
                    </div>
                    <div class="col signature__line"></div>

                    <div class="signature__buttons row">
                        <button type="button" @click="save" class="btn_modal col s3 offset-s8">Ok</button>

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
        name: "SignatureComponent",
        data() {
            return {
                signatures: [],
            }
        },
        created() {
            axios
                .get('api/signature')
                .then(response => {
                    this.signatures = response.data;
                })
        },
        methods: {

            close() {
                this.$emit('close')
            },
            del(index) {
                this.signatures.splice(index, 1);
            },
            add() {
                this.signatures.unshift({
                    name: '',
                    text: ''
                });
            },
            save() {
                axios.post('/api/signature/save',this.signatures);
                this.$emit('close')
            },
        }

    }
</script>

<style scoped>
    .m_modal_wrap{
        position: unset;
    }
    .m_modal {
        width: 500px;
        margin: 0 auto auto;

    }
</style>
