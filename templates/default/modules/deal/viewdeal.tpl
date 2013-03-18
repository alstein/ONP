{include file=$header_start}
{strip}
<!--<script src="http://code.jquery.com/jquery-latest.js"></script>-->
<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>-->
<script type="text/javascript" src="{$sitejs}/jquery.timeago.js"></script>
<!--<link href="{$siteroot}/templates/default/css/countdown.css" rel="stylesheet" type="text/css">-->
<!--<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>-->
<link href="{$siteroot}/templates/default/css/popup.css" rel="stylesheet" type="text/css"/>

{/strip}

{literal}

<script type="text/javascript">
var rewards_total= {/literal}'{$rewards}'{literal};
var shippingstatus={/literal}'{$shippingstatus}'{literal};
var siteurl= {/literal}'{$siteroot}'{literal};
var numericExpression = /^[0-9]+$/;
$("#submitreward").live("click",function(){
    $(".errmesage").hide();
    var reward=parseInt($("#rewardstotal").val());
    var amount={/literal}'{$admin_comm_amt|number_format:1}'{literal};
if($("#rewardstotal").val().length==0){
    $(".errmesage").html("Empty field"); 
    $(".errmesage").show();
    return false;
}
if($("#rewardstotal").val().match(numericExpression)){
      if(reward <= rewards_total ){ 
           if(reward<=(amount/0.1)){
                   jQuery.post(siteurl+"/modules/deal/viewdeal.php",{reward:reward},
                                   function(data)
                                     {  
                                       var substr = data.split(',');
                                       var finamt=amount-substr[0];
                                       var finalresult="$"+finamt
                                       $("#rewpay").html(substr[1]);
                                       $("#amtpay").html(finalresult);
                                       $('#amount').val(finamt);
                                       $(".box-popup").hide();
                                       if(shippingstatus==1){ 
                                         $("#shipping-pop").show();
                                       } else{
                                        var qty=$("#quantities").val();
                                        $("#frm").submit();
                                         }
                                       
                                     });
           }
           else{
                    $(".errmesage").html("Your entered rewards are greater than the amount you need to pay"); 
                    $(".errmesage").show();
                        return false;
               }
      }
      else{  
            $(".errmesage").html("Enter a value less than total rewards you have"); 
            $(".errmesage").show();
            return false; 
          }  
  }
  else{
           $(".errmesage").html("Enter numbers only"); 
           $(".errmesage").show();
           return false;   
       }
    });

$(".close-pop").live("click",function(){
          $("#reward-pop").hide();
});

$(document).ready(function(){
	
    $("#clickhere").click(function(){ 
        if({/literal}'{$smarty.session.csUserTypeId}'{literal} != 2) {
            window.location="{/literal}{$siteroot}{literal}/login/";
        }
        $("#reward-pop").show();
        var widthWrapper = $(".popnew").width();
        var widthPopup = $(".box-popup").width();
        var diff = widthWrapper - widthPopup;
        var poupLeft = $(".box-popup").parent().offset().left;
        var poupTop = $(window).height()-$(".box-popup").height();
        $(".box-popup").css("center", poupLeft + diff/2+"px");
        $(".box-popup").css("top", poupTop/2+"px");
    });
    $("#close-popup").click(function(){
         var shippingstatuss={/literal}'{$shippingstatus}'{literal};
            $(".box-popup").hide(); 
            var qty=$("#quantities").val();
            //$("#quantity").val(qty);
            //var amt = '{/literal}{$deal.offer_price}{literal}';
            //var tot_amt=parseInt(qty)*parseFloat(amt);
            //$("#amount").val(tot_amt);
             if(shippingstatuss==1){
                 $("#shipping-pop").show();
             }
                   else{	
                        $("#frm").submit();}
		});
	});

function clockon()
 {

 thistime= new Date();
  var today_dt = dateFormat(thistime, "dddd, mmmm dS, yyyy");
 var hours=thistime.getHours();
 var minutes=thistime.getMinutes();
 var seconds=thistime.getSeconds();
 if (eval(hours) <10) {hours="0"+hours;}
 if (eval(minutes) < 10) {minutes="0"+minutes;}
 if (seconds < 10) {seconds="0"+seconds;}
 thistime = hours+":"+minutes+":"+seconds;
 jQuery('#bgclocknoshade').html(today_dt);
 var timer=setTimeout("clockon()",200);
}

