<?php
function emailExists($mysqli, $email): bool
{
    $stmt = $mysqli->prepare("SELECT * FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $rows = $stmt->num_rows;
    return $rows != 0;
}

function userPwdExists($mysqli, $email, $password): bool
{
    $stmt = $mysqli->prepare("SELECT * FROM user WHERE email = ? and password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $stmt->store_result();
    $rows = $stmt->num_rows;
    return $rows == 1;
}

function updateCookie($mysqli, $email, $cookie)
{
    $stmt = $mysqli->prepare("UPDATE user SET cookie = ? WHERE email = ?");
    $stmt->bind_param("ss", $cookie, $email);
    $stmt->execute();
}

$res = "Login Success";
$servername = "128.205.36.4";
$username = "ywang298";
$password = "50336558";
$database = "cse442_2022_spring_team_c_db";
$mysqli = new mysqli($servername, $username, $password, $database);
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

if (!empty($_POST)) {
    $email = $_POST["email_phone_input"];
    $password = $_POST["password_input"];
    if (!emailExists($mysqli, $email)) {
        $res = "Email Doesn't Exist";
    } else if (!userPwdExists($mysqli, $email, $password)) {
        $res = "Wrong Password";
    } else {
        //Successful Login
        session_start();
        $_SESSION['email'] = $email;
        $cookie = hash("sha256", $email);
        setcookie("loginCookie", $cookie, time() + 3600);
        updateCookie($mysqli, $email, $cookie);
    }
}
echo $res;

$mysqli->close();
