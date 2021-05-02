<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Upvoted Restaurants</title>
	<lang="en"/>
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
	<?php include ('navbar.php'); ?>
	<div class="container-fluid mt-1 mt-lg-0 px-lg-5 pb-sm-5 mb-sm-5">
		<h1 class="text-center mt-5">Upvoted Restaurants</h1>
		<div class="row mt-5 mx-auto px-lg-5">
			<div id="upvotes-list" class="col-sm-12 col-md-6 col-lg-6">
				<ul class="list-group list-group-flush"> 
					<li class="list-group-item px-3 border-0 rounded-pill h3" data-image="https://scontent-lax3-1.xx.fbcdn.net/v/t1.6435-9/118544974_3537895139596193_5785301805624521604_n.jpg?_nc_cat=105&ccb=1-3&_nc_sid=a26aad&_nc_ohc=CS1DNR0Jn2MAX_J8-8k&_nc_ht=scontent-lax3-1.xx&oh=f7a524da06afbe9824084c509030c43d&oe=609BDF2D">
						<div class="list-item pl-0"><div class="pl-0 col-8">Toyose</div><div class="col-4 my-auto d-flex justify-content-end"><span class="pr-3">50</span><i class="bi bi-arrow-up-circle" aria-hidden="true"></i></div>
					</li>
					<li class="list-group-item px-3 border-0 rounded-pill h3" data-image="https://www.umamiburger.com/wp-content/uploads/2020/06/umamiburger_umamiburger_trustuscombo-e1593190873115.jpg">
						<div class="list-item pl-0"><div class="pl-0 col-8">Umami Burger</div><div class="col-4 my-auto d-flex justify-content-end"><span class="pr-3">43</span><i class="bi bi-arrow-up-circle" aria-hidden="true"></i></div>
					</li>
					<li class="list-group-item px-3 border-0 rounded-pill h3" data-image="https://i.redd.it/8gpgiz2mq2n41.jpg">
						<div class="list-item pl-0"><div class="pl-0 col-8">Randy's Donuts</div><div class="col-4 my-auto d-flex justify-content-end"><span class="pr-3">40</span><i class="bi bi-arrow-up-circle" aria-hidden="true"></i></div>
					</li>
					<li class="list-group-item px-3 border-0 rounded-pill h3" data-image="https://cdn.vox-cdn.com/thumbor/szjVspM0DwXneekFfxXdr74r9Hk=/1400x1400/filters:format(jpeg)/cdn.vox-cdn.com/uploads/chorus_asset/file/13652278/JakobLayman.1218.HowlinRaysSecretMenu_020.jpg">
						<div class="list-item pl-0"><div class="pl-0 col-8">Howlin' Ray's</div><div class="col-4 my-auto d-flex justify-content-end"><span class="pr-3">29</span><i class="bi bi-arrow-up-circle" aria-hidden="true"></i></div>
					</li>
					<li class="list-group-item px-3 border-0 rounded-pill h3" data-image="https://cdn.vox-cdn.com/thumbor/rDJSyJgy9xP_bI-NxCXNAKq7WJQ=/0x0:950x534/1820x1213/filters:focal(399x191:551x343):format(webp)/cdn.vox-cdn.com/uploads/chorus_image/image/67051459/Bacchanal_Buffet.0.jpg">
						<div class="list-item pl-0"><div class="pl-0 col-8">Bacchanal Buffet</div><div class="col-4 my-auto d-flex justify-content-end"><span class="pr-3">21</span><i class="bi bi-arrow-up-circle" aria-hidden="true"></i></div>
					</li>
					<li class="list-group-item px-3 border-0 rounded-pill h3" data-image="https://d1ralsognjng37.cloudfront.net/a15574d3-b83d-427e-b268-fbf1dd91e96c.jpeg">
						<div class="list-item pl-0"><div class="pl-0 col-8">Wurstkuche</div><div class="col-4 my-auto d-flex justify-content-end"><span class="pr-3">18</span><i class="bi bi-arrow-up-circle" aria-hidden="true"></i></div>
					</li>
					<li class="list-group-item px-3 border-0 rounded-pill h3" data-image="https://www.discoverlosangeles.com/sites/default/files/images/2019-03/Kogi%20Taqueria%20Short%20Rib%20Taco%20Jakob%20Layman.JPG?width=1600&height=1200&fit=crop&quality=78&auto=webp">
						<div class="list-item pl-0"><div class="pl-0 col-8">Kogi</div><div class="col-4 my-auto d-flex justify-content-end"><span class="pr-3">11</span><i class="bi bi-arrow-up-circle" aria-hidden="true"></i></div>
					</li>
					<li class="list-group-item px-3 border-0 rounded-pill h3" data-image="https://media.timeout.com/images/103939303/image.jpg">
						<div class="list-item pl-0"><div class="pl-0 col-8">Prince of Venice</div><div class="col-4 my-auto d-flex justify-content-end"><span class="pr-3">7</span><i class="bi bi-arrow-up-circle" aria-hidden="true"></i></div>
					</li>
				</ul>
			</div>
			<div id="img-container" class="col-md-6 col-lg-6 m-auto">
				<img id="img-preview" class="w-100 m-auto" src="https://scontent-lax3-1.xx.fbcdn.net/v/t1.6435-9/118544974_3537895139596193_5785301805624521604_n.jpg?_nc_cat=105&ccb=1-3&_nc_sid=a26aad&_nc_ohc=CS1DNR0Jn2MAX_J8-8k&_nc_ht=scontent-lax3-1.xx&oh=f7a524da06afbe9824084c509030c43d&oe=609BDF2D"/>
			</div>
		</div>
	</div>
	<script>

		$(".list-group-item").hover(function(event) {
			if ($(window).width() >= 768) {
				item = $(this);
				$("#img-preview").fadeOut(400, function() {
					$("#img-preview").attr("src", $(item).data("image"));
					$("#img-preview").fadeIn(400);
				});
			}
		});

		$("i").click(function(event) {
			event.stopPropagation();
			// If user has not upvoted restaurant
			numUpvotes = parseInt($(this).siblings("span").text());
			if ($(this).hasClass("bi-arrow-up-circle")) {
				$(this).siblings("span").text(numUpvotes + 1);
				$(this).removeClass("bi-arrow-up-circle");
				$(this).addClass("bi-arrow-up-circle-fill");
				$(this).css("transition-duration", "1s");
			}
			else {
				$(this).siblings("span").text(numUpvotes - 1);
				$(this).removeClass("bi-arrow-up-circle-fill");
				$(this).addClass("bi-arrow-up-circle");
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