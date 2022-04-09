<?php

$res = "Creation successful!";
$servername = "128.205.36.4";
$username = "felipega";
$password = "50315438";
$database = "cse442_2022_spring_team_c_db";

$mysqli = new mysqli($servername, $username, $password, $database);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
session_start();
$email = $_SESSION['email'];
echo "<p>Cards for user: $email</p>";
$card_tasks = array(); # associative array -> (card_name => [tasks 1, task 2, ....])
$card_info = array();   # 2d array -> ( (card_name, card_description), ... )

// Retrieve card info 
$select_stmt = $mysqli->prepare("SELECT name, description, cardID FROM cards WHERE email = ?");
$select_stmt->bind_param("s", $email);
$select_stmt->execute();
$select_stmt->store_result();
$select_stmt->bind_result($name, $description, $card_id);


if ($select_stmt->num_rows > 0) {
    while ($row = $select_stmt->fetch()) {
        $card_tasks[$card_id] = array();
        $card_info[] = array($name, $description);
    }
}

$task_stmt = $mysqli->prepare("SELECT name, description, taskID, cardID FROM tasks WHERE email = ?");
$task_stmt->bind_param("s", $email);
$task_stmt->execute();
$task_stmt->store_result();
$task_stmt->bind_result($name, $description, $task_id, $card_id);

$unassigned_tasks = array();

if ($task_stmt->num_rows > 0) {
    while ($row = $task_stmt->fetch()) {
        if ($card_id != NULL) {
            $card_tasks[$card_id][] = array($name, $description, $task_id);
        } else {
            $unassigned_tasks[] = array($name, $description, $task_id);
        }
    }
}

function generate_input($type, $name, $value)
{
    $input_string = "<input type='$type' name='$name' value='$value'><br>";
    echo $input_string;
}

function generate_task_input($type, $name, $value, $is_title)
{
    $input_string = '';
    if ($is_title) {
        $input_string = "<li><input type='$type' name='$name' value='$value'></li>";
    } else {
        $input_string = "<ul><li><input type='$type' name='$name' value='$value'></li></ul>";
    }
    echo $input_string;
}

?>