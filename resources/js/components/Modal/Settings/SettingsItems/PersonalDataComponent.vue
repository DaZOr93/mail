<template>
    <div class="personal_wrap">
        <div class="personal_header">Личные данные</div>
        <div class="hor-lin"></div>
        <div class="wrap">
            <div class="personal_items">
                <div class="personal_item">
                    <div class="item__icon">
                        <i class="material-icons">person</i>
                    </div>
                    <div class="item__text-wrap">
                        <div class="item-text">Иванов И Р</div>
                        <div class="item-dop"> Ф И О</div>
                    </div>
                </div>
                <div class="personal_item" >
                    <div class="item__icon">
                        <i class="material-icons">cake</i>
                    </div>
                    <div class="item__text-wrap">
                        <div class="item-text">22 Aug 1993</div>
                        <div class="item-dop"> Дата рождения</div>
                    </div>
                </div>
                <div class="personal_item">
                    <div class="item__icon">
                        <i class="material-icons">school</i>
                    </div>
                    <div class="item__text-wrap">
                        <div class="item-text"> ДДМА</div>
                        <div class="item-dop"> Образование</div>
                    </div>
                </div>
                <div class="personal_item" >
                    <div class="item__icon">
                        <i class="material-icons">work</i>
                    </div>
                    <div class="item__text-wrap">
                        <div class="item-text">It2.0</div>
                        <div class="item-dop"> Место работы</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="logout" @click="logout">
            ВЫЙТИ ИЗ АККАУНТА
        </div>
    </div>
</template>


<script>
    export default {
        name: "PersonalData",
        data: function () {
            return {};
        },
        computed: {
            user() {
                return this.$store.getters.getUser;
            }
        },
        created() {
            this.$store.dispatch('getUser')
        },
        methods: {
            logout() {
                axios.get('/auth/logout');
                axios.get('https://team1-group-project.azurewebsites.net/api/client_logout', {headers: {Authorization: "Bearer " + `${this.user.token}`}})
                    .then(r => location.href = r.data)
            },
        }
    }
</script>

<style lang="scss" scoped>
    .personal_header {
        font-weight: 500;
        font-size: 18px;
        color: #808080;
        padding-bottom: 15px;
    }

    .hor-lin {
        background: #F5F5F5;
        position: absolute;
        width: 100%;
        height: 2px;
        left: 0;
    }

    .personal_wrap {
        min-width: 380px;
    }

    .personal_items {
        margin-top: 15px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .personal_item {
        display: flex;
        margin-bottom: 15px;
        width: 120px;
        cursor: default;
    }

    .wrap {
        display: flex;
        justify-content: center;
    }

    .item__icon {
        margin-right: 15px;
    }

    .item-text {
        font-style: normal;
        font-weight: 500;
        font-size: 13px;
        color: #808080;
        padding-bottom: 5px;
    }

    .item-dop {
        font-style: normal;
        font-weight: 500;
        font-size: 11px;
        color: #CCCCCC;
    }

    .personal_item:nth-child(1) i {
        color: #5553CE;
    }

    .personal_item:nth-child(2) i {
        color: #F9AD3D;
    }

    .personal_item:nth-child(3) i {
        color: #1875F0;
    }

    .personal_item:nth-child(4) i {
        color: #34CB49;
    }

    .logout {
        font-style: normal;
        font-weight: 900;
        font-size: 12px;
        line-height: 50px;
        text-align: center;
        text-transform: uppercase;
        color: #FFFFFF;
        background: #1875F0;
        max-width: 200px;
        margin: auto;
        border-radius: 5px;
        margin-top: 15px;
        cursor: pointer;
    }

</style>
