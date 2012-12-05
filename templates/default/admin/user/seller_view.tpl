{include file=$header1}
{include file=$header2}


<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; <a href="{$siteroot}/admin/user/seller_list.php">Merchant List</a>
 &gt;Merchant Information</div>
<br />

<h3>Merchant information</h3>

<div class="holdthisTop">
      <span style="float:right;"> <h3><!-- <a href="{$siteroot}/admin/user/seller_list.php">--> <a href="javascript:void(0);" onclick="javascipt:history.go(-1);">Back </a><!--| <a href="{$siteroot}/admin/user/seller_information.php?userid={$smarty.get.userid}">Edit</a>--></h3> </span>

      <table width="100%" cellpadding="2" cellspacing="5" border="0" class="conttableDkBg conttable">
      <tr>
	<td valign="top"><img src="{if $user.photo neq ''}{$siteroot}/uploads/user/{$user.photo}{else}{$siteroot}/templates/default/images/profile_pic.png{/if}" height="125px" width="100px" align="top"></td>
      <td >
        <table width="90%" cellpadding="4" cellspacing="5" border="0">
          <tr><td width="25%" align="right"> </td><TD  align="right" valign="top">
          <strong><a href="edit-seller.php?userid={$user.userid}" title="Edit Merchant Details"> <strong>Edit</strong></a></strong> </td></tr>
          <tr><td width="25%" align="right"><strong>Account No:</strong> </td><TD  align="left"> #{$user.userid}</td></tr>
		<tr><td width="25%" align="right"><strong>Account Name: </strong></td><TD  align="left"> {$user.username}</td></tr>
		<!--<tr><td align="right"><strong>Seller Unique URL:</strong> </td><td align="left"><a style="color:blue" href="{$siteroot}/seller/{$user.username}/{$user.userid}" target="_blank">{$siteroot}/seller/{$user.username}/{$user.userid}</a></td></tr>-->
          <tr><td width="25%" align="right"><strong>Member Type:</strong> </td><TD  align="left"> {if $user.usertypeid eq 3}Merchant{/if}</td></tr>
          <!--<tr><td width="25%" align="right"><strong>First Name:</strong> </td><td  align="left"> {$user.first_name|@ucfirst}</td></tr>
          <tr><td width="25%" align="right"><strong>Last Name: </strong></td><TD  align="left"> {$user.last_name|@ucfirst}</td></tr>-->
		<!--{if $user.about_us neq ''}
			<tr><td width="25%" align="right"><strong>About Us: </strong></td><TD  align="left"> {$user.about_us|@ucfirst}</td></tr>
		{/if}-->

		{if $user.specility neq ''}
			<tr><td width="25%" align="right"><strong>Specility: </strong></td><TD  align="left"> {$user.specility|@ucfirst}</td></tr>
		{/if}

			


          <tr><td width="25%" align="right"><strong>Business Name: </strong></td><TD  align="left"> {$user.business_name|@ucfirst}</td></tr>
          <tr><td align="right"><strong>Email Address: </strong></td><TD  align="left">{$user.email}</td> </tr>
         <!--{* <tr><td   valign="top" align="right"><strong>Job Title:</strong></td><td align="left" >{*$user.title*}</td></tr>-->
          <!--<tr><td width="25%" align="right"><strong>Company Type: </strong></td><TD  align="left">{$seller1}</td></tr>
          <tr><td   valign="top" align="right"><strong>Company Name:</strong></td><td align="left" >{$user.company_name}</td></tr>
	  <tr><td   valign="top" align="right"><strong>Limited Company or PLC:</strong></td><td align="left" >{$user.limited_comp}</td></tr>
	  <tr> <td   valign="top" align="right"><strong>Vat Registration No:</strong></td><td align="left" >{$user.vat_reg}</td></tr>*}-->
          <tr><td width="25%" align="right"  valign="top"><strong>Address: </strong></td><TD  align="left"> {$user.address1}<br/>{$user.address2}</td></tr>
          <tr><td align="right"><strong>Town/City: </strong></td><TD  align="left">{$user.city}</td> </tr>
          <tr><td align="right"><strong>County: </strong></td><TD  align="left">{$user.country_name}</td> </tr>
          
          
          
           <tr><td align="right"><strong>Postal Code: </strong></td><TD  align="left">{$user.postalcode}</td> </tr>
          <tr><td align="right"><strong>Website URL: </strong></td><TD  align="left">{$user.business_webURL}</td> </tr>
           <tr><td align="right"><strong>Phone Number: </strong></td><TD  align="left">{$user.contact_detail}</td> </tr>
          <!--{*<tr><td align="right"><strong>Security Question and :<br/> answer</strong></td><TD  align="left"></td> </tr>
          <tr><td align="right"><strong>Activities: </strong></td><TD  align="left">{$user.activiti}</td> </tr>*}-->
          <tr><td align="right"><strong>Registered Date:</strong> </td> <td align="left">{$user.signup_date|date_format:$smarty_date_format}</td></tr>
          <tr><td align="right"><strong>IP Address:</strong> </td> <td align="left">{if $user.ipaddress}{$user.ipaddress}{else}-----{/if}</td></tr>
          <tr><td align="right"><strong>Last Login:</strong> </td> <td align="left">
		{if $user.last_login}{$user.last_login|date_format:$smarty_date_format}{else}-----{/if}</td></tr>
          <tr><td align="right">&nbsp; </td> <td align="left">&nbsp;
          </td></tr>
          <tr>
          
