function initMap() {
	var myLatLang = {lat: 51.46674, lng: -0.18976};

	var mapDiv = document.getElementById('map');
	var map = new google.maps.Map(mapDiv, {
		center: myLatLang,
		zoom: 17
	});

	var marker = new google.maps.Marker({
		position: myLatLang,
		map:map,
		title: 'Decorum Bulidng Consultancy'
	});

	var center;
	function calculateCenter() {
	center = map.getCenter();
	}
	google.maps.event.addDomListener(window, 'idle', function() {
		calculateCenter();
	});
	google.maps.event.addDomListener(window, 'resize', function() {
	map.setCenter(center);
	});

}
