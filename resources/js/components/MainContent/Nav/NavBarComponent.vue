<template>
    <div class="nav-wrap">
        <div class="write_letter">
            <router-link tag="a" class="waves-effect waves-light" to="/newEmail">написать письмо</router-link>
        </div>
        <div class="nav-menu">
            <ul>
                <li>
                    <router-link tag="a"  exact active-class="active" to="/">Входящие</router-link>
                    <span>5</span>
                </li>
                <li>
                    <router-link tag="a" active-class="active" to="/draft">Черновик</router-link>
                    <span>5</span>
                </li>
                <li>
                    <router-link tag="a" active-class="active" to="/sent">Отправленные</router-link>
                    <span>5</span>
                </li>
                <li>
                    <router-link tag="a" active-class="active" to="/basket">Корзина</router-link>
                    <span>5</span>
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
                <router-link tag="a" class="waves-effect waves-light" to="/newFile">новая папка</router-link>
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
    .nav-menu li {
        position: relative;
    }
    .nav-menu span {
        font-weight: 900;
        font-size: 9px;
        letter-spacing: 1.125px;
        text-transform: uppercase;
        color: #B3B3B3;
        position: absolute;
        margin-top: -10px;
        top: 50%;
        right: 10px;
        width: 20px;
        height: 20px;
        display: flex;
        background: #F7F7F7;
        border-radius: 4px;
        justify-content: center;
        align-items: center;
    }


</style>
