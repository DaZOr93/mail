<template>
    <div class="w100">
        <messages :getMessages="getMessages"></messages>
    </div>
</template>

<script>
    import messages from  '../Messages/DraftMessagesComponent';
    import {eventBus} from "../../../app"
    export default {
        name: "DraftComponent",
        components: {messages},
        computed: {
            getMessages() {
                return this.$store.getters.getMessages
            },
        },
        methods: {
            getResults(page = 1) {
                this.$store.dispatch('getServiceMessages', { folder : 'draft' , page:page});
            },
        },
        mounted() {
            this.getResults();
        },
        created() {
            eventBus.$on('paginate', (page) => {
                this.$store.dispatch('paginateMessages' , page);
            });
            eventBus.$on('searchMessages' , (search) => {
                this.$store.dispatch('searchMessages' , search)
            });
            eventBus.$on('getMessages' , () => {
                this.$store.dispatch('getServiceMessages', { folder : 'draft' , page: 1});
            })
        }
    }
</script>

<style scoped>
</style>
