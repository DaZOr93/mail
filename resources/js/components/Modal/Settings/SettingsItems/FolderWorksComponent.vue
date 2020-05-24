<template>
    <div>
        <div class="settings__folder-title">
            Управление папками
        </div>
        <div class="settings__folder-items">
            <div class="settings__folder-item" v-for="(folder, index) in folders.data" :key="index">
                <div class="folder__name">
                    <div class="input-field">
                        <input
                            :id="'folder_name' + index"
                            type="text" class="validate"
                            :value="folder.name"
                            @keyup="update('name' , $event , index)"
                        >
                        <label :for="'folder_name' + index" class="active">Наименование</label>
                    </div>
                </div>
                <div class="folder__desc">
                    <div class="input-field">
                        <input
                            :id="'folder_desc' + index"
                            type="text"
                            class="validate"
                            :value="folder.description"
                            @keyup="update('description' , $event , index)"
                        >
                        <label class="active" :for="'folder_desc' + index">Описание</label>
                    </div>
                </div>
                <div class="folder__color">
                    <div class="input-field" @click="folderColor(index)">
                        <input
                            :id="'folder_color' + index"
                            disabled
                            type="text" class="validate"
                            :value="folder.color_name"
                            @keyup="update('color' , $event , index)"
                        >
                        <label class="active" :for="'folder_color' + index">Цвет ярлыка</label>
                    </div>
                    <div class="color_picker" :data-picker="index">
                        <div v-for="color in colors" :key="color.id" class="colorpicker_panel-item col s2">
                            <div class="valign-wrapper" :class="color.name"
                                 @click="setColorName(color.colorName, index, color.hex)">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="settings__folder-action">
                    <div class="settings__delete" @click="deleteFolder(index)">Удалить из списка</div>
                </div>
            </div>
        </div>
        <div class="settings__folder-bottom">
            <div class="setting__create-folder" @click="modal = !modal">
                новая папка
            </div>
            <div class="settings__row-numbers">
                Строк:
                <select name="" id="" v-model="perItem">
                    <option value="1">1</option>
                    <option value="3">3</option>
                    <option value="5">5</option>
                </select>

            </div>
            <div class="settings__pagination">
                {{ folders.from}} - {{ folders.to}} of {{folders.total}}
                <span>
                     <i
                         title="Назад" class="material-icons"
                         @click="paginate(folders.prev_page_url)"
                     >
                        arrow_back
                    </i>
                    <i
                        class="material-icons"
                        @click="paginate(folders.next_page_url)"
                    >
                        arrow_forward
                    </i>
                </span>
            </div>
        </div>
        <div class="hor__line"></div>
        <div class="modal__buttons">
            <button type="button" @click="save" class="btn_modal">Сохранить</button>
            <button type="button" @click="close()" class="btn_modal">Отменить</button>
        </div>
        <createFolder @close="modal = !modal" :modal="modal"></createFolder>
    </div>
</template>


