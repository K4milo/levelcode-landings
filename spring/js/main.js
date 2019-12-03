
// Slider scripts
var initSlider = function() {

	var carousels = document.querySelectorAll(".glide");

	Object.values(carousels).map(carousel => {
		const slider = new Glide(carousel, {
			type: 'slider',
			startAt: 0,
			perView: 1
		});
		slider.mount();
	});
}

var buildMap = function () {

	var map = L.map('mapa').setView([4.6295548,-74.1241324],16);
	var linkMap = '<a href="http://openstreetmap.org">OpenStreetMap</a>';
	var markers = new L.LayerGroup();

	L.tileLayer(
		'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
		attribution: '&copy; ' + linkMap + ' Contributors',
		maxZoom: 18,
	}).addTo(map);

	var marker = new L.marker([4.6295548,-74.1241324]);
	markers.addLayer(marker);
	markers.addTo(map);

	return map;
}

function init() {
	// Trigger slider
	initSlider();
	// Trigger map
	buildMap();

}

// -- Event Listeners --//
document.addEventListener("DOMContentLoaded", init());