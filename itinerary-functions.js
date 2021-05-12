function changeImage(newImage) {
    let image = document.querySelector("img");

    if (image.src != newImage.dataset.image) {
        let old_width = image.width;
        let old_height = image.height;
        image.alt = newImage.dataset.alt;

        image.src = newImage.dataset.image;
        image.width = old_width;
        image.height = old_height;
    }
}

// Change image on hover over different item in destination list
let destinations = document.querySelector("#destinations").children;
for (let i = 0; i < destinations.length; i++) {
    destinations[i].onmouseenter = function () {
        changeImage(destinations[i]);
    };
}

$(".star").click(function (event) {
    event.stopPropagation();
    let icon = $(this);
    if (icon.hasClass("bi-star")) {
        // jquery AJAX PHP
        // Add favorite
        $.post(
            "favorite.php",
            { location_id: icon.data("loc") },
            function (response) {
                if (response == "unsuccessful") {
                    alert("Could not favorite.");
                } else {
                    icon.data("fav", response);
                    icon.removeClass("bi-star");
                    icon.addClass("bi-star-fill");
                    icon.css("transition-duration", "1s");
                }
            }
        );
    } else {
        // jquery AJAX PHP
        // Remove favorite
        $.post(
            "favorite.php",
            { favorite_id: icon.data("fav") },
            function (response) {
                if (response == "unsuccessful") {
                    alert("Could not remove favorite.");
                } else {
                    icon.removeClass("bi-star-fill");
                    icon.addClass("bi-star");
                }
            }
        );
    }
});

$(".arrow").click(function (event) {
    event.stopPropagation();
    // If restaurant not upvoted
    let arrow = $(this);
    if (arrow.hasClass("bi-arrow-up-circle")) {
        // jQuery AJAX PHP
        // Add upvote
        $.post(
            "vote.php",
            { res_id: $(this).data("res") },
            function (response) {
                if (response == "unsuccessful") {
                    alert("Database error: Could not upvote");
                } else {
                    arrow.attr("data-upvote", response);
                    arrow.removeClass("bi-arrow-up-circle");
                    arrow.addClass("bi-arrow-up-circle-fill");
                    arrow.css("transition-duration", "0.5s");
                }
            }
        );
    } else {
        // jQuery AJAX PHP
        // Remove upvote
        $.post(
            "vote.php",
            {
                res_id: $(this).data("res"),
                upvote_id: arrow.attr("data-upvote"),
            },
            function (response) {
                if (response == "unsuccessful") {
                    alert("Database error: Could not remove upvote");
                } else {
                    arrow.removeClass("bi-arrow-up-circle-fill");
                    arrow.addClass("bi-arrow-up-circle");
                }
            }
        );
    }
});

$(function () {
    $("#path > iframe").on("load", function () {
        // Anime.js
        anime({
            targets: ".col-lg",
            top: 0,
            duration: 1000,
            easing: "easeOutQuad",
        });

        anime({
            targets: ".row",
            opacity: 100,
            duration: 2000,
            easing: "easeInCubic",
        });
    });
});

// Card glow and scale on hover
$(".card, #path").mouseenter(function (event) {
    if ($(window).width() >= 992) {
        $(this).css("box-shadow", "0px 0px 7px #03dac6");
        $(this).css("transform", "scale(1.03)");
        $(this).css("transition-duration", "200ms");
    }
});

$(".card, #path").mouseleave(function (event) {
    if ($(window).width() >= 992) {
        $(this).css("transform", "scale(1)");
        $(this).css("box-shadow", "0px 0px");
    }
});

// Open google map query for destination
$(".list-group-item").click(function (event) {
    open($(this).data("gmap"));
});

// Open google map query for restaurant
$(".resName").click(function (event) {
    open($(this).data("gmap"));
});
