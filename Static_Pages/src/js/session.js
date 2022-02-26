function redirectIfLoggedIn() {
    $.ajax({
        type: 'get',
        url: "./php/checkIfloggedin.php",
        success: function (resp) {
            if (!resp.includes("Already logged in")) {
                window.location.replace("./login.php")
            }
        }
    });
}

function getSessionEmail() {
    let email = ""
    $.ajax({
        type: 'get',
        url: "./php/checkIfloggedin.php?param=email",
        async: false,
        success: function (resp) {
            if (resp === "Not logged in") {
                window.location.replace("./login.php")
            }
            else{
                email = resp
            }
        }
    });
    return email
}

function clearSession() {
    $.ajax({
        type: 'get',
        async: false,
        url: "./php/checkIfloggedin.php?param=clearsession",
    });
    location.reload();
}

$(document).ready(function () {
    redirectIfLoggedIn()
    const userEmail = getSessionEmail()
    $("#username_header").html(userEmail)
    $("#logout_btn").on("click", clearSession)
});