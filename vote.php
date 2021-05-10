<?php
session_start();
// establish DB connection
$host = "303.itpwebdev.com";
$user = "sinhan_db_user";
$password = "uscItp2021";
$db = "sinhan_road_trip";

// to use MySQLi extension
$mysqli = new mysqli($host, $user, $password, $db);

// returns error code from db connection call
if ($mysqli->connect_error) {
    // there is an error if in this block
    echo $mysqli->connect_error;
    // terminates PHP program
    exit();
}

$mysqli->set_charset('utf8');

if (!isset($_POST["upvote"])) {
    echo "unsuccessful";
    $mysqli->close();
    exit();
}

if ($_POST["upvote"] == "true") {
    $sql = "UPDATE sinhan_road_trip.restaurant SET upvotes = upvotes + 1 WHERE restaurant_id = ?;";
} else {
    $sql = "UPDATE sinhan_road_trip.restaurant SET upvotes = upvotes - 1 WHERE restaurant_id = ?;";
}

$stmt = $mysqli->prepare($sql);
$restaurant = $_POST["res_id"];
$stmt->bind_param("i", $restaurant);
$stmt->execute();

echo "successful";
$mysqli->close();
?>