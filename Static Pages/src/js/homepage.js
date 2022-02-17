function signUp() {
    if (password_input.value !== confirm_password_input.value) {
        document.querySelector("#diff_pwd_msg").style.display = "block"
        document.querySelector("#same_pwd_msg").style.display = "none"
    } else {
        document.querySelector("#same_pwd_msg").style.display = "block"
        document.querySelector("#diff_pwd_msg").style.display = "none"
    }
    password_input.value = ""
    confirm_password_input.value = ""
}

let btn = document.querySelector("#btn-signup")
btn.addEventListener("click", signUp);
let email_phone_input = document.querySelector("#email_phone_input")
let password_input = document.querySelector("#password_input")
let confirm_password_input = document.querySelector("#confirm_password_input")
email_phone_input.addEventListener("input", (event) => {
    if (/^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(event.target.value))
    {
        console.log("working email")
    }
    else {
        console.log("invalid email")
    }
    return false
})