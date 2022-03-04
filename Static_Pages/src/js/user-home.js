import {clearSession, getSessionEmail, redirectByLoginStatus} from "./session.js";

$(document).ready(function () {
        redirectByLoginStatus()
        const userEmail = getSessionEmail()
        if (userEmail === "Not logged in")
            window.location.replace("./login.html")
        $("#welcome_msg").html("Welcome " + userEmail)
        $("#logout_btn").on("click", clearSession)
    }
)