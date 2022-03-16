<?php
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);


function emailExists($mysqli, $email): bool
{
//    echo $email;
    $stmt = $mysqli->prepare("SELECT * FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $rows = $stmt->num_rows;
//    echo $rows;
    return $rows != 0;
}

$res = 0;
$servername = "128.205.36.4";
$username = "ywang298";
$password = "50336558";
$database = "cse442_2022_spring_team_c_db";
$mysqli = new mysqli($servername, $username, $password, $database);
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
//echo "<h1>Connection Succeeded\n</h1>";
$db_list = mysqli_query($mysqli, "SHOW DATABASES");
$sql = "SHOW DATABASES";
$result = $mysqli->query($sql);
//if ($result->num_rows > 0) {
//    while ($row = $result->fetch_assoc()) {
////        echo "Database: " . $row["Database"] . "<br>";
//    }
//}
//
//foreach ($_POST as $key => $value) {
////    echo "{$key} => {$value} " . "<br>";
//}

if (!empty($_POST)) {
//    echo "<h2>email_phone: " . $_POST["email_phone_input"] . "</h2>";
//    echo "<h2>password: " . $_POST["password_input"] . "</h2>";
//    echo "<h2>confirm_password: " . $_POST["confirm_password_input"] . "</h2>";
    $stmt = $mysqli->prepare("INSERT INTO user(password, email) VALUES (?, ?)");
    $password = password_hash($_POST["password_input"], PASSWORD_DEFAULT);

    echo $password;

    $email = $_POST["email_phone_input"];
    if (!emailExists($mysqli, $email)) {
        $stmt->bind_param("ss", $password, $email);
        echo $stmt->error;
        echo $mysqli->error;
        $stmt->execute();
        echo $stmt->error;
        echo $mysqli->error;
    } else {
//        echo " EMAIL ALREADY EXISTS";
        $res = 1;
    }
}
echo $res;

$mysqli->close();
//
//foreach ($arr as $key => $value) {
//    echo "{$key} => {$value} ";
//    print_r($arr);
//}