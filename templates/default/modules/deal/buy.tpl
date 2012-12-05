{include file=$header_start}
{strip}
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
<script language="javascript" type="text/javascript" src="{$siteroot}/js/jquery.countdown.js"></script>
<link href="{$siteroot}/templates/default/css/jquery.countdown.css" rel="stylesheet" type="text/css">

{/strip}
{literal}
<script type="text/javascript">
$(document).ready(function(){

	$('#defaultCountdown').countdown({until: new Date($("#deal_end_year").val(), parseInt($("#deal_end_month").val())-parseInt(1), $("#deal_end_day").val())}); 
	
	$('#removeCountdown').toggle(function() { 
			$(this).text('Re-attach'); 
			$('#defaultCountdown').countdown('destroy'); 
		}, 
		function() { 
			$(this).text('Remove'); 
			$('#defaultCountdown').countdown({until: newYear}); 
		} 
	);
});

function submit_form(){
	$("#frm").submit();
}
</script>
{/literal}
<body class="inner_body">
<!-- main continer of the page -->
<div id="wrapper">
  <!-- header container starts here-->
  {include file=$profile_header2}
  <!-- / header container ends here-->
  <!-- main container with changing content -->
  <div id="maincont">
    <!-- Left content Start here -->
    <div class="fl profile-lft">
      <div class="deal-photo"> <img src="{$siteroot}/uploads/deal/{$deal.deal_image}" height="210px" width="179px"></div>
     

 <div class="deal-map">
<iframe src="{$siteroot}/GoogleMapAPI-2.5/map.php?location={$maplocation}"  width="179px" height="191px"  frameborder="0" scrolling="no" marginheight="0" marginwidth="0" style="margin-left:1px"></iframe>
</div>

      <div class="friends">
        <h1 class="deal-title">Address </h1>
        <p class="address"> {$deal.address1} <br>
              </p>
      </div>
    </div>
    <!-- Middel content Start here -->
    <div class="deal-middel">
      <div class="deal-info">
        <h1 class="dealpage-title fl">{$deal.first_name} {$deal.last_name}</h1>
        <p class="fl" style="margin-top:14px"><img src="images/rating-stars.png" title="" alt=""  width="65" height="12"/></p>
        <div class="clr"></div>
        <h4 class="deal-sub-title">Deal Tagline: {$deal.discount_in_per}% Off on {$deal.deal_title}. </h4>



<form name="frm" id="frm" method="POST" action="{$action}" enctype="multipart/form-data">

		<input type="hidden" name="cmd" value="_xclick" />
		<input type="hidden" name="amount" id="amount" value="{$deal.offer_price}">
		<input type="hidden" name="item_number" id="item_number" value="{$deal.deal_title}">
		<input type="hidden" name="quantity" value="1" />
		<input type="hidden" name="custom" value="{$deal.deal_unique_id} | {$smarty.session.csUserId} |{$deal.userid}" />
		<input type="hidden" name="item_name" value="PayPal Deposit on Network on social draft Account">
		<input type="hidden" name="shipping" value="0.00" />
		<input type="hidden" name="shipping2" value="0.00" />
		<input type="hidden" name="handling" value="0.00" />					
		<input type="hidden" name="business" value="{$businessEmailId}" />
		<input type="hidden" name="receiver_email" value="{$businessEmailId}" /> <!-- -->
		<input type="hidden" name="currency_code" value="USD" />
		<input type="hidden" name="no_shipping" value="1" />
		<input type="hidden" name="no_note" value="0" />
		<input type="hidden" name="return" value="{$siteroot}/" />
		<input type="hidden" name="notify_url" value="{$siteroot}/ipn.php?payment_amount={$deal.offer_price}&payment_currency=USD" />
		<input type="hidden" name="rm" value="2" />					 
		<input type="hidden" name="cancel_return" value="{$siteroot}" />

        <div class="buy-now">
          <h4 class="deal-price">${$deal.offer_price}</h4>
          <div class="fl"><a href="javascript:void(0)" onclick="submit_form()" class="buy-btn"><span>Buy Now!</span></a></div>
        </div>
        <div class="clr"></div>



</form>

      </div>

     
    </div>
    <!-- footer container Start-->
    <div id="footerwrap" class="ovfl-hidden">
      <div id="footer" class="normTxt">
        <p class="footerinn fl"><a href="#">Help</a> : <a href="#">About </a> : <a href="#">Privacy</a> : <a href="#">Terms</a></p>
        <p class="fr">© 2012 Company Name. All Rights Reserved.</p>
        <div class="clr"></div>
      </div>
    </div>
    <!-- footer container End-->
  </div>
</div>
</body>
</html>
