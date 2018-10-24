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
	<h1 class="judul">Angkot</h1>
</div>

<div class="bagTambah">
	<h3 class="biru">Tambah Angkot</h3>
	<div class="wrap">
		<form id="formTambah">
			<div class="isi">Nama Angkot :</div>
			<input type="text" class="box" id="namaAngkot">
			<button class="tbl biru">Tambah</button>
		</form>
	</div>
</div>

<div class="container">
	<h2>List Angkot</h2>
	<div class="wrap">
		<div id="load"></div>
	</div>
</div>

<div class="bg"></div>
<div class="popupWrapper" id="bagHapus">
	<div class="popup">
		<div class="wrap">
			<h3>Hapus Angkot
				<div class="ke-kanan" id="xHapus"><i class="fa fa-close"></i></div>
			</h3>
			<p>
				Yakin ingin menghapus angkot ini?
			</p>
			<form id="formHapus">
				<input type="hidden" id="idangkot">
				<div class="bag-tombol">
					<button class="biru">Ya, hapus!</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script src="../aset/js/embo.js"></script>
<script>
	function load() {
		ambil('../angkot/load', (res) => {
			$("#load").tulis(res)
		})
	}
	function hapus(val) {
		$("#idangkot").isi(val)
		munculPopup("#bagHapus", $("#bagHapus").pengaya("top: 180px"))
	}
	load()

	submit('#formTambah', () => {
		let namaAngkot = $("#namaAngkot").isi()
		let add = "nama="+namaAngkot
		pos("../angkot/add", add, () => {
			$("#namaAngkot").isi(' ')
			load()
		})
		return false
	})
	submit("#formHapus", () => {
		let id = $("#idangkot").isi()
		let del = "idangkot="+id
		pos("../angkot/delete", del, () => {
			hilangPopup("#bagHapus")
			load()
		})
	})
	tekan("Escape", () => {
		hilangPopup("#bagHapus")
	})
	$("#xHapus").klik(function() {
		hilangPopup("#bagHapus")
	})
</script>

</body>
</html>