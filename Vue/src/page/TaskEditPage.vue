<template>
  <div class="editForm">
    <el-dialog
          :title="operateType === 'add' ? 'Add a task' : 'Update a task'"
          :visible.sync="isShown"
    >
        <CrudForm
            :formLabel="operateFormLabel"
            :form="operateForm"
            :inline="true"
            ref="form"
        ></CrudForm>
        <div slot="footer" class="dialog-footer">
            <el-button @click="isShow = false">Cancel</el-button>
            <el-button type="primary" @click="confirm">Confirm</el-button>
        </div>
    </el-dialog>
    <TaskTable></TaskTable>
  </div>
</template>

<script>
import CrudForm from "@/components/CrudForm"
import TaskTable from "@/components/TaskTable"
import axios from 'axios'

export default {
  name: 'StackEditPage',
  props: {
    msg: String
  },
  components:{
      CrudForm,
      TaskTable
  },
  data(){
    return {
        operateType:"add",
        isShown: false,
        operateFormLabel:[
            {
                model: 'TaskName',
                label: 'Task Name',
                type: 'input'
            },
            {
                model: 'TaskDescription',
                label: 'Description',
                type: 'input'
            },
            {
                
            }
        ],
        operateForm: {
            name: '',
            addr: '',
            age: '',
            birth: ''
        },
        formLabel:[
            {
                model:"keyword",
                label:'',
                type:'input'
            }
        ],
        searchForm:{
            keyword:''
        }
    }
  },
  methods:{
      confirm(){

      },
      addUser(){
          this.isShown = true
      },
      getList(){

      }
  },
  mounted(){
    let self = this
    this.$store.commit('setLoading', true)
    axios.get(axios.defaults.baseURL + 'task.php' + '?email=' + this.$store.state.user.email)
        .then(function (response) {
        self.$store.commit('setTasks', response.data.tasks)
        console.log(self.$store.state.user.cards)
        })
        .catch(function (error) {
        console.log(error);
    }).finally(()=>{self.$store.commit('setLoading', false)})
  }
}
</script>