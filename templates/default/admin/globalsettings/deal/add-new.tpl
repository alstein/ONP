{include file=$header1}
<script type="text/javascript" src="{$sitejs}/jquery.validate.pack.js"></script>
<script type="text/javascript" src="{$siteroot}/js/jquery.validate.min.js"></script>
<script language="JavaScript" src="{$siteroot}/js/validation/buydeal.js"></script>
<script type="text/javascript" src="{$siteroot}/js/facebox/facebox.js"></script>
<script type="text/javascript" src="{$siteroot}/js/jquery.jSuggest.1.0.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/chk_compose.js"></script>
<link href="{$siteroot}/js/facebox/facebox.css" rel="stylesheet" type="text/css"/>
<script language="JavaScript">
    var deal_price = '{$dealarr.groupbuy_price}';
    var delivery_cost = '{$dealarr.sub_delivery_cost}';
    var deal_id = '{$dealarr.deal_unique_id}';
</script>
{literal}
<script language="javascript">
jQuery(function(){
	jQuery("#email_id").jSuggest({
		url: SITEROOT+"/admin/globalsettings/deal/suggest-name.php",
		type: "GET",
		data: "searchQuery",
		autoChange: true
	});
        $('#mg').fadeOut(5000);
});

</script>
<script language="javascript">
function validate()
{
    if(document.dealbuyfrm.email_id.value== '' || document.dealbuyfrm.email_id.value=='Enter name of friends')
   {
   		alert("Please Select User email.");
		document.dealbuyfrm.email_id.focus();
		return false;
   }
   else
   {
	return true;
	}	 	
}
</script>
{/literal}
{literal}

<script language="JavaScript">
function updateTotal(qty)
{

   var total=document.getElementById('total').value;
   var total_qut=document.getElementById('qty').value;
   var minval=document.getElementById('min').value;
   var maxval=document.getElementById('max').value;

   var vatot=maxval-total;
		
   if(total_qut > vatot)
   {
	
	alert("Quantity must be "+vatot+" or less.");
	document.getElementById('qty').value = vatot;
	var totalAmount = 0; 
	var deliveryAmt = 0;
	var orderAmt = 0;
	totalAmount = (parseInt(deal_price) * parseInt(vatot));
	deliveryAmt = (parseInt(delivery_cost) * parseInt(vatot));
	orderAmt = totalAmount + deliveryAmt;
	document.getElementById('spantotalamt').innerHTML = totalAmount;
	document.getElementById('spandeliveryamt').innerHTML = deliveryAmt;
	document.getElementById('orderAmt').innerHTML = orderAmt;
	document.getElementById('totalamount').value = orderAmt;
	return false;
   }
   		
 
	var totalAmount = 0; 
	var deliveryAmt = 0;
	var orderAmt = 0;
	totalAmount = (parseInt(deal_price) * parseInt(qty));
	deliveryAmt = (parseInt(delivery_cost) * parseInt(qty));
	orderAmt = totalAmount + deliveryAmt;
	document.getElementById('spantotalamt').innerHTML = totalAmount;
	document.getElementById('spandeliveryamt').innerHTML = deliveryAmt;
	document.getElementById('orderAmt').innerHTML = orderAmt;
	document.getElementById('totalamount').value = orderAmt;
	
}

function giftbox()
{
    jQuery.facebox({ajax: SITEROOT+'/deal/giftbox/?id='+deal_id});
}

</script>
{/literal}
{include file=$header2}

