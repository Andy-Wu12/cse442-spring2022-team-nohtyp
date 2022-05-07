<template>
    <div>
      <UserTaskChart></UserTaskChart>
    </div>
</template>

<script>
  import UserTaskChart from "@/components/UserTaskChart"
  export default({
    components:{
      // LoginForm,
      UserTaskChart
    },
    data(){
      return {
        url:'https://fuss10.elemecdn.com/e/5d/4a731a90594a4af544c0c25941171jpeg.jpeg'
      }
    }
  })
</script>

<style scoped>
</style>>