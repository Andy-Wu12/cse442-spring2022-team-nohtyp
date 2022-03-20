<?php
# Updates the card name, card description, and tasks
$res = "Creation successful!";
$servername = "128.205.36.4";
$username = "awu46";
$password = "50335350";
$database = "cse442_2022_spring_team_c_db";

$email = $_SESSION['email'];
$mysqli = new mysqli($servername, $username, $password, $database);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
session_start();

$sql = ("DELETE FROM cards WHERE email=$email");
$mysqli->query($sql);

$sql = ("DELETE FROM tasks WHERE email=$email");
$mysqli->query($sql);

$mysqli->close();
?>