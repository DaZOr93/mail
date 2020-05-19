<template>
    <div class="w100">
        <sentMessages :getMessages="getMessages"></sentMessages>
    </div>
</template>

<script>
    import sentMessages from '../Messages/MessagesComponent';
    import {eventBus} from "../../../app"

    export default {
        name: "SentComponent",
        components: {sentMessages},
        data(){
          return {}
        },
        methods: {
            getResults(page = 1) {
                this.$store.dispatch('getServiceMessages', { folder : 'sending' , page:page});
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
