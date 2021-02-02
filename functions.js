function changeImage(newImage) {
	var image = document.querySelector("img");
	var old_width = image.width;
	var old_height = image.height;

	image.src = newImage;
	image.width = old_width;
	image.height = old_height;
}
