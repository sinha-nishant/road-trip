function changeImage(newImage) {
    let image = document.querySelector("img");
    let old_width = image.width;
    let old_height = image.height;

    image.src = newImage;
    image.width = old_width;
    image.height = old_height;
}

let destinations = document.querySelector("#destinations").children;
for (let i = 0; i < destinations.length; i++) {
    destinations[i].onmouseover = function () {
        changeImage(destinations[i].dataset.image);
    };
}

$(".star").click(function (event) {
    if ($(this).hasClass("bi-star")) {
        $(this).removeClass("bi-star");
        $(this).addClass("bi-star-fill");
        $(this).css("transition-duration", "1s");
    } else {
        $(this).removeClass("bi-star-fill");
        $(this).addClass("bi-star");
    }
});

$(".arrow").click(function (event) {
    event.stopPropagation();
    // If restaurant not upvoted
    if ($(this).hasClass("bi-arrow-up-circle")) {
        $(this).removeClass("bi-arrow-up-circle");
        $(this).addClass("bi-arrow-up-circle-fill");
        $(this).css("transition-duration", "0.5s");
    } else {
        $(this).removeClass("bi-arrow-up-circle-fill");
        $(this).addClass("bi-arrow-up-circle");
    }
});

anime({
    targets: '.col-lg',
    top: 0,
    duration: 1000,
    easing: 'easeOutQuad'
});

anime({
    targets: '.row',
    opacity: 100,
    duration: 10000,
    easing: 'easeInQuad'
});

$(".card, #path").mouseenter(function(event) {
    if ($(window).width() >= 992) {
        $(this).css("box-shadow", "0px 0px 7px #03dac6")
        $(this).css("transform", "scale(1.03)");
        $(this).css("transition-duration", "200ms");
    }
});

$(".card, #path").mouseleave(function(event) {
    if ($(window).width() >= 992) {
        $(this).css("transform", "scale(1)");
        $(this).css("box-shadow", "0px 0px")
    }
});