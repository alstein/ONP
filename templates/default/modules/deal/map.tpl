<head>
{literal}
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">

	var map;
	function initialize() {
		var mapDiv = document.getElementById('map-canvas');
		map = new google.maps.Map(mapDiv, {
// 			center: new google.maps.LatLng(54.9533, -2.5681),
			center: new google.maps.LatLng({/literal}'{$lat2}'{literal},{/literal}'{$long2}'{literal}),
			zoom: 17,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		});
		google.maps.event.addListenerOnce(map, 'tilesloaded', fetchLatLng);
	}

	function fetchLatLng() {
		////START Latlng using location name////

		//var locationName = '<?php echo $addressSTR; ?>';//'Nasik,maharashra,India';
			var locationName = {/literal}'{$maplocation}'{literal};//'Nasik,maharashra,India';
		//var locationName = 'Vally 420, london, United Kingdom.';
		var geocoder = new google.maps.Geocoder();
		geocoder.geocode( {'address': locationName }, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				var searchLoc = results[0].geometry.location;
				var lat = results[0].geometry.location.lat();
				var lng = results[0].geometry.location.lng();
 				//var info = '<?php echo $addressSTR; ?>';
				var info = {/literal}'{$maplocation}'{literal};;
				//var info = 'Vally 420, london, United Kingdom.';
				var markNo = 1;
				addMarker(lat,lng, info, markNo);
			}
		});
		////END Latlng using location name////
	}

	function addMarker(lat, lng, info, markNo) {
		var rozmiar = new google.maps.Size(30,30);
		var rozmiar_cien = new google.maps.Size(59,32);
		var punkt_startowy = new google.maps.Point(0,0);
		var punkt_zaczepienia = new google.maps.Point(16,16);

		var ikona1 = new google.maps.MarkerImage("{/literal}{$siteroot}{literal}/templates/default/images/gmap_button.gif", rozmiar, punkt_startowy, punkt_zaczepienia);

		var latLng = new google.maps.LatLng(lat, lng);
		var marker = new google.maps.Marker({
			position: latLng,
			map: map,
			icon:ikona1,
			title:"a"
		});

		var j = markNo;
		marker.setTitle(j.toString());
		message = info;
		attachSecretMessage(marker, markNo,message);
	}

	function attachSecretMessage(marker, number,message) {
		//alert(marker + "-" + number + " " + message);
		var message = message;
		var infowindow = new google.maps.InfoWindow(
		{ content: message,
			size: new google.maps.Size(50,50)
		});

	google.maps.event.addListener(marker, 'click', function() {
    			map.setZoom(15);
    			map.setCenter(marker.getPosition());
  		});
		//infowindow.open(map,marker);
		google.maps.event.addListener(marker, 'click', function() {
			//infowindow.open(map,marker);
		});
	}

	google.maps.event.addDomListener(window, 'load', initialize);
</script>

{/literal}
</head>
<title>Map</title>
<body>
 <div class="deal-map" style=" border: 1px solid #C9C9C9;
    height: 480px;
    margin-bottom: 9px;
    padding: 5px;
    width: 1300px;">
<div id="map-canvas" style="height:480px;width:1300px"></div>
<!--<iframe src="{$siteroot}/GoogleMapAPI-2.5/map.php?location={$maplocation}&height=500&width=1300" height="480px" width="1300px" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" style="margin-left:1px"></iframe>-->
</div>
</body>
</html>