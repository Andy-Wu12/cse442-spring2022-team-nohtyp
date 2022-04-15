<template>
    <div>
      <!-- <login-form></login-form> -->
      <el-card class="box-card"
       style="margin-left:auto; margin-right:auto; width:50%; margin-top:10vh">
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