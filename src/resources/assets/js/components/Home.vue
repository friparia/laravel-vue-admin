<template lang="pug">
  el-row.container
    Sidebar
    Headmenu
    el-row
      el-col(:span="20",:offset="4")
      router-view
</template>
<script>
import Headmenu from './HeadMenu'
import Sidebar from './Sidebar'
export default {
  name: 'home',
  components: {
    Headmenu,
    Sidebar
  }
}
</script>

<style lang="stylus">
#app,
.container
  height 100%
</style>
