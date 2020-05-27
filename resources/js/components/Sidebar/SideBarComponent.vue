<template>
    <div>
        <div class="side-bar" :class="{ compactBar: toggleBar }">
            <ul class="ul">
                <li><a href="https://team1-group-project.azurewebsites.net/">Главная</a></li>
                <li><a href="http://it20tools-disk.dtdgma.org.ua/disk">Диск</a></li>
                <li><a href="http://it20tools-disk.dtdgma.org.ua/available">Доступные</a></li>
                <li><a href="http://it20tools-disk.dtdgma.org.ua/recent">Недавние</a></li>
                <li><a href="http://it20tools-disk.dtdgma.org.ua/basket">Корзина</a></li>
                <li><a href="/" class="active">Почта</a></li>
                <li><a href="http://laravelproject.s-host.net">Календарь</a></li>
                <li><a href="https://it20-tools-photogallery.azurewebsites.net/">Фотографии</a></li>
                <li><a href="https://contacts-it.s-host.net/">Контакты</a></li>
                <li><a href="https://team1-group-project.azurewebsites.net/dashboard/departments">Управление </a></li>
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
