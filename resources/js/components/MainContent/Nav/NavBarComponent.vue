<template>
    <div class="nav-wrap">
        <div class="write_letter">
            <router-link tag="a" class="waves-effect waves-light" to="/it/newEmail">написать письмо</router-link>
        </div>
        <div class="nav-menu">
            <ul>
                <li>
                    <router-link tag="a" active-class="active" to="/it/incoming">Входящие</router-link>
                </li>
                <li>
                    <router-link tag="a" active-class="active" to="/it/draft">Черновик</router-link>
                </li>
                <li>
                    <router-link tag="a" active-class="active" to="/it/sent">Отправленные</router-link>
                </li>
                <li>
                    <router-link tag="a" active-class="active" to="/it/basket">Корзина</router-link>
                </li>
            </ul>
        </div>
        <div class="work-labels">
            <ul>
                <li><a href="#">Спам</a></li>
                <li><a href="#">Реклама</a></li>
                <li><a href="#">Работа </a></li>
                <li><a href="#">Личное </a></li>
            </ul>
        </div>
        <div class="new-file">
            <div class="write_letter">
                <router-link tag="a" class="waves-effect waves-light" to="/it/newFile">новая папка</router-link>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "NavBarComponent"
    }
</script>

<style scoped>

</style>
