<?php
include 'angkot.php';

class waypoint extends angkot {
	public function locate($place, $kolom) {
		$q = EMBO::tabel('waypoint')->pilih($kolom)->dimana(['placeName' => $place], 'like')->eksekusi();
		$r = EMBO::ambil($q);
		return $r[$kolom];
	}
	public function load() {
		$id = $_COOKIE['idangkot'];

		$q = EMBO::tabel('waypoint')->pilih()->dimana(['idangkot' => $id])->urutkan('added', 'DESC')->eksekusi();
		if(EMBO::hitung($q) == 0) {
			echo "No result";
		}else {
			while($r = EMBO::ambil($q)) {
				echo "<li>".$r['placeName']." <button style='background: none;border: none;color: #e74c3c;cursor: pointer;' onclick='hapus(this.value)' value='".$r['idway']."'><i class='fa fa-close'></i></button></li>";
			}
		}
	}
	public function get() {
		$id = $_COOKIE['idangkot'];
		$tot = EMBO::hitung(EMBO::tabel('waypoint')->pilih('idangkot')->dimana(['idangkot' => $id])->eksekusi());
		$q = EMBO::tabel('waypoint')->pilih()->dimana(['idangkot' => $id])->urutkan('added', 'ASC')->batas(1, $tot -2)->eksekusi();
		$i = 0;
		while($r = mysqli_fetch_array($q)) {
			$i++;
			$coords = $r['coords'];
			$lat = explode("|", $coords)[0];
			$lng = explode("|", $coords)[1];
			if(($tot - 2) == $i) {
				$koma = "";
			}else {
				$koma = ",";
			}
			$res[] = "{
	location: new google.maps.LatLng(".$lat.", ".$lng."),
	stopover: false
}".$koma."
";
		}
		foreach ($res as $key => $value) {
			echo $value;
		}
	}
	public function add() {
		$id = $_COOKIE['idangkot'];
		$lat = EMBO::pos('lat');
		$lng = EMBO::pos('lng');
		$coords = $lat."|".$lng;
		$place = EMBO::pos('place');

		$add = EMBO::tabel('waypoint')
					->tambah([
						'idway'		=> rand(1, 99999),
						'idangkot'	=> $id,
						'coords'	=> $coords,
						'placeName'	=> $place,
						'added'		=> time()
					])
					->eksekusi();
	}
	public function delete() {
		$id = EMBO::pos('idway');
		$del = EMBO::tabel('waypoint')->hapus()->dimana(['idway' => $id])->urutkan('added', 'ASC')->eksekusi();
	}
	public function search() {
		$query = "SELECT id, name, address, lat, lng, ( 3959 * acos( cos( radians('%s') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians('%s') ) + sin( radians('%s') ) * sin( radians( lat ) ) ) ) AS distance FROM markers HAVING distance < '%s' ORDER BY distance LIMIT 0 , 20";
	}
	public function start($id) {
		$get = EMBO::tabel('waypoint')->pilih()->dimana(['idangkot' => $id])->urutkan('added', 'ASC')->batas(1)->eksekusi();
		$r = EMBO::ambil($get);
		return $r['coords'];
	}
	public function end($id) {
		$get = EMBO::tabel('waypoint')->pilih()->dimana(['idangkot' => $id])->urutkan('added', 'DESC')->batas(1)->eksekusi();
		$r = EMBO::ambil($get);
		return $r['coords'];
	}
	public function extractPlaceName($name) {
		$p = explode(",", $name);
		// tanpa no
		$n = explode("No", $p[0]);
		// tanpa jalan
		if(strpos($n[0], "Jl.") !== false) {
			$exp = "Jl.";
		}else {
			$exp = "Jalan";
		}
		$j = explode($exp, $n[0]);
		if($j[0] == "") {
			$toShow = $j[1];
			}else {
				$toShow = $j[0];
			}
			$lim = explode(" ", $toShow);
			$toShow = $lim[0]." ".$lim[1];
			if(str_split($toShow)[0] == " ") {
				$toShow = substr($toShow, 1);
			}else {
			$toShow = $toShow;
		}
		return $toShow;
	}
	public function cari() {
		$kw = $_COOKIE['kw'];
		$asal = $_COOKIE['asal'];
		// pisah titik
		$k = explode(".", $asal);
		if(strpos($asal, ".") !== false) {
			$asal = $k[1];
		}else {
			$asal = $k[0];
		}

		// ngecek onok trayek ta gak?
		$q = EMBO::tabel('waypoint')->pilih()->dimana(['placeName' => $kw], 'like')->eksekusi();
		if(EMBO::hitung($q) == 0) {
			echo "No result";
		}else {
			?>
			<table>
				<thead>
					<tr>
						<th>Keterangan</th>
						<th style="width: 15%">Angkot</th>
						<th>Harga</th>
					</tr>
				</thead>
				<tbody>
					<?php
					while($r = EMBO::ambil($q)) {
						$price = "Rp 5.000";
						$idangkot = $r['idangkot'];
						$cekTrayek = EMBO::query("SELECT * FROM waypoint WHERE idangkot = '$idangkot' AND placeName LIKE '%$asal%' GROUP BY idangkot");
						if(EMBO::hitung($cekTrayek) == 0) {
							// oper
							$y = EMBO::query("SELECT * FROM waypoint WHERE idangkot = '$idangkot'");
							while($hai = EMBO::ambil($y)) {
								$namaAngkot = angkot::info($hai['idangkot'], 'nama');
								$place = $hai['placeName'];
								$toShow = $this->extractPlaceName($place);
								
								$halo = EMBO::query("SELECT * FROM waypoint WHERE placeName LIKE '%$toShow%' AND idangkot != '$idangkot'");
								while($dunia = EMBO::ambil($halo)) {
									$dari = angkot::info($dunia['idangkot'], 'nama');
									$ke = angkot::info($idangkot, 'nama');
									$extractedPlace = $this->extractPlaceName($dunia['placeName']);
									echo "<tr>".
											"<td>Berangkat dari <b>".$asal."</b> menuju <b>".$kw."</b>. &nbsp; <a href='./waypoint&idangkot=".$dunia['idangkot']."&idangkots=$idangkot'><button id='view' class='tbl biru' onclick='aturPlaceOper(this.value)' value='".$extractedPlace."'>lihat di peta</button></a><br />".
											"Bertemu di sekitar ".$extractedPlace.
											"</td>".
											"<td>".$dari." & ".$ke."</td>".
											"<td>Rp 10.000</td>".
										 "</tr>";
								}
							}
						}else {
							// gak oper
							while($rTrayek = EMBO::ambil($cekTrayek)) {
								$namaAngkot = angkot::info($rTrayek['idangkot'], 'nama');
								echo "<tr>".
										"<td>Berangkat dari <b>".$asal."</b> menuju <b>".$kw."</b> &nbsp; <button id='view' onclick='lihat(this.value)' value='".$idangkot."' class='tbl biru'>lihat di peta</button></td>".
										"<td>".$namaAngkot."</td>".
										"<td>".$price."</td>".
									 "</tr>";
							}
						}
					}
					?>
				</tbody>
			</table>
			<?php
		}
	}
}

$waypoint = new waypoint();

?>