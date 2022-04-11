<template>
    <div>
        <HelloWorld></HelloWorld>
<!--        <CardsStack></CardsStack>-->
        <DockContainer></DockContainer>
    </div>
</template>

<script>
    import HelloWorld from "../components/HelloWorld"
    import DockContainer from "@/components/Dock/DockContainer"
    // import CardsStack from "../components/CardsStack"

    export default({
        components:{
            HelloWorld,
            DockContainer,
            // CardsStack
        }
    })    
</script>

<style>
</style>