<?php
setcookie('public', '1', time() + 4000, '/');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale = 1">
	<title>Hello Embo!</title>
	<link href="aset/fw/build/fw.css" rel="stylesheet">
	<link href="aset/fw/build/font-awesome.min.css" rel="stylesheet">
	<link href="aset/css/style.index.css" rel="stylesheet">
</head>
<body>

<div id="map"></div>
<input type="hidden" id="setLat">
<input type="hidden" id="setLng">
<input type="text" class="box" id="cari" placeholder="Cari lokasimu" style="display: none;">

<div id="myAngkot">
	<div id="loadAngkot"></div>
</div>

<script src="aset/js/embo.js"></script>
<script>
	let myLat = -7.270156914276002
	let myLng = 112.72879890040281
	let myInput = $("#cari")

	function loadAngkot() {
		ambil("./angkot/load", (res) => {
			$("#loadAngkot").tulis(res)
		})
	}
	loadAngkot()

	function rad(x) {return x*Math.PI/180;}
	function find_closest_marker( event ) {
	    var lat = event.latLng.lat();
	    var lng = event.latLng.lng();
	    var R = 6371; // radius of earth in km
	    var distances = [];
	    var closest = -1;
	    for( i=0;i<map.markers.length; i++ ) {
	        var mlat = map.markers[i].position.lat();
	        var mlng = map.markers[i].position.lng();
	        var dLat  = rad(mlat - lat);
	        var dLong = rad(mlng - lng);
	        var a = Math.sin(dLat/2) * Math.sin(dLat/2) +
	            Math.cos(rad(lat)) * Math.cos(rad(lat)) * Math.sin(dLong/2) * Math.sin(dLong/2);
	        var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
	        var d = R * c;
	        distances[i] = d;
	        if ( closest == -1 || d < distances[closest] ) {
	            closest = i;
	        }
	    }

	    alert(map.markers[closest].title);
	}

	function initMap() {
		let directionsService = new google.maps.DirectionsService;
		var directionsDisplay = new google.maps.DirectionsRenderer;
		var latLng = new google.maps.LatLng(myLat, myLng);
		var searchBox = new google.maps.places.SearchBox(myInput)
		var geocoder = new google.maps.Geocoder;
		var infowindow = new google.maps.InfoWindow;

		// Init Map
		var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 14,
          center: latLng
        });

        // Create Marker
        var marker = new google.maps.Marker({
        	map: map,
        	title: 'hello',
        	position: latLng,
        	draggable: true
        })

        // Ganti marker
        marker.addListener('dragend', function(evt) {
			// alert(evt.latLng.lat())
			// Set Lat Lng
			let setLat = evt.latLng.lat()
			let setLng = evt.latLng.lng()
			$("#setLat").isi(setLat)
			$("#setLng").isi(setLng)

			getPlaceName(geocoder, map, infowindow)
		})

        // Ganti searchbox
        // searchBox.addListener('places_changed', find_closest_marker())

		directionsDisplay.setMap(map);
	}

	function getPlaceName(geocoder, map, infowindow) {
		let setLat = $("#setLat").isi()
		let setLng = $("#setLng").isi()
		let latLng = { lat: parseFloat(setLat), lng: parseFloat(setLng) }

		geocoder.geocode({
			'location': latLng,
		}, function(results, status) {
			if(status === 'OK') {
				let marker = new google.maps.Marker({
					position: latLng,
					map: map
				})
				let formattedAddr = results[0].formatted_address
				// infowindow.setContent(formattedAddr)
				$("#cari").isi(formattedAddr)
				// infowindow.open(map, marker)
			}else {
				// alert('No result foound')
			}
		})
	}
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD8NuAKWkdiDlpdNiJ_HA1l2w6oTYNoZVY&callback=initMap&libraries=places"></script>
<script>
	
</script>
</body>
</html>
