const formInputClassName = 'create-form-input';

function validateCreationForm(idName) {
    let alertFields = [];
    let inputFields = document.forms[idName];

    // Check only the optional fields
    if(inputFields["name"].value === "") { alertFields.push("name"); }
    if(inputFields["desc"].value === "") { alertFields.push("desc"); }

    if(alertFields.length === 0) {
        // Get all child elements of form with class "create-form-input"
        // Generalized to work with ALL forms that we have as long as we set class while writing HTML
        let formInputFields = document.getElementsByClassName(formInputClassName);
        console.log(formInputFields);
        parseData(formInputFields);
        return true;
    }

    // Set up alert to show user
    let alertMessage = "The following fields are required, but currently empty: \n\n";
    let firstField = alertFields[0];
    for(var field in alertFields) {
        alertMessage += (alertFields[field] + "\n");
    }
    alert(alertMessage);
    document.getElementById(firstField).focus();
    return false;
}

function parseData(htmlElemsArr) {
    // Can't do yet without database, so just storing in array and logging for now
    // console.log("array: " + htmlElemsArr);

    for(var i = 0; i < htmlElemsArr.length; i++) {
        console.log(htmlElemsArr[i].value);
    }
}