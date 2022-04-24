<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET, PUT, POST, DELETE");

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
        $resp["email"] = $user_email;
        session_start();
        $_SESSION['email'] = $user_email;
        $cookie = hash("sha256", $user_email);
        setcookie("token", $cookie, time() + 3600);
        $resp["token"] = $cookie;
        updateCookie($mysqli, $user_email, $cookie);
    }
}
else if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $post_body = file_get_contents('php://input');
    $json = json_decode($post_body);

    $user_email = $json->{'email'};
    $old_password = $json->{'password'};
    $new_password = $json->{'newPassword'};

    if(!userPwdExists($mysqli, $user_email, $old_password)){
        $resp["status"] = "error";
        $resp["error"] = "Wrong Password";
    }
    else{
        $new_password = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $mysqli->prepare("UPDATE user SET password=? WHERE email=?");
        $stmt->bind_param("ss", $new_password,$user_email);
        $stmt->execute();
        $resp["status"] = "success";
    }
}
else if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    $post_body = file_get_contents('php://input');
    $json = json_decode($post_body);
    $email = $_GET['email'];
    $stmt = $mysqli->prepare("DELETE FROM user WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    //delete all stacks
    $stmt = $mysqli->prepare("DELETE FROM stacks WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resp["status"] = "success";
}
else{
    $resp["status"] = "error";
    $resp["error"] = "Undefined API";
}
echo json_encode($resp);
