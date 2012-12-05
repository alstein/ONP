{include file=$header1}
<script type="text/javascript" src="{$siteroot}/js/validation/admin/edit_seller_subscrip.js"></script>
{include file=$header2}


<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; Seller Subscription</div>
<br />
<div align="center" id="msg">{$msg}</div>
 {if $smarty.session.sess_subcri_status eq 'oldsubscription'}
	<div align="center" id="msg" class="error">Your subscription has been expired, please renew your subscription!</div>
 {elseif  $smarty.session.sess_subcri_status eq 'newsubscription'}
	<div align="center" id="msg" class="error">Please subscribe below!</div>
 {/if}
	
<div class="holdthisTop">
	<h3>Seller Subscription</h3><br/><br/>

      <table width="100%" cellpadding="5" cellspacing="5" class="conttableDkBg conttable">
		<tr><td width="25%" align="left" colspan="2"><strong>Personal/Company Information</strong></td></tr>

          <tr>
			<td width="25%" align="right"><strong>First Name: </strong></td>
			<td  align="left">
				{if $userData.first_name}{$userData.first_name|@ucfirst}{else}------{/if}
			</td>
		</tr>
          <tr>
			<td align="right"><strong>Last Name: </strong></td>
			<td  align="left">
				{if $userData.last_name}{$userData.last_name|@ucfirst}{else}------{/if}
			</td>
		</tr>
          <tr>
			<td align="right"><strong>Email: </strong></td>
			<td  align="left">
				{if $userData.email}{$userData.email}{else}------{/if}
			</td>
		</tr>
          <tr>
			<td align="right"><strong>Street Address 1: </strong></td>
			<td align="left">
				{if $userData.address1}{$userData.address1|@ucfirst}{else}------{/if}
			</td>
		</tr>
          <tr>
			<td align="right"><strong>Street Address 2:</strong> </td>
			<TD  align="left">
				{if $userData.b_add2}{$userData.b_add2}{else}------{/if}
			</td>
		</tr>
          <tr>
			<td align="right"><strong>City/Town:</strong></td>
			<td align="left" >
				{if $userData.city}{$userData.city|@ucfirst}{else}------{/if}
			</td>
		</tr>
          <tr>
			<td align="right"><strong>County/State:</strong></td>
			<td align="left" >
				{if $userData.b_state_name}{$userData.b_state_name}{else}------{/if}
			</td>
		</tr>
		<tr>
			<td align="right"><strong>Country:</strong></td>
			<td align="left" >
				{if $userData.country_name}{$userData.country_name|@ucfirst}{else}------{/if}
			</td>
		</tr>
          <tr>
			<td align="right"><strong>Post/Zip Code:</strong></td>
			<td align="left" >
				{if $userData.postalcode}{$userData.postalcode}{else}------{/if}
			</td>
		</tr>
          <tr>
			<td align="right"><strong>Website URL:</strong></td>
			<td align="left" >
				{if $userData.business_webURL}{$userData.business_webURL}{else}------{/if}
			</td>
		</tr>
          <tr>
			<td align="right"><strong>Phone No.:</strong></td>
			<td align="left" >
				{if $userData.contact_detail}{$userData.contact_detail}{else}------{/if}
			</td>
		</tr>

		<!--{*}<tr><td width="25%" align="left" colspan="2"><strong>Payment Information</strong></td></tr>

		<tr>
			<td align="right"><strong>Cardholder Name:</strong> </td>
			<TD  align="left">
				{if $userData.p_card_holder_f_name || $userData.p_card_holder_l_name}
					{$userData.p_card_holder_f_name} {$userData.p_card_holder_l_name}
				{else}
						------
				{/if}
			</td>
		</tr>
          <tr>
			<td align="right"><strong>Credit Card Type:</strong></td>
			<td align="left" >
				{if $userData.p_credit_card_type}
					{$userData.p_credit_card_type}
				{else}
						------
				{/if}
			</td>
		</tr>
          <tr>
			<td align="right"><strong>Credit Card Number:</strong></td>
			<td align="left" >
				{if $userData.p_credit_card_no}
					{$userData.p_credit_card_no}
				{else}
						------
				{/if}
			</td>
		</tr>
          <tr>
			<td align="right"><strong>Expiry Date:</strong></td>
			<td align="left" >
				{if $userData.p_exp_month || $userData.p_exp_year}
					{if $userData.p_exp_month lte '9'}
						0{$userData.p_exp_month} / {$userData.p_exp_year}
					{else}
						{$userData.p_exp_month} / {$userData.p_exp_year}
					{/if}
				{else}
					------
				{/if}
			</td>
		</tr>
		<tr>
			<td align="right"><strong>Security Code:</strong></td>
			<td align="left" >
				{if $userData.p_sec_code neq 0}{$userData.p_sec_code}{else}------{/if}
			</td>
		</tr>

		<tr><td width="25%" align="left" colspan="2"><strong>Billing Address</strong></td></tr>

		<tr>
			<td align="right"><strong>Street Address 1: </strong></td>
			<td align="left">
				{if $userData.s_add1}{$userData.s_add1}{else}------{/if}
			</td>
		</tr>
          <tr>
			<td align="right"><strong>Street Address 2:</strong> </td>
			<TD  align="left">
				{if $userData.s_add2}{$userData.s_add2}{else}------{/if}
			</td>
		</tr>
          <tr>
			<td align="right"><strong>City/Town:</strong></td>
			<td align="left" >
				{if $userData.s_city}{$userData.s_city}{else}------{/if}
			</td>
		</tr>
          <tr>
			<td align="right"><strong>County/State:</strong></td>
			<td align="left" >
				{if $userData.s_state_name}{$userData.s_state_name}{else}------{/if}
			</td>
		</tr>
		<tr>
			<td align="right"><strong>Country:</strong></td>
			<td align="left" >
				{if $userData.s_country_name}{$userData.s_country_name}{else}------{/if}
			</td>
		</tr>
          <tr>
			<td align="right"><strong>Post/Zip Code:</strong></td>
			<td align="left" >
				{if $userData.s_zip_code}{$userData.s_zip_code}{else}------{/if}
			</td>
		</tr>{*}-->
      </table><br><br>


    <form name="frmModifSubs" id="frmModifSubs" method="post" action="">
        <table width="100%" border="0" cellspacing="5" cellpadding="5">

             <tr>
                <td colspan="2" align="middle"><b style="color:black;"><b>Subscription Packages:</b></div></td>
            </tr>
            <tr>
               <td colspan="2" align="middle">

                     <div class="packegname">
					<table class="packages">
						<tr>
							<td width="300"><strong>Package Name</strong></td>
							{section name=i loop=$subscriptionData}
							<td width="100"><strong>{$subscriptionData[i].pack_name}</strong>
								<input type="hidden" name="pack_name_{$subscriptionData[i].id}" id="pack_name_{$subscriptionData[i].id}" value="{$subscriptionData[i].pack_name}"></td>
							{/section}
						</tr>
						<tr>
							<td><strong>Type of Package<br/>(allow to post No. # deals per month)</strong></td>
							{section name=i loop=$subscriptionData}
							<td>{$subscriptionData[i].allow_deals_per_month}</td>
							{/section}
						</tr>
						<tr>
							<td><strong>Pack Price <span id="span_dlcurr_ubuyprice">&#163;</span></strong></td>
							{section name=i loop=$subscriptionData}
							<td>{$subscriptionData[i].pack_price}
								<input type="hidden" name="pack_price_{$subscriptionData[i].id}" id="pack_price_{$subscriptionData[i].id}" value="{$subscriptionData[i].pack_price}"></td>
							{/section}
						</tr>
						<tr>
							<td><strong>Cost Per Success Deal</strong></td>
							{section name=i loop=$subscriptionData}
							<td>{$subscriptionData[i].cost_per_success_deal}</td>
							{/section}
						</tr>
						<tr>
							<td><strong>Cost Per SMS Deal</strong></td>
							{section name=i loop=$subscriptionData}
							<td>{$subscriptionData[i].cost_sms_deal}</td>
							{/section}
						</tr>
						<tr>
							<td><strong>Pack Duration</strong></td>
							{section name=i loop=$subscriptionData}
							<td>{$subscriptionData[i].pack_duration}
								<input type="hidden" name="pack_duration_{$subscriptionData[i].id}" id="pack_duration_{$subscriptionData[i].id}" value="{$subscriptionData[i].pack_duration}"></td>
							{/section}
						</tr>
						<tr>
							<td><strong>Select Any One :</strong></td>
							{section name=i loop=$subscriptionData}
							<td><span class="radiobtn"><input type="radio" value="{$subscriptionData[i].id}" id="subscription" name="subscription" {if $subscriptionData[i].id eq $userData.subscription_pack_id}  checked="true" {/if} /></span></td>
							{/section}
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td colspan="{$subscriptionData|@count}">
								<div class="clr"></div>
								<div class="error" htmlfor="subscription" generated="true" ></div>
							</td>
						</tr>
					</table>
                                    </div>
               
               </td>
            </tr>
            
            <tr>
                <td>&nbsp;</td>
                <td align="center">
		    <input type="hidden" name="task" id="task" value="seller_subsc">
			{if $smarty.session.sess_subcri_status eq 'oldsubscription'}
				<input type="hidden" name="subs_type" id="subs_type" value="subscription_renew">
                    		<input type="submit" name="Submit" id="Submit" value="Renew Subscription" class="" />
			{elseif  $smarty.session.sess_subcri_status eq 'newsubscription'}
				<input type="hidden" name="subs_type" id="subs_type" value="subscription_do">
                    		<input type="submit" name="Submit" id="Submit" value="Subscribe" class="" />
			{/if}
                </td>
            </tr>
        </table>
    </form>
</div>
{include file=$footer}