/*function submit_form(){ 
        if($("#hidfield").val()==1){
	var qty=$("#quantities").val();
	$("#quantity").val(qty);
	//var amt = '{/literal}{$deal.offer_price}{literal}';
	//var tot_amt=parseInt(qty)*parseFloat(amt);
	//$("#amount").val(tot_amt);	
	$("#frm").submit();}
}*/

function showdate()
{
var trs = document.getElementsByTagName("abbr");
	for(var i=0;i<trs.length;i++)
	{
		j=i+1;
  		jQuery("#timeago_"+j+"").timeago(); 
	}
}

function add_sub_comment(rating_id,user_id){ 
	var comment=$("#subcomment_"+rating_id).val();
	//alert(comment);
	if(comment=="" || comment=="Add Comment"){
		alert("Please enter comment");
	}else{	
		jQuery.post(SITEROOT+"/modules/my-account/add_sub_comment.php",{rating_id:rating_id,user_id:user_id,comment:comment},function(data){
					//if(data==1)
						window.location=window.location.href;
		});
	}
}

function show_sub_comment_box(rating_id){ 
	$("#div_"+rating_id).toggle();
}

function redirect(){
	window.location="{/literal}{$siteroot}{literal}/deal/viewalldeal/";
}

$(document).ready(function(){
		$(".showdel1").mouseover(function(){ 
			var d = this.id; //alert(d);
			$("#msg_id"+d).css({visibility:'visible'});
		});

		$(".showdel1").mouseout(function(){
			var d = this.id;
			$("#msg_id"+d).css({visibility:'hidden'});
		});

		$(".showdel").mouseover(function(){
			var d = this.id;//alert(d);
			$("#dlid"+d).css({visibility:'visible'});
		});

		$(".showdel").mouseout(function(){
			var d = this.id;
			$("#dlid"+d).css({visibility:'hidden'});
		});
});
        $("#submitaddress").live("click",function(){
          var name=$("#shippingadd-name").attr("value");
          var add1=$("#shippingadd-add1").attr("value");
          var add2=$("#shippingadd-add2").attr("value");
          var add3=$("#shippingadd-add3").attr("value");
          var pin=$("#pincode").attr("value");
          if(name==""){
                 alert("Name field is mandatory"); return false;
             }
           if(add1==""){
                 alert("Address is mandatory"); return false;
             }
            if(add2==""){
                 alert("Address is mandatory"); return false;
             }
            if(pin==""){
                 alert("PINCODE is mandatory"); return false;
             }
          var numbers = /^[0-9]+$/;
          var address_shipping=name+" "+add1+" "+add2+" "+" "+add3+" "+pin;  
          if(pin.match(numbers)){
              jQuery.post(SITEROOT+"/modules/deal/viewdeal.php",{shippingaddress:address_shipping,name:name,add1:add1,add2:add2,add3:add3,pin:pin},function(data){
			$(".box-popup").hide();
                        
                        $("#frm").submit();		
		});  
          }
          else{

            alert("Enter numbers only"); return false;
          }
       
          
        });
