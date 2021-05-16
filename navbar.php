<?php

// establish DB connection
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
    <title>Navbar</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <style>
        .nav-item:hover {
            text-decoration: underline;
        }

        .dropdown:hover .dropdown-menu {
            display: block;
            margin-top: 0;
        }

        .dropdown-item:hover {
            background-color: black;
            color: white;
        }

        i {
            padding-right: 5px;
        }
    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

</head>

<body>
    <nav class="navbar navbar-expand-md navbar-light mt-3 ml-lg-4">
        <a class="navbar-brand h1 mb-0" href="index.php">Road Trip</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <?php if (!isset($_SESSION["email"])) : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="createAccount.php">Create Account</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                <?php endif; ?>
                <?php if (isset($_SESSION["email"])) : ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php echo $_SESSION["email"] ?>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="logout.php">Logout</a>
                        </div>
                    </li>
                <?php endif; ?>

                <li class="nav-item">
                    <a class="nav-link" href="favorites.php">Favorites</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="upvotedRestaurants.php">Upvoted Restaurants</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php if ($_SERVER['SCRIPT_NAME'] == "/index.php") : ?>
                            Itinerary - Day <?php echo $day_id ?>
                        <?php else : ?>
                            Itinerary
                        <?php endif; ?>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <?php foreach ($days as $day) : ?>
                            <a class="dropdown-item" href=<?php echo "index.php?day=" . $day["day_id"] ?>>
                                Day <?php echo $day["day_id"] ?> - <?php echo $day["region_name"] ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://drive.google.com/drive/folders/1GZp8hDEIsNs5e5D1azbRk5MApKUEtsk-?usp=sharing" target="_blank"><i class="fab fa-google-drive"></i>Folder</a>
                </li>
            </ul>
        </div>
    </nav>
</body>
</html>