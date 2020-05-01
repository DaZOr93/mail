<template>
    <div>
        <div class="side-bar" :class="{ compactBar: toggleBar }">
            <ul class="ul">
                <li><a href="#">Главная</a></li>
                <li><a href="#">Диск</a></li>
                <li><a href="#">Доступные</a></li>
                <li><a href="#">Недавние</a></li>
                <li><a href="#">Корзина</a></li>
                <li><a href="#" class="active">Почта</a></li>
                <li><a href="#">Календарь</a></li>
                <li><a href="#">Фотографии</a></li>
                <li><a href="#">Контакты</a></li>
                <li><a href="#">Управление </a></li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        name: "sidebar",
        computed: {
            toggleBar(){
                return this.$store.getters.toggleBar;
            }
        }
    }
</script>

<style scoped>

</style>
