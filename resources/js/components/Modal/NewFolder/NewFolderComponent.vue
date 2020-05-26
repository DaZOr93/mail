<template>
  <div class="m_modal_wrap" :class="{'m_modal_show' : modal}">
    <div class="m_modal_bg"></div>
    <div class="m_modal">
      <div class="close" @click="close"></div>
      <div class="content">
        <div class="integration-modal">
          <component  @checked="check_password = !check_password" @close="close" :check_password="check_password" :is="item"></component>
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
    close(){
      this.$emit('close') 
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
</style>
