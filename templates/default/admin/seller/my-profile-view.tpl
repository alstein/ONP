{include file=$header_seller1}
{include file=$header_seller2}

<section id="maincont" class="ovfl-hidden">

	<section class="grybg">
		<div class="pagehead">
			<div class="grpcol">
				<ul class="reset ovfl-hidden tab1">
					<li><a href="{$siteroot}/admin/seller/my-profile-view.php" class="active">My Account</a> </li>
					<li><a href="{$siteroot}/admin/seller/deal/add_product.php">Deal Management</a> </li>
					<li><a href="{$siteroot}/admin/seller/rating/raviews_rating_deals_list.php">Masters</a> </li>
					<li><a href="{$siteroot}/admin/seller/login-log.php">Tools</a> </li>
				</ul>
                <div class="SubNav">
                <a href="{$siteroot}/admin/seller/my-profile-view.php" class="active">My Profile</a>&nbsp;&nbsp;|&nbsp;&nbsp; 
                <a href="{$siteroot}/admin/seller/my-resolutions.php">Resolution Centre</a>
                </div>
			
           
			</div>
		</div>
		<div class="innerdesc">
        	 {if $msg}<div align="center" id="msg">{$msg}</div>{/if}
			<form name="frmregistration" id="frmregistration" action="" method="POST">
				<h3 class="pagehead2" style="float:left">Personal/Company Information</h3>
				<h3 class="pagehead2" style="float:right"><a href="{$siteroot}/admin/seller/my-profile-update.php">Edit</a></h3>
				<div style="clear:both;"></div>
				<div class="border"></div>
				<ul class="form_div">
					<li><label>Account No:</label>
						<div class="fl">#{$userData.userid}</div>
					</li>
                    <li><label>Account Name:</label>
						<div class="fl">{if $userData.username}{$userData.username}{else}------{/if}</div>
					</li>
                    <li><label>Seller Unique URL:</label>
						<div class="fl"><a style="color:blue" href="{$siteroot}/seller/{$userData.username}/{$userData.userid}" target="_blank">{$siteroot}/seller/{$userData.username}/{$userData.userid}</a></div>
					</li>
                    <li><label>First Name: </label>
						<div class="fl">{if $userData.first_name}{$userData.first_name|@ucfirst}{else}------{/if}</div>
					</li>
                    
                    
                    <li><label>Last Name: </label>
						<div class="fl">{if $userData.last_name}{$userData.last_name|@ucfirst}{else}------{/if}</div>
					</li>
                     <li><label>Email: </label>
						<div class="fl">{if $userData.email}{$userData.email}{else}------{/if}</div>
					</li>
                    
                     <li><label>Street Address 1: </label>
						<div class="fl">{if $userData.address1}{$userData.address1|@ucfirst}{else}------{/if}</div>
					</li>
                    
                     <li><label>Street Address 2: </label>
						<div class="fl">{if $userData.b_add2}{$userData.b_add2}{else}------{/if}</div>
					</li>
                    
                     <li><label>City/Town: </label>
						<div class="fl">{if $userData.city}{$userData.city|@ucfirst}{else}------{/if}</div>
					</li>
                    
                     <li><label>County/State: </label>
						<div class="fl">{if $userData.b_state_name}{$userData.b_state_name}{else}------{/if}</div>
					</li>
                    
                    <li><label>Country: </label>
						<div class="fl">{if $userData.b_state_name}{$userData.b_state_name}{else}------{/if}</div>
					</li>
                    
                    <li><label>Post/Zip Code: </label>
						<div class="fl">{if $userData.postalcode}{$userData.postalcode}{else}------{/if}</div>
					</li>
                    
                     <li><label>Website URL: </label>
						<div class="fl">{if $userData.business_webURL}{$userData.business_webURL}{else}------{/if}</div>
					</li>
                    
                    <li><label>Phone No.:</label>
						<div class="fl">{if $userData.contact_detail}{$userData.contact_detail}{else}------{/if}</div>
					</li>
				</ul>
              
				
				<h3 class="pagehead2">Payment Information</h3>
				<div class="border"></div>
				<ul class="form_div">
					<li><label>Cardholder Name:</label>
                    <div class="fl">
						{if $userData.p_card_holder_f_name || $userData.p_card_holder_l_name}
                        {$userData.p_card_holder_f_name} {$userData.p_card_holder_l_name}
                        {else}
                                ------
                        {/if}
                        </div>
					</li>
                    <li><label>Credit Card Type:</label>
                    <div class="fl">
						{if $userData.p_credit_card_type}
                        {$userData.p_credit_card_type}
                        {else}
                                ------
                        {/if}
                        </div>
					</li>
                    
                    <li><label>Credit Card Number:</label>
                    <div class="fl">
                        {if $userData.p_credit_card_no}
                        {$userData.p_credit_card_no}
                        {else}
                        ------
                        {/if}
                        </div>
					</li>
                    
                    <li><label>Expiry Date:</label>
                    <div class="fl">
                        {if $userData.p_exp_month || $userData.p_exp_year}
                        {if $userData.p_exp_month lte '9'}
                        0{$userData.p_exp_month} / {$userData.p_exp_year}
                        {else}
                        {$userData.p_exp_month} / {$userData.p_exp_year}
                        {/if}
                        {else}
                        ------
                        {/if}
                    </div>
					</li>
                    
                    <li><label>Security Code:</label>
                    <div class="fl">
                        {if $userData.p_sec_code neq 0}{$userData.p_sec_code}{else}------{/if}
                    </div>
					</li>
				</ul>
                
                
                <h3 class="pagehead2">Billing Address</h3>
				<div class="border"></div>
                <ul class="form_div">
                    <li><label>Street Address 1:</label>
                    <div class="fl">{if $userData.s_add1}{$userData.s_add1}{else}------{/if}</div>
                    </li>
                     <li><label>Street Address 2:</label>
                    <div class="fl">{if $userData.s_add2}{$userData.s_add2}{else}------{/if}</div>
                    </li>
                    <li><label>City/Town:</label>
                    <div class="fl">{if $userData.s_city}{$userData.s_city}{else}------{/if}</div>
                    </li>
                    <li><label>County/State:</label>
                    <div class="fl">{if $userData.s_state_name}{$userData.s_state_name}{else}------{/if}</div>
                    </li>
                    <li><label>Country:</label>
                    <div class="fl">{if $userData.s_country_name}{$userData.s_country_name}{else}------{/if}</div>
                    </li>
                    
                     <li><label>Post/Zip Code:</label>
                    <div class="fl">{if $userData.s_zip_code}{$userData.s_zip_code}{else}------{/if}</div>
                    </li>
                </ul>

				<h3 class="pagehead2" style="float:left">Other Details</h3>
				<h3 class="pagehead2" style="float:right"> <a href="{$siteroot}/admin/seller/manage_other_details.php" style="text-decoration: none;">Edit</a></h3>
				<div style="clear:both;"></div>
				<div class="border"></div>
				<ul class="form_div">
					<li>
						<label>Delivery Charges</label><br>
						<div class="fl">
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
						</div>
					</li>
					<li style="display:none;">
						<label>Pound (&#163;):</label>
						<div class="fl">{if $userData.delivery_charges_pound}{$userData.delivery_charges_pound} {else}-----{/if}</div>
					</li>
					<li style="display:none;">
						<label>Euro (&#8364;):</label>
						<div class="fl">{if $userData.delivery_charges_euro}{$userData.delivery_charges_euro} {else}-----{/if}</div>
					</li>
					<li style="display:none;">
						<label>Dollar ($):</label>
						<div class="fl">{if $userData.delivery_charges_dollar}{$userData.delivery_charges_dollar} {else}-----{/if}</div>
					</li>
					<li>
						<label>Seller Support Email:</label>
						<div class="fl">{if $userData.seller_support_email}{$userData.seller_support_email}{else}-----{/if}</div>
					</li>
					<li>
						<label>Tracking URL Code: </label>
						<div class="fl">{if $userData.tracking_url_code}{$userData.tracking_url_code} {else}-----{/if}</div>
					</li>
					<li>
						<label>Delivered Tracking URL Code:</label>
						<div class="fl">{if $userData.delivered_tracking_url_code}{$userData.delivered_tracking_url_code}{else}-----{/if}</div>
					</li>
					<li>
						<label>Affiliate URL:</label>
						<div class="fl">{if $userData.affiliate_link}{$userData.affiliate_link}{else}-----{/if}</div>
					</li>
					<li>
						<label>Affiliate Code:</label>
						<div class="fl">{if $userData.affiliate_code}{$userData.affiliate_code}{else}-----{/if}</div>
					</li>
					<li>
						<label>Refund Policy: </label>
						<div class="fl">{if $userData.refund_policy}{$userData.refund_policy|html_entity_decode} {else}-----{/if}</div>
					</li>
				</ul>

			</form>
		</div>
		<div class="clr">&#x00A0;</div>
	</section>
</section>
{include file=$footer_seller}
