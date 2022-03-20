import {getSessionEmail} from "./src/js/session.js";
$(document).ready(function () {
        const userEmail = getSessionEmail()
        alert(userEmail)
    }
)