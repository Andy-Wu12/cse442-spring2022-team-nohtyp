<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET, PUT, POST, DELETE");

function emailExists($mysqli, $email): bool
{
    $stmt = $mysqli->prepare("SELECT * FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $rows = $stmt->num_rows;
    return $rows != 0;
}

function cardNameExists($mysqli, $cardName, $email): bool
{
    $stmt = $mysqli->prepare("SELECT * FROM cards WHERE name = ? and email = ?");
    $stmt->bind_param("ss", $cardName, $email);
    $stmt->execute();
    $stmt->store_result();
    $rows = $stmt->num_rows;
    return $rows != 0;
}


function getCardsWithEmail($mysqli, $email): array
{
    $myArray = array();
    $stmt = $mysqli->prepare("SELECT * FROM cards WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();
    while($row = $res->fetch_array(MYSQLI_ASSOC)) {
        $myArray[] = $row;
    }
    return $myArray;
}


$res = "Login Success";
$servername = "128.205.36.4";
$db_username = "ywang298";
$db_password = "50336558";
$database = "cse442_2022_spring_team_c_db";
$mysqli = new mysqli($servername, $db_username, $db_password, $database);
$resp = array();

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET["email"])){
    $resp["status"] = "success";
    $resp["cards"] = getCardsWithEmail($mysqli, $_GET["email"]);
}
else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $post_body = file_get_contents('php://input');
    $json = json_decode($post_body);

    $user_email = $json->{'Email'};
    $new_card_name = $json->{'cardName'};
    $description = $json->{'description'};
    $extra_notes = $json->{'extra_notes'};
    $stackID = $json->{'stackID'};

    if (!emailExists($mysqli, $user_email)) {
        $resp["status"] = "error";
        $resp["error"] = "Email Doesn't Exist";
    } else {
        if(cardNameExists($mysqli, $new_card_name, $user_email)){
            $resp["status"] = "error";
            $resp["error"] = "Duplicate card name";
        }
        else{
            $stmt = $mysqli->prepare("INSERT INTO cards(name, description, extra_notes, email, stackID) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssi", $new_card_name, $description,$extra_notes, $user_email, $stackID);
            $stmt->execute();
            $resp["status"] = "success";
            $resp["email"] = $user_email;
            $resp["cardID"] = $stmt->insert_id;
        }
    }
}
else if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $post_body = file_get_contents('php://input');
    $json = json_decode($post_body);

    $user_email = $json->{'Email'};
    $new_card_name = $json->{'cardName'};
    $description = $json->{'description'};
    $extra_notes = $json->{'extra_notes'};
    $cardID = $json->{'cardID'};
    $stackID = $json->{'stackID'};

    $stmt = $mysqli->prepare("UPDATE cards SET name=?, description=?, extra_notes=?, stackID=? WHERE cardID=?");
    $stmt->bind_param("sssii", $new_card_name,$description,$extra_notes, $stackID, $cardID);
    $stmt->execute();
    $resp["status"] = "success";
}
else if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    $cardID = $_GET['cardID'];
    $stmt = $mysqli->prepare("DELETE FROM cards WHERE cardID=?");
    $stmt->bind_param("i", $cardID);
    $stmt->execute();
    $resp["status"] = "success";
}
else{
    $resp["status"] = "error";
    $resp["error"] = "Undefined API";
}
echo json_encode($resp);
//echo $_SERVER['REQUEST_METHOD'];