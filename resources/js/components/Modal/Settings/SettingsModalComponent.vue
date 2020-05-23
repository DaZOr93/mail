<template>
  <div class="m_modal_wrap" :class="{'m_modal_show' : modal}">
    <div class="m_modal_bg"></div>
    <div class="m_modal">
      <div class="close" @click="close"></div>
      <div class="content">
        <div class="integration-modal">
          <component @close="close" :is="item"></component>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
import PersonalData from "../../Modal/Settings/SettingsItems/PersonalDataComponent";
import MailWorks from "../../Modal/Settings/SettingsItems/MailWorksComponent";
import MailVisa from "../../Modal/Settings/SettingsItems/MailVisaComponent";
import MailFetch from "../../Modal/Settings/SettingsItems/MailFetchComponent";
import FolderWorks from "../../Modal/Settings/SettingsItems/FolderWorksComponent";

export default {
  name: "SettingsModal",
  components: {
    PersonalData,
    MailWorks,
    MailVisa,
    MailFetch,
    FolderWorks
  },
  props: ["modal", "item"],
  data() {
    return {
      show_personal_data: true,
    };
  },
  methods: {
    close() {
      this.$emit("close");
    }
  }
};
</script>

<style lang="scss" scoped>
.m_modal {
  position: relative;
  width: max-content;
  background-color: #fff;
  transition: transform 0.3s ease-out;
  transform: translate(0, -50px);
  margin: 100px auto auto;
  padding: 30px 30px 25px 21px;
  border-radius: 5px;
}
</style>
