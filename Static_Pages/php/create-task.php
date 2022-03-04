<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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

$card_name = $_POST["cardName"]; // Force unique card names for each individual
$card_id = 12; // Card name should be used to find corresponding unique ID global to all users

$email = $_SESSION['email'];

$stmt = $mysqli->prepare("INSERT INTO tasks(name, description, due_date, extra_notes, card_id, email) VALUES (?, ?, ?, ?, ?, ?)");
// echo $mysqli->error;
$stmt->bind_param("ssssss", $name, $desc, $due_date, $notes, $card_id, $email);
$stmt->execute();

header("Location: ../RUD.html");

$mysqli->close();