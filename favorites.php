<?php
session_start()
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
        <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
            integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l"
            crossorigin="anonymous"
        />

        <!-- Boostrap 4.6 js -->
        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns"
            crossorigin="anonymous"
        ></script>

        <!-- Bootstrap Icons -->
        <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css"
        />

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
        <?php include ('navbar.php'); ?>
        <div class="container-fluid mt-1 mt-lg-0">
            <h1 class="text-center mt-5">Your Favorites</h1>
            <div
                class="row mt-5 mx-auto px-sm-1 px-md-3 px-lg-5 pb-sm-5 mb-sm-5"
            >
                <div
                    id="favorites-list"
                    class="col-sm-12 col-md-6 col-lg-5 pe-5"
                >
                    <ul class="list-group list-group-flush">
                        <li
                            class="list-group-item border-0 rounded-pill h3"
                            data-image="https://www.history.com/.image/ar_16:9%2Cc_fill%2Ccs_srgb%2Cfl_progressive%2Cg_faces:center%2Cq_auto:good%2Cw_768/MTY1MTc3MjE0MzExMDgxNTQ1/topic-golden-gate-bridge-gettyimages-177770941.jpg"
                        >
                            <div class="list-item">
                                <div class="location-name pr-sm-2 pr-md-3">
                                    Golden Gate Bridge
                                </div>
                                <div class="my-auto pl-3">
                                    <i
                                        class="bi bi-star-fill"
                                        aria-hidden="true"
                                    ></i>
                                </div>
                            </div>
                        </li>
                        <li
                            class="list-group-item border-0 rounded-pill h3"
                            data-image="https://i.guim.co.uk/img/media/62c0826a1b6d7d7f390f9fd2ac4b1b7f7ff4c241/0_150_3024_1815/master/3024.jpg?width=1200&height=1200&quality=85&auto=format&fit=crop&s=e5885aba888050e88b4392f5eded1d8b"
                        >
                            <div class="list-item">
                                <div class="location-name pr-sm-2 pr-md-3">
                                    Joshua Tree
                                </div>
                                <div class="my-auto pl-3">
                                    <i
                                        class="bi bi-star-fill"
                                        aria-hidden="true"
                                    ></i>
                                </div>
                            </div>
                        </li>
                        <li
                            class="list-group-item border-0 rounded-pill h3"
                            data-image="https://www.smartertravel.com/wp-content/uploads/2017/08/grand-canyon-sunset-1200x627.jpg"
                        >
                            <div class="list-item">
                                <div class="location-name pr-sm-2 pr-md-3">
                                    Grand Canyon National Park
                                </div>
                                <div class="my-auto pl-4">
                                    <i
                                        class="bi bi-star-fill"
                                        aria-hidden="true"
                                    ></i>
                                </div>
                            </div>
                        </li>
                        <li
                            class="list-group-item border-0 rounded-pill h3"
                            data-image="https://images.squarespace-cdn.com/content/v1/5d44ac28d057b40001656b92/1566240759771-Z8BFSC0LGW7QBZPA5SBH/ke17ZwdGBToddI8pDm48kFWxnDtCdRm2WA9rXcwtIYR7gQa3H78H3Y0txjaiv_0fDoOvxcdMmMKkDsyUqMSsMWxHk725yiiHCCLfrh8O1z5QPOohDIaIeljMHgDF5CVlOqpeNLcJ80NK65_fV7S1UcTSrQkGwCGRqSxozz07hWZrYGYYH8sg4qn8Lpf9k1pYMHPsat2_S1jaQY3SwdyaXg/CathedralRock-SedonaAZ.jpg?format=2500w"
                        >
                            <div class="list-item">
                                <div class="location-name pr-sm-2 pr-md-3">
                                    Sedona
                                </div>
                                <div class="my-auto pl-4">
                                    <i
                                        class="bi bi-star-fill"
                                        aria-hidden="true"
                                    ></i>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item border-0 rounded-pill h3" data-image="https://www.mgmresorts.com/content/dam/MGM/bellagio/hotel/exterior/bellagio-hotel-exterior-early-evening-fountain-shot.jpg">
                            <div class="list-item">
                                <div class="location-name pr-sm-2 pr-md-3">
                                    Bellagio Fountain
                                </div>
                                <div class="my-auto pl-3">
                                    <i
                                        class="bi bi-star-fill"
                                        aria-hidden="true"
                                    ></i>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item border-0 rounded-pill h3" data-image="https://www.bartush.com/wp-content/uploads/2020/01/HOLLYWOOD-CALIFORNIA-APRIL-58735085-1.jpg">
                            <div class="list-item">
                                <div class="location-name pr-sm-2 pr-md-3">
                                    Hollywood Sign
                                </div>
                                <div class="my-auto pl-3">
                                    <i
                                        class="bi bi-star-fill"
                                        aria-hidden="true"
                                    ></i>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item border-0 rounded-pill h3" data-image="https://www.visitcalifornia.com/sites/visitcalifornia.com/files/styles/welcome_image/public/VC_California101_VeniceBeach_Stock_RF_638340372_1280x640.jpg">
                            <div class="list-item">
                                <div class="location-name pr-sm-2 pr-md-3">
                                    Venice Beach
                                </div>
                                <div class="my-auto pl-3">
                                    <i
                                        class="bi bi-star-fill"
                                        aria-hidden="true"
                                    ></i>
                                </div>
                            </div>
                        </li>
                        <li
                            class="list-group-item border-0 rounded-pill h3"
                            data-image="https://www.tripsavvy.com/thmb/3it2GRMqxoxpTWtisl8QK0hbGEE=/3424x2568/smart/filters:no_upscale()/yosemite-falls-yosemite-national-park-california-usa-683750029-58b0dfc75f9b5860462db5b0.jpg"
                        >
                            <div class="list-item">
                                <div class="location-name pr-sm-2 pr-md-3">
                                    Yosemite National Park
                                </div>
                                <div class="my-auto pl-3">
                                    <i
                                        class="bi bi-star-fill"
                                        aria-hidden="true"
                                    ></i>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="col-md-6 col-lg-6 m-auto">
                    <img
                        id="preview"
                        class="w-100 m-auto"
                        src="https://www.mercurynews.com/wp-content/uploads/2018/10/SJM-L-WEEKENDER-1018-01.jpg"
                    />
                </div>
            </div>
        </div>
        <script>

            $(".list-group-item").mouseenter(function (event) {
                if ($(window).width() >= 768) {
                    item = $(this);
                    if ($(item).data("image") != $("#preview").attr("src")) {
                        $("#preview").fadeOut(400, function () {
                            $("#preview").attr("src", $(item).data("image"));
                            $("#preview").fadeIn(400);
                        });
                    } 
                }
            });

            $("i").click(function (event) {
                if ($(this).hasClass("bi-star")) {
                    $(this).removeClass("bi-star");
                    $(this).addClass("bi-star-fill");
                    $(this).css("transition-duration", "1s");
                } else {
                    $(this).removeClass("bi-star-fill");
                    $(this).addClass("bi-star");
                    $(this).parent().parent().parent().fadeOut(400);
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
