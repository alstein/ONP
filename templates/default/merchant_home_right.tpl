{literal}
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script language="JavaScript" type="text/javascript">
function confirmation()
{
	var answer = confirm("You Want To Offer A Deal");
	if (answer)
	{
		window.location =SITEROOT+"/merchant-account/merchant_deal_request";
	}
	else{
		window.location =SITEROOT+"/merchant-account/merchant_profile_home";
	}
}

function appr(val1,fullname)
{  
	
	if(confirm("Would you like add "+fullname+" as fan?"))
	{
		$.post(SITEROOT+"/modules/merchant-account/become_fan.php",{merchant_id:val1},function(data){
				window.location=SITEROOT+"/friend/view_all_fav_places/";
		});
	}
}
</script>
<script type="text/javascript">
	var map;
	function initialize() {
		var mapDiv = document.getElementById('map-canvas');
		map = new google.maps.Map(mapDiv, {
// 			center: new google.maps.LatLng(54.9533, -2.5681),
			center: new google.maps.LatLng({/literal}'{$lat}'{literal},{/literal}'{$long}'{literal}),
			zoom: 17,
			//iwloc=A,
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


<td width="200" valign="top" style="border:none" class="last-td"><!-- Profile Search Section Start -->
          <div class="maincont-inner-rgt fl">

			{if $smarty.session.csUserTypeId eq 2 and $num_fan eq '0'} 
			<form name="bfan" id="bfan" action="{$siteroot}/modules/" method="POST">
				<input type="hidden" name="temp_mer_id" id="temp_mer_id" value="{$smarty.get.id1}">
				<div class="deal-red">
              <div class="deal-red-lft fl"> <img src="images/dollar-sign.png" width="38" height="35" alt="" title="" /> </div>
              <div class=" deal-red-rgt fl">
               <a onclick="appr({$smarty.get.id1},'{$fan_rrow.fullname}');"> <h1>Become A Fan</h1></a>
              </div>
              <div class="clr"></div>
            </div>
			</form>
			{/if}


		
              {if $smarty.session.csUserTypeId eq '3' && ($smarty.get.id1 eq '' || $smarty.get.id1 eq $smarty.session.csUserId)}
				{if $count_deal_eligibility eq 0}
					<div class="deal-red">
				<div class="deal-red-lft fl"> <img src="{$siteroot}/templates/default/images/dollar-sign.png" width="38" height="35" alt="" title="" /> </div>
				<div class=" deal-red-rgt fl">
				<a  href="javascript:void(0);" onclick="confirmation();"><h1 style="font-size:16px;">Give An Offer</h1></a>
				{else}
				{if $deal_eligibility.status eq 'yes' }
				<div class="deal-red" style="width:203px;">
              <div class="deal-red-lft fl"> <img src="{$siteroot}/templates/default/images/dollar-sign.png" width="38" height="35" alt="" title="" /> </div>
              <div class=" deal-red-rgt fl">
				<a href="{$siteroot}/deal/create_deal"><h1 style="width:168px;font-size:15px;">Create Offers</h1></a>
			 </div>
              <div class="clr"></div>
            </div>
				{elseif $deal_eligibility.status eq 'no'}
				 <div class="deal-red">
				<div class="deal-red-lft fl"> <img src="{$siteroot}/templates/default/images/dollar-sign.png" width="38" height="35" alt="" title="" /> </div>
				<div class=" deal-red-rgt fl">
				<a class="loc_busines" href="javascript:void(0);" ><h1 style="font-size:12px;">Request Pending</h1></a>
				 </div>
				<div class="clr"></div>
				</div>
				{elseif $deal_eligibility.status eq 'rejected'}
				<div class="deal-red">
              <div class="deal-red-lft fl"> <img src="{$siteroot}/templates/default/images/dollar-sign.png" width="38" height="35" alt="" title="" /> </div>
              <div class=" deal-red-rgt fl">
				<a  href="javascript:void(0);" ><h1 style="font-size:12px;">Request Rejected</h1></a>
			 </div>
              <div class="clr"></div>
            </div>
				{/if}
				{/if}
			{/if}
             
			

			
            <div class="average-rating">
              <div class="average-rating-top"> <span>Average Rating in Category:</span>
                <p class="fl">Rating:</p>
                <div class="fl" style="margin:5px 0 0 0">
					<span class="star_1"><img  {if $avg_rating  > 0 && $avg_rating  <= 0.5} src="{$siteroot}/templates/default/images/star-half.png"{/if} {if $avg_rating  > 0.5 } src="{$siteroot}/templates/default/images/star-on.png" {else}  src="{$siteroot}/templates/default/images/star-off.png" {/if}/></span>
					<span class="star_2"><img alt=""{if $avg_rating  > 1 && $avg_rating <= 1.5} src="{$siteroot}/templates/default/images/star-half.png"{/if} {if $avg_rating > 1.5}src="{$siteroot}/templates/default/images/star-on.png"{else} src="{$siteroot}/templates/default/images/star-off.png"{/if}/></span>
					<span class="star_3"><img  alt=""  {if $avg_rating > 2 && $avg_rating  <= 2.5} src="{$siteroot}/templates/default/images/star-half.png"{/if} {if $avg_rating  > 2.5}src="{$siteroot}/templates/default/images/star-on.png"{else} src="{$siteroot}/templates/default/images/star-off.png"{/if} /></span>
					<span class="star_4"><img  alt="" {if $avg_rating  > 3 && $avg_rating <= 3.5} src="{$siteroot}/templates/default/images/star-half.png"{/if} {if $avg_rating  > 3.5}src="{$siteroot}/templates/default/images/star-on.png"{else} src="{$siteroot}/templates/default/images/star-off.png"{/if}/></span>
					<span class="star_5"><img alt="" {if $avg_rating  > 4 && $avg_rating  <= 4.5} src="{$siteroot}/templates/default/images/star-half.png"{/if} {if $avg_rating  > 4.5}src="{$siteroot}/templates/default/images/star-on.png"{else} src="{$siteroot}/templates/default/images/star-off.png"{/if}/></span>
				</div>
                <div class="clr"></div>
              </div>
              <div> <span>Average Offer Discount in Category:</span>
                <p>Percent: <b>{$avg_discount|number_format:0}%</b></p>
              </div>
            </div>
            <div class="map">
              <h1>Location</h1>
              <div class="map-img"> <!--<iframe src="{$siteroot}/GoogleMapAPI-2.5/map.php?location={$maplocation}&width=182&height=195"  width="155px" height="191px"  frameborder="0" scrolling="no" marginheight="0" marginwidth="0" style="margin-left:1px"></iframe> --></div>
              <a href="{$siteroot}/merchant-account/{$mapuser}/map/" target="_blank" class="map-txt fr">Enlarge Our Location</a> </div>
          </div>
          <!-- Profile Search Section Start --></td>
