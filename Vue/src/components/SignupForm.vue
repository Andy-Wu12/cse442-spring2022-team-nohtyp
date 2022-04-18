<template>
  <div @keyup.enter="submitForm">
    <el-form ref="elForm" :model="formData" :rules="rules" size="small" label-width="100px"
      label-position="left">
      <el-row type="flex" justify="center" align="middle">
        <el-col :span="12">
          <el-form-item label="Email" prop="Email">
            <el-input v-model="formData.Email" placeholder="Email" clearable :style="{width: '100%'}">
            </el-input>
          </el-form-item>
        </el-col>
      </el-row>
      <el-row type="flex" justify="center" align="middle">
        <el-col :span="12">
          <el-form-item label="Password" prop="Password">
            <el-input v-model="formData.Password" placeholder="Password" clearable show-password
              :style="{width: '100%'}"></el-input>
          </el-form-item>
        </el-col>
      </el-row>
      <el-row type="flex" justify="center" align="middle">
        <el-col :span="12">
          <el-form-item label-width="138px" label="Confirm Password" prop="ConfirmPassword">
            <el-input v-model="formData.ConfirmPassword" placeholder="Confirm Password" clearable
              show-password :style="{width: '100%'}"></el-input>
          </el-form-item>
        </el-col>
      </el-row>
      <el-form-item size="large">
        <el-button type="primary" @click="submitForm">Sign Up</el-button>
        <el-button @click="resetForm">Reset</el-button>
      </el-form-item>
    </el-form>
  </div>
</template>

<script>
// import $ from "jquery"
import axios from 'axios'
import extractObjectProp from '../js/general_helper'
export default {
  components: {},
  props: [],
  data() {
    return {
      formData: {
        Email: undefined,
        Password: undefined,
        ConfirmPassword: undefined,
      },
      rules: {
        Email: [{
          required: true,
          message: 'Email cannot be empty',
          trigger: 'blur'
        }, {
          pattern: /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.(com|cn|edu))+$/,
          message: 'Wrong Email format',
          trigger: 'blur'
        }],
        Password: [{
          required: true,
          message: 'Password is required',
          trigger: 'blur'
        }],
        ConfirmPassword: [{
          required: true,
          message: 'Password cannot be empty',
          trigger: 'blur'
        }],
      },
    }
  },
  computed: {},
  watch: {},
  created() {},
  mounted() {},
  methods: {
    submitForm() {
      var self = this
      this.$refs['elForm'].validate(valid => {
        if (!valid) return
        if(!this.checkForm(this.formData)){
          this.showError('Passwords do not match');
          return
        }
        console.log(extractObjectProp(this.formData))
        axios.post(axios.defaults.baseURL + '/signup.php', extractObjectProp(this.formData))
          .then(function (response) {
            if(response.data.status === "error"){
              self.showError(response.data.error)
            }
            else{
              self.$store.commit('setLoading', true)
              setTimeout(()=>{
                self.$store.commit('setLoading', false)
                self.$router.push({name: 'UserHome'})
                self.$message({
                  message: 'Welcome!',
                  type: 'success'
              })
              }, 1000)
              self.$store.commit('setToken', response.data.token)
              self.$store.commit('setEmail', response.data.email)
              self.$store.commit('setIsLoggedIn', true)
            }
          })
          .catch(function (error) {
            console.log(error);
            self.showError("Server is down")
          });
      })
    },
    resetForm() {
      this.$refs['elForm'].resetFields()
    },
    checkForm(formData) {
      const pwd = formData.Password
      const confirmPwd = formData.ConfirmPassword
      return pwd === confirmPwd
    },
    showError(errMsg){
      this.$message.error(errMsg);
    },
    serializeFormData(formData){
      let res = ''
      res += ('Email=' + formData.Email)
      res += '&'
      res += ('Password=' + formData.Password)
      return res
    }
  }
}
</script>

<style>
</style>
