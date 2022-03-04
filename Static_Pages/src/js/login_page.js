import {redirectByLoginStatus} from "./session.js";

function showMsg(html, class_name = "alert alert-danger alert-dismissable") {
    pwd_msg.attr("class", class_name)
    pwd_msg.html(html)
    pwd_msg.css("display", "block")
}

function signUp_logIn(event) {
    event.preventDefault()
    if (state === "signup") {
        if ((password_input.val().length === 0 && confirm_password_input.val().length === 0)) {
            showMsg("Passwords cannot be empty")
            return false
        }
        if (!isCorrectEmailFormat(email_phone_input.val())) {
            showMsg("Wrong Email Format")
            return false
        }
        if (password_input.val() !== confirm_password_input.val()) {
            showMsg("Passwords do not match")
        } else {
            $.ajax({
                type: 'post',
                url: event.target.getAttribute("action"),
                data: $('#form').serialize(),
                success: function (resp) {
                    if (resp === '1') {
                        showMsg("Email already exists")
                    } else {
                        showMsg("Welcome!", "alert alert-success alert-dismissable")
                        setTimeout(() => {
                            login_title_btn.click()
                            password_input.val("")
                        }, 1000)
                    }
                }
            });
        }
    } else if (state === "login") {
        if (password_input.val().length === 0) {
            showMsg("Password cannot be empty")
            return false
        }
        if (!isCorrectEmailFormat(email_phone_input.val())) {
            showMsg("Wrong Email Format")
            return false
        }
        $.ajax({
            type: 'post',
            url: event.target.getAttribute("action"),
            data: $('#form').serialize(),
            success: function (resp) {
                if (resp === "Login Success") {
                    showMsg("Welcome!", "alert alert-success alert-dismissable")
                    setTimeout(() => {
                        window.location.replace("./user-home.html")
                    }, 1000)
                } else {
                    showMsg(resp)
                }
            }
        });
    }

    password_input.value = ""
    confirm_password_input.value = ""
    // event.preventDefault()
    // event.target.trigger("click")
    return false
}

const checkEmailFormat = (event) => {
    const email_input = event.target.value
    if (isCorrectEmailFormat(email_input)) {
        pwd_msg.css("display", "none")
    } else {
        showMsg("Wrong Email Format")
    }
}

function isCorrectEmailFormat(email_input) {
    console.log(email_input)
    return email_input.length === 0 || /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.(com|cn|edu))+$/.test(email_input)
}

const checkPwdMatch = () => {
    const pwd_input = password_input.val()
    const confirm_pwd_input = confirm_password_input.val()
    if (pwd_input.length === 0 || confirm_pwd_input.length === 0)
        return
    if (pwd_input !== confirm_pwd_input) {
        showMsg("Passwords do not match")
    } else {
        pwd_msg.css("display", "none")
    }
}

const setBtnActive = (event) => {
    const btn_id = event.target.getAttribute("id")
    if (btn_id === "login_title_btn") {
        state = "login"
        login_title_btn.attr("class", "active")
        signup_title_btn.attr("class", "")
        $("#btn-forgotPwd").css("display", "block")
        $("#confirm_password_input").css("display", "none")
        $("#pwd_msg").css("display", "none")
        form.attr("action", "./php/login.php")
        signup_btn.val("Log In")
        password_input.off("input")
        confirm_password_input.off("input")
    }
    if (btn_id === "signup_title_btn") {
        state = "signup"
        login_title_btn.attr("class", "")
        signup_title_btn.attr("class", "active")
        $("#btn-forgotPwd").css("display", "none")
        $("#confirm_password_input").css("display", "block")
        $("#pwd_msg").css("display", "none")
        form.attr("action", "./php/signup.php")
        signup_btn.val("Sign Up")
        password_input.on("input", checkPwdMatch)
        confirm_password_input.on("input", checkPwdMatch)
    }
}

const signup_btn = $("#btn-signup")
const email_phone_input = $("#email_phone_input")
const password_input = $("#password_input > label > input")
const confirm_password_input = $("#confirm_password_input > label > input")
const pwd_msg = $("#pwd_msg")
const login_title_btn = $("#login_title_btn")
const signup_title_btn = $("#signup_title_btn")
const form = $("#form")
let state = "signup"

$(document).ready(function () {
// signup_btn.on("click", signUp)
        redirectByLoginStatus()
        $('.email-input').on("input", checkEmailFormat)
        form.on("submit", signUp_logIn)
        password_input.on("input", checkPwdMatch)
        confirm_password_input.on("input", checkPwdMatch)
        login_title_btn.on("click", setBtnActive)
        signup_title_btn.on("click", setBtnActive)
    }
)