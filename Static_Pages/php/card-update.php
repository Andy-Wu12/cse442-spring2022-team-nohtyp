<?php
# Updates the card name, card description, and tasks
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

$sql = "SELECT name, description FROM cards";    # only using the latest card name and description for now
$results = $mysqli->query($sql);

// $card_tasks = array(); # associative array -> (card_name => [tasks 1, task 2, ....])
// echo "<p>" . count($results) . "</p>";
// echo '<pre>'; print_r($results); echo '</pre>';
$old_name = "No card here.";
$old_desc = "No description.";
$found_results = false;
$latest_id = 0;
if ($results->num_rows > 0) {
    // output data of each row
    while($row = $results->fetch_assoc()) {
      $old_name = $row["name"];
      $old_name = $row["description"];
      $latest_id = $row["cardID"];
      $found_results = true;
      break;
    }
  } else {
    ;
  }
$new_name = htmlspecialchars($_POST["card_title"]);
$new_desc = htmlspecialchars($_POST["card_desc"]);

$sql = "UPDATE cards SET name='$new_name', description='$new_desc'  WHERE cardID=$latest_id";
if ($found_results){
    $mysqli->query($sql);
}

$mysqli->close();
?>