<?php
session_start();

if (isset($_POST['email']) && !empty($_POST['email'])) {
	$email = $_POST['email'];
} else {
	$mysqli->close();
	exit();
}

if (isset($_POST['password']) && !empty($_POST['password'])) {
	$pass = $_POST['password'];
} else {
	$mysqli->close();
	exit();
}

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

function processQuery($mysqli, $stmt)
{
    $stmt->execute();
    $results = $stmt->get_result();
    if (!$results) {
        echo $mysqli->error;
		$mysqli->close();
        exit();
    }
    return $results;
}

$sql = "SELECT * FROM user WHERE email = ? AND password = ?";
$stmt = $mysqli->prepare($sql);
$email = $_POST["email"];
$pass = hash("sha512", $_POST["password"]);
$stmt->bind_param("ss", $email, $pass);
$result = processQuery($mysqli, $stmt);
if ($result->num_rows == 0) {
	$mysqli->close();
    echo "invalid";
}
else {
	$_SESSION["email"] = $email;
    $_SESSION["id"] = ($result->fetch_assoc())["user_id"];
	$mysqli->close();
	echo "";
	exit();
}
?>