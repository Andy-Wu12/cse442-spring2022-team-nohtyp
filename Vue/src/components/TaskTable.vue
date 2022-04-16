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
        <el-form-item label="Card" required="">
          <el-select v-model="form.cardID" placeholder="select one card" style="float:left">
            <el-option value='item.name' v-show="this.$store.state.user.cards.length === 0" disabled>You don't have any card yet</el-option>
            <el-option v-for="item in this.$store.state.user.cards" :key="item.cardID" :value='item.name'>{{item.name}}</el-option>
          </el-select>
        </el-form-item>
        <el-form-item label="Task Name">
          <el-input v-model="form.taskName"></el-input>
        </el-form-item>
        <el-form-item label="Task Description">
          <el-input v-model="form.description"></el-input>
        </el-form-item>
        <el-form-item label="Due Date">
          <el-date-picker
            v-model="form.due_date"
            type="datetime"
            format="yyyy-MM-dd HH:mm"
            placeholder="Select date and time"
            style="float:left"
            :picker-options="pickerOptions">
          </el-date-picker>
        </el-form-item>
        <el-form-item label="Email" v-show="operateType !== 'add'" hidden>
          <el-input v-model="form.Email"></el-input>
        </el-form-item>
        <el-form-item label="Extra Notes">
          <el-input v-model="form.extra_notes"></el-input>
        </el-form-item>
        <el-form-item label="Task ID" v-show="operateType !== 'add'" hidden>
          <el-input v-model="form.taskID"></el-input>
        </el-form-item>
      </el-form>
        <div slot="footer" class="dialog-footer">
            <el-button @click="isDialogShown = false">Cancel</el-button>
            <el-button type="primary" @click="onsubmit">Confirm</el-button>
        </div>
    </el-dialog>
    <el-table
      :data="tasks.filter(data => !taskSearch || data.name.toLowerCase().includes(taskSearch.toLowerCase()))"
      style="width: 100%"
      >
      <el-table-column
        sortable
        label="Card"
        prop="cardName">
      </el-table-column>
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
    components:{
    },
    mounted() {
      this.getCards()
    },
    data() {
      return {
        taskSearch: '',
        operateType:'add',
        isDialogShown: false,
        form: {
          Email:'',
          taskName:'',
          taskID: undefined,
          description:'',
          extra_notes:'',
          cardID: undefined,
          due_date: undefined
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
      tasks(){
        let original_tasks = this.$store.state.user.tasks
        for(let i = 0; i <original_tasks.length; i++){
          const cardID = original_tasks[i]['cardID']
          original_tasks[i]['cardName'] = this.getCardNameByCardId(cardID)
        }
        return original_tasks
      }
    },
    methods: {
      handleEdit(index, row) {
        this.isDialogShown = true
        this.operateType = 'edit'
        this.form.taskName = row.name
        this.form.Email = row.email
        this.form.taskID = row.taskID
        this.form.description = row.description
        this.form.extra_notes = row.extra_notes
        this.form.due_date = row.due_date
        this.form.cardID = this.getCardNameByCardId(row.cardID)
      },
      handleDelete(index, row) {
        const self = this
        this.$confirm('Are you sure to delete this task?', 'Warning', {
          confirmButtonText: 'OK',
          cancelButtonText: 'Cancel',
          type: 'warning'
        }).then(() => {
          this.$store.commit('setLoading', true)
          axios.delete(axios.defaults.baseURL + '/task.php?taskID='+ row.taskID)
          .then(function(response){
              self.$store.commit('setLoading', false)
              if(response.data.status && response.data.status === "success"){
                self.getCards()
                self.getTasks()
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
        this.form.taskName = ''
        this.form.Email = this.$store.state.user.email
        this.form.description = ''
        this.form.extra_notes = ''
        this.form.cardID = ''
        this.form.due_date = undefined
        this.isDialogShown = true
        this.operateType = 'add'
      },
      getCardNameByCardId(id){
        const cards = this.$store.state.user.cards
        for(let i = 0;i < cards.length ;i++){
          if(cards[i].cardID === id)
            return cards[i].name
        }
        return ''
      },
      onsubmit(){
        const self = this
        this.isDialogShown = false
        // this.form.due_date = this.form.due_date.substring(0, this.form.due_date.length - 4);
        this.form.cardID = this.getCardIdByCardName(this.form.cardID)
        axios({
          method: this.operateType === 'add' ? 'post' : 'put',
          url: axios.defaults.baseURL + '/task.php',
          data: extractObjectProp(this.form)
        }).then(function(response){
            self.$store.commit('setLoading', false)
            if(response.data.status && response.data.status === "success"){
              self.getCards()
              self.getTasks()
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
  }
</script>