export function showNotification(tasksJsonArray) {
    // const timeDiffObj = timeDifference(new Date(tasksJsonArray[0]["due_date"]), new Date())
    const summaryStr = generateSummary(tasksJsonArray)
    console.log(tasksJsonArray)
    const summaryNotification = new Notification("", {
        // body: Date.parse(tasksJsonArray[0]["due_date"])
        body:summaryStr
    })
}

function stringifyTaskArray(taskArr, param = "name"){
    let res = ""
    taskArr.forEach(task => res += ("- " + task[param] + "\r\n"))
    return res
}

function generateSummary(tasksJsonArray){
    const tasksPastDue = tasksJsonArray.filter(task => timeDifference(new Date(task["due_date"]), new Date())["days"] > 0)
    const tasksDueToday = tasksJsonArray.filter(task => timeDifference(new Date(task["due_date"]), new Date())["days"] === 0)
    const tasksBeforeDue = tasksJsonArray.filter(task => timeDifference(new Date(task["due_date"]), new Date())["days"] < 0)
    if(tasksPastDue.length === 0 && tasksDueToday.length === 0 && tasksBeforeDue.length === 0)
        return "Good job!\r\nYou've finished all your tasks!"

    const tasksDueTodayStr = stringifyTaskArray(tasksDueToday)
    const tasksPastDueStr = stringifyTaskArray(tasksPastDue)
    const tasksBeforeDueStr = stringifyTaskArray(tasksBeforeDue)

    let summary = "You have:\r\n"
    if(tasksPastDue.length > 0)
        summary += tasksPastDue.length + " task(s) past due date\r\n" + tasksPastDueStr
    if(tasksDueToday.length > 0)
        summary += tasksDueToday.length + " task(s) due today\r\n" + tasksDueTodayStr
    if(tasksBeforeDue.length > 0)
        summary += tasksBeforeDue.length + " task(s) coming up\r\n" + tasksBeforeDueStr
    return summary
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
