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
                        <div v-for="(signature, index) in paginatedData" class="row signature">
                            <div class="col s5 name__signature">
                                <label>Наименование подписи</label>
                                <input
                                    name="name"
                                    type="text"
                                    class="browser-default"
                                    v-model=signature.name
                                >
                            </div>
                            <div class="col s7 text__signature">
                                <label>Текст подписи</label>
                                <input
                                    name="text"
                                    type="text"
                                    class="browser-default"
                                    v-model="signature.text"
                                >
                            </div>
                            <div class="col s6 default_signature">
                                <label>
                                    <input  ref="signatures" :data-signature="signature.id" value="1" name="default"  v-model="signature.default"
                                           type="radio"/>
                                    <span>Подпись по умолчанию</span>
                                </label>
                            </div>

                                <div class="col s6 delete_signature" v-on:click="del(index)">
                                    <i class="material-icons left">clear</i>
                                    <span>Удалить подпись</span>

                            </div>
                            <div class="col signature__line"></div>
                        </div>
                    </div>
                    <div class="row nav__buttons">
                        <button type="button" @click="add" class=" col s5 btn_modal">НОВАЯ ПОДПИСЬ</button>
                        <div class="col sing_paginate">
                            <div class="paginate-numbers">
                                <div>
                                    <div class="col">
                                    Строк: {{sizeList}}
                                    <i
                                    @click="upSizeList"
                                    title="Добавить строку"
                                    class="material-icons"
                                >
                                    expand_less
                                </i>
                                    </div>
                                </div>
                                <div class="col">
                                {{pageFrom}}
                                -
                                {{pageTo}}
                                of
                                {{signatures.length}}
                                </div>
                            </div>
                            <div class="paginate-arrows">
                                <i
                                    @click="prevPage"
                                    title="Назад" class="material-icons"
                                >
                                    arrow_back
                                </i>
                                <i
                                    @click="nextPage"
                                    title="Вперед"
                                    class="material-icons"
                                >
                                    arrow_forward
                                </i>
                            </div>
                        </div>

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
                pageNumber: 0,
                sizeList: 3,
                signaturesLength: '',
            }
        },
        computed:{

            pageFrom (){
                return this.sizeList*this.pageNumber+1;

            },
            pageTo (){
                if(this.pageCount -1 !== this.PageNumber){
                    return this.sizeList*this.pageNumber+this.sizeList;

                }else {
                    this.signatures.length
                }
            },
            pageCount(){
                let l = this.signatures.length,
                    s = this.sizeList;
                return Math.ceil(l/s);
            },
            paginatedData() {
                const start = this.pageNumber * this.sizeList,
                    end = start + this.sizeList;
                return this.signatures
                    .slice(start, end);
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
            upSizeList(){
                if(this.signatures.length > this.sizeList){
                    this.sizeList++;
                }

            },
            nextPage(){

                if(this.pageNumber !== this.pageCount -1) {
                    this.pageNumber++;
                }

            },
            prevPage(){
                if(this.pageNumber !== 0) {
                this.pageNumber--;
                }
            },

            close() {
                this.$emit('close')
            },
            del(index) {
                this.signatures.splice(index, 1);
            },
            add() {
                this.signatures.unshift({
                    name: '',
                    text: '',
                    id: ''
                });
                this.pageNumber = 0;
            },
            save() {
                let signature = this.$refs.signatures.find(signature => signature.checked === true);
                if (signature) {
                    let signature_slug = signature.getAttribute('data-signature');
                    if (signature_slug){
                        this.signatures.unshift({
                            id: 'default',
                            idDefault: signature_slug,
                        });
                    }
                    else{
                        let signature__object = signature.parentNode.parentNode.parentNode;
                        let name_signature = signature__object.querySelector("input[name=name]").value;
                        let text_signature = signature__object.querySelector("input[name=text]").value;
                        this.signatures.unshift({
                            id: 'default',
                            idDefault: name_signature.trim() + text_signature.trim(),
                        });
                    }
                    axios.post('/api/signature/save',this.signatures);
                    this.$emit('close');
                    Vue.$toast.open({
                        message: `Настройки сохранены`,
                        type: 'success',
                        position: 'top',
                        duration: 2000
                    });
                } else {
                    Vue.$toast.open({
                        message: `Выберите подпись по умолчанию`,
                        type: 'error',
                        position: 'top',
                        duration: 1000
                    })
                }

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
