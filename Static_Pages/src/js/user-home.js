import {clearSession, getSessionEmail, redirectByLoginStatus, getJsonTasksArray} from "./session.js";
import {showNotification, getNotificationPermission} from "./notification.js";

$(document).ready(function () {

        redirectByLoginStatus();
        const userEmail = getSessionEmail();
        $("#welcome_msg").html("Welcome " + userEmail);
        $("#logout_btn").on("click", clearSession);
        const tasksJsonArray = getJsonTasksArray();
        if (getNotificationPermission() === true)
                showNotification(tasksJsonArray);

        // Stuff for #37
        // Get all card and task data using session.js' getJsonTasksArray().
        for(var i = 0; i < tasksJsonArray.length; i++) {
                let taskObj = tasksJsonArray[i];
                // console.log(taskObj["name"]);
                $("#task-card-container").append(
                    "<div class=\"card-node\">\n" +
                        "\t<h4 class=\"cardName\">" + "CardName PlaceHolder" + " </h4>\n" +
                        // "\t<p class=\"cardDesc\">" + "Card Description Placeholder" + " </p>\n" +
                        "\t<div class=\"task-node\">\n" +
                                "\t\t<h4 class=\"taskName\">" + taskObj["name"] + " </h4>\n" +
                                "\t\t<p class=\"taskDesc\">" + taskObj["description"] + " </p>\n" +
                        "\t</div>" +
                    "</div>\n");
        }

});