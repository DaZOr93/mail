<template>
  <div class="m_modal_wrap" :class="{'m_modal_show' : modal}">
    <div class="m_modal_bg"></div>
    <div class="m_modal">
      <div class="close" @click="close"></div>
      <div class="content">
        <div class="integration-modal">
          <component  @checked="check_password = !check_password" :check_password="check_password" :is="item"></component>
          <div class="hor__line"></div>
          <div class="modal__buttons">
            <button type="button" v-if="item==='NewFolderSettings'" @click="store" class="btn_modal">Продолжить</button> 
            <button type="button" v-if="item==='NewFolderSettings'" @click="close" class="btn_modal">Отменить</button> 
            <button type="button" v-if="item==='NewFolderPassword'" @click="add_password" class="btn_modal">ОК</button>
            <button type="button" v-if="item==='NewFolderPassword'" @click="back" class="btn_modal">Назад</button>
          </div>
        </div>  
      </div>
    </div>
  </div>
</template>


<script>
import {eventBus} from "../../../app";
import NewFolderSettings from "../NewFolder/NewFolderItems/NewFolderSettingsComponent";
import NewFolderPassword from "../NewFolder/NewFolderItems/NewFolderPasswordComponent";
export default {
  
  name: "NewFolderComponent",
  components: {
    NewFolderSettings,
    NewFolderPassword,
    },
  props: ['modal'],
  data() {
    return {
      item:'NewFolderSettings',
      check_password: false,
    };
  },
  mounted() {
    
  },
  methods: {
    store() {
      let check_pass = this.check_password;
      if(check_pass) {
        this.item = 'NewFolderPassword';
      } else {
          alert('folder created successfuly!');
          this.$emit('close');
        }
      },
    close() {
      this.$emit('close');
      },
    back() {
      this.item = 'NewFolderSettings';
      this.check_password = false;
    },
    add_password() {
      alert('password saved successfuly!');
      this.item = 'NewFolderSettings';
      this.check_password = false;
      this.$emit('close');
    }
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
/* .m_modal .password_button {
    width: 200px;
    height: 50px;
    color: #ffffff;
    font-family: Roboto;
    font-size: 12px;
    font-weight: 900;
    line-height: 50px;
    text-transform: uppercase;
} */
</style>