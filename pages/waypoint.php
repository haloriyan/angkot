<?php
include 'aksi/ctrl/waypoint.php';
$idangkot = $_GET['idangkot'];
$idangkots = $_GET['idangkots'];
$tempatOper = $_COOKIE['tempatOper'];
setcookie('idangkot', $idangkot, time() + 5555, '/');
setcookie('idangkots', $idangkots, time() + 5555, '/');

if($tempatOper == '') {
  $bayar = "Rp 10.000";
}else {
  $bayar = "Rp 20.000";
}

if($idangkots != '') {
  $startRute = $waypoint->start($idangkot);
  $endRute = $waypoint->end($idangkots);
}else {
  $startRute = $waypoint->start($idangkot);
  $endRute = $waypoint->end($idangkot);
}

function getTempatOper($place) {
  $waypoint = new waypoint();
  $coords = $waypoint->locate($place, 'coords');
  $c = explode("|", $coords);
  $lat = $c[0];
  $lng = $c[1];
  $res = "{
  location: new google.maps.LatLng(".$lat.", ".$lng."),
  stopover: false
}";
  return $res;
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset='UTF-8'>
	<meta name='viewport' content='width=device-width, initial-scale = 1'>
	<title>waypoint</title>
	<link href='aset/fw/build/fw.css' rel='stylesheet'>
	<link href='aset/fw/build/font-awesome.min.css' rel='stylesheet'>
  <style>
    #map {
      position: absolute;
      top: 0px;left: 0px;bottom: 0px;
      width: 60%;
    }
    .keterangan {
      position: absolute;
      top: 0px;left: 60%;right: 0px;
      color: #555;
    }
    .keterangan .wrap { margin: 10%; }
  </style>
</head>
<body>

<div id="map"></div> 
<input type="hidden" id="startRute" value="<?php echo $startRute; ?>">
<input type="hidden" id="endRute" value="<?php echo $endRute; ?>">

<div class="keterangan">
  <div class="wrap">
    <h2>Keterangan :</h2>
    <h3>Berangkat dari :</h3>
    <span id="addrStart"></span><br /><br />
    <h3>Menuju :</h3>
    <span id="addrEnd"></span>
    <h3>Jarak :</h3>
    <span id="jarakTempuh"></span>
    <h3>Oper di :</h3>
    <?php echo $tempatOper; ?>
    <h2>Bayar :</h2><?php echo $bayar; ?>
  </div>
</div>


<script src='aset/js/embo.js'></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD8NuAKWkdiDlpdNiJ_HA1l2w6oTYNoZVY&callback=initMap&libraries=places"></script>
<!-- AIzaSyD8NuAKWkdiDlpdNiJ_HA1l2w6oTYNoZVY -->
<script>
	function initMap() {
		let directionsService = new google.maps.DirectionsService;
		var directionsDisplay = new google.maps.DirectionsRenderer;
    var infowindow = new google.maps.InfoWindow;
    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 14,
      center: {lat: -7.270156914276002, lng: 112.72879890040281}
    });
    directionsDisplay.setMap(map);

    calculateAndDisplayRoute(directionsService, directionsDisplay);
	}
  function getPlaceName(setLat, setLng) {
    var geocoder = new google.maps.Geocoder;
    let latLng = { lat: parseFloat(setLat), lng: parseFloat(setLng) }

    geocoder.geocode({
      'location': latLng,
    }, function(results, status) {
      if(status === 'OK') {
        let formattedAddr = results[0].formatted_address
        return formattedAddr
      }else {
        // alert('No result foound')
      }
    })
  }

  let startRute = $("#startRute").isi()
  let endRute = $("#endRute").isi()
  let latStart = startRute.split("|")[0]
  let lngStart = startRute.split("|")[1]
  let latEnd = endRute.split("|")[0]
  let lngEnd = endRute.split("|")[1]

	function calculateAndDisplayRoute(directionsService, directionsDisplay) {
		directionsService.route({
         	origin: new google.maps.LatLng(latStart, lngStart),
         	destination: new google.maps.LatLng(latEnd, lngEnd),
         	// waypoints: waypts,
         	waypoints: [
            <?php
              if($idangkots == '') {
                echo $waypoint->get();
              }else {
                echo getTempatOper($tempatOper);
              }
            ?>
          ],
         	optimizeWaypoints: true,
         	travelMode: 'DRIVING'
        }, function(response, status) {
         	if (status === 'OK') {
            	directionsDisplay.setDirections(response);
            	var route = response.routes[0];
            	// For each route, display summary information.
            	for (var i = 0; i < route.legs.length; i++) {
              		var routeSegment = i + 1;
		              // summaryPanel.innerHTML += '<b>Route Segment: ' + routeSegment +
                //   		'</b><br>';
                  $("#addrStart").tulis(route.legs[i].start_address)
                  $("#addrEnd").tulis(route.legs[i].end_address)
                  $("#jarakTempuh").tulis(route.legs[i].distance.text)
            	}
          	} else {
            window.alert('Directions request failed due to ' + status);
          }
        });
	}
</script>

</body>
</html>