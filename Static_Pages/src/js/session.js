export function redirectByLoginStatus() {
    $.ajax({
        type: 'get',
        url: "./php/session.php",
        success: function (resp) {
            const resp_obj = JSON.parse(resp)
            if (resp_obj["logged_in"] === "false") {
                if (!window.location.href.includes("login.html")) {
                    window.location.replace("./login.html")
                }
            } else if (resp_obj["logged_in"] === "true") {
                if (window.location.href.includes("login.html") || !window.location.href.includes(".html")) {
                    window.location.replace("./user-home.html")
                }
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
            const resp_obj = JSON.parse(resp)
            if (resp_obj["logged_in"] === "true") {
                email = resp_obj["email"]
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

export function getJsonTasksArray() {
    let jsonTasksArray = []
    $.ajax({
        type: 'get',
        async: false,
        url: "./php/session.php?param=tasks",
        success: function (resp) {
            const resp_obj = JSON.parse(resp)
            console.log(resp_obj["tasks"])
            jsonTasksArray = resp_obj["tasks"]
        }
    });
    return jsonTasksArray
}