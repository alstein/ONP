{include file=$header_start}
{strip}
<script language="javascript" type="text/javascript" src="{$siteroot}/js/validation/validate_offer_deal.js"> </script>
<script type="text/javascript" src="{$sitejs}/jquery.timeago.js"></script>
<script language="javascript" type="text/javascript" src="{$siteroot}/js/calendarDateInput.js"> </script>


{/strip}
{literal}
<script type="text/javascript">
    jQuery(document).ready(function()
    {

		var txt_id=$("#txt_id").val();
		var remaining=parseFloat(100)-parseFloat(txt_id);
		$("#remain").html("("+remaining+"% of net amount.)");

		var moduleid = '{/literal}{$smarty.get.id2}{literal}';
	    jQuery('#show_thread').html("<img src='"+SITEROOT+"/templates/default/images/site/coming_soon/loadingAnimation.gif' alt='loading' />");
		viewDealsAsUsual();
    });
	function viewReview(obj)
	{

		var d='{/literal}{if $smarty.get.id1 eq ''}{ $smarty.session.csUserId }{else}{ $smarty.get.id1 }{/if}{literal}';
	    	cmt_url = SITEROOT+"/modules/my-account/ajax_my_review.php";
		
	    	jQuery.get(cmt_url,{userid:d,moduleid:'review'},function(data)
		{
			jQuery("#show_thread").html(data);
			$('#div_share').hide();
		});
//     		jQuery(obj).css('color','#FFFFFF');
// 		jQuery('#reviewlink').css('color','#000000');
	}  
	function viewFavLocalBusiness(obj)
	{

		var d='{/literal}{if $smarty.get.id1 eq ''}{ $smarty.session.csUserId }{else}{ $smarty.get.id1 }{/if}{literal}';
	    	cmt_url = SITEROOT+"/modules/my-account/ajax_my_review.php";
		
	    	jQuery.get(cmt_url,{userid:d,moduleid:'favlocalbusiness'},function(data)
		{
			jQuery("#show_thread").html(data);
			$('#div_share').hide();
		});
//     		jQuery(obj).css('color','#FFFFFF');
// 		jQuery('#reviewlink').css('color','#000000');
	}
	
	function viewFriends(obj)
	{

		var d='{/literal}{if $smarty.get.id1 eq ''}{ $smarty.session.csUserId }{else}{ $smarty.get.id1 }{/if}{literal}';
	    	cmt_url = SITEROOT+"/modules/my-account/ajax_my_review.php";
		
	    	jQuery.get(cmt_url,{userid:d,moduleid:'friend'},function(data)
		{
			jQuery("#show_thread").html(data);
			$('#div_share').show();
		});
//     		jQuery(obj).css('color','#FFFFFF');
// 		jQuery('#reviewlink').css('color','#000000');
	}  
function viewDealsAsUsual(obj)
	{
		var d='{/literal}{if $smarty.get.id1 eq ''}{ $smarty.session.csUserId }{else}{ $smarty.get.id1 }{/if}{literal}';
	    	cmt_url = SITEROOT+"/modules/my-account/ajax_my_review.php";
		
	    	jQuery.get(cmt_url,{userid:d,moduleid:'dealsasusual'},function(data)
		{
			jQuery("#show_thread").html(data);
			$('#div_share').hide();
		});
//     		jQuery(obj).css('color','#FFFFFF');
// 		jQuery('#reviewlink').css('color','#000000');
	}
	
	function viewRightNowDeal(obj)
	{
		var d='{/literal}{if $smarty.get.id1 eq ''}{ $smarty.session.csUserId }{else}{ $smarty.get.id1 }{/if}{literal}';
	    	cmt_url = SITEROOT+"/modules/my-account/ajax_my_review.php";
		
	    	jQuery.get(cmt_url,{userid:d,moduleid:'rightnowdeal'},function(data)
		{

			jQuery("#show_thread").html(data);
			$('#div_share').hide();
		});
//     		jQuery(obj).css('color','#FFFFFF');
// 		jQuery('#reviewlink').css('color','#000000');
	}  
