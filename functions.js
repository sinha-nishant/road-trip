function changeImage(newImage) {
	let image = document.querySelector("img");
	let old_width = image.width;
	let old_height = image.height;

	image.src = newImage;
	image.width = old_width;
	image.height = old_height;
}

let destinations = document.querySelector("#destinations").children;
for (let i=0; i < destinations.length; i++) {
	destinations[i].onmouseover = function() {
		changeImage(destinations[i].dataset.image);
	}
}