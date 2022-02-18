function signUp() {
    if (password_input.val().length === 0 && confirm_password_input.val().length === 0)
        return
    if (password_input.val() !== confirm_password_input.val()) {
        pwd_msg.attr("class", "alert alert-danger alert-dismissable")
        pwd_msg.html("Passwords do not match")
        pwd_msg.css("display", "block")
    } else {
        pwd_msg.attr("class", "alert alert-success alert-dismissable")
        pwd_msg.html("Welcome")
        pwd_msg.css("display", "block")
    }
    password_input.value = ""
    confirm_password_input.value = ""
}


const checkEmailFormat = (event) => {
    const email_input = event.target.value
    if (email_input.length === 0 || /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.(com|cn|edu))+$/.test(email_input)) {
        console.log("asas")
        email_msg.css("display", "none")
    } else {
        console.log("bbbb")
        email_msg.css("display", "block")
    }
}

const signup_btn = $("#btn-signup")
const email_phone_input = $("#email_phone_input")
const password_input = $("#password_input")
const confirm_password_input = $("#confirm_password_input")
const pwd_msg = $("#pwd_msg")
const email_msg = $("#email_msg")


signup_btn.on("click", signUp)
email_phone_input.on("input", checkEmailFormat)