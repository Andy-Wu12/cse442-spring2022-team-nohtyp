<template>
    <!--  -->
    <div class="card-stack" @wheel="scrollCards($event)">
        <vue-card-stack :cards="cards" :key="JSON.stringify(cards)" :stack-width="360" :card-width="280" :speed="0.5" style="padding-top: 100px">
            <template v-slot:card="{ card }">
                <div
                    style="width: 100%; height: 100%; border-radius: 8px; padding: 8px;"
                    :style="{ background: card.background}"
                    @click="clicked[card.data] = true"
                    @mouseleave="clicked[card.data] = false"
                >
                   
                   <card
                    :name="card.data.name"
                    :extra_notes="card.data.extra_notes"
                    :due_date="card.data.due_date"
                   />

                </div>
            </template>
        </vue-card-stack>
    </div>
</template>

<script>
    import VueCardStack from "vue-card-stack";
    import axios from 'axios'

    export default({
        name:'CardsStack',
        props: ['id', 'name'],
        data(){
            return{
                SchoolName:'aaa',
                address:'bbb',
                clicked: Array(5).fill(false),
                hidden: true,
            }
        },
        computed:{
            cards(){
                let original_cards = this.$store.state.user.cards;
                for(let i = 0; i <original_cards.length; i++){
                    original_cards = original_cards[i][this.props.id];
                }
                return this.initCards(original_cards);
            },
            isLoggedIn(){
                return this.$store.state.user.token && this.$store.state.user.token.length > 0
            }
        },
        methods: {
            getRandomColor(){
                const colors = ["#00659d", "#00abbc", "#e2c58a", "#fc8890", "#b35d7f"]
                return colors[Math.floor(Math.random() * colors.length)]
            },
            initCards(tasksJsonArray){
                let res = []
                for (let i = 0; i < tasksJsonArray.length; i++) {
                    let taskObj = {}
                    taskObj["background"] = this.getRandomColor()
                    taskObj["data"] = tasksJsonArray[i]
                    res.push(taskObj)
                }
                return res
            },
            scrollCards(e){
                e.preventDefault();
                const nextButton = this.$refs.nextButton
                const prevButton = this.$refs.prevButton
                if(e.deltaY > 0){
                    nextButton.click()
                }
                else{
                    prevButton.click()
                }
            },
            updateMouseover(cardIdx){
                this.clicked[cardIdx] = true
            },
            updateMouseLeave(cardIdx){
                this.clicked[cardIdx] = false
            },
            getAllTasks(){
                return axios.request({
                    url: axios.defaults.baseURL + 'session.php?param=tasks',
                    withCredentials: true
                })
            }
        },
        components:{
            VueCardStack
        },
        // mounted() {
        //     const self = this
        //     this.getAllTasks().then(res => {
        //         const {status, tasks} = res.data
        //         if(status === "success"){
        //             self.$store.commit('setTasks', JSON.parse(JSON.stringify(tasks)))
        //         }
        //         if(self.$store.state.user.email && self.$store.state.user.email.length > 0){
        //             this.$notify.info({
        //                 title: 'Reminder',
        //                 dangerouslyUseHTMLString: true,
        //                 message: 'You have ' + `<h1>${self.$store.state.user.tasks.length}</h1>` + ' tasks',
        //                 duration: 4500,
        //                 offset: 70
        //             });
        //         }
        //     })
        // },
    })
</script>

<style scoped>
/* Super important "scoped" used for saying we want to apply this stylesheet to only this component and its children */
.hidden{
    display: none;
}
.card-stack {
    max-width: 400px;
}
.card {
  height: 100%;
  border-radius: 8px;
}
.nav {
  display: flex;
  width: 100%;
  justify-content: center;
}
.nav .counter {
  font-weight: 600;
  font-size: 12px;
  background: #3eaf7c;
  padding: 4px;
  border-radius: 4px;
  color: white;
}
.nav .button {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  background: white;
  border: 1px solid #ccc;
  color: #2d2d2d;
  display: flex;
  align-items: center;
  justify-content: center;
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  z-index: 999;
  box-shadow: 0px 2px 8px rgba(0, 0, 0, 0.15);
}
.nav .button:first-of-type {
  left: 0;
}
.nav .button:last-of-type {
  right: 0;
}
.nav .button:hover {
  cursor: pointer;
}
.nav .button:focus {
  outline: 0;
  box-shadow: 0 0 0 2px rgba(0, 132, 255, 0.5);
}
.chevron {
  border-style: solid;
  border-width: 0.25em 0.25em 0 0;
  content: "";
  height: 0.45em;
  width: 0.45em;
}
.chevron.left {
  transform: rotate(-135deg);
  margin-left: 4px;
}
.chevron.right {
  transform: rotate(45deg);
  margin-right: 4px;
}
</style>