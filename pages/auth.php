<!DOCTYPE html>
<html>
<head>
	<meta charset='UTF-8'>
	<meta name='viewport' content='width=device-width, initial-scale = 1'>
	<title>auth</title>
	<link href='aset/fw/build/fw.css' rel='stylesheet'>
	<link href='aset/fw/build/font-awesome.min.css' rel='stylesheet'>
	<link href='aset/css/style.auth.css' rel='stylesheet'>
</head>
<body>

<div class="container">
	<form id="formLogin">
		<div class="wrap">
			<h2>Login</h2>
			<div class="isi">Email :</div>
			<input type="email" class="box" id="emailLog">
			<div class="isi">Password :</div>
			<input type="password" class="box" id="pwdLog">
			<div class="bag-tombol">
				<button class="biru">LOGIN</button>
			</div>
			<div class="opt rata-tengah">
				belum punya akun? <a href="#" id="linkRegist">register</a> sekarang!
			</div>
		</div>
	</form>
	<form id="formReg">
		<div class="wrap">
			<h2>Register</h2>
			<div class="isi">Nama :</div>
			<input type="text" class="box" id="namaReg">
			<div class="isi">Email :</div>
			<input type="email" class="box" id="emailReg">
			<div class="isi">Password :</div>
			<input type="password" class="box" id="pwdReg">
			<div class="bag-tombol">
				<button class="biru">REGISTER</button>
			</div>
			<div class="opt rata-tengah">
				sudah punya akun? <a href="#" id="linkLogin">login</a> sekarang!
			</div>
		</div>
	</form>
</div>

<script src='aset/js/embo.js'></script>
<script>
	$("#linkRegist").klik(function() {
		$("#formLogin").hilang()
		$("#formReg").muncul()
	})
	$("#linkLogin").klik(function() {
		$("#formLogin").muncul()
		$("#formReg").hilang()
	})
	submit('#formLogin', () => {
		let email = $("#emailLog").isi()
		let pwd = $("#pwdLog").isi()
		let login = "email="+email+"&pwd="+pwd
		pos("./users/login", login, () => {
			mengarahkan("./")
		})
		return false
	})
	submit('#formReg', () => {
		let nama = $("#namaReg").isi()
		let email = $("#emailReg").isi()
		let pwd = $("#pwdReg").isi()
		let register = "nama="+nama+"&email="+email+"&pwd="+pwd
		pos("./users/register", register, () => {
			mengarahkan("./")
		})
		return false
	})
</script>

</body>
</html>