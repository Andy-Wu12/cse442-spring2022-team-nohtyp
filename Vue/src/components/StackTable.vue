<template>
  <div>
    <el-row>
      <el-col>
          <el-button type="primary" style="float:left" @click="handleAdd()">Add</el-button>
      </el-col>
    </el-row>
    <el-dialog
          :title="operateType === 'add' ? 'Add a stack' : 'Update a stack'"
          :visible.sync="isDialogShown"
    >
      <el-form ref="form" :model="form" label-width="120px">
        <el-form-item label="Stack Name">
          <el-input v-model="form.stackName"></el-input>
        </el-form-item>
      </el-form>
        <div slot="footer" class="dialog-footer">
            <el-button @click="isDialogShown = false">Cancel</el-button>
            <el-button type="primary" @click="onsubmit">Confirm</el-button>
        </div>
    </el-dialog>
    <el-table
      :data="stacks.filter(data => !stackSearch || data.name.toLowerCase().includes(stackSearch.toLowerCase()))"
      style="width: 100%"
      >
      <el-table-column
        sortable
        label="Stack"
        prop="name">
      </el-table-column>
      <el-table-column
        align="right"
        >
        <template slot="header" slot-scope="scope">
          <el-input
            @click="console.log(scope)"
            v-model="stackSearch"
            placeholder="Type to search"/>
        </template>
        <template slot-scope="scope">
          <el-button
            @click="handleEdit(scope.$index, scope.row)">Edit</el-button>
          <el-button
            type="danger"
            @click="handleDelete(scope.$index, scope.row)">Delete</el-button>
        </template>
      </el-table-column>
    </el-table>
  </div>
</template>

<script>
  import axios from 'axios'
  import extractObjectProp from '../js/general_helper'

  export default {
    components:{
    },
    data() {
      return {
        stackSearch: '',
        operateType:'add',
        isDialogShown: false,
        form: {
          Email:'',
          stackName:'',
          stackID: -1
        },
      }
    },
    computed:{
      stacks(){
        return this.$store.state.user.stacks
      }
    },
    methods: {
      handleEdit(index, row) {
        console.log(index, row);
        this.isDialogShown = true
        this.operateType = 'edit'
        this.form.stackName = row.name
        this.form.Email = row.email
        this.form.stackID = row.stackID
      },
      handleDelete(index, row) {
        const self = this
        this.$confirm('Are you sure to delete this stack?', 'Warning', {
          confirmButtonText: 'OK',
          cancelButtonText: 'Cancel',
          type: 'warning'
        }).then(() => {
          this.$store.commit('setLoading', true)
          axios.delete(axios.defaults.baseURL + '/stack.php?stackID='+ row.stackID)
          .then(function(response){
              self.$store.commit('setLoading', false)
              if(response.data.status && response.data.status === "success"){
                self.getStacks()
                self.getCards()
                self.$message({
                  type: 'success',
                  message: 'Deleted successfully'
                })
              }
            })
        }).catch(() => {
        });
      },
      handleAdd(){
        this.form.stackName = ''
        this.form.Email = this.$store.state.user.email
        this.isDialogShown = true
        this.operateType = 'add'
      },
      onsubmit(){
        const self = this
        this.isDialogShown = false
        axios({
          method: this.operateType === 'add' ? 'post' : 'put',
          url: axios.defaults.baseURL + '/stack.php',
          data: extractObjectProp(this.form)
        }).then(function(response){
            self.$store.commit('setLoading', false)
            if(response.data.status && response.data.status === "success"){
              self.getStacks()
              self.$message({
                type: 'success',
                message: self.operateType === 'add' ? 'Added successfully':'Updated successfully'
              })
            }
            else if(response.data.status && response.data.status === "error"){
              self.$message({
                type: 'error',
                message: response.data.error
              })
            }
          })
      },
    },
    mounted(){
      let self = this
      this.$store.commit('setLoading', true)
      axios.get(axios.defaults.baseURL + 'stack.php' + '?email=' + this.$store.state.user.email)
        .then(function (response) {
          self.$store.commit('setStacks', response.data.stacks)
        })
        .catch(function (error) {
          console.log(error);
      }).finally(()=>{self.$store.commit('setLoading', false)})
    }
  }
</script>