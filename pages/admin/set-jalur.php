<?php
include 'aksi/ctrl/angkot.php';

$idAngkot = $_GET['angkot'];
if($angkot->info($idAngkot, "nama") == "") {
	die("error");
}

$namaAngkot = $angkot->info($idAngkot, "nama");

setcookie('idangkot', $idAngkot, time() + 4000, '/');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale = 1">
	<title>Admin Angkot</title>
	<link href="../aset/fw/build/fw.css" rel="stylesheet">
	<link href="../aset/fw/build/font-awesome.min.css" rel="stylesheet">
	<link href="../aset/css/admin.css" rel="stylesheet">
	<style>
		#map {
			position: absolute;
			top: 60px;left: 0px;bottom: 0px;
			width: 60%;
		}
		.kanan {
			position: absolute;
			top: 60px;right: 0px;bottom: 0px;
			width: 40%;
		}
		.kanan .wrap { margin: 6%; }
		.box { font-size: 16px; }
	</style>
</head>
<body>

<div class="atas biru">
	<h1 class="judul">Set Jalur Angkot <?php echo $namaAngkot; ?></h1>
</div>

<div id="map"></div>

<div class="kanan">
	<div class="wrap">
		<form id="formAdd">
			<input type="text" class="box" id="address">
			<button class="tbl biru">Add</button>
			<input type="hidden" id="latInput">
			<input type="hidden" id="lngInput">
		</form>
		<h3>List Point</h3>
		<div style="overflow: auto;height: 365px;" id="loadPoint"></div>
	</div>
</div>

<script type="text/javascript" src='https://maps.google.com/maps/api/js?libraries=places&key=AIzaSyDqYJGuWw9nfoyPG8d9L1uhm392uETE-mA'></script>
<script src="../aset/js/jquery-3.1.1.js"></script>
<script src="../aset/js/locationpicker.jquery.min.js"></script>
<script>
	let myLat = -7.270156914276002
	let myLng = 112.72879890040281

	function loadPoint() {
		$.get("../waypoint/load", (res) => {
			$("#loadPoint").html(res)
		})
	}
	function hapus(val) {
		let del = "idway="+val
		$.ajax({
			type: "POST",
			url: "../waypoint/delete",
			data: del,
			success: function() {
				loadPoint()
			}
		})
	}
	loadPoint()
	function getPlaceName(setLat, setLng) {
		var geocoder = new google.maps.Geocoder;
		var infowindow = new google.maps.InfoWindow;
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
				$("#address").val(formattedAddr)
				// infowindow.open(map, marker)
			}else {
				// alert('No result foound')
			}
		})
	}
	$('#map').locationpicker({
		location: {
			latitude: myLat,
			longitude: myLng
		},
		radius: 0,
		inputBinding: {
			latitudeInput: $('#latInput'),
			longitudeInput: $('#lngInput'),
			locationNameInput: $("#address")
		},
		onchanged: function() {
			getPlaceName($('#latInput').val(), $('#lngInput').val())
		},
		enableAutocomplete: true,
	})
	$("#formAdd").submit(() => {
		let idangkot = $("#idangkot").val()
		let setLat = $("#latInput").val()
		let setLng = $("#lngInput").val()
		let place = $("#address").val()
		let add = "lat="+setLat+"&lng="+setLng+"&place="+place+"&idangkot="+idangkot
		$.ajax({
			type: "POST",
			url: "../waypoint/add",
			data: add,
			success: function() {
				loadPoint()
			}
		})
		return false
	})
</script>

</body>
</html>