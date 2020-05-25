<template>
    <div class="">
        <div class="col s10 card-title">
            <span>Новая папка</span>
        </div>
        <div class="folder_name-block">
            <div class="input-field folder_name-input">
                <input id="folder_name" type="text" v-model="folder.name" class="validate"/>
                <label class="active" for="folder_name">Название папки</label>
            </div>
            <div class="input-field folder_description-input">
                <textarea v-model="folder.description" id="description" class="materialize-textarea"></textarea>
                <label for="description">Описание папки</label>
            </div>
        </div>
        <div class="colorpicker_header">
            <a href="#" class="dropdown-trigger valign-wrapper" data-target="dropdown">
                <span class="colorpicker_title">Цвет ярлыка</span>
                <i class="material-icons colorpicker_button">expand_more</i>
            </a>
        </div>
        <div class="row colorpicker_panel dropdown-content" id="dropdown">
            <div
                v-for="(color, index) in colors"
                :key="index"
                class="colorpicker_panel-item col s2"
                @click="setFolderColor(index , color.colorName , color.hex)">
                <a href="#" class="valign-wrapper" :class="color.name">
                    <i :data-index="index" class="colorpicker_panel_item-check_mark material-icons">done</i>
                </a>
            </div>
        </div>
        <div class="hor__line"></div>
        <div class="modal__buttons">
            <button type="button" @click="store" class="btn_modal">Продолжить</button>
            <button type="button" @click="close" class="btn_modal">Отменить</button>
        </div>
    </div>
</template>


<script>
    export default {
        name: "NewFolderSettings",
        data: function () {
            return {
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
                ],
                folder: {}
            };
        },
        mounted() {
            var elem = document.querySelector(".dropdown-trigger");
            var instance = new M.Dropdown(elem, {
                alignment: "right",
                constrainWidth: true,
                coverTrigger: false,
                closeOnClick: false,
                inDuration: 600,
                outDuration: 600,
                isOpen: true
            });
        },
        methods: {
            close() {
                this.folder = {};
                this.$emit('close')
            },
            store() {
                if (!this.folder.name || this.folder.name.length < 1) {
                    Vue.$toast.open({
                        message: `Назовите как то папку`,
                        type: "error",
                        position: "top",
                        duration: 2000
                    });
                } else {
                    axios.post('/api/user/store' , this.folder);
                    Vue.$toast.open({
                        message: `Папка создана`,
                        type: "success",
                        position: "top",
                        duration: 2000
                    });
                    this.folder = {};
                    this.$emit('close')
                }

            },
            setFolderColor(index, name, hex) {
                let pickers = document.querySelectorAll('[data-index]');
                for (let i = 0; i < pickers.length; i++) {
                    pickers[i].classList.add('colorpicker_panel_item-check_mark')
                }
                pickers[index].classList.remove('colorpicker_panel_item-check_mark');
                this.folder.color_name = name;
                this.folder.color = hex;
            }
        }
    };
</script>

