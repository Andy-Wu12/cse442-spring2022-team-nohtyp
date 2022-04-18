<template>
  <el-select v-model="value" placeholder="Select">
    <el-option-group
      v-for="group in options"
      :key="group.label"
      :label="group.label">
      <el-option
        v-for="item in group.options"
        :key="item.value"
        :label="item.label"
        :value="item.value">
      </el-option>
    </el-option-group>
  </el-select>
</template>

<script>
  export default {
    mounted(){
      this.getStacks()
      this.getCards()
      this.getTasks()
    },
    computed:{
      stackOption(){
        let options = []
        const currStacks = this.$store.state.user.stacks
        for(let i = 0; i < currStacks.length;i++){
          const newStackOption = {}
          newStackOption['value'] = currStacks[i].name
          newStackOption['label'] = currStacks[i].name
          options.push(newStackOption)
        }
        return {
          label: 'Stacks',
          options: options
        }
      },
      option2(){
        return {
          label: 'City name',
          options: [{
            value: 'Chengdu',
            label: 'Chengdu'
          }, {
            value: 'Shenzhen',
            label: 'Shenzhen'
          }, {
            value: 'Guangzhou',
            label: 'Guangzhou'
          }, {
            value: 'Dalian',
            label: 'Dalian'
          }]
        }
      },
      options(){
        let res = []
        res.push(this.stackOption)
        res.push(this.option2)
        return res
      }
    },
    data() {
      return {
        value: ''
      }
    }
  }
</script>