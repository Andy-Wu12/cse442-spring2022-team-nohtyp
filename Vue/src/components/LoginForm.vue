<template>
  <div>
    <el-form ref="elForm" :model="formData" :rules="rules" size="small" label-width="100px"
      label-position="left">
      <el-row type="flex" justify="center" align="middle">
        <el-col :span="6">
          <el-form-item label="Email" prop="Email">
            <el-input v-model="formData.Email" placeholder="Email" clearable :style="{width: '100%'}">
            </el-input>
          </el-form-item>
        </el-col>
      </el-row>
      <el-row type="flex" justify="center" align="middle">
        <el-col :span="6">
          <el-form-item label="Password" prop="Password">
            <el-input v-model="formData.Password" placeholder="Password" clearable show-password
              :style="{width: '100%'}"></el-input>
          </el-form-item>
        </el-col>
      </el-row>
      <el-form-item size="large">
        <el-button type="primary" @click="submitForm">Log In</el-button>
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
  props: ['isLoggedIn'],
  data() {
    return {
      formData: {
        Email: undefined,
        Password: undefined,
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
        axios.post('http://localhost:3000/login.php', extractObjectProp(this.formData))
          .then(function (response) {
            if(response.data.status === "success"){
                self.$message({
                    message: 'Login Success!',
                    type: 'success'
                })
                self.$store.commit('setToken', response.data.token)
                self.$store.commit('setEmail', response.data.email)
                self.$router.push({name: 'UserHome'})
            }
            else if(response.data.status === "error"){
                self.showError(response.data.error)
            }
          })
          .catch(function (error) {
            console.log(error);
            self.showError("Server is down")
          });
      })
      console.log(this.isLoggedIn)
    },
    showError(errMsg){
      this.$message.error(errMsg);
    },
  }
}
</script>

<style>
</style>
