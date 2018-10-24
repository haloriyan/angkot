<!DOCTYPE html>
<html>
<head>
	<meta charset='UTF-8'>
	<meta name='viewport' content='width=device-width, initial-scale = 1'>
	<title>waypoint</title>
	<link href='aset/fw/build/fw.css' rel='stylesheet'>
	<link href='aset/fw/build/font-awesome.min.css' rel='stylesheet'>
</head>
<body>

<div class='wrap'>
	<h2 class='rata-tengah'>waypoint's page created</h2>
</div>

<div id="map" style="height: 300px;"></div>
    <div id="right-panel">
    <div>
    <b>Start:</b>
    <select id="start">
    	<option value="Wonokromo, Surabaya City, East Java 60242, Indonesia">Wonokromo</option>
      <option value="Halifax, NS">Halifax, NS</option>
      <option value="Boston, MA">Boston, MA</option>
      <option value="New York, NY">New York, NY</option>
      <option value="Miami, FL">Miami, FL</option>
    </select>
    <br>
    <b>Waypoints:</b> <br>
    <i>(Ctrl+Click or Cmd+Click for multiple selection)</i> <br>
    <select multiple id="waypoints" onchange="console.log(this.value)">
      <option value="montreal, quebec">Montreal, QBC</option>
      <option value="toronto, ont">Toronto, ONT</option>
      <option value="chicago, il">Chicago</option>
      <option value="winnipeg, mb">Winnipeg</option>
      <option value="fargo, nd">Fargo</option>
      <option value="calgary, ab">Calgary</option>
      <option value="spokane, wa">Spokane</option>
      <option value="Banyu Urip, Sawahan, Surabaya City, East Java 60254, Indonesia">Banyu Urip</option>
    </select>
    <br>
    <b>End:</b>
    <select id="end">
    	<option value="Petemon, Sawahan, Surabaya City, East Java 60252, Indonesia">Petemon</option>
      <option value="Vancouver, BC">Vancouver, BC</option>
      <option value="Seattle, WA">Seattle, WA</option>
      <option value="San Francisco, CA">San Francisco, CA</option>
      <option value="Los Angeles, CA">Los Angeles, CA</option>
    </select>
    <br>
      <input type="submit" id="submit">
    </div>
    <div id="directions-panel"></div>
    </div>
<script src='aset/js/embo.js'></script>
<!-- AIzaSyD8NuAKWkdiDlpdNiJ_HA1l2w6oTYNoZVY -->
<script>
	function initMap() {
		let directionsService = new google.maps.DirectionsService;
		var directionsDisplay = new google.maps.DirectionsRenderer;
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 6,
          center: {lat: -7.270156914276002, lng: 112.72879890040281}
        });
        directionsDisplay.setMap(map);

        document.getElementById('submit').addEventListener('click', function() {
          calculateAndDisplayRoute(directionsService, directionsDisplay);
        });
	}

	function calculateAndDisplayRoute(directionsService, directionsDisplay) {
		let waypts = []
		let checkboxArr = document.getElementById('waypoints')
		for(var i = 0; i < checkboxArr.length; i++) {
			if(checkboxArr[i].selected) {
				waypts.push({
					location: checkboxArr[i].value,
					stopover: false
				})
			}
		}
		directionsService.route({
         	origin: document.getElementById('start').value,
         	destination: document.getElementById('end').value,
         	// waypoints: waypts,
         	waypoints: [
         		{
	         		location: new google.maps.LatLng(-7.270156914276002, 112.72879890040281),
	         		stopover: false
         		},
         		{
	         		location: new google.maps.LatLng(-7.259270361903685, 112.73272631154782),
	         		stopover: false
         		}
         	],
         	optimizeWaypoints: true,
         	travelMode: 'DRIVING'
        }, function(response, status) {
         	if (status === 'OK') {
            	directionsDisplay.setDirections(response);
            	var route = response.routes[0];
            	var summaryPanel = document.getElementById('directions-panel');
            	summaryPanel.innerHTML = '';
            	// For each route, display summary information.
            	for (var i = 0; i < route.legs.length; i++) {
              		var routeSegment = i + 1;
		              summaryPanel.innerHTML += '<b>Route Segment: ' + routeSegment +
                  		'</b><br>';
              		summaryPanel.innerHTML += route.legs[i].start_address + ' to ';
              		summaryPanel.innerHTML += route.legs[i].end_address + '<br>';
              		summaryPanel.innerHTML += route.legs[i].distance.text + '<br><br>';
            	}
          	} else {
            window.alert('Directions request failed due to ' + status);
          }
        });
	}
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD8NuAKWkdiDlpdNiJ_HA1l2w6oTYNoZVY&callback=initMap"></script>

</body>
</html>