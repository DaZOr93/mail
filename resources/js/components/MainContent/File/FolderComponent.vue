<template>
    <div class="massage__list w100">
        <messages :slug="this.slug" :getMessages="getMessages"></messages>
    </div>
</template>

<script>
    import messages from '../Messages/FolderMessagesComponent'
    export default {
        name: "FolderComponent",
        components: {messages},
        data() {
            return {
                slug: this.$route.params.slug,
            }
        },
        computed: {
            getMessages() {
                return this.$store.getters.getFolderMessages
            },
        },
        methods: {

        },
        watch: {
            $route(to) {
                this.slug = to.params['slug'];
                this.$store.dispatch('getFolderMessages' , this.slug)
            },
        },
        created() {
            this.$store.dispatch('getFolderMessages' , this.slug)
        }
    }
</script>

<style scoped>

</style>
