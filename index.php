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
	submit('#formCari', () => {
		let q = $("#q").isi()
		let set = "namakuki=kw&value="+q+"&durasi=5555"
		pos("./aksi/setCookie.php", set, () => {
			munculPopup("#search", $("#search").pengaya("top: 100px"))
			load()
		})
		return false
	})

	function getPosisi() {
		if(navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(function(position) {
				var posisi = {
					lat: position.coords.latitude,
					lng: position.coords.longitude,
				}
				console.log(posisi)
			})
		}else {
			console.log('gaisok geolocation')
		}
	}
	
</script>

</body>
</html>