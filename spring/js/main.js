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

// Iframe youtube

const IframeYT = () => {

    let tag = document.createElement('script');

    tag.src = "https://www.youtube.com/iframe_api";

    let firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

    // Init player

    let player;

    function readyYoutube() {
        (typeof YT !== "undefined") && YT && YT.Player ? player = new YT.Player('player', {
            height: '720',
            width: '640',
            videoId: '8PewRlz33E4',
            events: {
                'onReady': onPlayerReady,
                'onStateChange': onPlayerStateChange,
            },
            playerVars: {
                playlist: '8PewRlz33E4',
                loop: 1
            }
        }) : setTimeout(readyYoutube, 100);
    }

    // 4. The API will call this function when the video player is ready.
    function onPlayerReady(event) {
        event.target.playVideo();
    }

    // 5. The API calls this function when the player's state changes.
    //    The function indicates that when playing a video (state=1),
    //    the player should play for six seconds and then stop.
    let done = false;

    function onPlayerStateChange(event) {
        if (event.data == YT.PlayerState.PLAYING && !done) {
            player.playVideo();
        }
    }

    function stopVideo() {
        player.stopVideo();
    }

    return readyYoutube();

}

// Wow Support 
var wowInit = function() {
        var wow = new WOW({
            boxClass: 'wow',
            animateClass: 'animated',
            offset: 0,
            mobile: true,
            live: true,
            callback: function(box) {
                // the callback is fired every time an animation is started
                // the argument that is passed in is the DOM node being animated
            },
            scrollContainer: null, // optional scroll container selector, otherwise use window,
            resetAnimation: true, // reset animation on end (default is true)
        });
        wow.init();
    }
    // Create map
var buildMap = function() {

    var map = L.map('mapa').setView([4.6295548, -74.1241324], 16);
    var linkMap = '<a href="http://openstreetmap.org">OpenStreetMap</a>';
    var markers = new L.LayerGroup();

    L.tileLayer(
        'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; ' + linkMap + ' Contributors',
            maxZoom: 18,
        }).addTo(map);

    var marker = new L.marker([4.6295548, -74.1241324]);
    markers.addLayer(marker);
    markers.addTo(map);

    return map;
}

// Modal page
var modalEvents = function() {
    var modalWrapper = document.querySelector('.modal');
    // Bubbling click
    modalWrapper.addEventListener('click', function(e) {
        e.preventDefault();
        if (e.target.classList.contains('modal--close') || e.target.classList.contains('button-project')) {
            modalWrapper.classList.remove('enable');
        }
    })
}

// Post Ajax requests
var postAjax = function(url, data, success) {
    var params = typeof data == 'string' ? data : Object.keys(data).map(
        function(k) { return encodeURIComponent(k) + '=' + encodeURIComponent(data[k]) }
    ).join('&');

    var xhr = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
    xhr.open('POST', url);
    xhr.onreadystatechange = function() {
        if (xhr.readyState > 3 && xhr.status == 200) {
            success(xhr.responseText);
        }
    };
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send(params);
    return xhr;
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
    // YT
    setTimeout(IframeYT(), 6000);
}

// Post Ajax
var formWrapper = document.getElementById('subscription');

// -- Event Listeners --//
document.addEventListener("DOMContentLoaded", init());

var interest = document.getElementById('userInterest');
var nameUser = document.getElementById('userName');
var phoneUser = document.getElementById('userPhone');
var email = document.getElementById('userEmail');
var row = document.getElementById('addRow');
var table = document.getElementById('queryTable');
var habeas = document.getElementById('aceptar');


// Trigger Ajax
formWrapper.addEventListener('submit', function(e) {
    e.preventDefault();

    var OBJRequest = {
        tabla: table.value,
        s: row.value,
        nombre: nameUser.value,
        email: email.value,
        telefono: phoneUser.value,
        interes: interest.options[interest.selectedIndex].value,
        acepto: habeas.value
    }

    var url = 'http://springplaza.co/admin/includes/ajax.php';

    postAjax(url, OBJRequest, function(data) {
        alert('Su registro se ha efecturado exitosamente!');
    });
})