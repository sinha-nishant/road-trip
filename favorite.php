<?php
session_start();

// Establish DB connection
$mysqli = new mysqli(getenv("HOST"), getenv("USER"), getenv("PASSWORD"), getenv("DB"));

// returns error code from db connection call
if ($mysqli->connect_error) {
    // there is an error if in this block
    echo $mysqli->connect_error;
    // terminates PHP program
    exit();
}

$mysqli->set_charset('utf8');

if (!isset($_POST["favorite_id"]) && !isset($_POST["location_id"])) {
    echo "unsuccessful";
    $mysqli->close();
    exit();
}

if (isset($_POST["location_id"])) {
	// Add favorite
    $sql = "INSERT INTO user_has_favorite(user_id, location_id) VALUES (?, ?);";
	$stmt = $mysqli->prepare($sql);
	$user_id = $_SESSION["id"];
	$location_id = $_POST["location_id"];
	$stmt->bind_param("ii", $user_id, $location_id);
} else {
	// Remove favorite
    $sql = "DELETE FROM user_has_favorite WHERE favorite_id = ?;";
	$stmt = $mysqli->prepare($sql);
	$favorite_id = $_POST["favorite_id"];
	$stmt->bind_param("i", $favorite_id);
}

$stmt->execute();

echo $mysqli->insert_id;
$mysqli->close();
?>