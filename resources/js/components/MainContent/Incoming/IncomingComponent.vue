<template>
    <div class="w100">
        <messages></messages>
    </div>
</template>

<script>
    import messages from  '../Messages/MessagesComponent';
    export default {
        name: "IncomingComponent",
        components: {messages },
    }
</script>

<style>
.new__massage__list {
    font-weight: bold!important;
    color: #666666!important;
}
</style>
