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

<div class="atas">
	<h1 class="judul ke-kiri">Cariangkot</h1>
</div>

<div class="container">
	<div class="wrap">
		<form id="formCari">
			<h3>Mau kemana?</h3>
			<input type="text" class="box" id="q" placeholder="Cari lokasi">
			<button id="btnCari"><i class="fa fa-search"></i></button>
			<br />
			<input type="text" class="box" id="inputLocation" placeholder="Masukkan lokasi (nama jalan / kelurahan)" style="display: none;">
			<div id="myLocation">
				Lokasi kamu sekarang :<br />
				<span id="currLocation"><i class="fa fa-spinner"></i> loading...</span>
				. Bukan lokasimu? <a href="#" id="manualInput">ganti lokasi!</a>
			</div>
		</form>
	</div>
</div>

<div class="bg"></div>
<div class="popupWrapper" id="search">
	<div class="popup">
		<div class="wrap">
			<h3>Result
				<div class="ke-kanan" id="xSearch"><i class="fa fa-close"></i></div>
			</h3>
			<div id="load"></div>
		</div>
	</div>
</div>

<div id="map"></div>
<input type="hidden" id="myLat">
<input type="hidden" id="myLng">
<input type="hidden" id="myLoc">

<script src="aset/js/embo.js"></script>
<script>
	function load() {
		ambil("./waypoint/cari", (res) => {
			$("#load").tulis(res)
		})
	}
	tekan('Escape', () => {
		hilangPopup("#search")
	})
	$("#xSearch").klik(function() {
		hilangPopup("#search")
	})
	$("#manualInput").klik(function() {
		$("#myLocation").hilang()
		$("#inputLocation").muncul()
	})
	submit('#formCari', () => {
		let q = $("#q").isi()
		let myLoc
		let inputan = $("#inputLocation").isi()
		if(inputan == '') {
			myLoc = $("#myLoc").isi()
		}else {
			myLoc = inputan
		}
		let set = "namakuki=kw&value="+q+"&durasi=5555"
		pos("./aksi/setCookie.php", set, () => {
			munculPopup("#search", $("#search").pengaya("top: 100px"))
			load()
		})
		let set2 = "namakuki=asal&value="+myLoc+"&durasi=5555"
		pos("./aksi/setCookie.php", set2, () => {
			munculPopup("#search", $("#search").pengaya("top: 100px"))
			load()
		})
		return false
	})

	let myLat = $("#myLat").isi()
	let myLng = $("#myLng").isi()
	if(navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(function(pos) {
			let lat = pos.coords.latitude
			let lng = pos.coords.longitude
			$("#myLat").isi(lat)
			$("#myLng").isi(lng)
		})
	}else {
		console.log('gaisok geolocation')
	}
	function initMap() {
		var geocoder = new google.maps.Geocoder;
		var infowindow = new google.maps.InfoWindow;
		var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 14,
          center: {lat: myLat, lng: myLng}
        });

		setTimeout(function() {
			getPlaceName(geocoder, map, infowindow)
		}, 1000)
	}
	function getPlaceName(geocoder, map, infowindow) {
		let setLat = $("#myLat").isi()
		let setLng = $("#myLng").isi()
		let latLng = { lat: parseFloat(setLat), lng: parseFloat(setLng) }

		geocoder.geocode({
			'location': latLng,
		}, function(results, status) {
			if(status === 'OK') {
				let formattedAddr = results[0].formatted_address
				// infowindow.setContent(formattedAddr)
				console.log(formattedAddr)
				$("#myLoc").isi(formattedAddr)
				$("#currLocation").tulis(formattedAddr)
				// infowindow.open(map, marker)
			}else {
				// alert('No result foound')
			}
		})
	}
	setTimeout(function() {
		initMap()
	}, 3000)
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD8NuAKWkdiDlpdNiJ_HA1l2w6oTYNoZVY&libraries=places"></script>

</body>
</html>