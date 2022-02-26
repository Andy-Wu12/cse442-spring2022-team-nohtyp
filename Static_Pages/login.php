<!DOCTYPE html>
<html lang="en">
<head>
    <title>LOGIN/SIGNUP</title>
    <link rel="stylesheet" href="src/css/login.css">
    <link rel="stylesheet" href="./src/css/bootstrap.min.css">
</head>
<body>
<div class="login-container">

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">
            <img src="./src/img/logo.svg" width="30" height="30" class="logo d-inline-block align-middle" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Dropdown
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <h1 class="section_header">Get the ultimate<br data-mutiny="true">to-do list and time management tool</h1>
    <div class="login-box">
        <div class="login-text">
            <span id="login_title_btn">Log In</span><b>·</b><span class="active" id="signup_title_btn">Sign Up</span>
        </div>
        <form id="form" action="./php/signup.php" method="post">
            <div class="right_content" id="sign_up_content">
                <div class="input-box">
                    <div>
                        <img src="src/img/user.png" class="icon_before_input" alt="icon_before_input">
                        <label>
                            <input type="text" id="email_phone_input" class="ant-input input email-input"
                                   placeholder="Email / Phone" name="email_phone_input" value="">
                        </label>
                    </div>
                    <div id="password_input">
                        <img src="src/img/password.png" class="icon_before_input" alt="icon_before_input">
                        <label for="password_input">
                            <input type="password" class="ant-input input" name="password_input" maxlength="20"
                                   placeholder="Password">
                        </label>
                    </div>
                    <div id="confirm_password_input">
                        <img src="src/img/password.png" class="icon_before_input" alt="icon_before_input">
                        <label>
                            <input type="password" name="confirm_password_input" class="ant-input input" maxlength="20"
                                   placeholder="Confirm Password">
                        </label>
                    </div>
                    <div id="pwd_msg" class="">
                        <button type="button" class="close" data-dismiss="alert"
                                aria-hidden="true">
                            &times;
                        </button>
                    </div>
                </div>
                <button type="button" id="btn-forgotPwd" class="btn btn-signup forgotPwd">Forgot Password?</button>
                <input type="submit" value="Sign Up" id="btn-signup" class="btn btn-signup login-style">
            </div>
        </form>
    </div>
    <div class="pos-f-t">
        <div class="collapse" id="navbarToggleExternalContent">
            <div class="bg-light p-4">
                <h4 class="text-dark">Collapsed content</h4>
                <span class="text-muted">Toggleable via the navbar brand.</span>
            </div>
        </div>
        <nav class="navbar navbar-light bg-light" id="menu-button">
            <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </nav>
    </div>
</div>
<script src="./src/js/jquery-3.6.0.js"></script>
<script src="./src/js/homepage.js"></script>
<script src="./src/js/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="./src/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
</body>
</html>