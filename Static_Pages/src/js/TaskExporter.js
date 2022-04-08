import {getSessionEmail, redirectByLoginStatus, getJsonTasksArray} from "./session.js";

// exportTasksToICS has code referenced from https://codepen.io/vlemoine/pen/MLwygX?editors=1010

// Needs to be globally accessible to revoke object URL on new file generation
// (Handles memory leak issue)
let icsFile = null;

// Returns link to downloadable .ics file
function TaskExporter() {
    // Export ALL tasks into one .ics file.
    if(isNaN(localStorage.userTaskCounter)) {
        // Use this number as part of the unique identifier portion of UID field
        localStorage.userTaskCounter = 0;
    }

    function convertDate(date) {
        let event = new Date(date).toISOString();
        event = event.split("T")[0];
        event = event.split("-");
        event = event.join("");
        return event;
    }

    function getNextTaskCounter() {
        // parseInt necessary b/c local storage only stores strings as values
        let nextCounterVal = parseInt(localStorage.userTaskCounter) + 1;
        console.log(nextCounterVal);
        localStorage.userTaskCounter = nextCounterVal;

        return nextCounterVal;
    }

    function addEventDataToICSFile(taskJson) {
        let data_blob = "BEGIN:VEVENT\n";

        // Use session email as LHS of uid + incremented task counter to guarantee uniqueness
        let uid = `${getSessionEmail()}${getNextTaskCounter()}@cse442NohTypDotPlan`;
        let due_date = null;
        let start_date = convertDate(Date.now());
        if(taskJson["due_date"] != null) {
            console.log("Task with due date!")
            due_date = convertDate(taskJson["due_date"]);
        }
        let summary = taskJson["name"];
        let desc = taskJson["description"];

        data_blob +=
            `UID:${uid}\n` +
            `DTSTART:${start_date}\n` +
            `SUMMARY:${summary}\n` +
            `DESCRIPTION:${desc}\n`;

        if(due_date != null) {
            data_blob += `DTEND:${due_date}\n`;
        }
        data_blob += "END:VEVENT\n";

        // console.log(data_blob);
        return data_blob;
    }

    // Main function starts here
    redirectByLoginStatus();

    const tasksJsonArray = getJsonTasksArray();

    if(tasksJsonArray.length === 0) {
        alert("You have no tasks to export!");
        return;
    }

    console.log("Getting all tasks: " + tasksJsonArray);

    // Start creating ics file (header)
    let blob =
        "BEGIN:VCALENDAR\n" +
        "VERSION:2.0\n" +
        "PRODID:-//Dot-Plan-Cal//EN\n" +
        "CALSCALE:GREGORIAN\n" +
        "METHOD:PUBLISH\n";

    // Add all event data after header
    for(let i = 0; i < tasksJsonArray.length; i++) {
        blob += addEventDataToICSFile(tasksJsonArray[i]);
    }
    blob += "END:VCALENDAR\n";

    console.log(blob);
    let data = new File([blob], "DotPlanEvents.ics", {type: "text/calendar"});

    // If we are replacing a previously generated file we need to
    // manually revoke the object URL to avoid memory leaks.
    if (icsFile !== null) {
        window.URL.revokeObjectURL(icsFile);
    }

    icsFile = window.URL.createObjectURL(data);
    console.log(icsFile);
    return icsFile;
}


// Puts TaskExporter() into DOM's global scope so it can be called directly from <a> href tag
// window.TaskExporter = TaskExporter;

/////////////////////     Alternative way to get download data    ////////////////////////////
// Import this file as a script, create an <a> tag in your html with id="export-button"
let action_tag = document.getElementById("export-button");
action_tag.setAttribute('href', TaskExporter());
action_tag.setAttribute('download', "DotPlanEvents.ics");