<!-- Maincontent starts -->
<div class="selectsecbg fl" style="width:950px">

    <form action="" name="dealbuyfrm" id="dealbuyfrm" method="POST" onclick="return validate();">
    <input type="hidden" name="totalamount" id="totalamount" value="{$deliveryAmt}">
    <input type="hidden" name="max" id="max" value="{$dealarr.max_buyer}">
    <input type="hidden" name="min" id="min" value="{$dealarr.min_buyer}">
    <input type="hidden" name="total" id="total" value="{$total}">
    <input type="hidden" name="userid" id="userid" value="{$smarty.session.csUserId}" />
    <input type="hidden" name="dealid" id="dealid" value="{$dealarr.deal_unique_id}" />

    <table cellpadding="0" cellspacing="0" border="0" style="padding:2px">
      <tr><td>&nbsp;</td></tr>
      <tr>
	<td align="right" valign="middle"><strong>Select Users:&nbsp;</strong></td>
	<td><input type="text" name="email_id" id="email_id" value="{if $smarty.session.UserId eq ''}Enter name of friends{else}{$getuser.first_name} {$getuser.last_name}({$getuser.email}){/if}"  onfocus="if(this.value == 'Enter name of friends') {ldelim}this.value = '';{rdelim}" onBlur="if (this.value == '') {ldelim}this.value = 'Enter name of friends';{rdelim}" size="30" autocomplete="off" onclick="if (this.value != '') {ldelim}this.value = '';{rdelim}"/></td>
      </tr>
      <tr><td>&nbsp;</td></tr>
    </table>
	
    <div align="center" id="gift_suc_div" class="success" style="display:none;"></div> 
    <div class="selectsecbg2">
      <h3 class="subhead2">Order Summary</h3>
    </div><br/>
    <!--<h4 class="subheading">Order Summary</h4>-->
    <table border="0" cellspacing="2" cellpadding="2"  width="100%" class="payesumm">
      <col width="130" />
      <col width="700" />
      <col width="100" />
      <col width="100" />
      <col width="100" />
      <col width="0" />
      <tr>
        <th>Product Image</th>
        <th align="left">Deal Title</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Total</th>
        <th>&nbsp;</th>
      </tr>
      <tr class="prodeal">
        <td valign="top"><a href="#" ><img src="{$siteroot}/uploads/product/thumb32X32/{$deal_img}"></a></td>
        <td align="left">{$dealarr.title} </td>
        <td><input type="text" name="qty" id="qty" value="1" class="graybutton" style="width:30px;cursor:auto" onchange="updateTotal(this.value);"/></td>
        <td class="strong" >{$dealarr.groupbuy_price}</td>
        <td class="strong" >&pound;<span id="spantotalamt">{$dealarr.groupbuy_price}</span></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        {if $dealarr.deal_type eq "service"} <td colspan="2"> <!--<a class="purchasegift" href="javascript:void(0)" onclick="giftbox();">Give this voucher to your friend</a>--></td> 
        {else}
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        {/if}
        
        <td class="strong" >Delivery</td>
        <td class="strong">{$dealarr.sub_delivery_cost}</td>
        <td class="strong" >&pound;<span id="spandeliveryamt">{$dealarr.sub_delivery_cost}</span></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td class="strong" ><span class="red">Order Total</span></td>
        <td>&nbsp;</td>
        <td class="strong">&pound;<span id="orderAmt">{$deliveryAmt}</span></td>
        <td>&nbsp;</td>
      </tr>
    </table>
    <div class="clr">&nbsp;</div>
    <div class="selectsecbg2">
      <h3 class="subhead2">{if $dealarr.deal_unique_id eq 24} Order Summary for your purchase from {$dealarr.first_name|ucfirst} {$dealarr.last_name|ucfirst} {elseif ($dealarr.deal_type eq "service" and $dealarr.seller_id neq 1)} Payment {elseif $dealarr.seller_id eq 1} Payment {elseif ($dealarr.deal_type eq "product" and $dealarr.seller_id neq 1)} Payment/Delivery Address {/if}</h3>
    </div>
    <div class="fullwid ovfl-hidden">
      <div class="col_L fl">
      {if $smarty.session.UserId eq ''} 
      <div class="selectsecbg2">
	  <h3 class="subhead2">Billing Address</h3> 
      </div>
      {/if}
      <div class="note">
      <p>This must be the address the payment card is registered to.</p>
      <p>Fields marked with a star (*) are required</p></div>
	<div  class="graybgfiled">
                <ul class="reset form_seller ovfl-hidden">
		    <li>
		      <label for="firstname"><span>*</span> First Name:</label>
		      <div class="fl"><input id="firstname" name="firstname" type="text" class="inputbg" style="width:256px" value="{$billingaddr.first_name}"/></div>
                    </li>
                    <li>
                    	<label for="surname"><span>*</span> Surname:</label>
                        <div class="fl"><input id="surname" name="surname" type="text" class="inputbg" style="width:256px" value="{$billingaddr.last_name}" /></div>
                    </li>
                    <li>
                    	<label for="addrline1"><span>*</span> Address Line 1:</label>
                        <div class="fl"><input id="addrline1" name="addrline1" type="text" class="inputbg" style="width:256px" value="{$billingaddr.address1}" /></div>
                    </li>
                    <li>
                    	<label for="addrline2"><span>*</span> Address Line 2:</label>
                        <div class="fl"><input id="addrline2" name="addrline2" type="text" class="inputbg" style="width:256px" value="{$billingaddr.address2}" /></div>
                    </li>
                    <li>
                    	<label for="city"><span>*</span> Town/City:</label>
                        <div class="fl">
                            <select class="selectbg" id="city" name="city" style=" width:265px">
                                <option value="">- Select City -</option>
                                {section name=i loop=$city}
                                        <option value="{$city[i].city_name}" {if $billingaddr.city eq $city[i].city_name} selected="selected" {/if}>{$city[i].city_name}</option>
                                {/section}
                            </select>
                        </div>
                    </li>
                	<li>
                    	<label for="postcode"><span>*</span> Post Code:</label>
                        <div class="fl"><input id="postcode" name="postcode" type="text" class="inputbg" style="width:256px" value="{$billingaddr.address1}"/></div>
                    </li>
                    <li>
                    	<label for="phone"><span>&nbsp;</span> Phone:</label>
                        <div class="fl"><input id="phone" name="phone" type="text" class="inputbg" style="width:256px" value="{$billingaddr.contact_detail}"/></div>
                    </li>
                    <li>
                    	<label for="email"><span>&nbsp;</span> E-mail:</label>
                        <div class="fl"><input id="email" name="email1" type="text" class="inputbg" style="width:256px" value="{$billingaddr.email}"/></div>
                    </li>
                    <!--<li>
                    	<label for="conemail">Confirm E-mail:</label>
                        <div class="fl"><input id="conemail" name="conemail" type="text" class="inputbg" style="width:256px" value="{$billingaddr.email}"/></div>
                    </li>-->
                   <!-- {if $smarty.session.UserId eq ""}
                    <li>
                    If you don't already have an account, we will create one for you automatically. This will enable you to sign in and download your Vouchers.
                    </li>
                    <li>
                    	<label for="password1">Password:</label>
                        <div class="fl"><input id="password1" name="password1" type="password" class="inputbg" style="width:256px" /></div>
                    </li>
                    <li>
                        <label for="password2">Confirm Password:</label>
                        <div class="fl"><input id="password2" name="password2" type="password" class="inputbg" style="width:256px" /></div>
                    </li>
                    {/if}-->
                </ul>
	    </div>
	    {if $dealarr.deal_unique_id eq 24}
	    <div class="graybgfiled fl" style="margin-top:10px;"> 
	      <ul class="reset form_seller ovfl-hidden fl">
		<li class="fl">
		    <label class="label2 fl" style="width:400px;"> <span>*</span> I agree to the <a href="{$siteroot}/terms/" target="_blank">Terms &amp; Conditions</a> and <a href="{$siteroot}/privacy-policy/" target="_blank">Privacy Policy</a> &nbsp;<input type="checkbox" name="termandpolicy" id="termandpolicy" /></label> 
		</li>
		<li>
		<div class="buttongreen"><input type="submit" name="submit" style="width:136px;" value="Complete Order" class="inputbtn"/></div>
		</li>
	      </ul>
	    </div>
	    {/if}
    </div>
      <div class="col_L fr">
	{if $dealarr.deal_unique_id neq 24}
	<div class="selectsecbg2">
	  <h3 class="subhead2">Card Details</h3>
	</div>
	<div class="note"> {if ($dealarr.deal_type eq "service" and $dealarr.seller_id neq 1)} <p>Your card will not be charged unless the minimum buyers required is reached </p> {elseif $dealarr.seller_id eq 1} <p>Your card will not be charged unless the minimum buyers required is reached </p> {elseif ($dealarr.deal_type eq "product" and $dealarr.seller_id neq 1)} <p>Your card will not be charged unless the deal has tipped</p> {/if} </div>
	    <div class="graybgfiled">
		<ul class="reset form_seller ovfl-hidden">
		    <li style="margin-bottom:15px">
			<label><span>*</span> Card Type: </label>
			<div class="fl">
			<table width="100%" border="0" align="center" >
			<col width="60" />
			<col width="60" />
			<col width="60" />
			<col width="60" />
			<tr style="margin-bottom:10px">
			    <td align="center"><input type="radio" name="cardType" id="cardType" value="visa" checked="true"/></td>
			    <td align="center"><input type="radio" name="cardType" id="cardType" value="master"/></td>
			    <td align="center"><input type="radio" name="cardType" id="cardType" value="visaDebit"/></td>
			    <td align="center"><input type="radio" name="cardType" id="cardType" value="visaElectron"/></td>
			</tr>
			<tr>
			    <td align="center"><img src="{$siteimg}/icons/icon01.gif" alt="pay" /></td>
			    <td align="center"><img src="{$siteimg}/icons/icon02.gif" alt="pay" /></td>
			    <td align="center"><img src="{$siteimg}/icons/icon03.gif" alt="pay" /></td>
			    <td align="center"><img src="{$siteimg}/icons/icon04.gif" alt="pay" /></td>
			</tr>
			</table>

			</div>
		    </li>
		    <li>
			<label for="namecard"><span>*</span> Name On Card: </label>
			<div class="fl"><input id="namecard" name="namecard" type="text" class="inputbg" style="width:256px" value="" /></div>
		    </li>
		    <li>
			<label for="cardno"><span>*</span> Card Number:</label>
			<div class="fl"><input id="cardno" name="cardno" type="text" class="inputbg" style="width:256px" maxlength="16" /></div>
		    </li>
			      <li>
			<label for="cwvno"><span>*</span> CVV Number: </label>
			<div class="fl"><input id="cvvno" name="cvvno" type="text" class="inputbg" style="width:256px" maxlength="4" /></div>
		    </li>
			      <li>
			<label for="validu"><span>*</span> Valid Until: </label>
			<div class="fl">
			    <select name="expiry_month" id="expiry_month">
				<option value="">-Month-</option>
				{section name=mnth start=1 loop=13 step=1}
				<option value="{$smarty.section.mnth.index}"> {$smarty.section.mnth.index}</option>
				{/section}/
			    </select>&nbsp;&nbsp;&nbsp;
			    <select name="expiry_year" id="expiry_year">
				<option value="">-Year-</option>
				{section name=yer start=2010 loop=3000 step=1}
				<option value="{$smarty.section.yer.index}"> {$smarty.section.yer.index}</option>
				{/section}
			    </select>
			    <div id="date_err" class="error" style="display:none"></div>
			</div>
		    </li>
		    <li class="fl">
		      <label class="label2" style="width:450px;"> <span>*</span> I agree to the <a href="{$siteroot}/terms/" target="_blank">Terms &amp; Conditions</a> and <a href="{$siteroot}/privacy-policy/" target="_blank">Privacy Policy</a> &nbsp;<input type="checkbox" name="termandpolicy" id="termandpolicy" /></label> 
		    </li>
		    <li>
                        <label>&nbsp;</label>
			<div class="buttongreen"><input type="submit" name="submit" style="width:136px;" value="Complete Order" class="inputbtn"/></div>
		  </li>
		</ul>
            </div>
        {/if}
    </div>
    </div>
  </div>
</form>
<!--</div>-->
<!-- Maincontent ends -->
{include file=$footer} 