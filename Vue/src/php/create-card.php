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
$valid_form_submission = True;

$name = $_POST["name"];
$desc = $_POST["desc"];
$notes = $_POST["notes"];
$email = $_SESSION['email'];

// Find cards with same name. If none, execute insert, else show alert and redirect back to form page
$select_stmt = $mysqli->prepare("SELECT * FROM cards WHERE name = ? AND email = ?");
// echo $mysqli->error;
$select_stmt->bind_param("ss", $name, $email);
$select_stmt->execute();
$select_stmt->store_result();
// echo $mysqli->error;
// echo $mysqli->num_rows;

// If name already exists for user...
if($select_stmt->num_rows > 0) {
	$valid_form_submission = False;
}

if($valid_form_submission) {
// 	echo "valid form!";
	$stmt = $mysqli->prepare("INSERT INTO cards(name, description, extra_notes, email) VALUES (?, ?, ?, ?)");
// 	echo $mysqli->error;
	$stmt->bind_param("ssss", $name, $desc, $notes, $email);
	$stmt->execute();

	header("Location: ../create-card.html");
}
else {
	// Trigger alert describing unique name issue and redirect back to form once user confirms
	echo '<script type="text/javascript">
	alert("You cannot have more than one card of the same name! (Case sensitive)");
	window.location.href = "../create-card.html"</script>';
}


$mysqli->close();