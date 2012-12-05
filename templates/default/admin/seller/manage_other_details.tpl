{include file=$header_seller1}
<script type="text/javascript" src="{$siteroot}/js/ajax.js"></script>
<script type="text/javascript" src="{$siteroot}/js/ajax_user_search.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/userlist.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/edit_seller_manage_other_details.js"></script>
{include file=$header_seller2}

<!--<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt;<a href="{$siteroot}/admin/seller/my-profile-view.php">My Profile View</a> &gt; Manage Other Details
</div><br/>-->
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
		<h3 class="subtitle">{$sitetitle}  Manage Other Details</h3>
		<div class="innerdesc">
		{if $msg}<div align="center" id="msg"><br/>{$msg}<br/> <br/></div>{/if}
			<div id="UserListDiv" name="UserListDiv">
				<form name="home_form" action="" id="home_form" method="post" enctype="multipart/form-data">
					<input type="hidden" name="userid" id="userid" value="{$userid}">
					<h3 class="pagehead2">Delivery Charges</h3>
					<div class="border"></div>
					<ul class="form_div">
						<li style="display:none;"><label>Pound (&#163;):</label>
						<div class="fl">
							<input type="text" name="delivery_charges_pound" id="delivery_charges_pound" value="{$delivery_charges_pound.value}"  maxlength="4" class="textbox"/>
						</div>
						</li>
						
						<li style="display:none;"><label>Euro (&#8364;):</label>
						<div class="fl">
							<input type="text" name="delivery_charges_euro" id="delivery_charges_euro" value="{$delivery_charges_euro.value}"  class="textbox" maxlength="4"/>
						</div>
						</li>
						
						<li style="display:none;"><label>Dollar ($):</label>
						<div class="fl">
							<input type="text" name="delivery_charges_dollar" id="delivery_charges_dollar" value="{$delivery_charges_dollar.value}"  class="textbox" maxlength="4"/>
						</div>
						</li>
						
						<li><label>Delivery Service Options:</label><br>
						<div class="fl">
							<table border="1" cellpadding="5" cellspacing="1" style="border-width:3px; border-style:solid;" width="850px">
								<tr>
									<th rowspan="2" style="border-bottom-width:3px; border-bottom-style:solid;" width="2%">Sr. No.</th>
									<th rowspan="2" style="border-bottom-width:3px; border-bottom-style:solid;" width="13%">Select / Deselect</th>
									<th rowspan="2" style="border-bottom-width:3px; border-bottom-style:solid;">Delivery Service Option Name</th>
									<th colspan="3">Delivery Charges</th>
								</tr>
								<tr>
									<th style="border-bottom-width:3px; border-bottom-style:solid;" width="20%">Pound (&#163;)</th>
									<th style="border-bottom-width:3px; border-bottom-style:solid;" width="20%">Euro (&#8364;)</th>
									<th style="border-bottom-width:3px; border-bottom-style:solid;" width="20%">Dollar ($)</th>
								</tr>
								{section name=i loop=$data_delivery_chr}
								<tr id="tr_{$smarty.section.i.iteration}">
									<th>{$smarty.section.i.iteration}</th>
									<td align="center">
										<input type="hidden" name="delivery_service_option_{$smarty.section.i.iteration}" id="delivery_service_option_{$smarty.section.i.iteration}" value="{$data_delivery_chr[i].value}">
										<input type="checkbox" name="delivery_service_option_chk_{$smarty.section.i.iteration}" id="delivery_service_option_chk_{$smarty.section.i.iteration}" onchange="onChkChange('{$smarty.section.i.iteration}')" {if $data_delivery_service_chr[i].is_selected eq 'yes'} checked="true" {elseif $data_delivery_service_chr[i].is_selected neq 'no' && $smarty.section.i.iteration eq '1'} checked="true" {/if}>
									</td>
									<td>{$data_delivery_chr[i].value}</td>
									<td align="center">
										{if $smarty.section.i.iteration == 1}
											<input type="hidden" name="delivery_charges_pound_{$smarty.section.i.iteration}" id="delivery_charges_pound_{$smarty.section.i.iteration}" value="0" class="textbox" maxlength="4" style="width:40px;"/>----
										{else}
											<input type="text" name="delivery_charges_pound_{$smarty.section.i.iteration}" id="delivery_charges_pound_{$smarty.section.i.iteration}" value="{$data_delivery_service_chr[i].delivery_charges_pound}" class="textbox" maxlength="4" style="width:40px;"/>
										{/if}
										<div style="clear:both;"></div>
										<div style="display:none;" htmlfor="delivery_charges_pound_{$smarty.section.i.iteration}" generated="true" class="error"></div>
									</td>
									<td align="center">
										{if $smarty.section.i.iteration == 1}
											<input type="hidden" name="delivery_charges_euro_{$smarty.section.i.iteration}" id="delivery_charges_euro_{$smarty.section.i.iteration}" value="0" class="textbox" maxlength="4" style="width:40px;"/>----
										{else}
											<input type="text" name="delivery_charges_euro_{$smarty.section.i.iteration}" id="delivery_charges_euro_{$smarty.section.i.iteration}" value="{$data_delivery_service_chr[i].delivery_charges_euro}" class="textbox" maxlength="4" style="width:40px;"/>
										{/if}
										<div style="clear:both;"></div>
										<div style="display:none;" htmlfor="delivery_charges_euro_{$smarty.section.i.iteration}" generated="true" class="error"></div>
									</td>
									<td align="center">
										{if $smarty.section.i.iteration == 1}
											<input type="hidden" name="delivery_charges_dollar_{$smarty.section.i.iteration}" id="delivery_charges_dollar_{$smarty.section.i.iteration}" value="0" class="textbox" maxlength="4" style="width:40px;"/>----
										{else}
											<input type="text" name="delivery_charges_dollar_{$smarty.section.i.iteration}" id="delivery_charges_dollar_{$smarty.section.i.iteration}" value="{$data_delivery_service_chr[i].delivery_charges_dollar}" class="textbox" maxlength="4" style="width:40px;"/>
										{/if}
										<div style="clear:both;"></div>
										<div style="display:none;" htmlfor="delivery_charges_dollar_{$smarty.section.i.iteration}" generated="true" class="error"></div>
									</td>
								</tr>
								{/section}
							</table>
							<input type="hidden" name="delivery_service_options" id="delivery_service_options" value=""/>
						</div>
						</li>
						
						<li><label><span style="color:red;">*</span>Seller Support Email:</label>
						<div class="fl">
							<input type="text" name="seller_support_email" id="email" value="{$seller_support_email}" class="textbox"/>
						</div>
						</li>
						
							<li><label><span style="color:red;">*</span>Tracking URL Code:</label>
						<div class="fl">
							<input type="text" name="tracking_URL" id="tracking_URL" value="{$tracking_url_code}" class="textbox"/>
						</div>
						</li>
						
						<li><label><span style="color:red;">*</span>Delivered Tracking URL Code:</label>
						<div class="fl">
							<input type="text" name="delivered_tracking_URL" id="delivered_tracking_URL" value="{$delivered_tracking_url_code}" class="textbox"/>
						</div>
						</li>
						
						<li><label><span style="color:red;">*</span>Affiliate URL:</label>
						<div class="fl">
							<input type="text" name="affiliate_URL" id="affiliate_URL" value="{$affiliate_url}" class="textbox"/>
						</div>
						</li>
						
						<li><label><span style="color:red;">*</span>Affiliate Code:</label>
						<div class="fl">
							<textarea name="affiliate_code" id="affiliate_code" cols="40" rows="5" class="textbox">{$affiliate_code}</textarea>
						{*<input type="text" name="affiliate_code" id="affiliate_code" value="{$affiliate_code}" class="textbox"/>*}
						</div>
						</li>
						
						<li><label><span style="color:red;">*</span>Refund Policy:</label>
						<div class="fl">
							{*oFCKeditor->Create*} {$oFCKeditorDesc}
						</div>
						</li>
						
						<li><label>&nbsp;</label>
						<div class="fl btnmain">
							<input type="submit" name="Update" id="Update" value="Update" class="buybtn2"  /> 
						</div>
						</li>
					</ul>
				</form>
			</div>
		</div>
	</section>
</section>


{include file=$footer_seller}
