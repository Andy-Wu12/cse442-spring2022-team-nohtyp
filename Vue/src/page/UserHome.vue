<template>
    <div>
        <HelloWorld></HelloWorld>
        <CardsStack v-show="this.$store.state.user.tasks.length > 0"></CardsStack>
        <LandingPage v-if="!this.$store.state.user.isLoggedIn"></LandingPage>
        <el-result icon="success" 
            style="padding-top:200px"
            title="You have finished all your tasks!"
            v-if="this.$store.state.user.isLoggedIn && this.$store.state.user.tasks.length === 0"
        >
        </el-result>
        <!-- <TaskSelector></TaskSelector> -->
        <TaskCascader v-if="this.$store.state.user.isLoggedIn"></TaskCascader>
    </div>
</template>

<script>
    import HelloWorld from "../components/HelloWorld"
    import CardsStack from "../components/CardsStack"
    import LandingPage from "../page/LandingPage"
    // import TaskSelector from "@/components/TaskSelector"
    import TaskCascader from "@/components/TaskCascader"

    export default({
        mounted() {
            this.updateAllData()
        },
        components:{
            HelloWorld,
            CardsStack,
            LandingPage,
            // TaskSelector,
            TaskCascader
        },
        computed:{
            hasTasks(){
                return this.$store.state.user.tasks.length > 0 
            },
            tasksDisplaying(){
                return this.$store.state.displayingCardID !== undefined
            }
        }
    })    
</script>

<style>
</style>