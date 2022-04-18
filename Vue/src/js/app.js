import { clearSession, getSessionEmail, redirectByLoginStatus, getJsonTasksArray, getJsonCardsArray } from "./session.js";

const app = Vue.createApp({
    data() {
        return {
            showBooks: true,
            title: 'The Final Empire',
            age: 20,
            cards: getJsonCardsArray()
        }
    },
    methods: {
        changeTitle() {
            this.title = 'aaaa'
        },
        addAge() {
            this.age++
        },
        minusAge() {
            this.age--
        },
        toggleHide() {
            this.showBooks = !this.showBooks
        }
    },
})
app.mount('#app')

$(document).ready(function () {

    const userEmail = getSessionEmail();
    $("#welcome_msg").html("Welcome " + userEmail);
    $("#logout_btn").on("click", clearSession);

    const tasksJsonArray = getJsonTasksArray();
    const cardsJsonArray = getJsonCardsArray();
    console.log(tasksJsonArray)

});