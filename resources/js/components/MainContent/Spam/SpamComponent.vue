<template>
    <div class="w100">
        <spamMessages :getMessages="getMessages"></spamMessages>
    </div>
</template>

<script>
    import spamMessages from '../Messages/SpamMessagesComponent'
    import {eventBus} from "../../../app"

    export default {
        name: "spamComponent",
        components: {spamMessages},
        data(){
            return {}
        },
        methods: {
            getResults(page = 1) {
                this.$store.dispatch('getServiceMessages', { folder : 'spam' , page:page});
            },
        },
        computed: {
            getMessages() {
                return this.$store.getters.getMessages
            },
        },
        mounted() {
            this.getResults();
        },
        created() {
            eventBus.$on('paginate', (page) => {
                this.$store.dispatch('paginateMessages' , page);
            })
        }
    }
</script>

<style>
    .new__massage__list {
        font-weight: bold !important;
        color: #666666 !important;
    }
</style>
