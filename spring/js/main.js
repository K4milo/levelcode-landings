
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

// Wow Support 
var wowInit = function() {
	var wow = new WOW(
		{
			boxClass:     'wow',      // animated element css class (default is wow)
			animateClass: 'animated', // animation css class (default is animated)
			offset:       0,          // distance to the element when triggering the animation (default is 0)
			mobile:       true,       // trigger animations on mobile devices (default is true)
			live:         true,       // act on asynchronously loaded content (default is true)
			callback:     function(box) {
			// the callback is fired every time an animation is started
			// the argument that is passed in is the DOM node being animated
			},
			scrollContainer: null,    // optional scroll container selector, otherwise use window,
			resetAnimation: true,     // reset animation on end (default is true)
		}
	);
	wow.init();
}
// Create map
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

// Modal page
var modalEvents = function() {
	var modalWrapper = document.querySelector('.modal');
	// Bubbling click
	modalWrapper.addEventListener('click', function (e) {
		e.preventDefault();
		if (e.target.classList.contains('modal--close') || e.target.classList.contains('button-project')) {
			modalWrapper.classList.remove('enable');
		}
	})
}

function init() {
	// Wow
	wowInit();
	// Modals
	modalEvents();
	// Trigger slider
	initSlider();
	// Trigger map
	buildMap();
}

// -- Event Listeners --//
document.addEventListener("DOMContentLoaded", init());