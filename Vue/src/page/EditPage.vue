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
    <CrudTable></CrudTable>
  </div>
</template>

<script>
import CrudForm from "@/components/CrudForm"
import CrudTable from "@/components/CrudTable"

export default {
  name: 'EditPage',
  props: {
    msg: String
  },
  components:{
      CrudForm,
      CrudTable
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
  }
}
</script>