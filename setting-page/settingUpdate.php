<?php

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

function get_userid(mysqli &$connection, $email)
{
	$user_id = -1;
	$stmt = $connection->prepare("SELECT name FROM cards WHERE email=?");
	$stmt->bind_param("s", $email);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($id);
	 if ($stmt->num_rows > 0) {
        		while ($row = $stmt->fetch()) {
            		$user_id = $id;
        }
    }
	return $user_id;

	
}

# For debugging purposes
function get_user(mysqli &$connection, $user_id)
{
	$user_info = array();
	$stmt = $connection->prepare('SELECT username, email, password FROM user WHERE userid=?');
	$stmt->bind_param("s", $user_id);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($username, $ret_email, $password);
if ($stmt->num_rows > 0) {
        while ($row = $stmt->fetch()) {
            $user_info[] = $username;
	$user_info[] = $ret_email;
	$user_info[] = $password;
        }
    }
	Return $user_info;
}



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

$email = $_SESSION['email'];
$user_id = get_userid($mysqli, $email);
echo '<p>Email: $email UserID: $user_id</p>';




# if updating a user
If (empty($_POST["update"]) == false){
	$new_username = $_POST["Email"];
	$new_password = $_POST["password"];
	If (!empty($_POST["Email"]) and !empty($_POST["password"])){
		// TODO - CHANGE THIS 
		update_row($mysqli, "user", "username", $new_username, "email", $email);
		update_row($mysqli, "user", "password", $new_username, "email", $email);
		# $_SESSION[‘email’] = $email;
	}
}

echo "<p>";
print_r(get_user($mysqli, $user_id));

echo "</p>";
//header("Location: ../RUD.php");
$mysqli->close();
?>
