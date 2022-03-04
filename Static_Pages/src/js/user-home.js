import {clearSession, getSessionEmail, redirectByLoginStatus} from "./session.js";

$(document).ready(function () {
        redirectByLoginStatus()
        const userEmail = getSessionEmail()
        $("#welcome_msg").html("Welcome " + userEmail)
        $("#logout_btn").on("click", clearSession)
    }
)