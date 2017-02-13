<template lang="pug">
  #app
    router-view
</template>
<script>
export default {
  name: 'app',
  components:{
  }
}
</script>
<style>
body {
  /*background-color: #324057;*/
  margin: 0px;
  padding: 0px;
  /*background: url(assets/bg1.jpg) center !important;
  background-size: cover;*/
background: #1F2D3D;
font-family: Helvetica Neue, Helvetica, PingFang SC, Hiragino Sans GB, Microsoft YaHei, SimSun, sans-serif;
/*font-weight: 400;*/
font-size:14px;
-webkit-font-smoothing: antialiased;
}
#app {
  position: absolute;
  top: 0px;
  bottom: 0px;
  width: 100%;
}
</style>
