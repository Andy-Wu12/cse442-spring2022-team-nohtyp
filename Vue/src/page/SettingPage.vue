<template>
    <div>
      <!-- <login-form></login-form> -->
      <el-card class="box-card" style="margin-left:auto; margin-right:auto; width:50%; margin-top:10vh">
        <div slot="header" class="clearfix">
            <i class="el-icon-share"></i>
            <span><b> Settings</b></span>
        </div>
        <el-row>
          <el-link :href="icsFile" download="DotPlanEvents.ics" >
            <el-button type="primary" @click="generateIcsFile" icon="el-icon-download" style="width:230px" plain>Export my tasks</el-button>
          </el-link>
        </el-row>
        <el-row>
          <el-button type="primary" @click="handleUpdatePassword" icon="el-icon-edit" style="width:230px; margin-top:15px" plain>Change my password</el-button>
        </el-row>
        <el-row>
          <el-button type="danger" @click="handleDeleteUser" icon="el-icon-delete" style="width:230px; margin-top:15px" plain>Delete my account</el-button>
        </el-row>
      </el-card>    
      <el-dialog
          title="Change password"
          :visible.sync="isDialogShown"
          style="margin-left:auto; margin-right:auto; width:65%"
      >
        <el-form ref="formData" :model="formData" :rules="rules" label-width="180px">
          <el-form-item label="Email" hidden>
            <el-input v-model="formData.email"></el-input>
          </el-form-item>
          <el-form-item label="Old password" prop="password" >
            <el-input v-model="formData.password" clearable
            show-password></el-input>
          </el-form-item>
          <el-form-item label="New password" prop="newPassword">
            <el-input v-model="formData.newPassword" clearable
            show-password></el-input>
          </el-form-item>
          <el-form-item label="Confirm password" prop="confirmPassword">
            <el-input v-model="formData.confirmPassword" clearable
            show-password></el-input>
          </el-form-item>
        </el-form>
        <el-button @click="isDialogShown = false">Cancel</el-button>
        <el-button type="primary" @click="onsubmit">Confirm</el-button>
      </el-dialog>
    </div>
</template>

<script>
  import axios from "axios"
  import extractObjectProp from '../js/general_helper'

  export default({
    components:{
    },
    data(){
      return{
        rules: {
          password: [{
            required: true,
            message: 'Old password is required',
            trigger: 'blur'
          }],
          newPassword: [{
            required: true,
            message: 'Password cannot be empty',
            trigger: 'blur'
          }],
          confirmPassword: [{
            required: true,
            message: 'Password cannot be empty',
            trigger: 'blur'
          }],
        },
        isDialogShown: false,
        icsFile: null,
        selection: 1,
        loading: false,
        formData:{
          email: undefined,
          password: undefined,
          newPassword: undefined,
          confirmPassword: undefined
        }
      }
    },
    computed:{
      email(){
        return this.$store.state.user.email
      }
    },
    methods: {
      handleDeleteUser(){
        let self = this
        this.$confirm('This will permanently delete your account. Continue?', 'Warning', {
          confirmButtonText: 'OK',
          cancelButtonText: 'Cancel',
          type: 'warning'
        }).then(() => {
          axios.delete(axios.defaults.baseURL + '/login.php?email='+ this.email)
          .then(function(response){
              self.$store.commit('setLoading', false)
              if(response.data.status && response.data.status === "success"){
                self.$store.commit('clearToken')
                self.$store.commit('clearEmail')
                self.$store.commit('clearTasks')
                self.$store.commit('clearCards')
                self.$store.commit('clearStacks')
                self.$store.commit('setIsLoggedIn', false)
                self.$store.commit('setLoading', false)
                self.$router.push({name:'UserHome'})
                self.$message({
                  type: 'success',
                  message: 'Deleted successfully'
                })
              }
            })
          }).catch(() => {
        });
      },
      onsubmit(){
        let self = this
        this.formData.email = this.email
        if(this.formData.newPassword !== this.formData.confirmPassword){
          this.$message.error("Passwords do not match");
          return
        }
        this.isDialogShown = false 
        axios.put(axios.defaults.baseURL + '/login.php', extractObjectProp(this.formData))
          .then(function (response) {
            if(response.data.status === "success"){
                self.$store.commit('setLoading', true)
                setTimeout(()=>{
                  self.$store.commit('setLoading', false)
                  self.$message({
                    message: 'Password updated!',
                    type: 'success'
                })
                }, 1000)
            }
            else if(response.data.status === "error"){
              self.$store.commit('setLoading', true)
              setTimeout(()=>{
                self.$store.commit('setLoading', false)
                self.$message.error(response.data.error);
              }, 1000)
            }
          })
        .catch(function (error) {
          self.$message.error("Server is down");
          self.$message.error(error);
        });
      },
      handleUpdatePassword(){
        this.isDialogShown = true
        this.formData.email = this.email
        this.formData.password = undefined
        this.formData.newPassword = undefined
        this.formData.confirmPassword = undefined
      },
      reserve () {
        this.loading = true
        setTimeout(() => (this.loading = false), 2000)
      },
      convertDate(date) {
        let event = new Date(date).toISOString();
        event = event.split("T")[0];
        event = event.split("-");
        event = event.join("");
        return event;
      },
      getNextTaskCounter() {
        // parseInt necessary b/c local storage only stores strings as values
        let nextCounterVal = parseInt(localStorage.userTaskCounter) + 1;
        localStorage.userTaskCounter = nextCounterVal;
        return nextCounterVal;
      },
      addEventDataToICSFile(taskJson) {
        let data_blob = "BEGIN:VEVENT\n";

        // Use session email as LHS of uid + incremented task counter to guarantee uniqueness
        let uid = `${this.email}${taskJson.taskID}@cse442NohTypDotPlan`;
        let due_date = null;
        let start_date = this.convertDate(Date.now());
        if (taskJson["due_date"] != null) {
            console.log("Task with due date!")
            due_date = this.convertDate(taskJson["due_date"]);
        }
        let summary = taskJson["name"];
        let desc = taskJson["description"];

        data_blob +=
            `UID:${uid}\n` +
            `DTSTART:${start_date}\n` +
            `SUMMARY:${summary}\n` +
            `DESCRIPTION:${desc}\n`;

        if (due_date != null) {
            data_blob += `DTEND:${due_date}\n`;
        }
        data_blob += "END:VEVENT\n";
        return data_blob;
      },
      generateIcsFile(showWarning){
        const tasksJsonArray = this.$store.state.user.tasks
        if(!this.$store.state.user.tasks || this.$store.state.user.tasks.length === 0){
          if(showWarning)
            this.$message({
              message: 'You have no tasks to export!',
              type: 'warning'
            });
          return
        }
        let blob =
          "BEGIN:VCALENDAR\n" +
          "VERSION:2.0\n" +
          "PRODID:-//Dot-Plan-Cal//EN\n" +
          "CALSCALE:GREGORIAN\n" +
          "METHOD:PUBLISH\n";
          for (let i = 0; i < tasksJsonArray.length; i++) {
              blob += this.addEventDataToICSFile(tasksJsonArray[i]);
          }
        blob += "END:VCALENDAR\n";
        let data = new File([blob], "DotPlanEvents.ics", { type: "text/calendar"});
        if (this.icsFile !== null) {
          window.URL.revokeObjectURL(this.icsFile);
        }   
        this.icsFile = window.URL.createObjectURL(data);
        // window.location.href = this.icsFile
        return this.icsFile;
      },
    },
    mounted() {
      setTimeout(()=>{
        this.generateIcsFile(false)
      }, 800)
    },
  })
</script>

<style scoped>
</style>>