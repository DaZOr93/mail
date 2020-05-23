<template>
    <div>
        <div class="settings__folder-title">
            Управление папками
        </div>
        <div class="settings__folder-items">
            <div class="settings__folder-item" v-for="(folder, index) in folders" :key="index">
                <div class="folder__name">
                    <div class="input-field">
                        <input :id="'folder_name' + index" type="text" class="validate" :value="folder.name">
                        <label :for="'folder_name' + index" class="active">Наименование</label>
                    </div>
                </div>
                <div class="folder__desc">
                    <div class="input-field">
                        <input :id="'folder_desc' + index" type="text" class="validate" :value="folder.description">
                        <label  class="active" :for="'folder_desc' + index" >Описание</label>
                    </div>
                </div>
                <div class="folder__color">
                    <div class="input-field">
                        <input :id="'folder_color' + index" type="text" class="validate" :value="folder.color">
                        <label  class="active" :for="'folder_color' + index" >Цвет ярлыка</label>
                    </div>
                </div>
                <div class="settings__folder-action">
                    <div class="settings__change-pass">Изменить пароль</div>
                    <div class="settings__delete">Удалить из списка</div>
                </div>
            </div>
        </div>
        <div class="settings__folder-bottom">
            <div class="setting__create-folder">
                новая папка
            </div>
            <div class="settings__row-numbers">
                Строк:
                <span>3</span>
            </div>
            <div class="settings__pagination">
                1-10 of 100
                <span>
                     <i
                         title="Назад" class="material-icons"
                     >
                        arrow_back
                    </i>
                    <i
                        class="material-icons"
                    >
                        arrow_forward
                    </i>
                </span>
            </div>
        </div>
    </div>
</template>


<script>
    export default {
        name: "FolderWorks",
        data: function () {
            return {
                folders: {},
            };
        },
        created() {
            axios.get('/api/user/folders')
                .then ( r => this.folders = r.data)
        }
    }
</script>

<style scoped>
    .settings__pagination {
        margin-left: 65px;
        font-style: normal;
        font-weight: 500;
        font-size: 13px;
        text-align: right;
        color: #666666;
        display: flex;
        align-items: center;

    }

    .settings__pagination span {
        display: inline-block;
        margin-left: 55px;
        padding-top: 5px;
        color: #D8D8D8
    }

    .settings__pagination span i {
        cursor: pointer;
    }

    .settings__pagination span i:first-child {
        margin-right: 15px;
    }

    .settings__row-numbers {
        font-weight: 500;
        font-size: 13px;
        color: #666666;
    }

    .settings__row-numbers span {
        margin-left: 70px;
    }

    .settings__folder-bottom {
        display: flex;
        align-items: center;
        margin-bottom: 17px;
    }

    .setting__create-folder {
        font-style: normal;
        font-weight: 900;
        font-size: 12px;
        line-height: 50px;
        text-align: center;
        text-transform: uppercase;
        color: #FFFFFF;
        background: #1875F0;
        max-width: 185px;
        width: 100%;
        border-radius: 4px;
        cursor: pointer;
        margin-right: 70px;
    }

    .settings__folder-title {
        font-style: normal;
        font-weight: 500;
        font-size: 18px;
        color: #666666;
        margin-bottom: 5px;
    }

    .settings__folder-item {
        display: flex;
        position: relative;
        padding-bottom: 53px;
        margin-bottom: 30px;
    }

    .settings__folder-item::after {
        content: '';
        position: absolute;
        left: -3%;
        bottom: 0;
        height: 2px;
        width: 350px;
        background: #F5F5F5;
    }

    .settings__folder-action {
        display: flex;
        position: absolute;
        right: 0;
        bottom: 25px;
        font-style: normal;
        font-weight: 500;
        font-size: 13px;
        line-height: 50px;
        color: #B3B3B3;
    }

    .settings__folder-action div {
        position: relative;
    }

    .settings__delete {
        padding-left: 24px;
        margin-left: 24px;
        cursor: pointer
    }

    .settings__delete::before, .settings__delete::after {
        content: '';
        background: #F93F3F;
        position: absolute;
        width: 20px;
        height: 2px;
        left: -3px;
        top: 48%;
    }

    .settings__delete::before {
        transform: rotate(-45deg);
    }

    .settings__delete::after {
        transform: rotate(45deg);
    }

    .settings__change-pass {
        padding-left: 24px;
        cursor: pointer;
    }

    .settings__change-pass::before {
        content: '';
        position: absolute;
        background: url('/img/pen.svg');
        width: 30px;
        height: 30px;
        left: -10px;
        top: 50%;
        margin-top: -15px;
    }

    .settings__folder-items input {
        font-style: normal;
        font-weight: bold;
        font-size: 15px !important;
        line-height: 40px;
        padding-left: 30px !important;
        color: #808080;
        border: 2px solid #F5F5F5 !important;
        border-radius: 4px !important;
        box-sizing: border-box !important;
    }

    .settings__folder-items label {
        font-style: normal;
        font-weight: 500;
        font-size: 15px;
        line-height: 23px;
        color: #666666;
        padding-left: 15px;
    }

    .settings__folder-items .folder__name {
        margin-right: 43px;
        max-width: 160px;
        width: 100%;
    }

    .settings__folder-items .folder__desc {
        max-width: 218px;
        width: 100%;
        margin-right: 52px;
    }

    .settings__folder-items .folder__color {
        max-width: 160px;
        width: 100%;
    }


    .settings__folder-items .input-field > label:not(.label-icon).active {
        transform: translate(-12px, -24px) scale(0.8);
    }

    .settings__folder-items input[type=text]:not(.browser-default):focus:not([readonly]) {
        box-shadow: none
    }

    .settings__folder-items input[type=text]:not(.browser-default):focus:not([readonly]) + label {
        color: #666666;
    }

    .header {
        width: 100%;
        height: 68px;
        margin-bottom: 48px;
        color: #999999;
        font-size: 18px;
        font-weight: 700;
        line-height: 90px;
    }

    .header-text {
        margin: 0 auto;
    }

</style>
