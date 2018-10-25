<?php
include 'aksi/ctrl/angkot.php';

$idAngkot = $_GET['angkot'];
if($angkot->info($idAngkot, "nama") == "") {
	die("error");
}

$namaAngkot = $angkot->info($idAngkotwee, "nama");

setcookie('idangkot', $idAngkot, time() + 4000, '/');

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="">
	<title>Admin Angkot</title>
	<link href="../aset/fw/build/fw.css" rel="stylesheet">
	<link href="../aset/fw/build/font-awesome.min.css" rel="stylesheet">
	<link href="../aset/css/admin.css" rel="stylesheet">
</head>
<body>
	
<div class="atas biru">
	<h1 class="judul">Set Jalur Angkot <?php echo $namaAngkot; ?></h1>
</div>

<div id="maps">
	<div id="map" style="height: 100%"></div>
</div>

<div class="kanan">
	<form id="formAdd">
		<input type="hidden" id="idangkot" value="<?php echo $idangkot; ?>">
		<input type="hidden" id="setLat">
		<input type="hidden" id="setLng">
		<input type="text" class="box" id="place" placeholder="Search place">
		<button id="submit" class="tbl biru">submitmit</button>
	</form>
	<h3>List Point</h3>
	<div id="loadPoint"></div>
</div>

<script src="../aset/js/embo.js"></script>
<script>
	function loadPoint() {
		ambil("../waypoint/load", (res) => {
			$("#loadPoint").tulis(res)
		})
	}
	loadPoint()
	let myLat = -7.270156914276002
	let myLng = 112.72879890040281
	let myInput = $("#place")
	let marker = []
	function initMap() {
		let directionsService = new google.maps.DirectionsService;
		var directionsDisplay = new google.maps.DirectionsRenderer;
		var searchBox = new google.maps.places.SearchBox(myInput)
		var geocoder = new google.maps.Geocoder;
		var infowindow = new google.maps.InfoWindow;
        
        // set map
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 14,
          center: {lat: myLat, lng: myLng}
        });

        // map.addListener('bounds_changed', function() {
        //   searchBox.setBounds(map.getBounds());
        // });

        // set marker
        var marker = new google.maps.Marker({
        	position: {lat: myLat, lng: myLng},
        	map: map,
        	title: 'Hello world',
        	draggable: true
        })

        // set coords
        google.maps.event.addListener(marker, 'dragend', function(evt) {
			// alert(evt.latLng.lat())
			// Set Lat Lng
			let setLat = evt.latLng.lat()
			let setLng = evt.latLng.lng()
			$("#setLat").isi(setLat)
			$("#setLng").isi(setLng)

			getPlaceName(geocoder, map, infowindow)
		})

		// searchBox
		searchBox.addListener('places_changed', function() {
          var places = searchBox.getPlaces();

          // Clear out the old markers.
          Array.prototype.forEach.call(marker, mark => {
            mark.setMap(null);
          });
          marker = [];

          // For each place, get the icon, name and location.
          var bounds = new google.maps.LatLngBounds();
          places.forEach(function(place) {

            // Create a marker for each place.
            marker.push(new google.maps.Marker({
              map: map,
              title: place.name,
              position: place.geometry.location,
              draggable: true
            }));
            let thisLoc = place.geometry.location
            $("#setLat").isi(thisLoc.lat())
            $("#setLng").isi(thisLoc.lng())

            if (place.geometry.viewport) {
              // Only geocodes have viewport.
              bounds.union(place.geometry.viewport);
            } else {
              bounds.extend(place.geometry.location);
            }
          });
          map.fitBounds(bounds);
        });

		directionsDisplay.setMap(map); // set map
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
				$("#place").isi(formattedAddr)
				// infowindow.open(map, marker)
			}else {
				// alert('No result foound')
			}
		})
	}
	function hapus(val) {
		let del = "idway="+val
		pos("../waypoint/delete", del, () => {
			loadPoint()
		})
	}

	submit('#formAdd', () => {
		let idangkot = $("#idangkot").isi()
		let setLat = $("#setLat").isi()
		let setLng = $("#setLng").isi()
		let place = $("#place").isi()
		let add = "lat="+setLat+"&lng="+setLng+"&place="+place+"&idangkot="+idangkot
		pos("../waypoint/add", add, () => {
			location.reload()
		})
		return false
	})

</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD8NuAKWkdiDlpdNiJ_HA1l2w6oTYNoZVY&callback=initMap&libraries=places"></script>

</body>
</html>