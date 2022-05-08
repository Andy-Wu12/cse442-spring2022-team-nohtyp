<template>
    <div>
      <el-card class="box-card"
       style="margin-left:auto; margin-right:auto; width:750px; margin-top:10vh">
        <div slot="header" class="clearfix">
          <span>Login</span>
        </div>
        <LoginForm></LoginForm>
      </el-card>
    </div>
</template>

<script>
  import LoginForm from "@/components/LoginForm"
  export default({
    components:{
      // LoginForm,
      LoginForm
    },
    data(){
      return {
        url:'https://fuss10.elemecdn.com/e/5d/4a731a90594a4af544c0c25941171jpeg.jpeg'
      }
    }
  })
</script>

<style scoped>
</style>>