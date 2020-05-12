<template>
  <div class="modal-content">
    <div class="card">
        <div class="card-content">
          <div class="row">
            <div class="col s10 card-title">
              <span>Новая папка</span>
            </div>
            <div class="col s2 close_button modal-close">
               <i class="material-icons">clear</i>
            </div>
          </div>
          <div class="folder_name-block">
            <div class="input-field folder_name-input">
              <input id="folder_name" type="text" class="validate" />
              <label class="active" for="folder_name">Имя папки</label>
            </div>
            <div class="input-field folder_description-input">
              <textarea id="description" class="materialize-textarea"></textarea>
              <label for="description">Описание</label>
            </div>
          </div>
          <div class="colorpicker_header">
            <a href="#" class="dropdown-trigger valign-wrapper" data-target="dropdown">
              <span class="colorpicker_title">Цвет ярлыка</span>
              <i class="material-icons colorpicker_button">expand_more</i>
            </a>
          </div>
          <div class="row colorpicker_panel dropdown-content" id="dropdown">
            <div v-for="color in colors" :key="color.id" class="colorpicker_panel-item col s2">
              <a href="#" class="valign-wrapper" :class="color.name">
                <i class="colorpicker_panel_item-check_mark material-icons">done</i>
              </a>
            </div>
          </div>
          <form action="#" class="folder_password-block">
            <div>
              <label>
                <input type="checkbox" class="folder_password-checkbox filled-in" />
                <span>Защитить папку паролем</span>
              </label>
            </div>
          </form>
        </div>
        <div class="row card-action">
          <div class="col s6">
            <a
              class="action_button-continue btn waves-effect waves-light center-align"
              href="#"
            >Продолжить</a>
          </div>
          <div class="col s6">
            <a
              class="action_button-cancel btn waves-effect waves-light center-align"
              href="#"
            >Отменить</a>
          </div>
        </div>
      </div>
  </div>
</template>

<script>
export default {
  name: "NewFileComponent",

  data: function() {
    return {
      colors: [
        { name: "color_1" },
        { name: "color_2" },
        { name: "color_3" },
        { name: "color_4" },
        { name: "color_5" },
        { name: "color_6" },
        { name: "color_7" },
        { name: "color_8" },
        { name: "color_9" },
        { name: "color_10" },
        { name: "color_11" },
        { name: "color_12" }
      ]
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
      outDuration: 600
    });
  },
  methods: {
    selectColor() {}
  }
};
</script>

<style scoped>
/* переопределение переменных Materialize */

/* Text inputs */
input:not([type]),
input[type="text"]:not(.browser-default),
textarea.materialize-textarea {
  border-bottom: none;
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
  -webkit-transform: translateY(-30px) scale(0.8);
  transform: translateY(-30px) scale(0.8);
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
.close_button i:hover, .close_button i:focus {
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
.folder_name-block label{
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
}

.color_1 {
  box-shadow: 0 2px 2px rgba(0, 0, 0, 0.1);
  background-color: #ececec;
}
.color_2 {
  box-shadow: 0 2px 2px rgba(0, 0, 0, 0.1);
  background-color: #f1c928;
}
.color_3 {
  box-shadow: 0 2px 2px rgba(0, 0, 0, 0.1);
  background-color: #1441ec;
}
.color_4 {
  box-shadow: 0 2px 2px rgba(0, 0, 0, 0.1);
  background-color: #eb631f;
}
.color_5 {
  box-shadow: 0 2px 2px rgba(0, 0, 0, 0.1);
  background-color: #74af39;
}
.color_6 {
  box-shadow: 0 2px 2px rgba(0, 0, 0, 0.1);
  background-color: #1288bd;
}
.color_7 {
  box-shadow: 0 2px 2px rgba(0, 0, 0, 0.1);
  background-color: #c82484;
}
.color_8 {
  box-shadow: 0 2px 2px rgba(0, 0, 0, 0.1);
  background-color: #874ba7;
}
.color_9 {
  box-shadow: 0 2px 2px rgba(0, 0, 0, 0.1);
  background-color: #56c4ab;
}
.color_10 {
  box-shadow: 0 2px 2px rgba(0, 0, 0, 0.1);
  background-color: #976c4c;
}
.color_11 {
  box-shadow: 0 2px 2px rgba(0, 0, 0, 0.1);
  background-color: #f1e7c2;
}
.color_12 {
  box-shadow: 0 2px 2px rgba(0, 0, 0, 0.1);
  background: rgb(131, 58, 180);
  background: linear-gradient(
    0deg,
    rgba(131, 58, 180, 1) 0%,
    rgba(253, 29, 29, 1) 50%,
    rgba(252, 176, 69, 1) 100%
  );
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