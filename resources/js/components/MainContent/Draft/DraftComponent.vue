<template>
    <div class="w100">
        <messages></messages>
    </div>
</template>

<script>
    import messages from  '../Messages/IncomingMessagesComponent';
    export default {
        name: "DraftComponent",
        components: {messages },
    }
</script>

<style scoped>

</style>
