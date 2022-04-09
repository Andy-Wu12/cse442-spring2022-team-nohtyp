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
    $pwd = "";

    $stmt = $mysqli->prepare("SELECT user.password FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($pwd);

    $rows = $stmt->num_rows;
    if ($rows == 1) {
        $stmt->fetch();
        // echo password_verify($password, $pwd);
        return password_verify($password, $pwd);
    }
    return false;
}

function updateCookie($mysqli, $email, $cookie)
{
    $stmt = $mysqli->prepare("UPDATE user SET cookie = ? WHERE email = ?");
    $stmt->bind_param("ss", $cookie, $email);
    $stmt->execute();
}

$res = "Login Success";
$servername = "128.205.36.4";
$db_username = "ywang298";
$db_password = "50336558";
$database = "cse442_2022_spring_team_c_db";
$mysqli = new mysqli($servername, $db_username, $db_password, $database);
$resp = array();

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $post_body = file_get_contents('php://input');
    $json = json_decode($post_body);
    $user_email = $json->{'Email'};
    $user_password = $json->{'Password'};
    if (!emailExists($mysqli, $user_email)) {
        $resp["status"] = "error";
        $resp["error"] = "Email Doesn't Exist";
    } else if (!userPwdExists($mysqli, $user_email, $user_password)) {
        $resp["status"] = "error";
        $resp["error"] = "Wrong Password";
    } else {
        //Successful Login
        $resp["status"] = "success";
        session_start();
        $_SESSION['email'] = $user_email;
        $cookie = hash("sha256", $user_email);
        setcookie("loginCookie", $cookie, time() + 3600);
        updateCookie($mysqli, $user_email, $cookie);
    }
}
else{
    $resp["status"] = "error";
    $resp["error"] = "Undefined API";
}
echo json_encode($resp);
