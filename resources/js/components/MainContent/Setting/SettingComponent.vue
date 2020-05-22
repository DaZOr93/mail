<template>
    <div>
        Корзина1
        <signatureModal @close="modal = !modal" :modal="modal" ></signatureModal>
    </div>
</template>

<script>


    import VuePureLightbox from "vue-pure-lightbox";
    import signatureModal from "../../Modal/SignatureModalComponent"

    export default {
        name: "SettingComponent",
        components: { signatureModal, VuePureLightbox},
        data() {
            return {

                modal: true,

            }
        },
    }
</script>

<style scoped>

</style>