</script>
<script type="text/javascript">
	var map;
	function initialize() {
		var mapDiv = document.getElementById('map-canvas');
		map = new google.maps.Map(mapDiv, {
// 			center: new google.maps.LatLng(54.9533, -2.5681),
			center: new google.maps.LatLng({/literal}'{$lat1}'{literal},{/literal}'{$long1}'{literal}),
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
{strip}
<!--<script language="JavaScript" src="{$siteroot}/js/countdown.js"></script>-->
{/strip}
{literal}
<script language="JavaScript">

</script>

{/literal}
{include file=$profile_header2}

  <!-- Header ends -->

  <!-- Maincontent starts -->

  <div id="maincont" class="ovfl-hidden">

    <table width="1000" border="0" cellpadding="0" cellspacing="0" class="profile-tbl">

      <tr>

        <!-- Profile Left Section Start -->

        <td width="208" valign="top"><div class="maincont-inner-lft fl">

            <!-- Edit Profile Start -->

            <div class="user-pic">

              <div class="user-mer-big"> <a href="{$siteroot}/uploads/deal/{$deal.deal_image}" target="_blank"> <img src="{$siteroot}/uploads/deal/225x225/{$deal.deal_image}" height="209" width="178"></a> </div>

              <div class="clr"></div>

            </div>

            <div>

            <div class="map-img"> 
				<div class="google-map" style="margin:0px"> 
      				<div id="map-canvas" style="height:190px;width:179px"></div>
				</div>
			</div>

            <a href="{$siteroot}/deal/{$smarty.get.deal_id}/map/" target="_blank" class="map-txt fr" style="margin-right:15px">Enlarge Our Location</a> </div>

            <div class="clr"></div>

            <div class="detail-list">

            <h1>Details</h1>

            <ul class="reset detail-list">

            <li>

            <label class="road-img">&nbsp;</label>

            <a href="javascript:void(0)" class=" fl">{$deal.address1}
</a>

            <div class="clr"></div>

            </li>

            <li>

            <label class="phone-img">&nbsp;</label>

            <a href="javascript:void(0)" class=" fl">{$deal.contact_detail}
</a>

            <div class="clr"></div>

            </li>

            <li>

            <label class="mail-img ">&nbsp;</label>

           <a href="javascript:void(0)" class=" fl"> {$deal.email}
</a>

            <div class="clr"></div>

            </li>

            <li>

            <label class="web-img">&nbsp;</label>

            <a href="javascript:void(0)" class=" fl"><span>{$deal.business_webURL} </span>

</a>

            <div class="clr"></div>

            </li>

            

            </ul>

            

            </div>

            </div>

            

          <!-- Edit Profile End --></td>

        <!-- Profile Left Section End -->

        <!-- Profile Middle Section Start -->

        <td width="792" valign="top" style="border:none"><!-- Profile Comment Section Start -->

          <div class="maincont-buy-mid fl">

            <div class="fr" style="margin:10px 0 10px 0">

               <a href="javascript:void(0)" style="color: #FFFFFF; float:right" onClick="redirect()"><input name="name" type="button"  class="submit-btn" value="View All Offers" style="width:132px;"/></a>
              <div class="clr"></div>

            </div>

            <div class="buy-slogan">

              <p><abbr>&nbsp;</abbr><span>{$deal.discount_in_per}% OFF</span><abbr>&nbsp; On </abbr> {$deal.deal_title}</p>

            </div>
            <div class="buy-time">

              <div class="grey-box fl">

                <div class="grey-box-lft fl"> <img src="{$siteroot}/templates/default/images/grey-icon.png" width="34" height="43" alt="" title="" /> </div>

                <div class="grey-box-rgt fl">

                  <p>Time Left:</p>

                  <span><script language="javascript" src="{$siteroot}/timezone.php?timezone=Asia/Singapore&countto={$date_to_pass}&id={$smarty.get.deal_id}&allowPrintSpan=1&{$currenttime}"></script></span> </div>

                <div class="clr"></div>

              </div>

              <div class="blue-box fl">

                <p>In Stock</p>

                <span>{$remaining_deals}</span> </div>

            </div>

            <div class="main-deal"> 
				{if $deal_status eq 'SOLD'}
					<a href="javascript:void(0)" class="sold-btn"></a>

				{elseif $deal_status eq 'Expired'}
					<a href="javascript:void(0)" class="expired-btn"></a>

				{elseif $smarty.session.csUserTypeId neq 3}
					<a href="javascript:void(0)" class="buy-now-btn" id="clickhere"></a>

				{else}
					
				{/if}
				
              <div class="buy-now ">

                <p>Amount to Pay Now</p>

                <h1>${$admin_comm_amt|number_format:1}</h1>

              </div>

              <table width="435" cellpadding="0" cellspacing="0" border="0" class="deal-amt-tbl">

                <tr>

                  <td width="81" height="20" align="center"> Discount </td>

                  <td width="110" align="center">Original Price</td>

                  <td width="90" align="center">You Save</td>

                  <td width="155" align="center">Price After Discount</td>

                </tr>

                <tr>

                  <td width="81" height="40" align="center"><p>{$deal.discount_in_per}%</p></td>

                  <td width="110" align="center"><p>${$deal.original_price|number_format}</p></td>

                  <td width="90" align="center"><p>${$yousave}</p></td>

                  <td width="155" align="center"><p>${$deal.offer_price|number_format:1}</p></td>

                </tr>

              </table>

            </div>

            <div class="amt-section">
			  
              <p>Amount to pay directly to merchant: <span>${$merchant_pay|number_format:1} </span></p>

              <p>Redeem before: <span>{$deal.redeem_to|date_format:"%e %B  %Y"}</span></p>

			  <p>Reward points remaining:<span>{$rewards}</span></p> 	
            </div>

          </div>

          <div class="site-contain fl">

			 <div class="offer-detail">

              <!--<h1 class="contain-title">Deal Images</h1>-->

              <div  style="float: left;"><a href="{$siteroot}/uploads/deal/{$deal.deal_image1}" target="_blank"><img src="{$siteroot}/uploads/deal/225x225/{$deal.deal_image1}"   ></a> </div>

			<div style="float: left;margin-left:20px;" ><a href="{$siteroot}/uploads/deal/{$deal.deal_image2}" target="_blank"><img  src="{$siteroot}/uploads/deal/225x225/{$deal.deal_image2}" ></a></div>
<div class="clr"></div>
            </div>
            <div class="offer-detail">

              <h1 class="contain-title">Offer Details</h1>

              <p>{$deal.offer_details} </p>

            </div>


<!-- reward point popup-->

<div class="popnew">
	<div class="box-popup" style="padding-left:0px;padding-bottom:10px;" id="reward-pop">
    	   <div class="title" style="margin-top:0px">
        	<h1>You have {$rewards} Reward Points available. Would you like to redeem Some ?</h1>
           </div>
           <div class="pop-content">
              Redeem <input type="text" id="rewardstotal"/> Points
              
            <span class="errmesage" style="margin-left:20px;color: #DA4730; display:none;" ></span>
        </div>
        <div class="bottom" style="padding-top:10px">
            <input type="button" class="close-pop previe-btn" value="cancel" style="text-transform:none"/>
                 
               <button class="previe-btn"  id="close-popup"><span class="share-btn-lft" style="text-transform:none"><span class="share-btn-rgt">No Thanks</span></span></button>
            <button class="previe-btn" id="submitreward"><span class="share-btn-lft" style="text-transform:none"><span class="share-btn-rgt">Yes,Redeem My Points</span></span></button>
            <div class="clear"></div>
        </div> 
    </div> 
	
</div>
<!-- reward point popup-->

<!---shipping popup --->
<div class="popnew">
	<div class="box-popup" style="padding-left:0px;padding-bottom:10px;" id="shipping-pop">
    	   <div class="title" style="margin-top:0px">
        	<h1>Please enter shipping Address ?</h1>
           </div>
           <div class="pop-content" id="shippingadd-div">
              Name <span style="padding-left:10px;padding-right:10px;"> </span> <input type="text" id="shippingadd-name" />
            <br/> <br/>
              Address1 <input type="text" id="shippingadd-add1" /><br/> <br/>
              Address2 <input type="text" id="shippingadd-add2" />
<br/> <br/>
              Address3 <input type="text" id="shippingadd-add3" value="Singapore" readonly=""/><br/> <br/>
              PINCODE <input type="text" id="pincode" />
        </div>
        <div class="bottom" style="padding-top:10px">
            <button class="previe-btn" id="submitaddress"><span class="share-btn-lft" style="text-transform:none"><span class="share-btn-rgt">Submit Address</span></span></button>
            <div class="clear"></div>
        </div> 
    </div> 
	
</div>
 <!-- shipping popup---->

            <div class="offer-detail">

              <h1 class="contain-title">REASONS TO BUY</h1>

            <!--  <p>Curabitur eleifend libero nulla. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Morbi vestibulum blandit ante in sodales. Nam placerat felis ac tellus tincidunt mollis. Quisque et sodales turpis. Donec eleifend, sapien et sodales vehicula, enim libero molestie purus, consectetur sodales lorem eros eu arcu. </p>-->

              <ul class="reset reason-list">

				{if $deal.why_buy1 neq ''}
                	<li>{$deal.why_buy1}</li>

				{/if}

				{if $deal.why_buy2 neq ''}
                	<li>{$deal.why_buy2}</li>

				{/if}

				{if $deal.why_buy3 neq ''}
                	<li>{$deal.why_buy3}</li>

				{/if}

				{if $deal.why_buy4 neq ''}
                	<li>{$deal.why_buy4}</li>

				{/if}

				{if $deal.why_buy5 neq ''}
                	<li>{$deal.why_buy5}</li>

				{/if}
{if $smarty.session.csUserTypeId eq 2}
		<!--//buy now-->
		
			<form name="frm" id="frm" method="POST" action="{$action}" enctype="multipart/form-data">
		
				<input type="hidden" name="cmd" value="_xclick" />
				<!--<input type="hidden" name="amount" id="amount" value="{$deal.offer_price}">-->
				<input type="hidden" name="amount" id="amount" value="{$admin_comm_amt|number_format:1}">
				<input type="hidden" name="item_number" id="item_number" value="{$deal.deal_title}">
				<input type="hidden" name="quantity" id="quantity" value="1"/>
				<input type="hidden" name="custom" value="{$deal.deal_unique_id} | {$smarty.session.csUserId} |{$deal.userid}" />
				<input type="hidden" name="item_name" value="PayPal Deposit on Alstein Pte Ltd For OffersnPals.Com">
				<input type="hidden" name="shipping" value="0.00" />
				<input type="hidden" name="shipping2" value="0.00" />
				<input type="hidden" name="handling" value="0.00" />					
				<input type="hidden" name="business" value="{$businessEmailId}" />
				<input type="hidden" name="receiver_email" value="{$businessEmailId}" /> <!-- -->
				<input type="hidden" name="currency_code" value="SGD" />
				<input type="hidden" name="no_shipping" value="1" />
				<input type="hidden" name="no_note" value="0" />
				<input type="hidden" name="return" value="{$siteroot}/my-account/my_profile_home?flagchk=1" />
				<input type="hidden" name="notify_url" value="{$siteroot}/ipn.php?payment_amount={$admin_comm_amt}&payment_currency=SGD" />
				<input type="hidden" name="rm" value="2" />					 
				<input type="hidden" name="cancel_return" value="{$siteroot}/my-account/my_profile_home" />
				<input type="hidden" name="sold" id="sold" value="{$deal_status}">

			</form>
	<!--//buy now-->			
{/if}
               
              </ul>

            </div>

            <div class="offer-detail">

              <h1 class="contain-title">CONDITIONS</h1>

              <p>{$deal.conditions} </p>

            </div>

            <div class="merchant">

              <h1><a  href="{$siteroot}/merchant-account/{$deal.userid}/merchant_profile" >{$deal.business_name}</a></h1>

              <table width="770" cellpadding="0" cellspacing="0" border="0" class="merchant-rating-tbl">

                <tr>

                  <td width="250" valign="top"><div class="merchant-lft fl">

                      <ul class="reset">

                        <li>

                          <label>Rating:</label>

                          <div class="fl"> 

   		<span style="margin-left:15px;width:20px;" class="star_1"><img  {if $average_rating1  > 0 && $average_rating1 <= 0.5} src="{$siteroot}/templates/default/images/star-half.png"{/if} {if $average_rating1 > 0.5 } src="{$siteroot}/templates/default/images/star-on.png" {else}  src="{$siteroot}/templates/default/images/star-off.png" {/if}/></span>
		<span class="star_2" style="width:20px;"><img alt="" {if $average_rating1 > 1 && $average_rating1  <= 1.5} src="{$siteroot}/templates/default/images/star-half.png"{/if} {if $average_rating1 > 1.5}src="{$siteroot}/templates/default/images/star-on.png"{else} src="{$siteroot}/templates/default/images/star-off.png"{/if}/></span>
		<span class="star_3" style="width:20px;"><img  alt=""  {if $average_rating1 > 2 && $average_rating1  <= 2.5} src="{$siteroot}/templates/default/images/star-half.png"{/if} {if $average_rating1  > 2.5}src="{$siteroot}/templates/default/images/star-on.png"{else} src="{$siteroot}/templates/default/images/star-off.png"{/if} /></span>
		<span class="star_4" style="width:20px;"><img  alt="" {if $average_rating1 > 3 && $average_rating1  <= 3.5} src="{$siteroot}/templates/default/images/star-half.png"{/if} {if $average_rating1 > 3.5}src="{$siteroot}/templates/default/images/star-on.png"{else} src="{$siteroot}/templates/default/images/star-off.png"{/if}/></span>
		<span class="star_5" style="width:20px;"><img alt="" {if $average_rating1 > 4 && $average_rating1  <= 4.5} src="{$siteroot}/templates/default/images/star-half.png"{/if} {if $average_rating1  > 4.5}src="{$siteroot}/templates/default/images/star-on.png"{else} src="{$siteroot}/templates/default/images/star-off.png"{/if}/></span>

							 </div>

                          <div class="clr"></div>

                        </li>

                        <li>

                          <label>Category:</label>

                          <div class="fl">

                            <p>{$deal.category|replace:"_":" "|ucfirst}</p>

                          </div>

                          <div class="clr"></div>

                        </li>

                        <li>

                          <label>Speciality:</label>

                          <div class="fl">

                            <p>{$deal.specility}</p>

                          </div>

                          <div class="clr"></div>

                        </li>

                      </ul>

                    </div></td>

                  <td width="276" valign="top"><div class="merchant-mid fl">

                      <div class="merchant-mid-cont">

                        <p><span>About Us<br  />

                          </span>{$deal.about_us} </p>

                      </div>

                      <ul class="reset" style="margin:15px 0 0 0 ">

                        <li>

                          <label class="road-img">&nbsp;</label>

                          <p class="fl">  {$deal.address1} </p>

                          <div class="clr"></div>

                        </li>

                        <li>

                          <label class="phone-img ">&nbsp;</label>

                          <p class="fl"> {$deal.contact_detail} </p>

                          <div class="clr"></div>

                        </li>

                        <li>

                          <label class="mail-img">&nbsp;</label>

                          <p class="fl"> {$deal.email} </p>

                          <div class="clr"></div>

                        </li>

                        <li>

                          <label class="web-img ">&nbsp;</label>

                          <span class="fl"> {$deal.business_webURL} </span>

                          <div class="clr"></div>

                        </li>

                      </ul>

                    </div></td>

                  <td style="border:none" valign="top"><div class="merchant-rgt fl"> <span>Business Hour</span>

                      <div class="hour-time">

                        <p>{$business_start_hours}:{$business_start_minute}AM to {$business_end_hours}:{$business_end_minute}PM  <br  />

                          Monday to Friday </p>

                        <p>{$business_start_hours1}:{$business_start_minute1}AM to {$business_end_hours1}:{$business_end_minute1}PM <br  />

                          Saturday to Sunday </p>

                      </div>

                    </div></td>

                </tr>

              </table>

            </div>

            <div class="review">

              <h1 class="contain-title" style="margin-left:22px">REVIEWS</h1>

              <ul class="reset">

                <li>

                  <!--<div class="main-review">-->

{section name=i loop=$review}
<div class="main-review" {if $smarty.section.i.last} style="border:none" {/if}>
                    <div class="review-wall">

                      <div class="user-wall-lft fl">

                        <div class="user-frd-photo fl"> <img src="{if $review[i].photo eq '' }{$siteroot}/templates/default/images/profile_pic.png{else}{$siteroot}/uploads/user/{if $smarty.get.id1 neq ''}{$review[i].photo}{else}{$review[i].photo}{/if}{/if}" title="" alt="" width="50" height="50" /> </div>

                      </div>

                      <div class="user-wall-rgt fr">

                        <div class="post-bg">

                          <div class="post-bg-top"> <a href="{$siteroot}/my-account/{$review[i].user_id}/my_profile" class="fl" target="_blank">{$review[i].first_name} {$review[i].last_name} </a>

                            <p class="fl">said on <!--6 September 2012  |   2.22pm--> {$review[i].rating_date|date_format:"%e %B %Y at "} {$review[i].rating_date|date_format:$config.date}</p>

                          </div>

                          <div class="post-bg-mid showdel" id="{$review[i].rating_id}">

                            <div style="margin-bottom:10px">

                              <p class="fl ratingtxt"> Rating:</p>

                              <div class="fl"> 
										{section name=j loop=$review[i].average_rating }
											<span><img src="{$siteroot}/templates/default/images/star-on.png"></span>
										{/section}
									
										{section name=j loop=$review[i].empty_stars}
											<span><img src="{$siteroot}/templates/default/images/star-off.png"></span>
										{/section}

                              </div>

							{if $smarty.get.id1 eq '' && $smarty.session.csUserTypeId eq '2' && $smarty.session.csUserId eq $review[i].user_id}
								<span class="fr" style="visibility:hidden" id="dlid{$review[i].rating_id}">
									<a href="{$siteroot}/modules/my-account/my_review.php?adel_id={$review[i].rating_id}" id="dlid{$review[i].rating_id}" style="color:#044EA2;font:bold 13px/15px Arial,Helvetica,sans-serif">x
										<!--<img src="{$siteroot}/templates/default/images/btn_close.png"  id="dlid{$review[i].rating_id}">-->
									</a>
								</span>
							{/if}

                              <div class="clr"> </div>



                            </div>

                            <div class="user-blog">

                              <p class="userblue-txt">Keyword/ Summary:</p>

                              <p class="usertxtcom">{$review[i].summary}</p>

                            </div>

                            <div>

                              <p class="userblue-txt">Review:</p>

                              <p class="usertxtcom">{$review[i].feedback}</p>

                            </div>

                          </div>

                        </div>

                        <div class="post-bg-btm">

                          <div class="user-com"> <a href="javascript:void(0)" class="fl commenttxt">Comment</a>

                            <div class=" clr"></div>

                          </div>

                          <ul class="reset">

{section name=j  loop=$review[i].sub}
                            <li class="showdel1" id="{$review[i].sub[j].msg_id}">

                              <div class="main-wall">

                                <div class="wall-img-lft fl"> <img  src="{if $review[i].sub[j].photo eq '' }{$siteroot}/templates/default/images/profile_pic.png{else}{$siteroot}/uploads/user/{$review[i].sub[j].photo}{/if}" title="" alt="" width="50" height="50" /> </div>

                                <div class="wall-info-rgt fl">

                                  <div> <a {if $review[i].sub[j].usertypeid eq 2}  href="{$siteroot}/my-account/{$review[i].sub[j].userid}/my_profile" {elseif  $review[i].sub[j].usertypeid eq 3} href="{$siteroot}/merchant-account/{$review[i].sub[j].userid}/merchant_profile"  {/if}  target="_blank" class="fl">{if $review[i].sub[j].usertypeid eq 2}{$review[i].sub[j].first_name} {$review[i].sub[j].last_name}{else if $review[i].sub[j].usertypeid eq 3}{$review[i].sub[j].business_name}{/if}</a> <span class="fl">{$review[i].sub[j].timestamp|date_format:"%e %B %Y at "} {$review[i].sub[j].timestamp|date_format:$config.date} 
								</span>
								
								{if $smarty.get.id1 eq '' && $smarty.session.csUserTypeId eq '2' && $smarty.session.csUserId eq $review[i].sub[j].userid}
									<span class="fr" style="visibility:hidden" id="msg_id{$review[i].sub[j].msg_id}">
										<a href="{$siteroot}/modules/my-account/my_review.php?adel_id={$review[i].sub[j].msg_id}" id="msg_id{$review[i].sub[j].msg_id}">x
											<!--<img src="{$siteroot}/templates/default/images/btn_close.png" id="msg_id{$review[i].sub[j].msg_id}" >-->
										</a>
									</span>
								{/if}



                                    <div class="clr"></div>

				

                                  </div>

                                  <p>{$review[i].sub[j].msg}</p>

                                </div>

                                <div class="clr"></div>

                              </div>

                            </li>
{/section}
                           

                            <li>

                              <div class="frd-comm">

                               
								<input type="text" name="subcomment_{$review[i].rating_id}" id="subcomment_{$review[i].rating_id}" class="signinput" style="width:474px" value="Add Comment" onfocus="if(this.value=='Add Comment')this.value=''" onblur="if(this.value=='')this.value='Add Comment'">

                              </div>

                            </li>

                            <li>

                              <div class="fr" style="margin-right:10px">
<input type="button" name="addsub" id="addsub" value="Post" class="post-btn" onClick="add_sub_comment({$review[i].rating_id},{$smarty.session.csUserId})">

                               

                              </div>

                            </li>

                          </ul>

                          <div class="clr"></div>

                        </div>

                      </div>

                      <div class="clr"></div>

                    </div>
			 </div>
{/section}

                 <!-- </div>-->

                </li>

                

              </ul>

              <div class="clr"></div>

            </div>

          </div>

          <!-- Profile Comment Section End --></td>

        <!-- Profile Middle Section End -->

      </tr>

    </table>

  </div>

  <!-- Maincontent ends -->

</div>

{include file=$footer}

<!--<td class="timer"><div style="float:left">Number of coupons that can be bought : </div> <span ></span><span style="font-size:18px;" > {$no_of_bought}</span></td> -->

<!--<td class="price01">Amount to Pay Now<span id="amtpay">${$admin_comm_amt}</span></td>-->