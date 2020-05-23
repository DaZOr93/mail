<template>
  <div class="row card-wrapper">
    <div class="col s10 card-title header">
      <span>Личные данные</span>
    </div>
    <ul class="row body">
          <li class="col s12 nav-item" v-for="item in items" :key="item.id">
            <ul class="row">
                <li class="col nav-icon">
                  <span class="valign-wrapper center-align">
                    <i class="material-icons">{{ item.iconName }}</i>
                  </span>
                </li>
                <li class="col s9 valign-wrapper nav-title">
                  <span class>{{ item.navTitleText }}</span>
                </li>
                <li class="col s9 valign-wrapper nav-helper">
                  <span class>{{ item.navHelperText }}</span>
                </li>
              </ul>
          </li>
        </ul>
  </div>
</template>


<script>
export default {
  name: "PersonalData",
  data: function() {
    return {
      items: [
        {
          iconName: "person",
          navHelperText: "Ф И О",
          navTitleText: "Иванов И Р",
        },
        {
          iconName: "cake",
          navHelperText: "Дата рождения",
          navTitleText: "22 Aug 1993",
        },
        {
          iconName: "school",
          navHelperText: "Образование",
          navTitleText: "ДДМА",
        },
        {
          iconName: "work",
          navHelperText: "Место работы",
          navTitleText: "It2.0", 
        },
      ]
    };
  },
  mounted() {

    },
  methods: {
    
  }
}
</script>

<style lang="scss" scoped>

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
}
.body li.nav-item {
  margin-bottom: 15px;
  margin-left: 80px;
}
.nav-icon {
  width: 45px;
  height: 45px;
  /* border: 2px solid #f5f5f5;
  border-radius: 50%; */
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
height: 15px;
color: #cccccc;
font-family: Roboto;
font-size: 11px;
font-weight: 500;
line-height: 15px;
}
.nav-title {
height: 30px;
color: #808080;
font-family: Roboto;
font-size: 13px;
font-weight: 500;
line-height: 30px;
}
</style>