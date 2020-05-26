<template>
  <div class="row card-wrapper">
    <div class="col s12">
      <div class="row header">
        <div class="col s8 m10 card-title">
          <span>Сбор почты</span>
        </div>
      </div>
      <div class="row mailbox_groupe" v-for="item in 3" :key="item.id">
        <div class="col s12 m5 input-field email_input-groupe">
          <input placeholder="Email" id="email" type="text" class="validate valign-wrapper" v-model="email"/>
        </div>
        <div class="col s12 m6 input-field password_input-groupe">
          <input placeholder="Пароль" id="password" type="password" class="validate valign-wrapper" v-model="password"/> 
        </div>
        <div class="col s12 m5 input-field protocol_input-groupe">
          <!-- добавить кнопку <i class="material-icons">expand_more</i>-->
          <select class="browser-default" v-model="protocol">
            <option value="" selected>Протокол</option>
            <option value="2">IMAP</option>
            <option value="3">POP3</option>
          </select>
          <!--  -->
        </div>
        <div class="col s6 m2 input-field email_input-groupe">
          <input placeholder="Порт" id="port" type="text" class="validate valign-wrapper" v-model="port"/>
        </div>
        <div class="col s12 m4 right-align">
          <button type="button" @click="chek" class="btn_chek">Проверка</button>
          <div class="btn_delete valign-wrapper">
            <i class="material-icons">close</i>
            <span>Удалить запись</span>
          </div>
        </div>
        <div class="col underline"></div>
      </div>
      <!-- <div class="hor__line__mailbox_groupe"></div> -->
      
      <div class="row settings__mailbox-bottom">
        <div class="col s4 setting__create-mailbox" @click="modal = !modal">новый ящик</div>
        <div class="col s3 csettings__row-numbers">
          Строк:
          <select name="" id="" v-model="perItem">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
          </select>
        </div>
        <div class="col s5 settings__pagination">
          {{ mailboxes.from}} - {{ mailboxes.to}} of {{mailboxes.total}}
          <span>
            <i
              title="Назад"
              class="material-icons"
              @click="paginate(mailboxes.prev_page_url)"
            >arrow_back</i>
            <i class="material-icons" @click="paginate(mailboxes.next_page_url)">arrow_forward</i>
          </span>
        </div>
      </div>
      <div class="hor__line"></div>
      <!-- <div class="row underline_w100"></div> -->
      <div class="row modal__buttons">
        <div class="col s12">
          <button type="button" @click="save" class="btn_modal">Сохранить</button>
          <button type="button" @click="close()" class="btn_modal">Отменить</button>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
export default {
  name: "MailFetch",
  data: function() {
    return {
      chekbtnColor: [
        {
          name: "default",
          colorName: 'Синий',
          hex: '#1875f0' 
        },
        {
          name: "failed",
          colorName: 'Красный',
          hex: '#f93f3f' 
        },
        {
          name: "success",
          colorName: 'Зеленый',
          hex: '#34cb49' 
        },
      ],
      email: "", //...................времянка
      password: "", //...................времянка
      protocol: "", //..............времянка
      port: "", //...............времянка
      mailboxes: [],
      deleteModal: false,
      mailboxesItem: [],
      deleteStatus: false,
      pickerOpen: false,
      deleteItems: [],
      errors: [],
      modal: false,
      perItem: 3
    };
  },
  created() {
    
  },
  mounted() {
    this.getMailboxes();
  },
  methods: {
    paginate(paginate) {
      if (paginate) {
        axios.get(paginate).then(r => (this.mailboxes = r.data));
      }
    },
    chek() {},
    save() {},
    close() {
      axios
        .get("/api/user/settings/mailbox/" + this.perItem + "?page=" + 1)
        .then(r => {
          this.mailboxes = r.data;
        });
      this.deleteStatus = false;
      this.deleteItems = {};
      this.$emit("close");
    },
    getMailboxes(page = 1) {
      axios
        .get("/api/user/settings/mailbox/" + this.perItem + "?page=" + page)
        .then(r => {
          this.mailboxes = r.data;
        });
    }
  },
  watch: {
    deleteItems() {
      if (this.deleteItems.length < 1) this.deleteStatus = false;
    },
    perItem() {
      axios
        .get("/api/user/settings/mailbox/" + this.perItem + "?page=" + 1)
        .then(r => {
          this.mailboxes = r.data;
        });
    }
  }
};
</script>

