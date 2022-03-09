<?php

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
$name = $_POST["name"];
$desc = $_POST["desc"];
$due_date = $_POST["dueDate"];
$notes = $_POST["notes"];
$card_name = $_POST["cardName"]; // Force unique (case-insensitive) card names for each individual

$email = $_SESSION['email'];
$card_id = NULL; // Card name should be used to find corresponding unique cardID

if($card_name != "") {
	$card_stmt = $mysqli->prepare("SELECT * FROM cards WHERE name = ? AND email = ?");
    $card_stmt->bind_param("ss", $card_name, $email);
    $card_stmt->execute();
    $card_stmt->store_result();

    $result = $card_stmt->get_result();

    // Assume card doesn't exist unless you find it in db
    $card_exists = False;
    if($result->num_rows > 0) {
        $card_exists = True;
        // Find way to do this w/o while loop.
        // There will only ever be one row since no duplicate card_names allowed
        while($row = $result->fetch()) {
            $card_id = $row["cardID"];
            break;
        }
    }
    else {
        // Trigger alert describing card_name issue and redirect back to form once user confirms
        echo '<script type="text/javascript">
        alert("Cannot assign task to a card that doesn\'t exist!");
        window.location.href = "../create-task.html"</script>';
    }
}

$stmt = $mysqli->prepare("INSERT INTO tasks(name, description, due_date, extra_notes, card_id, email) VALUES (?, ?, ?, ?, ?, ?)");
// echo $mysqli->error;
$stmt->bind_param("ssssis", $name, $desc, $due_date, $notes, $card_id, $email);
$stmt->execute();

header("Location: ../RUD.html");

$mysqli->close();