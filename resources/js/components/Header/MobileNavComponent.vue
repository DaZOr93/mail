<template>
    <div class="mobile-nav" id="mob_nav">
        <ul class="ul">
            <li class="toggleClose-wrap" @click="toggleClose">
                <div class="toggleClose"></div>
            </li>
            <li>
                <i class="material-icons">home</i>
                <a href="#">Главная</a>
            </li>
            <li>
                <i class="material-icons">cloud_download</i>
                <a href="https://it20tools-disk.azurewebsites.net/">Диск</a>
            </li>
            <li>
                <i class="material-icons">people</i>
                <a href="https://it20tools-disk.azurewebsites.net/available">Доступные</a>
            </li>
            <li>
                <i class="material-icons">watch_later</i>
                <a href="https://it20tools-disk.azurewebsites.net/recent">Недавние</a>
            </li>
            <li>
                <i class="material-icons">star_border</i>
                <a href="https://it20tools-disk.azurewebsites.net/recent">Избранное</a>
            </li>
            <li>
                <i class="material-icons">delete</i>
                <a href="https://it20tools-disk.azurewebsites.net/basket">Корзина</a>
            </li>
            <li class="active">
                <i class="material-icons">email</i>
                <a href="#">Почта</a>
            </li>
            <li>
                <i class="material-icons">today</i>
                <a href="#">Календарь</a>
            </li>
            <li>
                <i class="material-icons">photo_camera</i>
                <a href="https://it20-tools-photogallery.azurewebsites.net/">Фотографии</a>
            </li>
            <li>
                <i class="material-icons">people</i>
                <a href="https://contactmodule.azurewebsites.net">Контакты</a>
            </li>
            <li>
                <i class="material-icons">business_center</i>
                <a href="#">Управление </a>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        name: "MobileNavComponent",
        methods: {
            toggleClose() {
                let nav = document.getElementById('mob_nav');
                document.body.classList.toggle('hidden');
                nav.classList.toggle('mon_nav_open')
            }
        }
    }
</script>

<style>
    .togglermenu {
        width: 57px;
        cursor: pointer;
        display: none;
    }

    .hidden {
        overflow: hidden;
    }

    .togglermenu div {
        height: 1px;
        background: #3a0085;
        margin-bottom: 11px;
    }

    .mobile-nav {
        overflow-y: auto;
        z-index: 2222;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
        position: fixed;
        width: 100%;
        height: 100%;
        top: 0;
        background: #fff;
        -webkit-overflow-scrolling: touch;
        -webkit-transform: translateY(-100%);
        -ms-transform: translateY(-100%);
        transform: translateY(-120%);
        -webkit-transition-property: -webkit-transform;
        transition-property: -webkit-transform;
        -o-transition-property: transform;
        transition-property: transform;
        transition-property: transform, -webkit-transform;
        -webkit-transition-duration: .9s ease-in;
        -o-transition-duration: .9s ease-in;
        transition-duration: .9s ease-in;
        -webkit-transition: all .9s cubic-bezier(.11, .37, 0, .98);
        -o-transition: all .9s cubic-bezier(.11, .37, 0, .98);
        transition: all .9s cubic-bezier(.11, .37, 0, .98);
    }

    .mobile-nav ul li a {
        font-style: normal;
        font-weight: 500;
        font-size: 20px;
        line-height: 45px;
        color: #999999;
    }

    .mobile-nav ul li {
        display: flex;
        align-items: center;
        transition: all .5s
    }

    .mobile-nav ul li:hover a, .mobile-nav ul li:hover i {
        color: #1875F0
    }

    .mobile-nav .active a, .mobile-nav .active i {
        color: #1875F0
    }

    .mobile-nav i {
        color: #D8D8D8;
        margin-right: 20px;
    }

    .toggleClose-wrap {
        width: 35px;
        height: 35px;
        background: #1875F0;
        transform: rotate(45deg);
        margin: auto auto 42px;
        position: relative;
        cursor: pointer;
    }

    .toggleClose-wrap::after, .toggleClose-wrap::before {
        content: '';
        width: 35px;
        height: 1px;
        background: #000;
        position: absolute;
    }

    .toggleClose-wrap::after {
        right: 0;

    }

    .toggleClose-wrap::before {
        left: 0;
        transform: rotate(90deg);
    }

    .mon_nav_open {
        transform: translateY(-0%);
    }

</style>
