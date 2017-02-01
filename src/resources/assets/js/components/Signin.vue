<template lang="pug">
  el-col#login(:span = "6",:offset="9") 
    .title 登录
    el-input.usr-input(v-for="item in info",:type="item.type",:placeholder="item.text",v-model="login[item.name]",@keyup.enter.native="signin") {{item.text}}
    el-button.login-button(type="primary",@click="signin") 登录
</template>
<script>
export default {
  data() {
    return {
      info: [{
        text: "请输入您的账号",
        name: "username",
        type: "text"
      },{
        text: "请输入您的密码",
        name: "password",
        type: "password"
      }],
      login:{
        username: "",
        password: "",
      }
    }
  },
  methods:{
    signin(event){
      event.preventDefault()
      this.$http.post('/admin/auth/signin', {
        username: this.login.username,
        password: this.login.password,
      }).then((res) => {
        if(res.body.success == true){
          localStorage.setItem('token', res.body.token);
          this.$message({
            message: '恭喜你，登录成功',
            type: 'success'
          });
          this.$router.push('/')
        }else{
          this.$message.error(res.body.msg);
          localStorage.setItem('token', null)
        }
      },(err) => {
        console.log(err);
      });
    }
  }
}
</script>
<style lang="stylus" scoped>
  #login
    margin-top 3rem
    position relative
    .title
      color light-bl
      margin-bottom 1rem
      text-align center
    .usr-input
      margin-bottom 0.5rem
    .refresh
      position absolute
      bottom 2.35rem
      right 0
      height 1.75rem
      border-radius 0 4px 4px 0
    .login-button
      width 100%
      margin-left 0
</style>
