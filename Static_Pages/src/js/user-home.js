import {clearSession, getSessionEmail, redirectByLoginStatus, getJsonTasksArray, getJsonCardsArray} from "./session.js";
import {showNotification, getNotificationPermission} from "./notification.js";

$(document).ready(function () {

        redirectByLoginStatus();
        const userEmail = getSessionEmail();
        $("#welcome_msg").html("Welcome " + userEmail);
        $("#logout_btn").on("click", clearSession);

        const tasksJsonArray = getJsonTasksArray();
        const cardsJsonArray = getJsonCardsArray();

        // console.log(tasksJsonArray);
        // console.log(cardsJsonArray);

        if (getNotificationPermission() === true)
                showNotification(tasksJsonArray);

        // KEY = cardID, VALUE = [] of corresponding tasks
        var tasksAssignedCards = {};
        // Render general "no card" tasks after the rest
        var cardlessTasks = [];

        // Initialize empty list of tasks for each of the user's cards
        for(var i = 0; i < cardsJsonArray.length; i++) {
                let card = cardsJsonArray[i];
                tasksAssignedCards[card["cardID"]] = [];
        }

        // Add all tasks to their corresponding card's list of tasks to render
        // OR add unmatched tasks to cardlessTasks
        for(var i = 0; i < tasksJsonArray.length; i++) {
                let taskObj = tasksJsonArray[i];
                if(taskObj["cardID"] !== null) {
                        tasksAssignedCards[taskObj["cardID"]].push(taskObj);
                        console.log(tasksAssignedCards);
                }
                else {
                        cardlessTasks.push(taskObj);
                }
        }


        // Render all card with their tasks by templating with jquery
        for(var i = 0; i < cardsJsonArray.length; i++) {
                let cardJSON = cardsJsonArray[i];
                let cardTaskSet = tasksAssignedCards[cardJSON["cardID"]];
                var newCardTasksHTML = "<div class=\"card-node\">\n" +
                        "\t<h4 class=\"cardName\">" + cardJSON["name"] + " </h4>\n" +
                        "\t<p class=\"cardDesc\">" + cardJSON["description"] + " </p>\n";

                for(var k = 0; k < cardTaskSet.length; k++) {
                        let taskObj = cardTaskSet[i];
                        newCardTasksHTML += "\t<div class=\"task-node\">\n" +
                                "\t\t<h4 class=\"taskName\">" + taskObj["name"] + " </h4>\n" +
                                "\t\t<p class=\"taskDesc\">" + taskObj["description"] + " </p>\n" +
                                // "\t\t<p class=\"taskDueDate\">" + taskObj["due_date"] + " </p>\n" +
                                "\t</div><br>";
                }
                $("#task-card-container").append(newCardTasksHTML + "</div><br>\n");
        }

        // Render all the standalone tasks (those w/o associated card)
        console.log(cardlessTasks);
        for(var i = 0; i < cardlessTasks.length; i++) {
                console.log("adding cardless task!");
                let taskJSON = cardlessTasks[i];
                let cardlessTasksHTML = ("<div class=\"task-node\">\n" +
                        "\t<h4 class=\"taskName\">" + taskJSON["name"] + " </h4>\n" +
                        "\t<p class=\"taskDesc\">" + taskJSON["description"] + " </p>\n" +
                        // "\t\t<p class=\"taskDueDate\">" + "Due: " + taskJSON["due_date"] + " </p>\n" +
                        "</div><br>");
                $("#task-card-container").append(cardlessTasksHTML);
        }
});