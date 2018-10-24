<?php
include 'controller.php';

class admin extends EMBO {
	public function me($u, $kolom) {
		$q = EMBO::tabel('admin')->pilih($kolom)->dimana(['username' => $u])->eksekusi();
		if(EMBO::hitung($q) == 0) {
			$q = EMBO::tabel('admin')->pilih($kolom)->dimana(['idadmin' => $u])->eksekusi();
		}
		$r = EMBO::ambil($q);
		return $r[$kolom];
	}
	public function sesi($auth = NULL) {
		session_start();
		$this->sesi = $_SESSION['uadmin'];
		if($auth != "") {
			if(empty($this->sesi)) {
				header("location: ./login");
			}
		}
	}
	public function login() {
		if(EMBO::pos('uname') == "") {
			return lihat('admin/login');
		}else {
			$u = EMBO::pos('uname');
			$p = EMBO::pos('pwd');

			$un = $this->info($u, "username");
			$pw = $this->info($u, "password");

			if($u == $un && $p == $pw) {
				session_start();
				$_SESSION['uadmin']=$u;
			}else {
				setcookie('kukiLogin', 'Username / Password salah!');
			}
		}
	}
	public function addNew() {
		if(EMBO::pos('uname') == "") {
			return lihat('admin/register');
		}else {
			$uname = EMBO::pos('uname');
			$pwd = EMBO::pos('pwd');
			$add = EMBO::tabel('admin')
						->tambah([
							'idadmin' 		=> rand(1, 99999),
							'username'		=> $uname,
							'password'		=> $pwd,
							'registered' 	=> time()
						])
						->eksekusi();
		}
	}
	public function delete() {
		$id = EMBO::pos('idadmin');
		$del = EMBO::tabel('admin')->hapus()->dimana(['idadmin' => $id])->eksekusi();
		return $del;
	}
}

$admin = new admin();

?>