function getPercentage(orgPrice)
{

	var amt_spend =$("#amt_spend").val();
	var discount = (parseFloat(amt_spend) * parseFloat(orgPrice))/100;
	var net_amount=amt_spend - discount;
	$("#netamount").val(net_amount);
	var merchant_pay=$("#txt_id").val();
	var discount_pay = (parseFloat(net_amount) * parseFloat(merchant_pay))/100;
	var amt_to_pay=net_amount - discount_pay;
	alert(amt_to_pay);
	$("#amt_to_pay").val(discount_pay);
	$("#accepted_to_paid").val(amt_to_pay);
}
</script>
{/literal}
<body class="inner_body">
{include file=$profile_header2}

<!-- main continer of the page -->
<div id="wrapper">
  <!-- header container starts here-->
  
  <!-- / header container ends here-->
  <!-- main container with changing content -->
  <div id="maincont">
    <!-- Left content Start here -->
      {include file=$merchant_home_left}
    <!-- Middel content Start here -->
   <div class="profile-middel">
	<h2 style="margin-left:20px;color: #2B587A" >Create Deal Offer</h2><br>
         <form name="frmdeal" id="frmdeal" action="" method="post">
	<input type="hidden" name="temp_mer_id" id="temp_mer_id" value="{$smarty.get.id1}">
    <input type="hidden" name="txt_id" id="txt_id" value="{$merchant_pay}">
      <table cellspacing="5" cellpadding="5" width="100%" border="0" align="center">
		<tr>
			<td align="right" valign="top"  class="profile-name" style="width:148px;" ><span style="color:red">*</span> Business Name:</td>
			<td align="left" width="60%">
			{$bussines_name}
			<div class="clr"></div>
			<div class="error" htmlfor="business_name" generated="true"></div>
			</td>
		</tr>
      
		<tr>
			<td align="right" valign="top" style="width:148px;" class="profile-name" ><span style="color:red">*</span> Address: </td>
			<td align="left" width="60%">
			{$address}
			<div class="clr"></div>
			<div class="error" htmlfor="address" generated="true"></div>
			</td>
		</tr>
	

		<tr>
			<td align="right" valign="top" class="profile-name" style="width:148px;" ><span style="color:red">*</span> Phone No:</td>
			<td align="left" >
			{$phone_no}
			<div class="clr"></div>
			<div class="error" htmlfor="phone_no" generated="true"></div>
			</td>
		</tr>
		<input type="hidden" name="temp_min_offer_amt" id="temp_min_offer_amt" value="{$deal_cond_row.min_offer_amt}">
		<input type="hidden" name="temp_amount" id="temp_amount" value="{$deal_cond_row.amount}">
{if $deal_cond_row.min_offer_amt eq 'yes'}
		<tr>
			<td align="right" valign="top" style="width:148px;" class="profile-name" ><span style="color:red">*</span>Amount To Be Spend: </td>
			<td align="left" width="60%">
