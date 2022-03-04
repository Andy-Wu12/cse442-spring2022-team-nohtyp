<?php

function getEmailWithCookie($mysqli, $cookie): string
{
    $email = "";
    $stmt = $mysqli->prepare("SELECT email FROM user WHERE cookie = ?");
    $stmt->bind_param("s", $cookie);
    $stmt->execute();
    $stmt->bind_result($email);
    $stmt->fetch();
    $stmt->close();
    return $email;
}

session_start();
$res = "Login Success";
$servername = "128.205.36.4";
$username = "ywang298";
$password = "50336558";
$database = "cse442_2022_spring_team_c_db";
$mysqli = new mysqli($servername, $username, $password, $database);
$resp = array();
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if (isset($_COOKIE["loginCookie"]) && strlen($_COOKIE["loginCookie"]) == 64) {
        $resp["logged_in"] = "true";
        $_SESSION["email"] = getEmailWithCookie($mysqli, $_COOKIE["loginCookie"]);
        if (isset($_GET["param"])) {
            if ($_GET["param"] == "email") {
                $resp["email"] = $_SESSION["email"];
            } else if ($_GET["param"] == "clearsession") {
                setcookie("loginCookie", "", time() - 1);
                header("Location: ../login.html");
            }
        }
    } else {
        $resp["logged_in"] = "false";
    }
}
echo json_encode($resp);