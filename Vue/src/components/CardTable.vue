<template>
  <div>
    <el-row>
      <el-col>
          <el-button type="primary" style="float:left" @click="handleAdd()">Add</el-button>
      </el-col>
    </el-row>
    <el-dialog
          :title="operateType === 'add' ? 'Add a card' : 'Update a card'"
          :visible.sync="isDialogShown"
    >
      <el-form ref="form" :model="form" label-width="120px">
        <el-form-item label="Card Name">
          <el-input v-model="form.cardName"></el-input>
        </el-form-item>
        <el-form-item label="Stack Name" required="">
          <el-select v-model="form.stackID" placeholder="select one stack" style="float:left">
            <el-option value='item.name' v-show="this.$store.state.user.stacks.length === 0" disabled>You don't have any card yet</el-option>
            <el-option v-for="item in this.$store.state.user.stacks" :key="item.stackID" :value='item.name'>{{item.name}}</el-option>
          </el-select>
        </el-form-item>
        <el-form-item label="Card ID" hidden>
          <el-input v-model="form.cardID"></el-input>
        </el-form-item>
        <el-form-item label="Description">
          <el-input v-model="form.description"></el-input>
        </el-form-item>
        <el-form-item label="Extra Notes">
          <el-input v-model="form.extra_notes"></el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
          <el-button @click="isDialogShown = false">Cancel</el-button>
          <el-button type="primary" @click="onsubmit">Confirm</el-button>
      </div>
    </el-dialog>
    <el-table
      :data="cards.filter(data => !cardSearch || data.name.toLowerCase().includes(cardSearch.toLowerCase()))"
      style="width: 100%"
      >
      <el-table-column
        sortable
        label="Stack"
        prop="stackName">
      </el-table-column>
      <el-table-column
        sortable
        label="Card Name"
        prop="name">
      </el-table-column>
      <el-table-column
        sortable
        label="Description"
        prop="description">
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
            v-model="cardSearch"
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
        cardSearch: '',
        operateType:'add',
        isDialogShown: false,
        form: {
          Email:'',
          cardName:'',
          cardID: undefined,
          description:'',
          extra_notes:'',
          stackID: undefined
        },
      }
    },
    computed:{
      cards(){
        let original_cards = this.$store.state.user.cards
        for(let i = 0; i <original_cards.length; i++){
          const stackID = original_cards[i]['stackID']
          original_cards[i]['stackName'] = this.getStackNameByStackId(stackID)
        }
        return original_cards
      }
    },
    methods: {
      getCards(){
        let self = this
        axios.get(axios.defaults.baseURL + 'card.php' + '?email=' + this.$store.state.user.email)
          .then(function (response) {
            self.$store.commit('setCards', response.data.cards)
          })
          .catch(function (error) {
            console.log(error);
        });
      },
      handleEdit(index, row) {
        console.log(index, row);
        this.isDialogShown = true
        this.operateType = 'edit'
        this.form.cardName = row.name
        this.form.Email = row.email
        this.form.cardID = row.cardID
        this.form.description = row.description
        this.form.extra_notes = row.extra_notes
        this.form.stackID = this.getStackNameByStackId(row.stackID)
      },
      handleDelete(index, row) {
        const self = this
        this.$confirm('Are you sure to delete this card?', 'Warning', {
          confirmButtonText: 'OK',
          cancelButtonText: 'Cancel',
          type: 'warning'
        }).then(() => {
          this.$store.commit('setLoading', true)
          axios.delete(axios.defaults.baseURL + '/card.php?cardID='+ row.cardID)
          .then(function(response){
              self.$store.commit('setLoading', false)
              if(response.data.status && response.data.status === "success"){
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
        this.form.cardName = ''
        this.form.Email = this.$store.state.user.email
        this.form.description = ''
        this.form.extra_notes = ''
        this.form.stackID = ''
        this.isDialogShown = true
        this.operateType = 'add'
      },
      getStackIdByStackName(name){
        const stacks = this.$store.state.user.stacks
        for(let i = 0;i < stacks.length ;i++){
          if(stacks[i].name === name)
            return stacks[i].stackID
        }
        return undefined
      },
      getStackNameByStackId(id){
        const stacks = this.$store.state.user.stacks
        console.log(stacks[0])
        for(let i = 0;i < stacks.length ;i++){
          if(stacks[i].stackID === id)
            return stacks[i].name
        }
        return ''
      },
      onsubmit(){
        const self = this
        this.isDialogShown = false
        this.form.stackID = this.getStackIdByStackName(this.form.stackID)
        axios({
          method: this.operateType === 'add' ? 'post' : 'put',
          url: axios.defaults.baseURL + '/card.php',
          data: extractObjectProp(this.form)
        }).then(function(response){
            self.$store.commit('setLoading', false)
            if(response.data.status && response.data.status === "success"){
              self.getCards()
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