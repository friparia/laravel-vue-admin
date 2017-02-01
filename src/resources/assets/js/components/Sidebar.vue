<template lang="pug">
  el-col(:span="4").side-bar
    #logo
      | LOGO
    el-menu(theme="dark",:router="true")
      template(v-for="(menu, index) in menus")
        el-submenu(:index="String(index)", v-if="menu.hasOwnProperty('submenus')")
          template(slot="title") {{ menu.name }}
          template(v-for="(submenu, subindex) in menu.submenus")
            el-menu-item(:index ="String(index) + '-' + String(subindex)") {{ submenu.name }}
        el-menu-item(:index = "String(index)", v-else) {{ menu.name }}
</template>

<script>
export default {
  name: 'Sidebar',
  data () {
    return {
      menus: [
      ]
    }
  },
  created() {
      var self = this;
      $.get('/admin/menu', function(data){
          self.menus = data;
      });
  }
};
</script>

<style lang="stylus" scoped>
#logo
  height 60px
  background-color light-blk
  color wt
  line-height 60px
.el-menu
  text-align left
  border-radius 0
.side-bar
  height 100%
  background-color light-blk
  position fixed
  z-index 10
.el-menu--dark
  a
    cleanA(wt)
  .el-menu-item
    background-color blk
    height 2.5rem
    line-height 2.5rem
    &.is-active
      background bl
      color dark-wt
    &:hover
      color wt
</style>
