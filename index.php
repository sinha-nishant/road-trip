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

if (!isset($_GET["day"])) {
    $day_id = 1;
} else {
    $day_id = $_GET["day"];
}

// Region name and hotel name query
$sql = "SELECT region_name, hotel.name AS hotel, hotel.map_url AS hotel_map_url, day.map_url FROM day INNER JOIN hotel
ON day.hotel_id = hotel.hotel_id WHERE day_id=?;";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $day_id);
$result = processQuery($mysqli, $stmt)->fetch_assoc();
$region_name = $result['region_name'];
$hotel_name = $result['hotel'];
$hotel_map_url = $result['hotel_map_url'];
$map_url = $result['map_url'];

// Locations for day query
$sql = "SELECT location_id, name, image_url from location WHERE day_id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $day_id);
$locations = processQuery($mysqli, $stmt)->fetch_all(MYSQLI_ASSOC);

// User's favorited locations
if (isset($_SESSION["id"])) {
    $id = $_SESSION["id"];
    $sql = "SELECT user_has_favorite.favorite_id, location.location_id
    FROM user_has_favorite
    INNER JOIN location
    ON user_has_favorite.location_id = location.location_id
    WHERE user_has_favorite.user_id = ?
    ORDER BY location.name;";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $id);
    $favorites = processQuery($mysqli, $stmt)->fetch_all(MYSQLI_ASSOC);

    for ($i = 0; $i < count($locations); $i++) {
        for ($j = 0; $j < count($favorites); $j++) {
            if ($locations[$i]["location_id"] == $favorites[$j]["location_id"]) {
                $locations[$i]["favorite_id"] = $favorites[$j]["favorite_id"];
                break;
            }
        }
    }
}

// Restaurants for day query
$sql = "SELECT restaurant.restaurant_id AS res_id, name, cuisine FROM restaurant INNER JOIN restaurant_has_day
ON restaurant.restaurant_id = restaurant_has_day.restaurant_id
WHERE restaurant_has_day.day_id = ?
ORDER BY name;";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $day_id);
$restaurants = processQuery($mysqli, $stmt)->fetch_all(MYSQLI_ASSOC);

// User's upvoted restaurants
if (isset($_SESSION["id"])) {
    $id = $_SESSION["id"];
    $sql = "SELECT user_has_upvote.upvote_id, restaurant.restaurant_id
    FROM user_has_upvote
    INNER JOIN restaurant
    ON user_has_upvote.restaurant_id = restaurant.restaurant_id
    WHERE user_has_upvote.user_id = ?;";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $id);
    $upvotes = processQuery($mysqli, $stmt)->fetch_all(MYSQLI_ASSOC);

    for ($i = 0; $i < count($restaurants); $i++) {
        for ($j = 0; $j < count($upvotes); $j++) {
            if ($restaurants[$i]["res_id"] == $upvotes[$j]["restaurant_id"]) {
                $restaurants[$i]["upvote_id"] = $upvotes[$j]["upvote_id"];
                break;
            }
        }
    }
}

$mysqli->close();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Road Trip Day <?php echo $day_id . " - " . $region_name ?></title>
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

    <!-- Google Material Design Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet" />

    <!-- CSS for itinerary pages -->
    <link rel="stylesheet" href="itinerary.css" />
</head>

<body>
    <?php include('navbar.php'); ?>

    <div class="container-fluid mt-1 px-lg-5 pb-sm-2 pb-lg-0">
        <div class="row">
            <div id="destinations-col" class="col-lg">
                <div class="card w-100 rounded-lg">
                    <img class="card-image-top w-100 rounded-top" src=<?php echo $locations[0]["image_url"] ?> alt=<?php echo $locations[0]["name"] ?> />
                    <div id="locations" class="card-body px-0 overflow-auto">
                        <h2 class="card-title pl-3"><?php echo $region_name ?></h2>
                        <h6 class="card-subtitle pl-3 mb-2 text-muted">
                            Day <?php echo $day_id ?>
                        </h6>
                        <div id="destinations-container" class="px-0">
                            <ul id="destinations" class="list-group list-group-flush w-100">
                                <?php foreach ($locations as $loc) : ?>
                                    <li class="list-group-item px-0 border-0" data-gmap=<?php echo "https://www.google.com/maps/search/?api=1&query=" . urlencode($loc["name"] . "+" . $region_name) ?> data-image=<?php echo $loc["image_url"] ?> data-alt=<?php echo $loc["name"] ?>>
                                        <div class="list-item">
                                            <div class="location-name pl-3 pr-sm-2 pr-md-3">
                                                <?php echo $loc["name"] ?>
                                            </div>
                                            <?php if (isset($_SESSION["email"])) : ?>
                                                <div class="my-auto pl-3">
                                                    <?php if (isset($loc["favorite_id"])) : ?>
                                                        <i class="star bi bi-star-fill" data-loc=<?php echo $loc["location_id"] ?> data-fav=<?php echo $loc["favorite_id"] ?> aria-hidden="true"></i>
                                                    <?php else : ?>
                                                        <i class="star bi bi-star" data-loc=<?php echo $loc["location_id"] ?> aria-hidden="true"></i>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div id="hotel-food" class="col-lg d-flex flex-column">
                <div class="hotel row">
                    <div class="card w-100 rounded-lg">
                        <div class="row h-100 no-gutters">
                            <div class="col-6">
                                <div class="card-body">
                                    <h4 class="card-title"><span class="material-icons-round">hotel</span></h4>
                                    <p id="hotel-name"><?php echo $hotel_name ?></p>
                                </div>
                            </div>
                            <div class="col-6 p-0 rounded-right">
                                <iframe class="w-100 h-100" src=<?php echo $hotel_map_url ?> style="border: 0" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="food row">
                    <div class="card w-100 rounded-lg">
                        <div class="card-body">
                            <div id="restaurants-container" class="overflow-auto">
                                <table class="table table-borderless">
                                    <thead>
                                        <tr>
                                            <th class="pl-0 pb-0"><span class="material-icons-round">restaurant_menu</span></th>
                                            <th scope="col">Restaurant</th>
                                            <th scope="col">Cuisine</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($restaurants as $res) : ?>
                                            <tr>
                                                <td>
                                                    <?php if (isset($_SESSION["email"])) : ?>
                                                        <?php if (isset($res["upvote_id"])) : ?>
                                                            <i class="arrow bi bi-arrow-up-circle-fill" data-res=<?php echo $res["res_id"] ?> data-upvote=<?php echo $res["upvote_id"] ?> aria-hidden="true"></i>
                                                        <?php else : ?>
                                                            <i class="arrow bi bi-arrow-up-circle" data-res=<?php echo $res["res_id"] ?> aria-hidden="true"></i>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="resName" data-gmap=<?php echo "https://www.google.com/maps/search/?api=1&query=" . urlencode($res["name"] . "+" . $region_name . "+" . $res['cuisine'] . "+" . "food") ?>>
                                                    <?php echo $res['name'] ?>
                                                </td>
                                                <td><?php echo $res['cuisine'] ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="path-col" class="col-lg">
                <div id="path" class="h-100 rounded-lg overflow-hidden">
                    <iframe class="w-100" src=<?php echo $map_url ?> style="border: 0" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                </div>
            </div>
        </div>
    </div>
    <script type="module" src="itinerary-functions.js"></script>
</body>

</html>