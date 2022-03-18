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


// Retrieve card info 
$sql = "SELECT * description FROM cards";    # only using the card name and description for now
$results = $mysqli->query($sql);

$card_tasks = array(); # associative array -> (card_name => [tasks 1, task 2, ....])

if ($results->num_rows > 0) {
    $index = 0;
    while ($row = $results->fetch_assoc()) {
        // echo "id: " . $row["id"]. " - Name: " . $row["name"]. "Description: " . $row["description"]. "<br>";
        $card_tasks[$row["name"]] = array();
        $_SESSION["Card_$index"] = $row["name"];    // Used for hardcoded stuff
        $index += 1;
    }
}
//else{
//        echo "No cards in database. <br>";
//    }
//}


// Retrieve info
// Does not handle the case where there is no card
// This only works if the card name is passed as the parameter in "name" instead of the label
$sql = "SELECT * FROM cards";
$results = $mysqli->query($sql);


?>