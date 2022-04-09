<template>
    <!--  -->
    <div class="demo" @wheel="scrollCards($event)">
        <vue-card-stack :cards="cards" :stack-width="1200" :card-width="400" :card-height="300" :speed="0.5">
            <template v-slot:card="{ card }">
                <div style="width: 100%; height: 100%; padding: 15px;" :style="{ background: card.background}" @click="clicked[card.data] = true" @mouseleave="clicked[card.data] = false">
                    <!-- <el-dropdown>
                        <el-button>
                            Dropdown List<i class="el-icon-arrow-down el-icon--right"></i>
                        </el-button>
                        <el-dropdown-menu slot="dropdown">
                            <el-dropdown-item icon="el-icon-plus">Action 1</el-dropdown-item>
                            <el-dropdown-item icon="el-icon-circle-plus">Action 2</el-dropdown-item>
                            <el-dropdown-item icon="el-icon-circle-plus-outline">Action 3</el-dropdown-item>
                            <el-dropdown-item icon="el-icon-check">Action 4</el-dropdown-item>
                            <el-dropdown-item icon="el-icon-circle-check">Action 5</el-dropdown-item>
                        </el-dropdown-menu>
                    </el-dropdown> -->
                    <!-- {{card.data}} -->
                    <!-- { "name": "bbb", "description": "sadaaa", "extra_notes": "", "cardID": null, "email": "wyc935398521@gmail.com", "due_date": "2022-03-17 20:16:00", "taskID": 4 } -->

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
                </div>
            </template>

            <template v-slot:nav="{ activeCardIndex, onNext, onPrevious }">
                <nav class="nav">
                    <div class="counter">{{cards.length - activeCardIndex}}/{{cards.length}}</div>
                    <button v-on:click="onPrevious" class="button" ref="nextButton">
                        <span class="chevron left"> &lt; </span>
                    </button>
                    <button v-on:click="onNext" class="button" ref="prevButton">
                        <span class="chevron right"> &gt; </span>
                    </button>
                </nav>
            </template>
        </vue-card-stack>
    </div>
</template>

<script>
    import VueCardStack from "vue-card-stack";
    import * as session from '../js/session'
    let tasks = session.getJsonTasksArray()
    if(tasks === undefined || tasks.length === 0)
        tasks = [
                {
                    "name": "dasd",
                    "description": "s",
                    "extra_notes": "sdads",
                    "cardID": null,
                    "email": "wyc935398521@gmail.com",
                    "due_date": "2022-03-08 14:14:00",
                    "taskID": 17
                },
                {
                    "name": "aaaaa",
                    "description": "aaaaaaaaaa",
                    "extra_notes": "bbbbbbbbbbbbbbbbbbbbbbbbbb",
                    "cardID": null,
                    "email": "wyc935398521@gmail.com",
                    "due_date": "2022-03-11 10:12:00",
                    "taskID": 3
                },
                {
                    "name": "bbb",
                    "description": "sadaaa",
                    "extra_notes": "",
                    "cardID": null,
                    "email": "wyc935398521@gmail.com",
                    "due_date": "2022-03-17 20:16:00",
                    "taskID": 4
                },
                {
                    "name": "bbb",
                    "description": "sadaaa",
                    "extra_notes": "",
                    "cardID": null,
                    "email": "wyc935398521@gmail.com",
                    "due_date": "2022-03-17 20:16:00",
                    "taskID": 4
                },
                {
                    "name": "bbb",
                    "description": "sadaaa",
                    "extra_notes": "",
                    "cardID": null,
                    "email": "wyc935398521@gmail.com",
                    "due_date": "2022-03-17 20:16:00",
                    "taskID": 4
                },
                {
                    "name": "bbb",
                    "description": "sadaaa",
                    "extra_notes": "",
                    "cardID": null,
                    "email": "wyc935398521@gmail.com",
                    "due_date": "2022-03-17 20:16:00",
                    "taskID": 4
                }
            ]
    export default({
        name:'CardsStack',
        data(){
            return{
                SchoolName:'aaa',
                address:'bbb',
                clicked: Array(5).fill(false),
                hidden: true
            }
        },
        computed:{
            tasks(){
                
                return session.getJsonTasksArray()
            },
            cards(){
                return this.initCards(tasks)
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
            }
        },
        components:{
            VueCardStack
        }
    })
</script>

<style>
    .hidden{
        display: none;
    }
</style>