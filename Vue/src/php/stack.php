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

function stackNameExists($mysqli, $stackName, $email): bool
{
    $stmt = $mysqli->prepare("SELECT * FROM stacks WHERE name = ? and email = ?");
    $stmt->bind_param("ss", $stackName, $email);
    $stmt->execute();
    $stmt->store_result();
    $rows = $stmt->num_rows;
    return $rows != 0;
}


function getStacksWithEmail($mysqli, $email): array
{
    $myArray = array();
    $stmt = $mysqli->prepare("SELECT * FROM stacks WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();
    while($row = $res->fetch_array(MYSQLI_ASSOC)) {
        $myArray[] = $row;
    }
    return $myArray;
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
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET["email"])){
    $resp["status"] = "success";
    $resp["stacks"] = getStacksWithEmail($mysqli, $_GET["email"]);
}
else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $post_body = file_get_contents('php://input');
    $json = json_decode($post_body);
    $user_email = $json->{'Email'};
    $new_stack_name = $json->{'stackName'};
    if (!emailExists($mysqli, $user_email)) {
        $resp["status"] = "error";
        $resp["error"] = "Email Doesn't Exist";
    } else {
        if(stackNameExists($mysqli, $new_stack_name, $user_email)){
            $resp["status"] = "error";
            $resp["error"] = "Duplicate stack name";
        }
        else{
            $stmt = $mysqli->prepare("INSERT INTO stacks(name, email) VALUES (?, ?)");
            $stmt->bind_param("ss", $new_stack_name, $user_email);
            $stmt->execute();
            $resp["status"] = "success";
            $resp["email"] = $user_email;
            $resp["stackID"] = $stmt->insert_id;
        }
    }
}
else if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $post_body = file_get_contents('php://input');
    $json = json_decode($post_body);
    $stackID = $json->{'stackID'};
    $new_stack_name = $json->{'stackName'};
    $stmt = $mysqli->prepare("UPDATE stacks SET name=? WHERE stackID=?");
    $stmt->bind_param("si", $new_stack_name, $stackID);
    $stmt->execute();
    $resp["status"] = "success";
}
else if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    $stmt = $mysqli->prepare("DELETE FROM stacks WHERE stackID=?");
    $stmt->bind_param("i", $_GET["stackID"]);
    $stmt->execute();
    $resp["status"] = "success";
}
else{
    $resp["status"] = "error";
    $resp["error"] = "Undefined API";
}
echo json_encode($resp);
//echo $_SERVER['REQUEST_METHOD'];