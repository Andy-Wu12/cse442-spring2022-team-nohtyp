<?php
// TODO - This is for the static example. Will remove later
$res = "Creation successful!";
$servername = "128.205.36.4";
$username = "felipega";
$password = "50315438";
$database = "cse442_2022_spring_team_c_db";

$mysqli = new mysqli($servername, $username, $password, $database);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
    echo "<p>connection failed</p>";
}
session_start();

// Retrieve card info 
$sql = "SELECT name, description FROM cards ORDER BY cardID";    # only using the latest card name and description for now
$results = $mysqli->query($sql);

// $card_tasks = array(); # associative array -> (card_name => [tasks 1, task 2, ....])
echo "<p>" . count($results) . "</p>";
echo '<pre>'; print_r($results); echo '</pre>';
$card_name = "";
$card_desc = "";

// if ($results->num_rows > 0){
//     while($row = $results->fetch_assoc()){
//         // $card_tasks += array($row["name"] => array());
//         $card_name = $row["name"];    // Used for hardcoded stuff
//         $card_desc = $row["description"];
//         echo "<p>card name is $card_name and card_desc is $card_desc</p>"
//         break;
//     }
// else{
//     echo "No cards in database. <br>";
// }   
// }

// // Retrieve info
// // Does not handle the case where there is no card
// // This only works if the card name is passed as the parameter in "name" instead of the label
// $sql = "SELECT * FROM tasks";
// $results = $mysql->query($sql);
// $_SESSION["tasks"] = array()

// if ($results->num_rows > 0){
//     while($row = $results->fetch_assoc()){
//         $card_title = $row["card_id"]
//         if (array_key_exists($card_title, $card_tasks)){    # if there is card associated with the task
//             $card_tasks[$card_title][] = $row["description"]; 
//             break;
//         }
//         if(strtolower($card_title) == strtolower($_SESSION["card_name"]) ){ // hardcoded stuff
//             $_SESSION["tasks"][] = $row["description"];
//         }
//     }
// else{
//     echo "No tasks in database. <br>"
// }
// }

// // Print all tasks associated with a card name
// function print_tasks($card_name){
//     if (in_array($card_name, $GLOBAL['card_tasks'])){
//         $tasks = $GLOBAL['card_tasks'][$card_name]
//         foreach ($tasks as $task){
//             echo "<li><input type='test' value="$task"></li>"
//         }
//     } else{
//         echo "<li></li>"
//     }
// }

?>