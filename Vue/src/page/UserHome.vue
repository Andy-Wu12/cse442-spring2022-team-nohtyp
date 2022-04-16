<template>
    <div>
        <HelloWorld></HelloWorld>
        <CardsStack v-if="hasTasks"></CardsStack>
        <LandingPage v-show="!this.$store.state.user.isLoggedIn"></LandingPage>
        <el-empty description="You don't have any task" v-if="!hasTasks"></el-empty>
    </div>
</template>

<script>
    import HelloWorld from "../components/HelloWorld"
    import CardsStack from "../components/CardsStack"
    import LandingPage from "../page/LandingPage"

    export default({
        mounted() {
            this.getTasks()
        },
        components:{
            HelloWorld,
            CardsStack,
            LandingPage
        },
        computed:{
            hasTasks(){
                return this.$store.state.user.tasks.length > 0
            }
        }
    })    
</script>

<style>
</style>