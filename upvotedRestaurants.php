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

$sql = "SELECT * FROM sinhan_road_trip.restaurant ORDER BY upvotes DESC LIMIT 10;";
$stmt = $mysqli->prepare($sql);
$restaurants = processQuery($mysqli, $stmt)->fetch_all(MYSQLI_ASSOC);

// User's upvoted restaurants
if (isset($_SESSION["id"])) {
	$user_id = $_SESSION["id"];
	$sql = "SELECT user_has_upvote.upvote_id, restaurant.restaurant_id 
    FROM user_has_upvote
    INNER JOIN restaurant
    ON user_has_upvote.restaurant_id = restaurant.restaurant_id
    WHERE user_has_upvote.user_id = ?;";
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param("i", $user_id);
	$upvotes = processQuery($mysqli, $stmt)->fetch_all(MYSQLI_ASSOC);

	for ($i = 0; $i < count($restaurants); $i++) {
		for ($j = 0; $j < count($upvotes); $j++) {
			if ($restaurants[$i]["restaurant_id"] == $upvotes[$j]["restaurant_id"]) {
				$restaurants[$i]["upvote_id"] = $upvotes[$j]["upvote_id"];
				break;
			}
		}
	}
}

$mysqli->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Upvoted Restaurants</title>
	<lang="en" />
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- jQuery -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	<!-- Boostrap 4.6 CSS -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

	<!-- Boostrap 4.6 js -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

	<!-- Bootstrap Icons -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">

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
		}

		.bi-arrow-up-circle-fill {
			color: #03DAC6;
		}

		img {
			display: none;
		}

		@media (min-width: 768px) {

			#upvotes-list {
				max-height: 60vh;
				overflow: auto;
			}

			img {
				display: block;
				border-radius: 10px;
			}

			#img-container {
				max-width: 70vh;
			}
		}
	</style>

</head>

<body>
	<?php include('navbar.php'); ?>
	<div class="container-fluid mt-1 mt-lg-0 px-lg-5 pb-sm-5 mb-sm-5">
		<h1 class="text-center mt-5">Most Upvoted Restaurants</h1>
		<div class="row mt-5 mx-auto px-lg-5">
			<div id="upvotes-list" class="col-sm-12 col-md-6 col-lg-6">
				<ul class="list-group list-group-flush">
					<?php foreach ($restaurants as $res) : ?>
						<li class="list-group-item px-3 border-0 rounded-pill h3" data-image=<?php echo $res["image_url"] ?>>
							<div class="list-item pl-0">
								<div class="pl-0 col-8"><?php echo $res["name"] ?></div>
								<div class="col-4 my-auto d-flex justify-content-end"><span id=<?php echo $res["restaurant_id"] ?> class="pr-3"><?php echo $res["upvotes"] ?></span>
									<?php if (isset($_SESSION["email"])) : ?>
										<div class="my-auto pl-3">
											<?php if (isset($res["upvote_id"])) : ?>
												<i class="arrow bi bi-arrow-up-circle-fill" data-res=<?php echo $res["restaurant_id"] ?> data-upvote=<?php echo $res["upvote_id"] ?> aria-hidden="true"></i>
											<?php else : ?>
												<i class="arrow bi bi-arrow-up-circle" data-res=<?php echo $res["restaurant_id"] ?> aria-hidden="true"></i>
											<?php endif; ?>
										</div>
									<?php endif; ?>
								</div>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
			<div id="img-container" class="col-md-6 col-lg-6 m-auto">
				<img id="img-preview" class="w-100 m-auto" src="https://i.pinimg.com/originals/8d/11/6a/8d116aa75e0a4e779b57682e0a92c84d.jpg" alt="image of food at restaurant" />
			</div>
		</div>
	</div>
	<script>
		$(".list-group-item").mouseenter(function(event) {
			if ($(window).width() >= 768) {
				item = $(this);
				if ($(item).data("image") != $("#img-preview").attr("src")) {
					$("#img-preview").fadeOut(400, function() {
						$("#img-preview").attr("src", $(item).data("image"));
						$("#img-preview").fadeIn(400);
					});
				}
			}
		});

		$("i").click(function(event) {
			event.stopPropagation();
			// If user has not upvoted restaurant
			let icon = $(this);
			numUpvotes = parseInt($("#" + $(icon).data("res")).text());
			if ($(icon).hasClass("bi-arrow-up-circle")) {
				// jQuery AJAX PHP
				// Add upvote
				$.post('vote.php', {
					'res_id': $(icon).data("res")
				}, function(response) {
					if (response == "unsuccessful") {
						alert("Database error: Could not upvote");
					} else {
						icon.attr("data-upvote", response);
						$("#" + $(icon).data("res")).text(numUpvotes + 1)
						$(icon).removeClass("bi-arrow-up-circle");
						$(icon).addClass("bi-arrow-up-circle-fill");
						$(icon).css("transition-duration", "1s");
					}
				});
			} else {
				// jQuery AJAX PHP
				// Remove upvote
				$.post('vote.php', {
					'upvote_id': $(icon).attr("data-upvote"),
					'res_id': $(icon).data("res")
				}, function(response) {
					if (response == "unsuccessful") {
						alert("Database error: Could not remove upvote");
					} else {
						$("#" + $(icon).data("res")).text(numUpvotes - 1)
						$(icon).removeClass("bi-arrow-up-circle-fill");
						$(icon).addClass("bi-arrow-up-circle");
					}
				});
			}
		});

		// Middle to top slide list animation
		anime({
			targets: '.list-group-item',
			opacity: 100,
			top: 0,
			delay: anime.stagger(150),
			easing: 'easeInQuart'
		});
	</script>
</body>

</html>