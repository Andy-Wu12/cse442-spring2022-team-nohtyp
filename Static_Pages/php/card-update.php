<?php
# Updates the card name, card description, and tasks

function update_row(mysqli &$connection, $table, $to_set, $new_val, $id_column, $id)
{
    $stmt = $connection->prepare("UPDATE $table SET $to_set=? WHERE $id_column=?");
    $stmt->bind_param('ss', $new_val, $id);
    $stmt->execute();
}

function delete_row(mysqli &$connection, $table, $id_column, $id)
{
    $stmt = $connection->prepare("DELETE FROM $table WHERE $id_column=?");
    $stmt->bind_param('s', $id);
    $stmt->execute();

}

# get all tasks associated with a card in a 2d array
# Return val = [ [task name, task description, task id], ... ]
function get_tasks(mysqli &$connection, $card_id)
{
    $task_stmt = $connection->prepare("SELECT name, description, taskID FROM tasks WHERE cardID = ?");
    $task_stmt->bind_param("s", $card_id);
    $task_stmt->execute();
    $task_stmt->store_result();
    $task_stmt->bind_result($name, $description, $task_id);

    $tasks = array();
    if ($task_stmt->num_rows > 0) {
        while ($row = $task_stmt->fetch()) {
            $tasks[] = array($name, $description, $task_id);
        }
    }
    return $tasks;
}

$res = "Creation successful!";
$servername = "128.205.36.4";
$username = "awu46";
$password = "50335350";
$database = "cse442_2022_spring_team_c_db";

$mysqli = new mysqli($servername, $username, $password, $database);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
session_start();

# If update was clicked
if (empty($_POST['submit']) == false) {
    foreach ($_POST as $name => $value) {
        $name_split = explode("_", $name);
        $deleting = true;
        $prefix = $name_split[0];
        $id = (int)$name_split[1];
        $new_val = htmlspecialchars($value);

        switch ($prefix) {
            case 'cardTitle':
                update_row($mysqli, 'cards', 'name', $new_val, 'cardID', $id);
                break;
            case 'cardDesc':
                update_row($mysqli, 'cards', 'description', $new_val, 'cardID', $id);
                break;
            case 'taskTitle':
                update_row($mysqli, 'tasks', 'name', $new_val, 'taskID', $id);
                break;
            case 'taskDesc':
                update_row($mysqli, 'tasks', 'description', $new_val, 'taskID', $id);
                break;
        }
    }
}
# if delete was clicked
foreach ($_POST as $name => $value) {
    //    # if substring 'delete' is not in $name then continue
    # I hate php
    if (strpos($name, 'delete') === false) {
        continue;
    }
    $name_split = explode("_", $name);
    $type = $name_split[1];
    $id = (int)$name_split[2];
    if ($type == 'card') {
        // Delete all associated tasks first
        $assoc_tasks = get_tasks($mysqli, $id);
        foreach ($assoc_tasks as $task) {
            $task_id = $task[2];
            delete_row($mysqli, 'tasks', 'taskID', $task_id);
        }
        delete_row($mysqli, 'cards', 'cardID', $id);
    } elseif ($type == 'task') {
        // Delete the lone task
        delete_row($mysqli, 'tasks', 'taskID', $id);
    }
}

//
//foreach ($_POST as $name => $value) {
//    # if substring '_' is not in $name then continue
//    if (strpos($name, '_') == false) {
//        continue;
//    }
//    $name_split = explode("_", $name);
//    $deleting = true;
//    $prefix = $name_split[0];
//    $id = $name_split[1];
//
//    # if not deleting something
//    if (empty($_POST['submit']) == false) {
//        $deleting = false;
//        $id = (int)$name_split[1];
//    }
//
//    # Update all values
//    $new_val = htmlspecialchars($value);
//    if ($deleting == false) {
//        switch ($prefix) {
//            case 'cardTitle':
//                update_row($mysqli, 'cards', 'name', $new_val, 'cardID', $id);
//                break;
//            case 'cardDesc':
//                update_row($mysqli, 'cards', 'description', $new_val, 'cardID', $id);
//                break;
//            case 'taskTitle':
//                update_row($mysqli, 'tasks', 'name', $new_val, 'taskID', $id);
//                break;
//            case 'taskDesc':
//                update_row($mysqli, 'tasks', 'description', $new_val, 'taskID', $id);
//                break;
//        }
//    } else {
//        // Now Handle deleting
//        // A card/task is deleted when the input field is left blank then updated
//        // If a card is deleted then delete all associated tasks first
//        $type = $name_split[1];
//        $id = (int)$name_split[2];
//        $card_id = -1;
//        if (strpos($prefix, 'card')) {
//            $card_id = $id;
//        }
//        # if card is being deleted
//        if ($card_id != -1) {
//            $assoc_tasks = get_tasks($mysqli, $card_id);
//            foreach ($assoc_tasks as $task) {
//                $task_id = $task[2];
//                delete_row($mysqli, 'tasks', 'taskID', $task_id);
//            }
//            delete_row($mysqli, 'cards', 'cardID', $card_id);
//        } else {
//            # delete single task
//            delete_row($mysqli, 'tasks', 'taskID', $id);
//        }
//    }
//}
header("Location: ../RUD.php");

$mysqli->close();

?>
