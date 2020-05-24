<template>
  <div class>
    <div class="col s10 card-title">
      <span>Введите пароль к папке</span>
    </div>
    <div class="folder_password-block">
      <div class="input-field folder_password-input">
        <i class="material-icons prefix">lock</i>
        <input id="folder_password" type="password" class="validate" />
        <label for="folder_password">Ваш пароль</label>
      </div>
    </div>
    <div class="folder_password-block">
      <div class="input-field folder_password-input">
        <i class="material-icons prefix">lock</i>
        <input id="confirm_folder_password" type="password" class="validate" />
        <label for="confirm_folder_password">Повторите пароль</label>
      </div>
    </div>
  </div>
</template>


<script>
import {eventBus} from "../../../../app";

export default {
  name: "NewFolderSettings",
  data: function() {
    return {
      password: ''
    };
  },
  mounted() {

  },
  methods: {
    close() {
      this.$emit("close");
    },
    edit_password() {

    }
  }
};
</script>

<style scoped>
/* переопределение переменных Materialize */

/* Text inputs */
input:not([type]),
input[type="text"]:not(.browser-default),
input[type="password"]:not(.browser-default),
textarea.materialize-textarea {
  border-bottom: none;
}

input:not([type]):focus:not([readonly]),
input[type="text"]:not(.browser-default):focus:not([readonly]),
input[type="password"]:not(.browser-default):focus:not([readonly]),
textarea.materialize-textarea:focus:not([readonly]) {
  border-bottom: none;
  -webkit-box-shadow: none;
  box-shadow: none;
}

input:not([type]):focus:not([readonly]) + label,
input[type="text"]:not(.browser-default):focus:not([readonly]) + label,
input[type="password"]:not(.browser-default):focus:not([readonly]) + label,
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
.input-field .prefix {
  margin-left: 5px;
  font-size: 26px;
  color: #b2b2b2;
  }
.input-field .prefix.active {
  font-size: 30px;
  color: #666666;
  }
  
/* custom styles */
.folder_password-block {
  width: 282px;
  margin-top: 70px;
}
.input-field {
  width: 100%;
  height: 50px;
  border-radius: 4px;
  border: 2px solid #f5f5f5;
  background-color: #ffffff;
}
.folder_password-input {
  margin-bottom: 55px;
}
.folder_password-block label {
  margin-left: 20px;
}
.folder_password-block .validate {
  padding-left: 20px;
}
</style>