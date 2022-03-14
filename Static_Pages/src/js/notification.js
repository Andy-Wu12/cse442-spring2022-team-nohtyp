export function showNotification(tasksJsonArray) {
    const timeDiffObj = timeDifference(new Date(tasksJsonArray[0]["due_date"]), new Date())
    const newNotification = new Notification(tasksJsonArray[0]["name"], {
        // body: Date.parse(tasksJsonArray[0]["due_date"])
        body: "Due in " + timeDiffObj["days"] + " days " + timeDiffObj["hours"] + " hours " + timeDiffObj["minutes"]
            + " minutes " + timeDiffObj["seconds"] + " seconds"
    })

    newNotification.onclick = (e) => {
        alert(e)
    }
}

export function timeDifference(date1, date2) {
    const millisecondsDifference = date2.getTime() - date1.getTime();
    const daysDifference = Math.floor(millisecondsDifference / (24 * 60 * 60 * 1000))
    const hoursDifference = parseInt(millisecondsDifference / (60 * 60 * 1000) % 24)
    const minutesDifference = parseInt(millisecondsDifference / (60 * 1000)) % 60
    const secondsDifference = parseInt(millisecondsDifference / 1000) % 60
    return {
        "days": daysDifference,
        "hours": hoursDifference,
        "minutes": minutesDifference,
        "seconds": secondsDifference
    }
}

export function getNotificationPermission() {
    console.log(Notification.permission)
    if (Notification.permission === "granted") {
        return true
    } else if (Notification.permission === "default") {
        Notification.requestPermission().then(permission => {
            return permission === "granted"
        })
    }
    return false
}
