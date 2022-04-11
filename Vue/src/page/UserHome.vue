<template>
    <div>
        <HelloWorld></HelloWorld>
        <CardsStack v-show="isLoggedIn"></CardsStack>
        <LandingPage v-show="!isLoggedIn"></LandingPage>
    </div>
</template>

<script>
    import HelloWorld from "../components/HelloWorld"
    import CardsStack from "../components/CardsStack"
    import LandingPage from "../page/LandingPage"

    export default({
        components:{
            HelloWorld,
            CardsStack,
            LandingPage
        },
        computed:{
            isLoggedIn(){
                return this.$store.state.user.token && this.$store.state.user.token.length > 0
            }
        }
    })    
</script>

<style>
</style>