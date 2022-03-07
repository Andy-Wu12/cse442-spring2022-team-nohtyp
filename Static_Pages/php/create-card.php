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

$email = $_SESSION['email'];

$stmt = $mysqli->prepare("INSERT INTO cards(name, description, due_date, extra_notes, email) VALUES (?, ?, ?, ?, ?)");
echo $mysqli->error;
$stmt->bind_param("sssss", $name, $desc, $due_date, $notes, $email);
$stmt->execute();

header("Location: ../RUD.html");

$mysqli->close();