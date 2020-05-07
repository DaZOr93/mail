<template>
    <div class="new__massage__list">
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
.new__massage__list tr {
    font-weight: bold;
    color: #666666;
}
</style>
