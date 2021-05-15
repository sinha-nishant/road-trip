<?php
session_start();

// to use MySQLi extension
$mysqli = new mysqli(getenv("HOST"), getenv("DB_USER"), getenv("PASSWORD"), getenv("DB"));

// returns error code from db connection call
if ($mysqli->connect_error) {
    // there is an error if in this block
    echo $mysqli->connect_error;
    // terminates PHP program
    exit();
}

$mysqli->set_charset('utf8');

// Dropdown itinerary options
$sql = "SELECT day_id, region_name from day;";
$stmt = $mysqli->prepare($sql);
$stmt->execute();
$results = $stmt->get_result();
if (!$results) {
    echo $mysqli->error;
    exit();
}
$days = $results->fetch_all(MYSQLI_ASSOC);

$mysqli->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Create Account</title>
    <lang="en" />
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Boostrap 4.6 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous" />

    <!-- Boostrap 4.6 js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

    <style>
        body {
            height: 100vh;
        }

        #submitBtn:hover {
            background-color: white !important;
            color: black !important;
            border-style: solid !important;
            border-color: black;
            transform: scale(1.1);
            transition-duration: 0.4s;
        }
    </style>
</head>

<body>
    <?php include('navbar.php'); ?>

    <div class="container-fluid d-flex align-items-center justify-content-center h-75 mt-1 mt-lg-0 pb-0 mb-0 px-lg-5">
        <form action="accountCreated.php" method="POST" name="create-form" class="col-sm-6 col-md-4 col-lg-4">
            <h1 class="text-center mb-5">Create Account</h1>
            <div>
                <input name="email" type="email" class="form-control form-control-lg rounded-pill" id="email" placeholder="Email" required />
                <div id="email-error" class="pt-3 text-danger"></div>
            </div>
            <div>
                <input name="confirm-email" type="email" class="form-control form-control-lg rounded-pill mt-3" id="confirm-email" placeholder="Confirm Email" required />
                <div id="confirm-email-error" class="pt-3 text-danger"></div>
            </div>
            <div>
                <input name="password" type="password" class="form-control form-control-lg mt-3 rounded-pill" id="password" placeholder="Password" required />
                <div id="password-error" class="pt-3 text-danger"></div>
            </div>
            <div class="d-flex justify-content-center">
                <button id="submitBtn" type="submit" class="btn btn-lg btn-block mt-5 bg-dark text-white rounded-0 w-50">
                    Create
                </button>
            </div>
        </form>
    </div>
    <script>
        $(function() {
            $('form[name="create-form"]').submit(function(event) {
                if (
                    $("#email").val().trim() !=
                    $("#confirm-email").val().trim()
                ) {
                    event.preventDefault();
                    $("#confirm-email-error").text("Emails do not match");
                }

                if ($("#password").val().trim().length == 0) {
                    event.preventDefault();
                    $("#password-error").text("Invalid Password");
                }
            });
        });
    </script>
</body>

</html>