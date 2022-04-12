<template>
  <div>
    <el-row>
      <el-col>
          <el-button type="primary" style="float:left" @click="handleAdd()">Add</el-button>
      </el-col>
    </el-row>
    <el-dialog
          :title="operateType === 'add' ? 'Add a task' : 'Update a task'"
          :visible.sync="isDialogShown"
    >
      <el-form ref="form" :model="form" label-width="120px">
        <el-form-item label="Card ID" required="">
          <el-select v-model="form.cardID" placeholder="select one card" style="float:left">
            <el-option value='item.name' v-show="this.$store.state.user.cards.length === 0" disabled>You don't have any card yet</el-option>
            <el-option v-for="item in this.$store.state.user.cards" :key="item.cardID" :value='item.name'>{{item.name}}</el-option>
          </el-select>
        </el-form-item>
        <el-form-item label="Task Name">
          <el-input v-model="form.name"></el-input>
        </el-form-item>
        <el-form-item label="Task Description">
          <el-input v-model="form.description"></el-input>
        </el-form-item>
        <el-form-item label="Due Date">
          <el-date-picker
            v-model="form.due_date"
            type="datetime"
            placeholder="Select date and time"
            style="float:left"
            :picker-options="pickerOptions">
          </el-date-picker>
        </el-form-item>
        <el-form-item label="Email" v-show="operateType !== 'add'">
          <el-input v-model="form.Email"></el-input>
        </el-form-item>
        <el-form-item label="Extra Notes">
          <el-input v-model="form.extra_notes"></el-input>
        </el-form-item>
        <el-form-item label="Task ID" v-show="operateType !== 'add'">
          <el-input v-model="form.taskID"></el-input>
        </el-form-item>
      </el-form>
        <div slot="footer" class="dialog-footer">
            <el-button @click="isDialogShown = false">Cancel</el-button>
            <el-button type="primary" @click="onsubmit">Confirm</el-button>
        </div>
    </el-dialog>
    <el-table
      :data="this.$store.state.user.tasks.filter(data => !taskSearch || data.name.toLowerCase().includes(taskSearch.toLowerCase()))"
      style="width: 100%"
      >
      <el-table-column
        sortable
        label="Task Name"
        prop="name">
      </el-table-column>
      <el-table-column
        sortable
        label="Description"
        prop="description">
      </el-table-column>
      <el-table-column
        sortable
        label="Due Date"
        prop="due_date">
      </el-table-column>
      <el-table-column
        sortable
        label="Extra Notes"
        prop="extra_notes">
      </el-table-column>
      <el-table-column
        align="right">
        <template slot="header" slot-scope="scope">
          <el-input
            @click="console.log(scope)"
            v-model="taskSearch"
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
    data() {
      return {
        taskSearch:'',
        operateType:'add',
        isDialogShown: false,
        form: {
          cardID: undefined,
          description: '',
          due_date: undefined,
          Email: '',
          extra_notes: '',
          name: '',
          taskID: -1 
        },
        pickerOptions: {
          shortcuts: [{
            text: 'Today',
            onClick(picker) {
              picker.$emit('pick', new Date());
            }
          }, {
            text: 'Tomorrow',
            onClick(picker) {
              const date = new Date();
              date.setTime(date.getTime() + 3600 * 1000 * 24);
              picker.$emit('pick', date);
            }
          }, {
            text: 'A week later',
            onClick(picker) {
              const date = new Date();
              date.setTime(date.getTime() + 3600 * 1000 * 24 * 7);
              picker.$emit('pick', date);
            }
          }]
        }
      }
    },
    computed:{
    },
    methods: {
      handleEdit(index, row) {
        console.log(index, row);
        this.isDialogShown = true
        this.operateType = 'edit'
        this.form.cardID = row.cardID
        this.form.description = row.description
        this.form.due_date = row.due_date
        this.form.Email = row.email
        this.form.extra_notes = row.extra_notes
        this.form.name = row.name
        this.form.taskID = row.taskID
      },
      handleDelete(index, row) {
        console.log(index, row);
      },
      handleAdd(){
        this.form.name = ''
        this.form.Email = this.$store.state.user.email
        this.isDialogShown = true
        this.operateType = 'add'
      },
      onsubmit(){
        if(this.operateType === 'add'){
          axios.post(axios.defaults.baseURL + '/task.php', extractObjectProp(this.form))
        }
      },
    },
    mounted(){
      let self = this
      this.$store.commit('setLoading', true)
      axios.get(axios.defaults.baseURL + 'task.php' + '?email=' + this.$store.state.user.email)
        .then(function (response) {
          self.$store.commit('setTasks', response.data.tasks)
        })
        .catch(function (error) {
          console.log(error);
      }).finally(()=>{self.$store.commit('setLoading', false)})
    }
  }
</script>