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
    const tasksPastDue = tasksJsonArray.filter(task => new Date(task["due_date"]) < new Date())
    const tasksDueToday = tasksJsonArray.filter(task => new Date(task["due_date"]) > new Date() && timeDifference(new Date(task["due_date"]), new Date())["days"] === 0)
    const tasksDueSoon = tasksJsonArray.filter(task => new Date(task["due_date"]) > new Date() && timeDifference(new Date(task["due_date"]), new Date())["days"] !== 0)
    if(tasksPastDue.length === 0 && tasksDueToday.length === 0 && tasksDueSoon.length === 0)
        return "Good job!\r\nYou've finished all your tasks!"

    let summary = ""
    if(tasksPastDue.length > 0)
        summary += tasksPastDue.length + " task(s) past due date\r\n"
    if(tasksDueToday.length > 0)
        summary += tasksDueToday.length + " task(s) due today\r\n"
    if(tasksDueSoon.length > 0)
        summary += tasksDueSoon.length + " task(s) due soon"
    return summary
}

export function timeDifference(date1, date2) {
    const utc1 = Date.UTC(date1.getFullYear(), date1.getMonth(), date1.getDate());
    const utc2 = Date.UTC(date2.getFullYear(), date2.getMonth(), date2.getDate());
    const millisecondsDifference = utc1 - utc2;
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
