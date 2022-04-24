<template>
  <div class="editForm">
    <StackTable></StackTable>
  </div>
</template>

<script>
import StackTable from "@/components/StackTable"

export default {
  name: 'StackEditPage',
  props: {
    msg: String
  },
  components:{
      StackTable
  },
  data(){
    return {
        operateType:"add",
        isDialogShown: false,
    }
  },
  methods:{
  }
}
</script>