<?php

$string = "jalan hayam wuruk baru";
$needle = "hay";

if(strpos($string, $needle) !== false) {
	echo "ada";
}else {
	echo "tiada";
}

exit();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset='UTF-8'>
	<meta name='viewport' content='width=device-width, initial-scale = 1'>
	<title>test</title>
	<link href='aset/fw/build/fw.css' rel='stylesheet'>
	<link href='aset/fw/build/font-awesome.min.css' rel='stylesheet'>
</head>
<body>

<div class='wrap'>
	<table>
		<thead>
			<tr id="head">
				<th>Nama</th>
				<th>Email</th>
				<th style="width: 10%">Aksi</th>
			</tr>
		</thead>
		<tbody id="loads">
			
		</tbody>
	</table>
	<br />
</div>

<div class="bg"></div>
<div class="popupWrapper" id="tambah">
	<div class="popup">
		<div class="wrap">
			<h3>Tambah User</h3>
			<form id="formTambah">
				<div class="isi">Nama :</div>
				<input type="text" class="box" id="nama">
				<div class="isi">Email :</div>
				<input type="text" class="box" id="email">
				<button class="tbl merah-2" style="margin-top: 15px">Add</button>
			</form>
		</div>
	</div>
</div>

<div class="popupWrapper" id="hapus">
	<div class="popup">
		<div class="wrap">
			<h3>Hapus User</h3>
			<form id="formHapus">
				<input type="hidden" id="iduser" value="">
				<p>Yakin ingin menghapus user ini?</p>
				<div class="bag-tombol">
					<button class="merah-2">Ya, hapus!</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script src='aset/js/embo.js'></script>
<script>
	function load() {
		ambil("./user/loads", (res) => {
			$("#loads").tulis(res)
		})
	}
	function hapus(val) {
		$("#iduser").isi(val)
		munculPopup("#hapus", $("#hapus").pengaya("top: 170px"))
	}

	load()

	tekan('Escape', () => {
		hilangPopup("#tambah")
		hilangPopup("#hapus")
	})

	$("#newUser").klik(function() {
		munculPopup("#tambah", $("#tambah").pengaya("top: 90px"))
	})

	submit("#formTambah", () => {
		let nama = $("#nama").isi()
		let email = $("#email").isi()
		let add = "nama="+nama+"&email="+email
		pos("./user/addUser", add, () => {
			document.querySelector("#nama").value = ""
			document.querySelector("#email").value = ""
			load()
			hilangPopup("#tambah")
		})
		return false
	})
	submit("#formHapus", () => {
		let iduser = $("#iduser").isi()
		let del = "iduser="+iduser
		pos("./user/delete", del, () => {
			load()
			hilangPopup("#hapus")
		})
		return false
	})
</script>

</body>
</html>