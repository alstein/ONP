{include file=$header_start}

<body class="inner_body">
<!-- main continer of the page -->
<div id="wrapper">
  <!-- header container starts here-->
  {include file=$profile_header2}
  <!-- / header container ends here-->
  <!-- main container with changing content -->
  <div id="maincont">
    <!-- Left content Start here -->
      {include file=$merchant_home_left}
    <!-- Middel content Start here -->
   <div class="profile-middel">
	<h2 style="margin-left:20px;color: #2B587A" >Create Deal Offer</h2><br>
         <form name="frmdeal" id="frmdeal" action="" method="post">
    <input type="hidden" name="txt_id" id="txt_id" value="{$merchant_pay}">
      <table cellspacing="5" cellpadding="5" width="100%" border="0" align="center">
		<tr>
			<td align="right" valign="top" width="40%" class="profile-name" style="width:131px;" ><span style="color:red">*</span> Business Name:</td>
			<td align="left" width="70%">
			{$offer_deal_det.fullname}
			<div class="clr"></div>
			<div class="error" htmlfor="business_name" generated="true"></div>
			</td>
		</tr>
      
		<tr>
			<td align="right" valign="top" width="40%" class="profile-name" style="width:131px;" ><span style="color:red">*</span> Address: </td>
			<td align="left" width="70%">
			{$offer_deal_det.address1}
			<div class="clr"></div>
			<div class="error" htmlfor="address" generated="true"></div>
			</td>
		</tr>
	

		<tr>
			<td align="right" valign="top" class="profile-name" style="width:131px;" ><span style="color:red">*</span> Phone No:</td>
			<td align="left"  width="70%">
			{$offer_deal_det.contact_detail}
			<div class="clr"></div>
			<div class="error" htmlfor="phone_no" generated="true"></div>
			</td>
		</tr>

		<tr>
			<td align="right" valign="top" width="40%" class="profile-name" style="width:131px;" ><span style="color:red">*</span>Amount To Be Spend: </td>
			<td align="left" width="70%">
				{$offer_deal_det.amount_spend}	
			<div class="clr"></div>
				<div class="error" htmlfor="rel_status" generated="true"></div>
			</td>
		</tr>
		
		<tr>
			<td align="right" valign="top" width="40%" class="profile-name" style="width:131px;"><span style="color:red">*</span>Discount Requested: </td>
			<td align="left" width="70%">
				{$offer_deal_det.discount}	
				<div class="clr"></div>
				<div class="error" htmlfor="rel_status" generated="true"></div>
			</td>
		</tr>

		
		<tr>
			<td align="right" valign="top" width="40%" class="profile-name" style="width:131px;" ><span style="color:red">*</span>Product Name: </td>
			<td align="left" width="70%">
				{$offer_deal_det.product_name}
				
				<div class="clr"></div>
				<div class="error" htmlfor="rel_status" generated="true"></div>
			</td>
		</tr>

		<tr>
			<td align="right" valign="top" width="40%" class="profile-name" style="width:131px;" ><span style="color:red">*</span>OutFlow: </td>
			<td align="left" width="70%">
				{$offer_deal_det.outflow}
				<div class="clr"></div>
				<div class="error" htmlfor="rel_status" generated="true"></div>
			</td>
		</tr>

		<tr>
			<td align="right" valign="top" width="40%" class="profile-name" style="width:131px;" ><span style="color:red">*</span>Redeem From: </td>
			<td align="left" width="70%">
				{$offer_deal_det.redeem_from}
				<div class="clr"></div>
				<div class="error" htmlfor="rel_status" generated="true"></div>
			</td>
		</tr>

		<tr>
			<td align="right" valign="top" width="40%" class="profile-name" style="width:131px;" ><span style="color:red">*</span>Redeem To: </td>
			<td align="left" width="70%">
				{$offer_deal_det.redeem_to}
				<div class="clr"></div>
				<div class="error" htmlfor="rel_status" generated="true"></div>
			</td>
		</tr>

		<tr>
			<td align="right" valign="top" width="40%" class="profile-name" style="width:131px;" ><span style="color:red">*</span>Bid Valid Till: </td>
			<td align="left" width="70%">
				{$offer_deal_det.bid_validity}
				<div class="clr"></div>
				<div class="error" htmlfor="rel_status" generated="true"></div>
			</td>
		</tr>

		<tr>
			<td align="right" valign="top" width="40%" class="profile-name" style="width:131px;" ><span style="color:red">*</span>Amount To Pay Now: </td>
			<td align="left" width="70%">
				{$offer_deal_det.amt_to_pin}
				
				<div class="clr"></div>
				<div class="error" htmlfor="rel_status" generated="true"></div>
			</td>
		</tr>

		<tr>
			<td align="right" valign="top" width="40%" class="profile-name" style="width:131px;"><span style="color:red">*</span>If Accepted To Be Paid: </td>
			<td align="left" width="70%">
				{$offer_deal_det.accepted_to_paid}
				<div class="clr"></div>
				<div class="error" htmlfor="accepted_to_paid" generated="true"></div>
			</td>
		</tr>

		<tr>
			<td align="right" valign="top" width="40%" class="profile-name" style="width:131px;" > {if $offer_deal_det.status eq 'yes' || $offer_deal_det.status eq 'rejected' }Status{/if}</td>
			<td>
				{if $offer_deal_det.status eq 'no'}<span class="sitesub-btn-lft"><span class="sitesub-btn-right"><a class="loc_busines fl"  href="{$siteroot}/php_nvp_samples/DoCapture.php?status=yes&id={$offer_deal_det.offer_deal_id}&authorisation_id={$offer_deal_det.authorisation_id}&currency_code={$offer_deal_det.currency_code}&amt={$offer_deal_det.amt_to_pin}">Accept</a></span></span>
				
				 <span style="margin-left:10px;" class="sitesub-btn-lft"><span class="sitesub-btn-right"><a class="loc_busines fl"  href="{$siteroot}/admin/deal/offer_deal_request.php?status=rejected&id={$offer_deal_det.offer_deal_id}">Reject</a></span></span>{elseif $offer_deal_det.status eq 'yes'}Accepted {else} Rejected {/if}
				<!--<span class="sitesub-btn-lft"><span class="sitesub-btn-right">
				<input class="loc_busines fl" type="submit" value="Save" name="Submit" id="Submit"/>
				</span></span> &nbsp; &nbsp; 
				<span style="margin-left:10px;" class="sitesub-btn-lft"><span class="sitesub-btn-right">
				<input  class="loc_busines fl" type="button" value="Cancel" />
				</span></span>-->
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

