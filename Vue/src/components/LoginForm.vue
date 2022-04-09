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

export default {
  components: {},
  props: [],
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
        const serializedFormData = this.serializeFormData(this.formData)
        axios.post('./php/login.php', serializedFormData)
          .then(function (response) {
            console.log(response)
            if(response.data === "Login Success"){
                self.$message({
                    message: 'Login Success!',
                    type: 'success'
                });
            }
            else{
                self.showError(response.data)
            }
          })
          .catch(function (error) {
            console.log(error);
            self.showError("Server is down")
          });
      })
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