<input class="signinput" name="amt_spend" type="text" id="amt_spend" size="25" class="textbox fl"/><br>(Minimum amount should be  S${$deal_cond_row.amount})
				<div class="clr"></div>
				<div class="error" htmlfor="amt_spend" generated="true"></div>
			</td>
		</tr>
{/if}
		<tr>
			<td align="right" valign="top" style="width:148px;" class="profile-name" ><span style="color:red">*</span>Discount Requested(%): </td>
			<td align="left" width="60%">
				<input class="signinput" name="discount" type="text" id="discount" onblur="getPercentage(this.value);" size="25" class="textbox fl"/>
				<div class="clr"></div>
				<div class="error" htmlfor="rel_status" generated="true"></div>
			</td>
		</tr>

		<tr>
			<td align="right" valign="top" style="width:148px;" class="profile-name" ><span style="color:red">*</span>Net amount tobe spend: </td>
			<td align="left" width="60%">
				<input class="signinput" name="netamount" type="text" id="netamount" onblur="getPercentage(this.value);" size="25" class="textbox fl"/>
				<div class="clr"></div>
				<div class="error" htmlfor="rel_status" generated="true"></div>
			</td>
		</tr>

	
		<tr>
			<td align="right" valign="top" style="width:148px;" class="profile-name" ><span style="color:red">*</span>Product Name: </td>
			<td align="left" width="60%">
				<input class="signinput" name="product_name" type="text" id="product_name" value="{$smarty.post.product_name}"  size="25" class="textbox fl"/>
				<div class="clr"></div>
				<div class="error" htmlfor="rel_status" generated="true"></div>
			</td>
		</tr>


		<tr>
			<td align="right" valign="top" style="width:148px;" class="profile-name" ><span style="color:red">*</span>Redeem From: </td>
			<td align="left" width="60%">
				<script type="text/javascript">DateInput('redeem_from', true, 'YYYY-MM-DD');</script>
				<div class="clr"></div>
				<div class="error" htmlfor="rel_status" generated="true"></div>
			</td>
		</tr>

		<tr>
			<td align="right" valign="top" style="width:148px;" class="profile-name" ><span style="color:red">*</span>Redeem To: </td>
			<td align="left" width="60%">
				<script type="text/javascript">DateInput('redeem_to', true, 'YYYY-MM-DD');</script>
				<div class="clr"></div>
				<div class="error" htmlfor="rel_status" generated="true"></div>
			</td>
		</tr>

		<tr>
			<td align="right" valign="top" style="width:148px;" class="profile-name" ><span style="color:red">*</span>Bid Valid Till: </td>
			<td align="left" width="60%">
				<script type="text/javascript">DateInput('bid_validity', true, 'YYYY-MM-DD');</script>
				<!--<input class="signinput" name="bid_validity" type="text" id="bid_validity" value="{$smarty.post.bid_validity}"  size="25" class="textbox fl" style="width:50px"/>-->
				<div class="clr"></div>
				<div class="error" htmlfor="rel_status" generated="true"></div>
			</td>
		</tr>

		<tr>
			<td align="right" valign="top" style="width:148px;" class="profile-name" ><span style="color:red">*</span>Amount To Pay Now: </td>
			<td align="left" width="60%">
				<input class="signinput" readonly="true"  name="amt_to_pay" type="text" id="amt_to_pay" size="25" class="textbox fl"/>({$merchant_pay}% of net amount.)
				<div class="clr"></div>
				<div class="error" htmlfor="rel_status" generated="true"></div>
			</td>
		</tr>

		<tr>
			<td align="right" valign="top" style="width:148px;" class="profile-name" ><span style="color:red">*</span>Amount to pay merchant: </td>
			<td align="left" width="60%">
				<input class="signinput" readonly="true"  name="accepted_to_paid" type="text" id="accepted_to_paid" value="{$smarty.post.accepted_to_paid}"  size="25" class="textbox fl"/><span id="remain"></span>
				<div class="clr"></div>
				<div class="error" htmlfor="accepted_to_paid" generated="true"></div>
			</td>
		</tr>

<tr>
			<td align="right" valign="top" style="width:148px;" class="profile-name" ><span style="color:red">*</span>Available on weekends on case to case basis: </td>
			<td align="left" width="60%">
				<input type="radio" name="weekends" id="weekends" value="yes" {if $deal_cond_row.offer_weekend eq 'yes'} checked="true"{/if} disabled="true">Yes&nbsp;&nbsp;&nbsp;<input type="radio" name="weekends" id="weekends" value="no" {if $deal_cond_row.offer_weekend eq 'no'} checked="true"{/if} disabled="true">No
				<div class="clr"></div>
			</td>
		</tr>

		<tr>
			<td align="right" valign="top" style="width:148px;" class="profile-name" ><span style="color:red">*</span>Conditions: </td>
			<td align="left" width="60%">
				<input name="conditions" type="text" id="conditions" value="{$deal_cond_row.condition}" readonly="true" size="25" class="signinput"/>
				<div class="clr"></div>
				<div class="error" htmlfor="accepted_to_paid" generated="true"></div>
			</td>
		</tr>


		<tr>
			<td></td>
			<td>
				<span class="sitesub-btn-lft"><span class="sitesub-btn-right">
				<!--<input class="loc_busines fl" type="button" value="Save" name="Submit" id="Submit" onclick="check_minimum_offer_amount()"/>-->
	<input class="loc_busines fl" type="submit" value="Save" name="Submit" id="Submit"/>
				</span></span> &nbsp; &nbsp; 
				<span style="margin-left:10px;" class="sitesub-btn-lft"><span class="sitesub-btn-right">
				<input  class="loc_busines fl" type="button" value="Cancel" />
				</span></span>
			</td>
		</tr>
    </table>
 
  </form>
    </div>
    <!-- Right content Start here -->
      {include file=$merchant_home_right}
    <!-- footer container Start-->
  {include file=$footer}
    <!-- footer container End-->
  </div>
</div>
</body>

