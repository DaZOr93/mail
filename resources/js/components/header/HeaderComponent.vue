<template>
    <div>
        <header class="header">
            <div class="wrap">
                <div class="logo-wrap">
                    <div class="logo">
                        <router-link tag="a" to="/">
                            <img src="/img/main_logo.png" alt="main-logo">
                        </router-link>
                    </div>
                    <div class="arrow-left">
                        <img src="/img/arrow.png" alt="">
                    </div>
                </div>
                <div class="user-wrap">
                    <div class="user-name">
                        Анна Кононенко
                    </div>
                    <div class="user-photo">
                        <img src="/img/user.png" alt="">
                    </div>
                    <div class="arrow-bottom">
                        <img src="/img/arrow.png" alt="">
                    </div>
                </div>
            </div>
        </header>
    </div>
</template>

<script>
    export default {
        name: "main-header"
    }
</script>

<style scoped>

</style>
