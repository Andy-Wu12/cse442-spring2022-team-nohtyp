<template>
    <div>
      <!-- <login-form></login-form> -->
      <el-card class="box-card"
       style="margin-left:auto; width:750px; margin-right:auto; margin-top:10vh">
        <div slot="header" class="clearfix">
          <span>Sign Up</span>  
        </div>
      <SignupForm></SignupForm>
      </el-card>
    </div>
</template>

<script>
  // import LoginForm from "@/components/LoginForm.vue";
  import SignupForm from "@/components/SignupForm.vue";
  export default({
    components:{
      // LoginForm,
      SignupForm
    }
  })
</script>

<style scoped>
</style>>