<template>
    <!--  -->
    <div class="card-stack" @wheel="scrollCards($event)">
        <vue-card-stack :cards="cards" :key="JSON.stringify(cards)" :stack-width="360" :card-width="280" :speed="0.5" style="padding-top: 100px">
            <template v-slot:card="{ card }">
                <div style="width: 100%; height: 100%; border-radius: 8px; padding: 8px;" :style="{ background: card.background}" @click="clicked[card.data] = true" @mouseleave="clicked[card.data] = false">
                   
                   <!--
                    <el-row style="margin:10px">
                        <el-button type="primary" icon="el-icon-edit" circle></el-button>
                        <el-button type="success" icon="el-icon-check" circle></el-button>
                        <el-button type="danger" icon="el-icon-delete" circle></el-button>
                    </el-row>
                    <el-descriptions direction="horizontal" :column="1" border size="medium">
                    <el-descriptions-item label="Name">{{card.data.name}}</el-descriptions-item>
                    <el-descriptions-item label="Extra Notes">{{card.data.extra_notes}}</el-descriptions-item>
                    <el-descriptions-item label="Due date" :span="2">{{card.data.due_date}}</el-descriptions-item>
                    <el-descriptions-item ></el-descriptions-item>
                    </el-descriptions>
                    -->
                </div>
            </template>
            <!-- 
            <template v-slot:nav="{ onNext, onPrevious }">
                <nav class="nav">
                    <div class="counter">{{cards.length - activeCardIndex}}/{{cards.length}}</div>
                    <button v-on:click="onPrevious" class="button" ref="nextButton">
                        <span class="chevron left"></span>
                    </button>
                    <button v-on:click="onNext" class="button" ref="prevButton">
                        <span class="chevron right"></span>
                    </button>
                </nav>
            </template>
            -->
        </vue-card-stack>
    </div>
</template>

<script>
    import VueCardStack from "vue-card-stack";
    import axios from 'axios'

    export default({
        name:'CardsStack',
        data(){
            return{
                SchoolName:'aaa',
                address:'bbb',
                clicked: Array(5).fill(false),
                hidden: true,
                testCards: [
                    {
                        due_date: 'Today',
                        extra_notes: 'Omg do the thing',
                        name: 'First Card',
                    },
                    {
                        due_date: undefined,
                        extra_notes: undefined,
                        name: 'Second Card',
                    },
                    {
                        due_date: 'Tomorrow',
                        extra_notes: 'Some notes',
                        name: 'Third Card',
                    },
                    {
                        due_date: 'Tomorrow',
                        extra_notes: 'Some notes',
                        name: 'Fourth Card',
                    },
                    {
                        due_date: 'Tomorrow',
                        extra_notes: 'Some notes',
                        name: 'Fifth Card',
                    },
                ]
            }
        },
        computed:{
            cards(){
                return this.initCards(this.testCards)
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