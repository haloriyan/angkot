<?php
include 'controller.php';

class users extends EMBO {
	public function info($e, $kolom) {
		$q = EMBO::tabel('user')->pilih($kolom)->dimana(['email' => $e])->eksekusi();
		if(EMBO::hitung($q) == 0) {
			$q = EMBO::tabel('user')->pilih($kolom)->dimana(['iduser' => $e])->eksekusi();
		}
		$r = EMBO::ambil($q);
		return $r[$kolom];
	}
	public function register() {
		if(!EMBO::pos('email')) {
			return lihat('user/register');
		}else {
			$nama 	= EMBO::pos('nama');
			$email 	= EMBO::pos('email');
			$pwd 	= EMBO::pos('pwd');

			$reg = EMBO::tabel('user')
						->tambah([
							'iduser'		=> null,
							'nama'			=> $nama,
							'email'			=> $email,
							'password'		=> $pwd,
							'registered'	=> time()
						])
						->eksekusi();
			session_start();
			$_SESSION['uangkot']=$email;
		}
	}
	public function login() {
		if(!EMBO::pos('email')) {
			return lihat('user/login');
		}else {
			$e = EMBO::pos('email');
			$p = EMBO::pos('pwd');
			$em = $this->info($e, 'email');
			$pw = $this->info($e, 'password');

			if($e == $em && $p == $pw) {
				session_start();
				$_SESSION['uangkot']=$e;
			}else {
				setcookie('kukiLogin', 'Email / Password salah!', time() + 35, '/');
			}
		}
	}
	public function sesi($auth = NULL) {
		session_start();
		$this->sesi = $_SESSION['uangkot'];
		if($auth != "") {
			if(empty($this->sesi)) {
				header("location: ./auth");
			}
		}
		return $this->sesi;
	}
}

$users = new users();

?>