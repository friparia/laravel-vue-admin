<template lang="pug">
el-row.panel
  el-col.panel-top(:span="24")
    el-col(:span="20")
      span
        | LOGO
    el-col.rightbar(:span="4")
      el-dropdown(trigger="click")
        span.el-dark-link 
          | {{ name }}
        el-dropdown-menu(slot="dropdown")
          el-dropdown-item(command="logout")
            | 退出登陆
  el-col.panel-center(:span="24")
    aside(style="width:230px;")
      el-menu(theme="dark",:router="true")
        template(v-for="(menu, index) in menus")
          el-submenu(:index="index + ''", v-if="menu.hasOwnProperty('submenus')")
            template(slot="title") {{ menu.name }}
            template(v-for="(submenu, subindex) in menu.submenus")
              el-menu-item(:index ="submenu.url") {{ submenu.name }}
          el-menu-item(:index = "menu.url", v-else) {{ menu.name }}
    section.panel-c-c
      .grid-content.bg-purple-light
        el-col(:span="24")
          strong(stype="width:200px;float:left;color: #475669;")
            | aaa
        el-col(:span="24", style="background-color:#fff;box-sizing: border-box;")
          router-view
</template>
<script>
export default {
  name: 'home',
  data () {
    return {
      name: "test",
      menus: [
      ]
    };
  },
  created() {
      this.$http.get('/admin/menu').then((res) => {
        this.menus = res.body;
      });
  },
  methods: {
    logOut: function(){
    }
  },
}
</script>

<style>
.panel {
  position: absolute;
  top: 0px;
  bottom: 0px;
  width: 100%;
}

.panel-top {
  height: 60px;
  line-height: 60px;
  background: #1F2D3D;
  color: #c0ccda;
}

.panel-top .rightbar {
  text-align: right;
  padding-right: 35px;
}

.panel-center {
  background: #324057;
  position: absolute;
  top: 60px;
  bottom: 0px;
  overflow: hidden;
}

.panel-c-c {
  background: #f1f2f7;
  position: absolute;
  right: 0px;
  top: 0px;
  bottom: 0px;
  left: 230px;
  overflow-y: scroll;
  padding: 20px;
}

</style>
