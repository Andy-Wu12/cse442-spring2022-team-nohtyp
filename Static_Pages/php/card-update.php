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

# Get the names of all the cards for a user
function get_card_names(mysqli &$connection, $user_email)
{
    $card_names = array();
    $stmt = $connection->prepare("SELECT name FROM cards WHERE email=?");
    $stmt->bind_param('s', $user_email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($name);
    if ($stmt->num_rows > 0) {
        while ($row = $stmt->fetch()) {
            $card_names[] = $name;
        }
    }
    return $card_names;
}

# Get the current name if a card in the database given the cardID
function get_current_name(mysqli &$connection, $card_id)
{
    $cur_name = '';
    $stmt = $connection->prepare("SELECT name FROM cards WHERE cardID=?");
    $stmt->bind_param('s', $card_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($name);
    if ($stmt->num_rows > 0) {
        while ($row = $stmt->fetch()) {
            $cur_name = $name;
        }
    }
    return $cur_name;
}

# Returns the number of duplicates
function count_duplicates(mysqli &$connection, $query_card_name, $user_email)
{
    $stmt = $connection->prepare("SELECT * FROM cards WHERE name=? and email=?");
    $stmt->bind_param('ss', $query_card_name, $user_email);
    $stmt->execute();
    $stmt->store_result();
    return $stmt->num_rows;
}

# Returns alert when a duplicate card name was entered
function duplicate_alert()
{
    echo '<script type="text/javascript">
    alert("You cannot have more than one card of the same name! (Case sensitive)");
    window.location.href = "../RUD.php"</script>';
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

$email = $_SESSION['email'];
# Check for duplicate card names before updating or deleting
$duplicate_exists = false;
if (empty($_POST['submit']) == false) {
    foreach ($_POST as $name => $value) {
        # We're only checking for card names
        if (strpos($name, 'cardTitle') === false) {
            continue;
        }
        $card_name = $value;
        $card_id = (int)explode('_', $name)[1];
        $duplicates = count_duplicates($mysqli, $card_name, $email);
        $old_val = get_current_name($mysqli, $card_id);

        $old_num = $duplicates;
        # If no change was made to the card name
        if ($old_val === $card_name){
            $duplicates -= 1;
        }
        # If there's another card with the same name
        if ($duplicates > 0) {
            $duplicate_exists = true;
            break;
        }
    }
}

# Changes are only made when a duplicate card name does not exists
# If update was clicked
if (empty($_POST['submit']) == false && $duplicate_exists == false) {
    foreach ($_POST as $name => $value) {
        # Check for duplicate card names

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
if ($duplicate_exists == false) {
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
}

if ($duplicate_exists) {
    duplicate_alert();
} else {
    header("Location: ../RUD.php");
}

$mysqli->close();

?>
