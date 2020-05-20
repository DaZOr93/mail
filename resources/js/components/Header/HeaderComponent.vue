<template>
    <div>
        <header class="header">
            <div class="wrap">
                <div class="logo-wrap ">
                    <div class="logo-inner" :class="{ compactBar: toggleBol }">
                        <div class="logo">
                            <router-link tag="a" to="/it/home">
                                <img src="/img/main_logo.png" alt="main-logo">
                            </router-link>
                        </div>
                        <div class="arrow-left" :class="{ arrow_right: toggleBol }" @click="toggleBar">
                            <img src="/img/arrow.png" alt="">
                        </div>
                    </div>
                </div>
                <div class="user-wrap">
                    <div class="user-name">
                        {{ user.surname}} {{ user.name}}
                    </div>
                    <div class="user-photo">
                        <img :src="user.avatar_url" alt="">
                    </div>
                    <div class="arrow-bottom">
                        <img  @click="userDrop = !userDrop" src="/img/arrow.png" alt="">
                        <div class="user_drop" :class="{user_show : userDrop}">
                            <a href="#" @click.prevent="logout">Выйти из системы</a>
                        </div>
                    </div>
                </div>
            </div>
        </header>
    </div>
</template>

<script>
    export default {
        name: "main-header",
        data() {
          return {
              userDrop: false
          }
        },
        computed: {
            toggleBol() {
                return this.$store.getters.toggleBar;
            },
            user(){
                return this.$store.getters.getUser;
            }
        },
        methods: {
            toggleBar() {
                this.$store.commit('toggleBar');
            },
            auth(){
                this.$store.dispatch('auth')
            },
            logout(){
                axios.get('/auth/logout');
                axios.get('https://team1-group-project.azurewebsites.net/api/client_logout' , { headers: {Authorization: "Bearer " + `${this.user.token}`}})
                    .then(r => location.href= r.data)
            }

        },
        created() {
            this.$store.dispatch('getUser')
        }

    }
</script>

<style scoped>

</style>
