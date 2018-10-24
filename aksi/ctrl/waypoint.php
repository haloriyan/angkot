<?php
include 'angkot.php';

class waypoint extends angkot {
	public function load() {
		$id = $_COOKIE['idangkot'];

		$q = EMBO::tabel('waypoint')->pilih()->dimana(['idangkot' => $id])->eksekusi();
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
	public function start() {
		$id = $_COOKIE['idangkot'];
		$get = EMBO::tabel('waypoint')->pilih()->dimana(['idangkot' => $id])->urutkan('added', 'ASC')->batas(1)->eksekusi();
		$r = EMBO::ambil($get);
		return $r['coords'];
	}
	public function end() {
		$id = $_COOKIE['idangkot'];
		$get = EMBO::tabel('waypoint')->pilih()->dimana(['idangkot' => $id])->urutkan('added', 'DESC')->batas(1)->eksekusi();
		$r = EMBO::ambil($get);
		return $r['coords'];
	}
}

$waypoint = new waypoint();

?>