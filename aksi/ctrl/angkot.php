<?php
include 'admin.php';

class angkot extends admin {
	public function info($id, $kolom) {
		$q = EMBO::tabel('angkot')->pilih($kolom)->dimana(['idangkot' => $id])->eksekusi();
		$r = EMBO::ambil($q);
		return $r[$kolom];
	}
	public function delete() {
		$id = EMBO::pos('idangkot');
		$del = EMBO::tabel('angkot')->hapus()->dimana(['idangkot' => $id])->eksekusi();
		$x 	 = EMBO::tabel('waypoint')->hapus()->dimana(['idangkot' => $id])->eksekusi();
		return $del;
	}
	public function add() {
		$nama = EMBO::pos('nama');

		$add = EMBO::tabel('angkot')
					->tambah([
						'idangkot' 	=> rand(1, 9999),
						'nama'		=> $nama,
						'added'		=> time()
					])
					->eksekusi();
	}
	public function load() {
		$public = $_COOKIE['public'];
		$q = EMBO::tabel('angkot')->pilih()->eksekusi();
		if(EMBO::hitung($q) == 0) {
			echo "No result";
		}else {
			while($r = EMBO::ambil($q)) {
				if($public == 1) {
					echo "<a href='./waypoint&idangkot=".$r['idangkot']."'>";
				}
				echo "<div class='result'>".
						"<div class='wrap'>".
							"<h3>".$r['nama']."</h3>".
							"<div class='ket'>";
								if($public != 1) {
									echo "<a href='./set-jalur&angkot=".$r['idangkot']."'><button class='tbl biru'><i class='fa fa-cogs'></i></button></a> &nbsp; ".
										 "<button class='tbl merah' onclick='hapus(this.value)' value='".$r['idangkot']."'><i class='fa fa-trash'></i></button>";
								}
				echo
							"</div>".
						"</div>".
					 "</div>";
				if($public == 1) {
					echo "</a>";
				}
			}
		}
	}
}

$angkot = new angkot();

?>