<!--           <tr>
                <td  align="right"><b style="color:black;"><b>Subscription Packages:</b></div></td><td></td></tr>
          <tr><td align="right"><strong>Subscription Status: </strong></td><TD  align="left">{if $user.subscribe_status eq 'Expired'}Deleted{else}{$user.subscribe_status}{/if}</td> </tr>
           <tr><td align="right"><strong>Package Name: </strong></td><TD  align="left">{ if $user.pack_name}{$user.pack_name}{else}-----{/if}</td> </tr>
           <tr><td align="right"><strong>Type of Package: </strong></td><TD  align="left">{if $user.allow_deals_per_month}{$user.allow_deals_per_month} (allow to post No. # deals per month){else}-----{/if}</td> </tr>
           <tr><td align="right"><strong>Pack Price <span id="span_dlcurr_ubuyprice">&#163;</span>: </strong></td><TD  align="left">{if $user.pack_price}{$user.pack_price} {else}-----{/if}</td> </tr>
           <tr><td align="right"><strong>Cost Per Success Deal: </strong></td><TD  align="left">{if $user.cost_per_success_deal}{$user.cost_per_success_deal}{else}-----{/if}</td> </tr>
            <tr><td align="right"><strong>Cost Per SMS Deal: </strong></td><TD  align="left">{if $user.cost_sms_deal}{$user.cost_sms_deal}{else}-----{/if}</td> </tr>
            <tr><td align="right"><strong>Pack Duration: </strong></td><TD  align="left">{if $user.pack_duration}{$user.pack_duration} (months){else}-----{/if}</td> </tr>
            
            <tr><td align="right">&nbsp; </td> <td align="left">
          &nbsp;</td></tr>
          
          <tr><td width="25%" align="right"> </td><TD  align="right" valign="top">
           <a href="{$siteroot}/admin/user/manage_other_details.php?userid={$user.userid}" 
           style="text-decoration: none;"><strong>Edit</strong></a> </td></tr>

           <tr><td  align="right"><b style="color:black;"><b>Other Details:</b></div></td><td></td></tr>

		 <tr><td  align="right" valign="top"><strong>Delivery Service Options:</strong></td><td align="left">&nbsp;</td></tr>

           <tr style="display:none;"><td align="right"><strong>Pound (&#163;):&nbsp; </strong></td><TD  align="left">
           {if $user.delivery_charges_pound}{$user.delivery_charges_pound} {else}-----{/if}</td> </tr>
           <tr style="display:none;"><td align="right"><strong>Euro (&#8364;):&nbsp; </strong></td><TD  align="left">
           {if $user.delivery_charges_euro}{$user.delivery_charges_euro} {else}-----{/if}</td> </tr>
           <tr style="display:none;"><td align="right"><strong>Dollar ($):&nbsp; </strong></td><TD  align="left">
           {if $user.delivery_charges_dollar}{$user.delivery_charges_dollar} {else}-----{/if}</td> </tr>

		 <tr>
			<td align="right" colspan="2">
				<table border="1" cellpadding="5" cellspacing="1" style="border-width:3px; border-style:solid;" width="850px">
					<tr>
						<th rowspan="2" style="border-bottom-width:3px; border-bottom-style:solid;" width="2%">Sr. No.</th>
						<th rowspan="2" style="border-bottom-width:3px; border-bottom-style:solid;">Delivery Service Option Name</th>
						<th colspan="3">Delivery Charges</th>
					</tr>
					<tr>
						<th style="border-bottom-width:3px; border-bottom-style:solid;" width="20%">Pound (&#163;)</th>
						<th style="border-bottom-width:3px; border-bottom-style:solid;" width="20%">Euro (&#8364;)</th>
						<th style="border-bottom-width:3px; border-bottom-style:solid;" width="20%">Dollar ($)</th>
					</tr>
					{assign var=j value=1}
					{section name=i loop=$data_delivery_chr}
						{if $data_delivery_service_chr[i].is_selected eq 'yes'}
					<tr id="tr_{$smarty.section.i.iteration}">
						<th>{$j++}</th>
						<td>{$data_delivery_chr[i].value}</td>
						<td align="center">
							{if $smarty.section.i.iteration == 1}
								----
							{else}
								{$data_delivery_service_chr[i].delivery_charges_pound}
							{/if}
						</td>
						<td align="center">
							{if $smarty.section.i.iteration == 1}
								----
							{else}
								{$data_delivery_service_chr[i].delivery_charges_euro}
							{/if}
						</td>
						<td align="center">
							{if $smarty.section.i.iteration == 1}
								----
							{else}
								{$data_delivery_service_chr[i].delivery_charges_dollar}
							{/if}
						</td>
					</tr>
						{/if}
					{/section}
				</table>
			</td>
		 </tr>

           <tr><td align="right"><strong>Seller Support Email:</strong></td><TD  align="left">{if $user.seller_support_email}{$user.seller_support_email}{else}-----{/if}</td> </tr>
           <tr><td align="right"><strong>Tracking URL Code: </strong></td><TD  align="left">{if $user.tracking_url_code}{$user.tracking_url_code} {else}-----{/if}</td> </tr>
           <tr><td align="right"><strong>Delivered Tracking URL Code: </strong></td><TD  align="left">{if $user.delivered_tracking_url_code}{$user.delivered_tracking_url_code}{else}-----{/if}</td> </tr>
           <tr><td align="right"><strong>Affiliate URL: </strong></td><TD align="left">{if $user.affiliate_link}{$user.affiliate_link}{else}-----{/if}</td> </tr>
           <tr><td align="right"><strong>Affiliate Code: </strong></td><TD align="left">{if $user.affiliate_code}{$user.affiliate_code}{else}-----{/if}</td> </tr>
           <tr><td align="right" valign="top"><strong>Refund Policy: </strong></td><TD  align="left">{if $user.refund_policy}{$user.refund_policy|html_entity_decode} {else}-----{/if}</td> </tr>
          -->
         <!--{* <tr>
              <td align="right" valign="top"><strong>Messages:</strong> </td>
              <td  align="left">
	      {if $user.tot_msg}<a href="{$siteroot}/admin/modules/user-message/user-message.php?uname={$user.username}" target="_blank">{$user.tot_msg}{else}0{/if}</a>
              </td>
          </tr>
          <tr>
	      <td align="right"><strong>History Of Purchases: </strong></td>
              <td>{if $user.tot_purchase}<a href="{$siteroot}/admin/globalsettings/deal/deal-purchase.php?uname={$user.username}&status=pending" target="_blank">{$user.tot_purchase}</a>{else}0{/if}</td> 
          </tr>
          <tr>
	      <td align="right"><strong>History Of Order: </strong></td>
              <td>{if $user.tot_order}<a href="{$siteroot}/admin/globalsettings/deal/deal-order.php?uname={$user.username}&status=pending" target="_blank">{$user.tot_order}</a>{else}0{/if}</td> 
          </tr>
          <tr>
              <td align="right"><strong>Rejected Listings: </strong></td>
              <td  align="left">{if $user.tot_cancel}<a href="{$siteroot}/admin/globalsettings/deal/rejected-deals.php?uname={$user.username}" target="_blank">{$user.tot_cancel}</a>{else}0{/if}</td>
          </tr>
          <tr>
              <td align="right" valign="top"><strong>Sold Product: </strong></td>
              <td  align="left">
                  {if $user.tot_feedback}<a href="{$siteroot}/admin/globalsettings/deal/manage_complete_deal.php?seller_id={$user.userid}&type=product" target="_blank">{$user.tot_soldproduct}{else}0{/if}</a> 
              </td>
           </tr>
          <tr>
              <td align="right" valign="top"><strong>Sold Voucher: </strong></td>
              <td  align="left">
                  {if $user.tot_feedback}<a href="{$siteroot}/admin/globalsettings/deal/manage_complete_deal.php?seller_id={$user.userid}&type=service" target="_blank">{$user.tot_soldordr}</a>{else}0{/if} 
              </td>
           </tr>

          <tr>
              <td align="right" valign="top"><strong>Feedback: </strong></td>
              <td  align="left">
                  {if $user.tot_feedback}<a href="{$siteroot}/admin/modules/feedback/feedback.php?uname={$user.username}" target="_blank">{$user.tot_feedback}{else}0{/if}</a> 
              </td>
           </tr>
          <tr><td align="right"><strong>Disputes: </strong></td><TD  align="left"></td> </tr>
          <tr>
              <td align="right" valign="top"><strong>Forum Participation: </strong></td>
              <td  align="left">{if $user.tot_forum}<a href="{$siteroot}//admin/modules/forum/index.php?uname={$user.username}" target="_blank">{$user.tot_forum}</a>{else}0{/if}</td> 
          </tr>
          <tr><td align="right"><strong>Total Listing Fees Paid: </strong></td><TD  align="left">{$user.tot_paid}</td></tr>
           <tr><td align="right"><strong>Payment Method: </strong></td><TD  align="left">{$payment.payment_method}</td></tr>
           <tr><td align="right"><strong>Payment Details: </strong></td>
                <td  align="left">{$payment.details}</td></tr>*}-->
          <!--<tr><td align="right" valign="top"><strong>Status: </strong></td><td>{$user.status}</td></tr> -->
        </table>
      </td>
      <td width="250"  align="right" valign="top">
      <table align="right">
      <tr><td width="20%" height="25"  align="left"><img src="{$siteroot}/templates/default/images/icons/film.png" align="absmiddle" />  <a href="seller_photo_list.php?userid={$smarty.get.userid}" title="Show Merchant Details">
		     		 <strong>View Photo Album</strong></a></td></tr>
<!--<tr><td width="20%" height="25"  align="left"><img src="{$siteroot}/templates/default/images/icons/film.png" align="absmiddle" />  <a href="{$siteroot}/admin/globalsettings/deal/pending-deal.php?deal_from_seller_name={$smarty.get.userid}" title="Show Merchant Details">
		     		 <strong>View {$user.first_name|@ucfirst}'s Pending Deals</strong></a></td></tr>-->
<tr><td width="20%" height="25"  align="left"><img src="{$siteroot}/templates/default/images/icons/film.png" align="absmiddle" />  <a href="{$siteroot}/admin/globalsettings/deal/manage_deal.php?deal_from_seller_name={$smarty.get.userid}" title="Show Merchant Details">
		     		 <strong>View {$user.first_name|@ucfirst}'s Active Deals</strong></a></td></tr>
<!--<tr><td width="20%" height="25"  align="left"><img src="{$siteroot}/templates/default/images/icons/film.png" align="absmiddle" />  <a href="{$siteroot}/admin/globalsettings/deal/rejected-deals.php?deal_from_seller_name={$smarty.get.userid}" title="Show Merchant Details">
		     		 <strong>View {$user.first_name|@ucfirst}'s Rejected Deals</strong></a></td></tr>-->
<tr><td width="20%" height="25"  align="left"><img src="{$siteroot}/templates/default/images/icons/film.png" align="absmiddle" />  <a href="{$siteroot}/admin/globalsettings/deal/upcoming_deal.php?deal_from_seller_name={$smarty.get.userid}" title="Show Merchant Details">
		     		 <strong>View {$user.first_name|@ucfirst}'s Upcoming Deals</strong></a></td></tr>
<tr><td width="20%" height="25"  align="left"><img src="{$siteroot}/templates/default/images/icons/film.png" align="absmiddle" />  <a href="{$siteroot}/admin/globalsettings/deal/expired_deal.php?deal_from_seller_name={$smarty.get.userid}" title="Show Merchant Details">
		     		 <strong>View {$user.first_name|@ucfirst}'s Expired Deals</strong></a></td></tr>
<tr><td width="20%" height="25"  align="left"><img src="{$siteroot}/templates/default/images/icons/film.png" align="absmiddle" />  <a href="{$siteroot}/admin/friend/fan.php?seller_id={$smarty.get.userid}" title="Show Merchant Details">
		     		 <strong>View {$user.first_name|@ucfirst}'s Fan </strong></a></td></tr>
<tr><td height="25" align="left"><img src="{$siteroot}/templates/default/images/icons/film.png" align="absmiddle" />  <a href="view_review_merchant.php?userid={$smarty.get.userid}" title="Show Seller Details">
		     		 <strong>View Review</strong></a></td></tr>
<tr><td height="25" align="left"><img src="{$siteroot}/templates/default/images/icons/film.png" align="absmiddle" />  <a href="view_voucher.php?userid={$smarty.get.userid}" title="Show Seller Details">
		     		 <strong>View Coupons</strong></a></td></tr>

<tr><td height="25" align="left"><img src="{$siteroot}/templates/default/images/icons/film.png" align="absmiddle" />  <a href="view_merchant_incoming_deal.php?userid={$smarty.get.userid}" title="Show Seller Details">
		     		 <strong>View Incoming Deals Of {$user.first_name|@ucfirst}'s </strong></a></td></tr>

<tr><td height="25" align="left"><img src="{$siteroot}/templates/default/images/icons/film.png" align="absmiddle" />  <a href="view_merchant_offered_deal.php?userid={$smarty.get.userid}" title="Show Seller Details">
		     		 <strong>View Deals Offered By {$user.first_name|@ucfirst}'s </strong></a></td></tr>
</table>
      
      </td>
      </tr>
      </table> 

</div>
{include file=$footer}
