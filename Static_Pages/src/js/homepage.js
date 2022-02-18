function showPwdWarning() {
    pwd_msg.attr("class", "alert alert-danger alert-dismissable")
    pwd_msg.html("Passwords do not match")
    pwd_msg.css("display", "block")
}

function showWelcome() {
    pwd_msg.attr("class", "alert alert-success alert-dismissable")
    pwd_msg.html("Welcome")
    pwd_msg.css("display", "block")
}

function signUp() {
    if ((password_input.val().length === 0 && confirm_password_input.val().length === 0) || !isCorrectEmailFormat(email_phone_input.val()))
        return
    if (password_input.val() !== confirm_password_input.val()) {
        showPwdWarning()
    } else {
        showWelcome()
    }
    password_input.value = ""
    confirm_password_input.value = ""
}

const checkEmailFormat = (event) => {
    const email_input = event.target.value
    if(isCorrectEmailFormat(email_input)){
        email_msg.css("display", "none")
    }
    else{
        email_msg.css("display", "block")
    }
}

function isCorrectEmailFormat (email_input) {
    console.log(email_input)
    return email_input.length === 0 || /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.(com|cn|edu))+$/.test(email_input)
}

const checkPwdMatch = (event) => {
    const pwd_input = password_input.val()
    const confirm_pwd_input = event.target.value
    if (pwd_input !== confirm_pwd_input) {

    }
}

const setBtnActive = (event) => {
    const btn_id = event.target.getAttribute("id")
    if (btn_id === "login_title_btn") {
        login_title_btn.attr("class", "active")
        signup_title_btn.attr("class", "")
        $("#btn-forgotPwd").css("display", "block")
        $("#confirm_password_input").css("display", "none")
        $("#btn-signup").css("display", "none")
        $("#btn-login").css("display", "block")
    }
    if (btn_id === "signup_title_btn") {
        login_title_btn.attr("class", "")
        signup_title_btn.attr("class", "active")
        $("#btn-forgotPwd").css("display", "none")
        $("#confirm_password_input").css("display", "block")
        $("#btn-signup").css("display", "block")
        $("#btn-login").css("display", "none")
    }
}

const signup_btn = $("#btn-signup")
const email_phone_input = $("#email_phone_input")
const password_input = $("#password_input")
const confirm_password_input = $("#confirm_password_input")
const pwd_msg = $("#pwd_msg")
const email_msg = $("#email_msg")
const login_title_btn = $("#login_title_btn")
const signup_title_btn = $("#signup_title_btn")

signup_btn.on("click", signUp)
$('.email-input').on("input", checkEmailFormat)
confirm_password_input.on("input", checkPwdMatch)
login_title_btn.on("click", setBtnActive)
signup_title_btn.on("click", setBtnActive)