<style lang="scss" scoped>
.row {
  margin-bottom: 0px;
}
.card-wrapper {
  max-width: 500px;
  margin-left: 9px;
  border-radius: 6px;
  background-color: #ffffff;
}
.underline{
  width: 350px;
  margin-bottom: 10px;
  border-bottom: 2px solid #f5f5f5;
}
// .underline_w100{
//   width: 100%;
//   border-bottom: 2px solid #f5f5f5;
// }
.header {
  height: 40px;
  margin-bottom: 11px;
}
.card-title {
  color: #666666;
  font-family: Roboto;
  font-size: 18px;
  font-weight: 500;
  line-height: 40px;
}
.email_input-groupe,
.protocol_input-groupe { 
  margin-right: 10px;
}
.input-field {
  width: 100%;
  height: 50px;
  margin-top: 0rem;
  margin-bottom: 6px;
  border-radius: 4px;
  border: 2px solid #f5f5f5;
  background-color: #ffffff;
}
.email_input-groupe input::placeholder,
.password_input-groupe input::placeholder,
.port_input-groupe input::placeholder {
  color: #808080;
  font-family: Roboto;
  font-size: 10px;
  font-weight: 700;
  line-height: 40px;
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
select:focus {
  outline: none;
}
select.browser-default {
  display: block;
  background-color: rgba(255, 255, 255, 0.9);
  width: 100%;
  padding: 0px;
  border: none;
  height: 46px;
  color: #808080;
  font-family: Roboto;
  font-size: 10px;
  font-weight: 700;
  line-height: 40px;
  
}
select.browser-default:focus {
  display: block;
  background-color: rgba(255, 255, 255, 0.9);
  width: 100%;
  padding: 0px;
  border: none;
  height: 46px;
  outline: none;
}
.btn_chek {
  width: 70px;
  height: 30px;
  padding: 0px;
  margin-top: -4px;
  background-color: #1875f0;
  border: 2px solid #f5f5f5;
  border-radius: 4px;
  color: #ffffff;
  font-family: Roboto;
  font-size: 9px;
  font-weight: 900;
  line-height: 30px;
  text-transform: uppercase;
}
.btn_delete {
  width: 125px;
  margin-left: 25px;
}
.btn_delete i {
  font-size: 26px;
  color: #f93f3f;
}
.btn_delete span {
  padding: 0px;
  color: #b2b2b2;
  font-family: Roboto;
  font-size: 12px;
  font-weight: 500;
  line-height: 30px;
}
.hor__line__mailbox_groupe{
  position: absolute;
  border-top: 2px solid  #F5F5F5;
  width: 350px;
  left: 0;
}
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
  color: #d8d8d8;
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

.settings__mailbox-bottom {
  display: flex;
  align-items: center;
  margin-bottom: 17px;
  margin-top: 20px;
}

.setting__create-mailbox {
  font-style: normal;
  font-weight: 900;
  font-size: 12px;
  line-height: 50px;
  text-align: center;
  text-transform: uppercase;
  color: #ffffff;
  background: #1875f0;
  max-width: 185px;
  width: 100%;
  border-radius: 4px;
  cursor: pointer;
  margin-right: 70px;
}
.settings__row-numbers select {
  display: inline-block;
  border: none;
  padding: 0;
  width: 30px;
  appearance: none;
  height: 15px;
  position: relative;
  background: none;
  z-index: 22;
  cursor: pointer;
}

.settings__row-numbers::after {
  content: "";
  display: block;
  position: absolute;
  width: 0;
  height: 0;
  top: 68%;
  transform: translate(50%, -50%) rotate(-135deg);
  right: 12px;
  border-right: 2px solid #d8d8d8;
  border-bottom: 2px solid #d8d8d8;
  padding: 3px;
}

.settings__row-numbers select:focus {
  outline: none;
}
.settings__folder-items .errors {
  border: 1px solid red !important;
}
/* переопределение переменных Materialize */

/* Text inputs */
input:not([type]),
input[type="text"]:not(.browser-default),
input[type="password"]:not(.browser-default),
textarea.materialize-textarea {
  border-bottom: none !important;
  color: #999999;
  font-family: Roboto;
  font-size: 12px;
  font-weight: 700;
  line-height: 50px;
}

input:not([type]):focus:not([readonly]),
input[type="text"]:not(.browser-default):focus:not([readonly]),
input[type="password"]:not(.browser-default):focus:not([readonly]),
textarea.materialize-textarea:focus:not([readonly]) {
  border-bottom: none;
  -webkit-box-shadow: none;
  box-shadow: none;
  color: #999999;
  font-family: Roboto;
  font-size: 12px;
  font-weight: 700;
  line-height: 50px;
}
</style>