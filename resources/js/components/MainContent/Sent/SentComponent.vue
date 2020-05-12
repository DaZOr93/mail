
<template>
    <div class="w100">
        <sentMessages></sentMessages>
    </div>
</template>

<script>
    import sentMessages from  '../Messages/SentMessagesComponent';
    export default {
        name: "SentComponent",
        components: {sentMessages },
    }
</script>

<style>
.new__massage__list {
    font-weight: bold!important;
    color: #666666!important;
}
</style>
