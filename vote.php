<?php
session_start();

$mysqli = new mysqli(getenv("HOST"), getenv("USER"), getenv("PASSWORD"), getenv("DB"));

// returns error code from db connection call
if ($mysqli->connect_error) {
    // there is an error if in this block
    echo $mysqli->connect_error;
    // terminates PHP program
    exit();
}

$mysqli->set_charset('utf8');

if (!isset($_POST["res_id"])) {
    echo "unsuccessful";
    $mysqli->close();
    exit();
}

$user_id = $_SESSION["id"];
$restaurant = $_POST["res_id"];

// Remove upvote
if (isset($_POST["upvote_id"])) {
    $sql = "DELETE FROM sinhan_road_trip.user_has_upvote WHERE upvote_id = ?;";
    $stmt = $mysqli->prepare($sql);
    $upvote_id = $_POST["upvote_id"];
    $stmt->bind_param("i", $upvote_id);
    $stmt->execute();

    $sql = "UPDATE sinhan_road_trip.restaurant SET upvotes = upvotes - 1 WHERE restaurant_id = ?;";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $restaurant);
    $stmt->execute();
    echo "succesful";
    
} else {
    // Add upvote
    $sql = "UPDATE sinhan_road_trip.restaurant SET upvotes = upvotes + 1 WHERE restaurant_id = ?;";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $restaurant);
    $stmt->execute();

    $sql = "INSERT INTO sinhan_road_trip.user_has_upvote(user_id, restaurant_id) VALUES (?, ?);";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ii", $user_id, $restaurant);
    $stmt->execute();

    echo $mysqli->insert_id;
}

$mysqli->close();
?>