export function redirectByLoginStatus() {
    $.ajax({
        type: 'get',
        url: "./php/session.php",
        success: function (resp) {
            if (resp.includes("Not logged in")) {
                if (!window.location.href.includes("login.html"))
                    window.location.replace("./login.html")
            } else if (resp.includes("Already logged in")) {
                if (window.location.href.includes("login.html") || !window.location.href.includes(".html"))
                    window.location.replace("./user-home.html")
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
                email = "Not logged in"
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