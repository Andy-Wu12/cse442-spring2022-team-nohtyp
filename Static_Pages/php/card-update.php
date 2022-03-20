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

foreach ($_POST as $name => $value){
  # if substring '_' is not in $name then continue
  if (strpos($name, '_') == false){
    continue;
  }
  $name_split = explode("_", $name);

  $prefix = $name_split[0];
  $id = (int) $name_split[1];

  $new_val = htmlspecialchars($value);
  if ($prefix == 'cardTitle'){
    $stmt = $mysqli->prepare("UPDATE cards SET name=? WHERE cardID=?");
    $stmt->bind_param('si', $new_val, $id);
    $stmt->execute();
  }
  elseif ($prefix == "cardDesc"){
    $stmt = $mysqli->prepare("UPDATE cards SET description=? WHERE cardID=?");
    $stmt->bind_param('si', $new_val, $id);
    $stmt->execute();
  }
  elseif ($prefix == "taskTitle"){
    $stmt = $mysqli->prepare("UPDATE tasks SET name=? WHERE taskID=?");
    $stmt->bind_param('ss', $new_val, $id);
    $stmt->execute();
  }
  elseif ($prefix == "taskDesc"){
    $stmt = $mysqli->prepare("UPDATE tasks SET description=? WHERE taskID=?");
    $stmt->bind_param('ss', $new_val, $id);
    $stmt->execute();
  }
  else{
    continue;
  }
}


// $sql = "SELECT * FROM cards ORDER BY cardID DESC LIMIT 1";    # only using the latest card name and description for now
// $results = $mysqli->query($sql);

// $card_tasks = array(); # associative array -> (card_name => [tasks 1, task 2, ....])
// // echo "<p>" . count($results) . "</p>";
// // echo '<pre>'; print_r($results); echo '</pre>';
// $old_name = "No card here.";
// $old_desc = "No description.";
// $found_results = false;
// $latest_id = 0;
// if ($results->num_rows > 0) {
//     // output data of each row
//     while($row = $results->fetch_assoc()) {
//       $old_name = $row["name"];
//       $old_name = $row["description"];
//       $latest_id = $row["cardID"];
//       $found_results = true;
//       break;
//     }
//   } else {
//     ;
//   }
// $new_name = htmlspecialchars($_POST["card_title"]);
// $new_desc = htmlspecialchars($_POST["card_desc"]);
// $stmt = $mysqli->prepare("UPDATE cards SET name= ?, description=?  WHERE cardID=?");
// $mysqli->bind_param('ssi', $new_name, $new_desc, $latest_id);
// // $sql = "UPDATE cards SET name='$new_name', description='$new_desc'  WHERE cardID=$latest_id";
// if ($found_results){
//     // $mysqli->query($sql);
//     $mysqli->execute();
// }

header("Location: ../RUD.php");

$mysqli->close();

?>
