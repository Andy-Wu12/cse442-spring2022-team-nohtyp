<?php
header("Access-Control-Allow-Origin: http://localhost:8080");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Credentials: true");
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

function taskNameExists($mysqli, $taskName, $email): bool
{
    $stmt = $mysqli->prepare("SELECT * FROM tasks WHERE name = ? and email = ?");
    $stmt->bind_param("ss", $taskName, $email);
    $stmt->execute();
    $stmt->store_result();
    $rows = $stmt->num_rows;
    return $rows != 0;
}


function getTasksWithEmail($mysqli, $email): array
{
    $myArray = array();
    $stmt = $mysqli->prepare("SELECT * FROM tasks WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($row = $res->fetch_array(MYSQLI_ASSOC)) {
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
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET["email"])) {
    $resp["status"] = "success";
    $resp["tasks"] = getTasksWithEmail($mysqli, $_GET["email"]);
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $post_body = file_get_contents('php://input');
    $json = json_decode($post_body);

    $new_task_name = $json->{'taskName'};
    $description = $json->{'description'};
    $extra_notes = $json->{'extra_notes'};
    $cardID = $json->{'cardID'};
    $user_email = $json->{'Email'};
    $due_date = $json->{'due_date'};
    $pos = strripos($due_date, ".");
    if($pos != FALSE){
        $due_date = substr($due_date, 0, $pos);
    }
    if (!emailExists($mysqli, $user_email)) {
        $resp["status"] = "error";
        $resp["error"] = "Email Doesn't Exist";
    } else {
        if (taskNameExists($mysqli, $new_task_name, $user_email)) {
            $resp["status"] = "error";
            $resp["error"] = "Duplicate task name";
        } else {
            $stmt = $mysqli->prepare("INSERT INTO tasks(name, description, extra_notes, cardID, email, due_date) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $new_task_name, $description, $extra_notes, $cardID, $user_email, $due_date);
            $stmt->execute();
            $resp["status"] = "success";
            $resp["email"] = $user_email;
            $resp["taskID"] = $stmt->insert_id;
        }
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $post_body = file_get_contents('php://input');
    $json = json_decode($post_body);

    $new_task_name = $json->{'taskName'};
    $description = $json->{'description'};
    $extra_notes = $json->{'extra_notes'};
    $cardID = $json->{'cardID'};
    $taskID = $json->{'taskID'};
    $user_email = $json->{'Email'};
    $due_date = $json->{'due_date'};
    $pos = strripos($due_date, ".");
    if($pos != FALSE){
        $due_date = substr($due_date, 0, $pos);
    }

    $stmt = $mysqli->prepare("UPDATE tasks SET name=?, description=?, extra_notes=?, cardID=?,due_date=? WHERE taskID=?");
    $stmt->bind_param("sssssi", $new_task_name, $description, $extra_notes, $cardID, $due_date, $taskID);
    $stmt->execute();
    $resp["status"] = "success";
} else if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    $taskID = $_GET['taskID'];
    $stmt = $mysqli->prepare("DELETE FROM tasks WHERE taskID=?");
    $stmt->bind_param("i", $taskID);
    $stmt->execute();
    $resp["status"] = "success";
} else {
    $resp["status"] = "error";
    $resp["error"] = "Undefined API";
}
echo json_encode($resp);
//echo $_SERVER['REQUEST_METHOD'];