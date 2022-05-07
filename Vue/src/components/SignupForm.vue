<template>
	<div @keyup.enter="submitForm">
		<el-form ref="elForm" :model="formData" :rules="rules" size="small" label-width="100px" label-position="left">
			<el-row type="flex" justify="center" align="middle">
				<el-col :span="12">
					<el-form-item label="Email" prop="Email">
						<el-input v-model="formData.Email" placeholder="Email" clearable :style="{ width: '100%' }"> </el-input>
					</el-form-item>
				</el-col>
			</el-row>
			<el-row type="flex" justify="center" align="middle" style="padding-top:30px; padding-bottom: 30px">
				<el-col :span="12">
					<el-form-item label="Password" prop="Password">
						<el-input
							v-model="formData.Password"
							placeholder="Password"
							clearable
							show-password
							:style="{ width: '100%' }"
						></el-input>
						<el-progress :percentage="passwordPercent"></el-progress>
					</el-form-item>
				</el-col>
			</el-row>
			<el-row type="flex" justify="center" align="middle">
				<el-col :span="12">
					<el-form-item label-width="138px" label="Confirm Password" prop="ConfirmPassword">
						<el-input
							v-model="formData.ConfirmPassword"
							placeholder="Confirm Password"
							clearable
							show-password
							:style="{ width: '100%' }"
						></el-input>
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
	import Cookies from 'js-cookie'

	import extractObjectProp from '../js/general_helper'
	export default {
		components: {},
		props: [],
		data() {
			const validatePassword = (rule, value, callback) => {
				if (value === '') {
					callback(new Error('Password cannot be empty'))
				} else {
					var complexity = 0
					if (this.formData.Password !== '') {
						if (this.formData.Password.match(/([a-z])+/)) {
							complexity++
						}
						if (this.formData.Password.match(/([0-9])+/)) {
							complexity++
						}
						if (this.formData.Password.match(/([A-Z])+/)) {
							complexity++
						}
						if (this.formData.Password.match(/([\W])+/)) {
							complexity++
						}
						if (this.formData.Password.length < 6) {
							callback(new Error('The password has to more than 6 characters'))
							complexity = 0
						}
						switch (complexity) {
							case 0:
								this.passwordPercent = 0
								callback(new Error('At least include 1 uppercase, 1 lowercase, 1 symbol and 1 number'))
								break
							case 1:
								this.passwordPercent = 33
								callback(new Error('At least include 1 uppercase, 1 lowercase, 1 symbol and 1 number'))
								break
							case 2:
								this.passwordPercent = 66
								callback(new Error('At least include 1 uppercase, 1 lowercase, 1 symbol and 1 number'))
								break
							case 3:
							case 4:
								this.passwordPercent = 100
								break
							default:
								this.passwordPercent = 0
								break
						}
					}
					callback()
				}
			}
			const validateConfirmPassword = (rule, value, callback) => {
				if (value === '') {
					callback(new Error('Confirm your password'))
				} else {
					if (this.formData.ConfirmPassword !== this.formData.Password) {
						callback(new Error('Passwords do not match'))
					}
					callback()
				}
			}
			return {
				passwordPercent: 0,
				formData: {
					Email: undefined,
					Password: undefined,
					ConfirmPassword: undefined,
				},
				rules: {
					Email: [
						{
							required: true,
							message: 'Email cannot be empty',
							trigger: 'blur',
						},
						{
							pattern: /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.(com|cn|edu))+$/,
							message: 'Wrong Email format',
							trigger: 'blur',
						},
					],
					Password: [
						{ required: true, validator: validatePassword, trigger: ['blur', 'change'] },
					],
					ConfirmPassword: [
						{ required: true, validator: validateConfirmPassword, trigger: ['blur', 'change'] },
					],
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
				this.$refs['elForm'].validate((valid) => {
					if (!valid) return
					if (!this.checkForm(this.formData)) {
						this.showError('Passwords do not match')
						return
					}
					axios
						.post(axios.defaults.baseURL + '/signup.php', extractObjectProp(this.formData))
						.then(function (response) {
							if (response.data.status === 'error') {
								self.showError(response.data.error)
							} else {
								self.$store.commit('setLoading', true)
								setTimeout(() => {
									self.$store.commit('setLoading', false)
									self.$router.push({ name: 'UserHome' })
									self.$message({
										message: 'Welcome!',
										type: 'success',
									})
									Cookies.set('tour', 'true')
								}, 1000)
								self.$store.commit('setToken', response.data.cookie)
								self.$store.commit('setEmail', response.data.email)
								self.$store.commit('setIsLoggedIn', true)
							}
						})
						.catch(function (error) {
							console.log(error)
							self.showError('Server is down')
						})
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
			showError(errMsg) {
				this.$message.error(errMsg)
			},
			serializeFormData(formData) {
				let res = ''
				res += 'Email=' + formData.Email
				res += '&'
				res += 'Password=' + formData.Password
				return res
			},
		},
	}
</script>

<style></style>
