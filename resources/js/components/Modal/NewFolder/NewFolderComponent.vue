<template>
  <div class="m_modal_wrap" :class="{'m_modal_show' : modal}">
    <div class="m_modal_bg"></div>
    <div class="m_modal">
      <div class="close" @click="close"></div>
      <div class="content">
        <div class="integration-modal">
          <NewFolderSettings v-if="show_settings"></NewFolderSettings>
          <NewFolderPassword v-if="show_edit_password"></NewFolderPassword>
          <ChangeFolderPassword v-if="show_change_password"></ChangeFolderPassword>
          <div class="hor__line"></div>
          <div class="modal__buttons">
            <button type="button" @click="store" class="btn_modal">Продолжить</button>
            <button type="button" @click="close" class="btn_modal">Отменить</button>
          </div>
        </div>  
      </div>
    </div>
  </div>
</template>


<script>
import {eventBus} from "../../../app";
import NewFolderSettings from "../NewFolder/NewFolderSettingsComponent";
import NewFolderPassword from "../NewFolder/NewFolderPasswordComponent";
import ChangeFolderPassword from "../NewFolder/ChangeFolderPasswordComponent";
export default {
  
  name: "NewFolderComponent",
  components: {NewFolderSettings, NewFolderPassword, ChangeFolderPassword},
  props: ['modal'],
  data() {
    return {
      show_settings: true,
      show_edit_password: false,
      show_change_password: false,
    };
  },
  mounted() {
    
  },
  methods: {
    store() {
      this.show_settings=false;
      this.show_edit_password=false;
      this.show_change_password=true;
      },
    close() {
      this.$emit('close')
      },
  }
};
</script>

<style scoped>

.m_modal {
    position: relative;
    width: 350px;
    background-color: #fff;
    transition: transform .3s ease-out;
    transform: translate(0,-50px);
    margin: 100px auto auto;
    padding: 30px 30px 25px 21px;
    border-radius: 5px;
}
</style>