<style scoped>
    /* переопределение переменных Materialize */

    /* Text inputs */
    input:not([type]),
    input[type="text"]:not(.browser-default),
    textarea.materialize-textarea {
        border-bottom: none !important;
    }

    input:not([type]):focus:not([readonly]),
    input[type="text"]:not(.browser-default):focus:not([readonly]),
    textarea.materialize-textarea:focus:not([readonly]) {
        border-bottom: none;
        -webkit-box-shadow: none;
        box-shadow: none;
    }

    input:not([type]):focus:not([readonly]) + label,
    input[type="text"]:not(.browser-default):focus:not([readonly]) + label,
    textarea.materialize-textarea:focus:not([readonly]) + label {
        color: #666666;
        border-bottom: none;
    }

    .input-field > label:not(.label-icon).active {
        transform: translate(-18px,-31px) scale(0.8);
        -webkit-transform-origin: 0 0;
        transform-origin: 0 0;
    }

    /* Checkbox */
    [type="checkbox"].filled-in + span:not(.lever):after {
        border-radius: 4px;
    }

    [type="checkbox"].filled-in:not(:checked) + span:not(.lever):after {
        height: 20px;
        width: 20px;
        background-color: transparent;
        border: 2px solid #e6e6e6;
        top: 0px;
        z-index: 0;
    }

    [type="checkbox"].filled-in:checked + span:not(.lever):after {
        top: 0;
        width: 20px;
        height: 20px;
        border: 2px solid #1875f0;
        background-color: #1875f0;
        z-index: 0;
    }

    /* custom styles */
    .m_modal {
        position: relative;
        width: 350px;
        background-color: #fff;
        transition: transform .3s ease-out;
        transform: translate(0, -50px);
        margin: 100px auto auto;
        padding: 30px 30px 25px 21px;
        border-radius: 5px;
    }

    .row .col .wrapper {
        font-family: Roboto;
        width: 350px;
        padding: 0rem;
    }

    .card {
        box-sizing: border-box;
        font-family: Roboto;
        width: 350px;
        width: 100%;
        height: 550px;
        border-radius: 6px;
        background-color: #ffffff;
        margin: 0rem;
    }

    .input.valid[type=text]:not(.browser-default) {
        border-bottom: none !important
    }

    .card .card-content {
        padding-top: 30px;
        padding-left: 30px;
    }

    .close_button {
        width: 26px;
        height: 26px;
    }

    .close_button i {
        font-size: 26px;
        color: #dfdfdf;
    }

    .close_button i:hover,
    .close_button i:focus {
        font-size: 30px;
        color: #b8b8b8;
        -webkit-transform: rotate(360deg);
        transform: rotate(360deg);
        transition: all 0.9s ease-in-out 0s;
    }

    .card-title {
        color: #666666;
        font-family: Roboto;
        font-size: 18px;
        font-weight: 500;
        line-height: 40px;
    }

    .folder_name-block {
        width: 282px;
        margin-top: 38px;
    }

    .input-field {
        width: 100%;
        height: 50px;
        border-radius: 4px;
        border: 2px solid #f5f5f5;
        background-color: #ffffff;
    }

    .folder_name-input {
        margin-bottom: 55px;
    }

    .folder_name-block label {
        margin-left: 20px;
    }

    .folder_name-block .validate,
    .folder_name-block .materialize-textarea {
        padding-left: 20px;
    }

    .colorpicker_header {
        height: 110px;
        width: 220px;
        margin-bottom: 5px;
        padding: 0;
        margin-left: 5px;
    }

    .colorpicker_panel-item {
        padding: 0;
    }

    .colorpicker_title {
        width: 105px;
        height: 30px;
        margin-right: 100px;
        padding: 0;
        color: #666666;
        font-family: Roboto;
        font-size: 14px;
        font-weight: 500;
        line-height: 30px;
    }

    .colorpicker_button {
        width: 26px;
        height: 26px;
        color: #b2b2b2;
    }

    .colorpicker_panel {
        padding: 5px;
        min-height: 80px;
        background: transparent;
        border: none;
        box-shadow: none;
    }

    .colorpicker_panel a {
        padding: 3px;
        margin-top: 15px;
        height: 21px;
        width: 21px;
        border-radius: 50%;
        border: transparent;
        display: flex;
        justify-content: center;
    }

    .colorpicker_panel a {
        pointer-events: none;
    }

    .colorpicker_panel-item {
        outline: none;
        cursor: pointer;
    }

    .colorpicker_panel-item a {
        pointer-events: none;
    }


    .colorpicker_panel_item-check_mark {
        font-size: 14px;
        font-weight: 1000;
        color: transparent;
    }

    .color_1 .colorpicker_panel_item-check_mark:focus,
    .color_1 .colorpicker_panel_item-check_mark:hover,
    .color_2 .colorpicker_panel_item-check_mark:focus,
    .color_2 .colorpicker_panel_item-check_mark:hover,
    .color_11 .colorpicker_panel_item-check_mark:focus,
    .color_11 .colorpicker_panel_item-check_mark:hover {
        color: #666666;
    }

    .color_3 .colorpicker_panel_item-check_mark:focus,
    .color_3 .colorpicker_panel_item-check_mark:hover,
    .color_4 .colorpicker_panel_item-check_mark:focus,
    .color_4 .colorpicker_panel_item-check_mark:hover,
    .color_5 .colorpicker_panel_item-check_mark:focus,
    .color_5 .colorpicker_panel_item-check_mark:hover,
    .color_6 .colorpicker_panel_item-check_mark:focus,
    .color_6 .colorpicker_panel_item-check_mark:hover,
    .color_7 .colorpicker_panel_item-check_mark:focus,
    .color_7 .colorpicker_panel_item-check_mark:hover,
    .color_8 .colorpicker_panel_item-check_mark:focus,
    .color_8 .colorpicker_panel_item-check_mark:hover,
    .color_9 .colorpicker_panel_item-check_mark:focus,
    .color_9 .colorpicker_panel_item-check_mark:hover,
    .color_10 .colorpicker_panel_item-check_mark:focus,
    .color_10 .colorpicker_panel_item-check_mark:hover,
    .color_12 .colorpicker_panel_item-check_mark:focus,
    .color_12 .colorpicker_panel_item-check_mark:hover {
        color: #ffffff;
    }

    .folder_password-block {
        height: 45px;
        color: #b2b2b2;
        font-size: 12px;
        font-weight: 500;
        line-height: 50px;
    }

    .folder_password-block .password-checkbox {
        width: 20px;
        height: 20px;
        border-radius: 4px;
        border: 2px solid #e6e6e6;
        background-color: #ffffff;
    }

    .row .card-action {
        padding-top: 24px;
        margin-left: 0rem;
        margin-right: 0rem;
    }

    .action_button-continue,
    .action_button-cancel {
        font-size: 10px;
        font-weight: 900;
        line-height: 40px;
        color: #b2b2b2;
        text-transform: uppercase;
        width: 130px;
        height: 40px;
        border-radius: 4px;
        border: 2px solid #f5f5f5;
        background-color: #ffffff;
        box-shadow: none;
    }

    .action_button-continue:focus,
    .action_button-continue:hover,
    .action_button-cancel:focus,
    .action_button-cancel:hover {
        color: #ffffff;
        border: 2px solid #1875f0;
        background-color: #1875f0;
        box-shadow: none;
    }
</style>
