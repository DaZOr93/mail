<template>
    <!-- telegtam-modal -->
    <div class="m_modal_wrap" :class="{'m_modal_show' : deleteModal}" id="folder_modal">
        <div class="m_modal_bg"></div>
        <div class="m_modal">
            <div class="close" @click="close"></div>
            <div class="content">
                <div class="integration-modal">
                    <div class="form-group mb-0">
                        <div class="sup-title">Удалить письмо?</div>
                    </div>

                    <div class="modal__buttons">
                        <button type="button" @click="deleteMess" class="btn_modal">Да</button>
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
        props: ['deleteModal', 'uid', 'message_id', 'messages'],
        name: "DeleteComponent",
        methods: {
            close() {
                this.$emit('close')
            },
            deleteMess() {
                if (!this.messages) {
                    axios.get('/api/delete/' + this.uid + '/' + this.message_id);
                    this.$router.go(-1);
                } else {
                    this.$store.dispatch('update_messages', {action: 'deleted', messages: this.messages});
                    this.$store.dispatch('countMessages');

                    return window.location.reload()
                }
            },
        }

    }
</script>

<style scoped>

</style>
