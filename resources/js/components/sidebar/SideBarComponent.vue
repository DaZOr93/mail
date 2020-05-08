<template>
    <div>
        <div class="side-bar" :class="{ compactBar: toggleBar }">
            <ul class="ul">
                <li><a href="#">Главная</a></li>
                <li><a href="https://it20tools-disk.azurewebsites.net/">Диск</a></li>
                <li><a href="https://it20tools-disk.azurewebsites.net/available">Доступные</a></li>
                <li><a href="https://it20tools-disk.azurewebsites.net/recent">Недавние</a></li>
                <li><a href="https://it20tools-disk.azurewebsites.net/basket">Корзина</a></li>
                <li><a href="#" class="active">Почта</a></li>
                <li><a href="#">Календарь</a></li>
                <li><a href="https://it20-tools-photogallery.azurewebsites.net/">Фотографии</a></li>
                <li><a href="https://contactmodule.azurewebsites.net">Контакты</a></li>
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
