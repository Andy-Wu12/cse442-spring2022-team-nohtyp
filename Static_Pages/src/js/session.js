export function redirectByLoginStatus() {
    $.ajax({
        type: 'get',
        url: "./php/session.php",
        success: function (resp) {
            if (resp.includes("Not logged in")) {
                if (!window.location.href.includes("login.html"))
                    setTimeout(() => {
                        window.location.replace("./login.html")
                    }, 1500)
            } else if (resp.includes("Already logged in")) {
                if (window.location.href.includes("login.html"))
                    setTimeout(() => {
                        window.location.replace("./user-home.html")
                    }, 1500)
            }
        }
    });
}

export function getSessionEmail() {
    let email = ""
    $.ajax({
        type: 'get',
        url: "./php/session.php?param=email",
        async: false,
        success: function (resp) {
            if (resp === "Not logged in") {
                window.location.replace("./login.html")
            } else {
                email = resp
            }
        }
    });
    return email
}

export function clearSession() {
    $.ajax({
        type: 'get',
        async: false,
        url: "./php/session.php?param=clearsession",
    });
    location.reload();
}

// $(document).ready(function () {
//     redirectIfLoggedIn()
//     const userEmail = getSessionEmail()
//     $("#username_header").html(userEmail)
//     $("#logout_btn").on("click", clearSession)
// });