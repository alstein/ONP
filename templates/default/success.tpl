
{strip}
<script src="http://code.jquery.com/jquery-latest.js"></script>


{/strip}
{literal}
<script type="text/javascript">
	/*function tb_remove1(){
		alert('test');
		$("#TB_overlay").css({display:"none"});
		$("#TB_window").css({display:"none"});
	}*/
	
</script>
{/literal}
<body>
<div style="height:20px;"></div>
<div align="center" style=" color: #656565;
    font: 14px Arial,Helvetica,sans-serif;
    margin-bottom: 10px;
    text-align: center;">Shared on OffersnPals. Share it on Facebook also ?</div>
	<div align="center" style=" color: #656565;
    font: 14px Arial,Helvetica,sans-serif;
    margin-bottom: 10px;
    text-align: center;"><a href="https://www.facebook.com/dialog/feed?
  app_id=458358780877780&
  link=https://developers.facebook.com/docs/reference/dialogs/&
  picture=http://testwww.offersnpals.com/templates/default/images/offernpals_logo.png&
  name={$username} Shared An Offer On OffersnPals&
  caption={$discount}% Off On {$deal_title} Deal At {$business_name}&
  description=Login to OffersnPals to buy  such cool offers and share with friends.&
  redirect_uri=https://mighty-lowlands-6381.herokuapp.com/" target="_blank">Facebook Share</a>
  </div>
	
  </body>