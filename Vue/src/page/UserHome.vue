<template>
    <div>
        <HelloWorld></HelloWorld>
        <CardsStack v-show="this.$store.state.user.isLoggedIn"></CardsStack>
        <LandingPage v-show="!this.$store.state.user.isLoggedIn"></LandingPage>
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
        }
    })    
</script>

<style>
</style>