<script>
    import createFolder from '../../NewFolder/NewFolderComponent'

    export default {
        name: "FolderWorks",
        components: {createFolder},
        data: function () {
            return {
                folders: [],
                deleteModal: false,
                foldersItem: [],
                deleteStatus: false,
                pickerOpen: false,
                deleteItems: [],
                modal: false,
                perItem: 3,
                colors: [
                    {
                        name: "color_1",
                        colorName: 'Белый',
                        hex: '#ececec'
                    },
                    {
                        name: "color_2",
                        colorName: 'Желтый',
                        hex: '#f1c928'
                    },
                    {
                        name: "color_3",
                        colorName: 'Синий',
                        hex: '#1441ec'
                    },
                    {
                        name: "color_4",
                        colorName: 'Оранжевый',
                        hex: '#eb631f'

                    },
                    {
                        name: "color_5",
                        colorName: 'Зеленый',
                        hex: '#74af39'
                    },
                    {
                        name: "color_6",
                        colorName: 'Голубой',
                        hex: '#1288bd'
                    },
                    {
                        name: "color_7",
                        colorName: 'Розовый',
                        hex: '#c82484'
                    },
                    {
                        name: "color_8",
                        colorName: 'Фиолетовый',
                        hex: '#874ba7'
                    },
                    {
                        name: "color_9",
                        colorName: 'Зеленый',
                        hex: '#56c4ab'
                    },
                    {
                        name: "color_10",
                        colorName: 'Коричневый',
                        hex: '#976c4c'
                    },
                    {
                        name: "color_11",
                        colorName: 'Желтый',
                        hex: '#f1e7c2'
                    },

                    {
                        name: "color_12",
                        colorName: 'Градиент',
                        hex: '#FF6376'
                    }
                ]
            };
        },
        methods: {
            setColorName(color, index, hex) {
                let pickers = document.querySelectorAll('[data-picker]');
                pickers[index].style.display = 'none';
                this.folders.data[index]['color_name'] = color;
                this.folders.data[index]['color'] = hex;
                this.pickerOpen = false;
            },
            paginate(paginate) {
                if (paginate) {
                    axios.get(paginate)
                        .then(r => this.folders = r.data)
                }
            },
            save() {
                console.log(this.deleteStatus);
                axios.post('/api/user/update', this.folders.data);

                console.log(this.deleteStatus);
                if (this.deleteStatus) {
                    axios.post('api/user/delete', this.deleteItems)
                }
                this.$emit('close')
            },
            update(name, event, index) {
                this.folders.data[index][name] = event.target.value;
            },
            deleteFolder(index) {
                this.deleteStatus = true;
                this.deleteItems.push(this.folders.data[index].id);
                this.folders.data.splice(index, 1);
            },
            folderColor(index) {
                let pickers = document.querySelectorAll('[data-picker]');
                if (pickers[index].style.display === 'flex') {
                    pickers[index].style.display = 'none';
                } else {
                    pickers[index].style.display = 'flex';
                }


            },
            close() {
                this.$emit('close')
            },
            getFolders(page = 1) {
                axios.get('/api/user/settings/folder/' + this.perItem + '?page=' + page)
                    .then(r => {
                        this.folders = r.data;
                    })
            },
        },
        watch: {
            deleteItems() {
                if (this.deleteItems.length < 1) this.deleteStatus = false;
            },
            perItem() {
                axios.get('/api/user/settings/folder/' + this.perItem + '?page=' + 1)
                    .then(r => {
                        this.folders = r.data;
                    })
            }
        },
        mounted() {
            this.getFolders();
        },
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
        position: relative;
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

    .settings__folder-item:last-child {
        margin-bottom: 15px;
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

    .settings__folder-items {
        min-width: 580px;
    }

    .settings__folder-items input {
        font-style: normal;
        font-weight: bold;
        font-size: 15px !important;
        line-height: 40px;
        padding-left: 30px !important;
        color: #808080 !important;
        border: 2px solid #F5F5F5 !important;
        border-radius: 4px !important;
        box-sizing: border-box !important;
    }

    .settings__folder-items label {
        font-style: normal;
        font-weight: 500;
        font-size: 15px;
        line-height: 23px;
        color: #666666 !important;
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
        position: relative;
    }

    .settings__folder-items .folder__color input {
        cursor: pointer;
    }

    .folder__color:after {
        content: '';
        display: block;
        position: absolute;
        width: 0;
        height: 0;
        top: 44%;
        transform: translate(50%, -50%) rotate(45deg);
        right: 15px;
        border-right: 3px solid #D8D8D8;
        border-bottom: 3px solid #D8D8D8;
        padding: 3px;
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

    .color_picker {
        display: flex;
        width: 221px;
        flex-wrap: wrap;
        position: absolute;
        right: -20px;
        top: 60px;
        background: #fff;
        z-index: 2;
    }

    .color_picker {
        display: none;
    }

    .color_picker div {
        width: 21px;
        height: 21px;
        margin-right: 15px;
        border-radius: 50%;
        margin-bottom: 14px;
        cursor: pointer;
    }

    select {
        display: inline-block;
        border: none;
        padding: 0;
        width: 30px;
        appearance: none;
        height: 15px;
        position: relative;
        background: none;
        z-index: 22;
        cursor: pointer
    }

    .settings__row-numbers::after {
        content: '';
        display: block;
        position: absolute;
        width: 0;
        height: 0;
        top: 68%;
        transform: translate(50%, -50%) rotate(-135deg);
        right: 12px;
        border-right: 2px solid #D8D8D8;
        border-bottom: 2px solid #D8D8D8;
        padding: 3px;
    }

    select:focus {
        outline: none;
    }
</style>
