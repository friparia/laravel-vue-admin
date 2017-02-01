<template lang="pug">
  el-row
    el-col(:span="20",:offset="4").grid-content
      el-row
        el-col(:span="2",:offset="22")
          el-dropdown(v-if="name != null" @command="logOut").hover
            span
              | {{ name }} <i class="el-icon-caret-bottom el-icon--right"></i>
            el-dropdown-menu(slot="dropdown")
              el-dropdown-item(command="logout") 注销
</template>
<script>
export default {
  data () {
    return {
      name: "test"
    };
  },
  methods: {
    logOut: function(){
    }
  }
};
</script>
<style lang="stylus" scoped>
.grid-content
    min-height 60px
    background #fff
    line-height 60px
</style>
