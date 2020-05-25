<template>
    <div class="m_modal_wrap" :class="{'m_modal_show' : modal_folder}" id="folder_modal">
        <div class="m_modal_bg"></div>
        <div class="m_modal">
            <div class="close" @click="close"></div>
            <div class="content">
                <div class="integration-modal">
                    <div class="form-group mb-0">
                        <div class="sup-title">Переместить в :</div>
                        <p v-for="folder in getFolders">
                            <label>
                                <input ref="folders" :data-folder="folder.slug" class="with-gap" name="group1"
                                       type="radio"/>
                                <span>{{folder.name}}</span>
                            </label>
                        </p>
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
        props: ['modal_folder', 'messages'],
        name: "FolderComponent",
        methods: {
            close() {
                this.$emit('close')
            },
            store() {
                let folder = this.$refs.folders.find(folder => folder.checked === true);
                if (folder) {
                    let folder_slug = folder.getAttribute('data-folder');
                    this.$store.dispatch('update_messages', {slug: folder_slug, action: 'folder' ,  messages: this.messages});
                    this.$emit('close');
                    Vue.$toast.open({
                        message: `Добавил`,
                        type: 'success',
                        position: 'top',
                        duration: 2000
                    });
                    this.$store.dispatch('countFolderMessages');
                } else {
                    Vue.$toast.open({
                        message: `Выберите папку`,
                        type: 'error',
                        position: 'top',
                        duration: 1000
                    })
                }
            }
        },
        computed: {
            getFolders() {
                return this.$store.getters.getFolders
            },
        },
        created() {
            this.$store.dispatch('userFolders');
        },
    }
</script>

<style scoped>

</style>
