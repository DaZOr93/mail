<template>
  <div class="container-fluid wrapper">
    <div class="row">
      <div class="col card-wrapper">
        <div class="row">
          <div class="col s12 valign-wrapper header">
            <span class="header-text">Настройки</span>
          </div>
        </div>
        <ul class="row body">
          <li class="col s12 m6 nav-item" v-for="item in items" :key="item.id">
            <ul class="row nav-item-link modal-trigger" @click="open_settings_item(item.modalName)">
                <li class="col nav-icon-circle">
                  <span class="valign-wrapper center-align">
                    <i class="material-icons">{{ item.iconName }}</i>
                  </span>
                </li>
                <li class="col s9 valign-wrapper nav-helper">
                  <span class>{{ item.navHelperText }}</span>
                </li>
                <li class="col s9 valign-wrapper nav-title">
                  <span class>{{ item.navTitleText }}</span>
                </li>
              </ul>
          </li>
        </ul>
      </div>
    </div>
    <SettingsModal @close="modal = !modal" :modal="modal" :item="item" ></SettingsModal>
  </div>
</template>

<script>
import { eventBus } from "../../app";
import SettingsModal from "../Modal/Settings/SettingsModalComponent";
export default {
  name: "Settings",
  components: { SettingsModal },
  data() {
    return {
      modal: false,
      item: null,
      items: [
        {
          iconName: "account_circle",
          navHelperText: "Иванов И И",
          navTitleText: "Личные данные",
          modalName: "PersonalData"
        },
        {
          iconName: "playlist_add",
          navHelperText: "Подписи к письмам",
          navTitleText: "Подпись",
          modalName: "MailVisa"
        },
        {
          iconName: "drafts",
          navHelperText: "Список писем, их отправка",
          navTitleText: "Работа с письмами",
          modalName: "MailWorks"
        },
        {
          iconName: "email",
          navHelperText: "Сбор почты",
          navTitleText: "Почта с других ящиков",
          modalName: "MailFetch"
        },
        {
          iconName: "folder",
          navHelperText: "Управление папками",
          navTitleText: "Папки",
          modalName: "FolderWorks"
        }
      ]
    };
  },
  methods: {
    open_settings_item(item) {
      this.modal = true;
      this.item = item;
    }
  }
};
</script>

<style lang="scss" scoped>
.wrapper {
  width: 100%;
  height: 100%;
  border-radius: 12px;
  background-color: #ffffff;
  box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.05);
  font-family: Roboto;
  padding: 0rem;
}

.card-wrapper {
  width: 700px;
  height: 700px;
}
.header {
  width: 100%;
  height: 68px;
  margin-bottom: 48px;
  color: #999999;
  font-size: 18px;
  font-weight: 700;
  line-height: 90px;
  border-bottom: 3px solid #f5f5f5;
}
.header-text {
  margin: 0 auto;
}
.col .row.body {
  margin-left: 0rem;
  margin-right: 0rem;
  margin-left: 30px;
}
.nav-item {
  margin-bottom: 50px;
}
.nav-item {
    cursor: pointer;
}
.nav-icon-circle {
  width: 60px;
  height: 60px;
  border: 2px solid #f5f5f5;
  border-radius: 50%;
  background-color: #ffffff;
}
.nav-item li span {
  height: 100%;
  width: 100%;
}
.nav-item i {
  font-size: 26px;
  color: #d8d8d8;
  margin: 0 auto;
}
.nav-helper {
  height: 34px;
  color: #cccccc;
  font-family: Roboto;
  font-size: 10px;
  font-weight: 900;
  letter-spacing: 0.83px;
  line-height: 30px;
}
.nav-title {
  height: 34px;
  color: #666666;
  font-family: Roboto;
  font-size: 14px;
  font-weight: 500;
  line-height: 30px;
}
.nav-item-link:hover i,
.nav-item-link:focus i,
.nav-item-link:active i {
  color: #999999;
  font-size: 30px;
  transition: hover 0.5s;
}
.nav-item-link:focus .nav-icon-circle,
.nav-item-link:hover .nav-icon-circle,
.nav-item-link:active .nav-icon-circle,
.nav-item-link:focus .nav-helper,
.nav-item-link:hover .nav-helper,
.nav-item-link:active .nav-helper,
.nav-item-link:focus .nav-title,
.nav-item-link:hover .nav-title,
.nav-item-link:active .nav-title {
  background: rgba(24, 117, 240, 0.16);
  transition: hover 0.5s;
}
</style>
