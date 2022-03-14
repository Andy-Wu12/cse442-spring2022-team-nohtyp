import {clearSession, getSessionEmail, redirectByLoginStatus, getJsonTasksArray} from "./session.js";
import {showNotification, getNotificationPermission} from "./notification.js";

$(document).ready(function () {
        redirectByLoginStatus()
        const userEmail = getSessionEmail()
        $("#welcome_msg").html("Welcome " + userEmail)
        $("#logout_btn").on("click", clearSession)
        const tasksJsonArray = getJsonTasksArray()
        console.log(tasksJsonArray)
        if(getNotificationPermission() === true)
                showNotification(tasksJsonArray)
    }
)