<template>
    <div class="m_modal_wrap" :class="{'m_modal_show' : modal_spam}" id="spam_modal">
        <div class="m_modal_bg"></div>
        <div class="m_modal">
            <div class="close" @click="close"></div>
            <div class="content">
                <div class="integration-modal">
                    <div class="form-group mb-0">
                        <div class="sup-title">Пометить как спам?</div>
                    </div>
                    <div class="hor__line"></div>
                    <div class="modal__buttons">
                        <button type="button" @click="store" class="btn_modal">Продолжить</button>
                        <button type="button" @click="close" class="btn_modal">Отменить</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "SpamModalComponent",
        props: ['modal_spam', 'messages'],
        methods: {
            close() {
                this.$emit('close');
            },
            store() {
                this.$store.dispatch('update_messages', {action: 'spam', messages: this.messages});
                this.$emit('close');
                Vue.$toast.open({
                    message: `Доавил`,
                    type: 'success',
                    position: 'top',
                    duration: 2000
                });

                return window.location.reload()
            }
        },
    }
</script>

<style scoped>

</style>
