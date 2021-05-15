<?php
session_start();

if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

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

function processQuery($mysqli, $stmt)
{
    $stmt->execute();
    $results = $stmt->get_result();
    if (!$results) {
        echo $mysqli->error;
        exit();
    }
    return $results;
}

$sql = "SELECT region_name, user_has_favorite.favorite_id, location.location_id, location.name, image_url
FROM user_has_favorite
INNER JOIN location ON user_has_favorite.location_id = location.location_id
INNER JOIN day ON location.day_id = day.day_id
WHERE user_has_favorite.user_id = ?
ORDER BY location.name;";
$stmt = $mysqli->prepare($sql);
$id = $_SESSION["id"];
$stmt->bind_param("i", $id);
$result = processQuery($mysqli, $stmt);

$mysqli->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Your Favorites</title>
    <lang="en" />
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Boostrap 4.6 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous" />

    <!-- Boostrap 4.6 js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" />

    <!-- anime.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>

    <style>
        body {
            height: 100vh;
        }

        .list-item {
            display: flex;
            justify-content: space-between;
            margin-top: 2%;
            margin-bottom: 2%;
            font-weight: 300;
        }

        .list-group-item {
            top: 200px;
            opacity: 0;
            transform: scale(0.95);
        }

        .list-group-item:hover {
            background-color: black;
            color: white;
            transform: scale(1);
            transition-duration: 0.5s;
            cursor: pointer;
        }

        .location-name {
            display: inline;
        }

        img {
            display: none;
        }

        .bi-star-fill {
            color: #03dac6;
        }

        @media (min-width: 768px) {
            #favorites-list {
                height: 65vh;
                overflow: auto;
            }

            img {
                display: block;
                border-radius: 10px;
                max-width: 70vh;
            }
        }
    </style>
</head>

<body>
    <?php include('navbar.php'); ?>
    <div class="container-fluid mt-1 mt-lg-0">
        <h1 class="text-center mt-5">Your Favorites</h1>
        <div class="row mt-5 mx-auto px-sm-1 px-md-3 px-lg-5 pb-sm-5 mb-sm-5">
            <div id="favorites-list" class="col-sm-12 col-md-6 col-lg-5 pe-5">
                <ul class="list-group list-group-flush">
                    <?php foreach ($result as $loc) : ?>
                        <li class="list-group-item border-0 rounded-pill h3" data-gmap=<?php echo "https://www.google.com/maps/search/?api=1&query=" . urlencode($loc["name"] . "+" . $loc["region_name"]) ?> data-image=<?php echo $loc["image_url"] ?>>
                            <div class="list-item">
                                <div class="location-name pr-sm-2 pr-md-3">
                                    <?php echo $loc["name"] ?>
                                </div>
                                <div class="my-auto pl-3">
                                    <i class="bi bi-star-fill" data-fav=<?php echo $loc["favorite_id"] ?> data-loc=<?php echo $loc["location_id"] ?> aria-hidden="true"></i>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="col-md-6 col-lg-6 m-auto">
                <img id="preview" class="w-100 m-auto" src="https://storage.needpix.com/rsynced_images/star-602148_1280.png" alt="a star icon indicating you are on the favorites page" />
            </div>
        </div>
    </div>
    <script>
        // Open google map query for destination
        $(".list-group-item").click(function(event) {
            open($(this).data("gmap"));
        });

        // Change image shown on list item mouseenter
        $(".list-group-item").mouseenter(function(event) {
            if ($(window).width() >= 768) {
                item = $(this);
                if ($(item).data("image") != $("#preview").attr("src")) {
                    $("#preview").fadeOut(400, function() {
                        $("#preview").attr("src", $(item).data("image"));
                        $("#preview").fadeIn(400);
                    });
                }
            }
        });

        $("i").click(function(event) {
            event.stopPropagation();
            let icon = $(this);
            if (icon.hasClass("bi-star")) {
                // jquery AJAX PHP
                // Add favorite
                $.post("favorite.php", {
                    'location_id': icon.data("loc")
                }, function(response) {
                    if (response == "unsuccessful") {
                        alert("Could not favorite.");
                    } else {
                        icon.removeClass("bi-star");
                        icon.addClass("bi-star-fill");
                        icon.css("transition-duration", "1s");
                    }
                });
            } else {
                // jquery AJAX PHP
                // Remove favorite
                $.post("favorite.php", {
                    'favorite_id': icon.data("fav")
                }, function(response) {
                    if (response == "unsuccessful") {
                        alert("Could not remove favorite.");
                    } else {
                        icon.removeClass("bi-star-fill");
                        icon.addClass("bi-star");
                        icon.parent().parent().parent().fadeOut(400, function() {
                            icon.parent().parent().parent().remove();
                            if ($("#favorites-list > ul").children().length == 0) {
                                $("#preview").attr("src", "https://storage.needpix.com/rsynced_images/star-602148_1280.png");
                            }
                        });
                    }
                });
            }
        });

        // Middle to top slide list animation
        anime({
            targets: '.list-group-item',
            opacity: 100,
            top: 0,
            delay: anime.stagger(150), // increase delay by 150ms for each elements.
            easing: 'easeInQuart'
        });
    </script>
</body>

</html>