<?php
function emailExists($mysqli, $email): bool
{
//    echo $email;
    $stmt = $mysqli->prepare("SELECT * FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $rows = $stmt->num_rows;
//    echo $rows;
    return $rows != 0;
}

$res = 0;
$servername = "128.205.36.4";
$username = "ywang298";
$password = "50336558";
$database = "cse442_2022_spring_team_c_db";
$mysqli = new mysqli($servername, $username, $password, $database);
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
$db_list = mysqli_query($mysqli, "SHOW DATABASES");
$sql = "SHOW DATABASES";
$result = $mysqli->query($sql);
$resp = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $post_body = file_get_contents('php://input');
    $json = json_decode($post_body);
    $password = password_hash($json->{'Password'}, PASSWORD_DEFAULT);
    $email = $json->{'Email'};

    $stmt = $mysqli->prepare("INSERT INTO user(password, email) VALUES (?, ?)");

    if (!emailExists($mysqli, $email)) {
        $stmt->bind_param("ss", $password, $email);
        $stmt->execute();
        $resp["status"] = "success";
    } else {
        $resp["status"] = "error";
        $resp["error"] = "Email already exists";
    }
}
echo json_encode($resp);