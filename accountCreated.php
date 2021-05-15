<?php
session_start();

// establish DB connection
$mysqli = new mysqli(getenv("HOST"), getenv("USER"), getenv("PASSWORD"), getenv("DB"));

// returns error code from db connection call
if ($mysqli->connect_error) {
	// there is an error if in this block
	echo $mysqli->connect_error;
	// terminates PHP program
	exit();
}

$mysqli->set_charset('utf8');

if (isset($_POST['email']) && !empty($_POST['email'])) {
	$email = $_POST['email'];
} else {
	$mysqli->close();
	exit();
}

if (isset($_POST['confirm-email']) && !empty($_POST['confirm-email'])) {
	$email = $_POST['confirm-email'];
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

// Insert account into database
$sql = "INSERT INTO user(email, password) VALUES (?, ?);";
$stmt = $mysqli->prepare($sql);
$pass = hash("sha512", $pass);
$stmt->bind_param("ss", $email, $pass);
$stmt->execute();

$_SESSION["id"] = $mysqli->insert_id;

$mysqli->close();

$_SESSION["email"] = $_POST["confirm-email"];
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Account Created</title>
	<style>
		.display-1 {
			width: 100vw;
			height: 50vw;
			display: flex;
			justify-content: center;
			align-items: center;
		}

		/* Tablet or smaller */
		@media (max-width: 991.9px) {
			.display-1 {
				font-size: 48px !important;
			}
		}

		@media (max-width: 768px) {
			.display-1 {
				font-size: 36px !important;
			}
		}
	</style>

	<!-- jQuery -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	<!-- Boostrap 4.6 CSS -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous" />

	<!-- Boostrap 4.6 js -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
</head>

<body>
	<?php include "navbar.php" ?>
	<div class="display-1">
		Account Created
	</div>
</body>

</html>