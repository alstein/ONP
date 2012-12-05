{include file=$header_seller1}
<script language="javascript" type="text/javascript" src="{$siteroot}/js/validation/admin/seller/buy_sms_email_subscriber.js"></script>
{literal}
<script language="JavaScript" type="text/javascript">
	function setAmt(amt)
	{
		amt = (amt?amt:'0');
		$('#final_value').val(amt);
		$('#totAmtHTML').html(amt);
	}
</script>
{/literal}
{include file=$header_seller2}

<!--<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; Send SMS / Email</div><br/>-->

<section id="maincont" class="ovfl-hidden">

	<section class="grybg">
		<div class="pagehead">
			<div class="grpcol">
				<ul class="reset ovfl-hidden tab1">
					<li><a href="{$siteroot}/admin/seller/my-profile-view.php">My Account</a> </li>
					<li><a href="{$siteroot}/admin/seller/deal/add_product.php" class="active">Deal Management</a> </li>
					<li><a href="{$siteroot}/admin/seller/rating/raviews_rating_deals_list.php">Masters</a> </li>
					<li><a href="{$siteroot}/admin/seller/login-log.php">Tools</a> </li>
				</ul>
                <div class="SubNav">
                <a href="{$siteroot}/admin/seller/deal/add_product.php">Add New Deal</a> &nbsp;&nbsp;|&nbsp;&nbsp; 
                <a href="{$siteroot}/admin/seller/deal/pending-deal.php"  >Pending Deals ({$deal_notice_info_seller.tot_pending})</a> &nbsp;&nbsp;|&nbsp;&nbsp; 
                <a href="{$siteroot}/admin/seller/deal/manage_deal.php" class="active">Active Deals ({$deal_notice_info_seller.tot_actv1})</a> &nbsp;&nbsp;|&nbsp;&nbsp; 
                <a href="{$siteroot}/admin/seller/deal/featured_deal.php">Featured Deals ({$deal_notice_info_seller.tot_fea})</a> &nbsp;&nbsp;|&nbsp;&nbsp; 
                <a href="{$siteroot}/admin/seller/deal/rejected-deals.php">Rejected Deals ({$deal_notice_info_seller.tot_rej})</a>&nbsp;&nbsp;|&nbsp;&nbsp; 
                <a href="{$siteroot}/admin/seller/deal/upcoming_deal.php">Upcoming Deals ({$deal_notice_info_seller.tot_upcom})</a> &nbsp;&nbsp;|&nbsp;&nbsp; 
                <a href="{$siteroot}/admin/seller/deal/expired_deal.php">Expired Deals ({$deal_notice_info_seller.tot_exp})</a>
                </div>
			
           
			</div>
		</div>
		<div class="innerdesc">
    
<h3 class="pagehead2 fl">Manage Send SMS / Email</h3>

<div class="pagehead2 fr">
<a href="manage_deal.php"><strong>Back</strong></a></div>
<div class="clr"></div>   
<div class="border"></div> 


<div class="holdthisTop">
{if $msg}<br/><div align="center">{$msg}</div>{/if}

    <form action="" method="post" name='frm' id="frm" enctype="multipart/form-data" {if $sub eq 'over'} style="display:none;" {/if}>
    <input type="hidden" id="final_value" name="final_value" value="{$totSmsAmt}" />
    <input type="hidden" id="listing" name="listing" value="0" />
    <input type="hidden" id="option_selected" value="" name="option_selected">
    {if $errormsg}<div align="center">{$errormsg}</div>{/if}
    
    <h3 class="pagehead2" style="color:#000; margin-bottom:10px; font-weight:bold;">Deal Information</h3>
		<ul class="form_div">
        <li>
        <label>Deal Name :</label>
        <div class="fl">{$dealInfo.title|html_entity_decode}</div>
        </li>
        
        <li>
        <label>Start Date :</label>
        <div class="fl">{$dealInfo.start_date}</div>
        </li>
        
         <li>
        <label>End Date :</label>
        <div class="fl">{$dealInfo.end_date}</div>
        </li>
        
        <li>
        <label>Deal Type :</label>
        <div class="fl">{$dealInfo.deal_main_type}</div>
        </li>
        
        <li>
        <label>Cities :</label>
        <div class="fl">{$dealInfo.city_name}</div>
        </li>
        
        <li>
        <label>Price :</label>
        <div class="fl">{$dealInfo.deal_currency_type}{$dealInfo.groupbuy_price}</div>
        </li>
        
        <li>
        <label>Original Price :</label>
        <div class="fl">{$dealInfo.deal_currency_type}{$dealInfo.orignal_price}</div>
        </li>
        
        <li>
        <label>% Saved :</label>
        <div class="fl">{$dealInfo.quantity} %</div>
        </li>
        </ul>
        <br />
        <div>Fields marked<span class="red"> *</span> are required</div>
    	<br />
        <ul class="form_div">
        <li>
        <label>Deal Name :</label>
        <div class="fl" style="background:#ccc;">
        <table border="0" cellpadding="5" cellspacing="1">
					<tr align="center">
						<td style="background:#f2f2f2">&nbsp;</td>
						<td style="background:#f2f2f2">Total Sbuscriber</td>
						<td style="background:#f2f2f2">Cost per SMS/E-mail</td>
						<td style="background:#f2f2f2">Total</td>
					</tr>
					<tr align="center">
						<td style="background:#fff">SMS</td>
						<td style="background:#fff">{$totSmsSub}</td>
						<td style="background:#fff">(&#163;) {$costPerSms}</td>
						<td style="background:#fff">(&#163;) {$totSmsAmt}</td>
					</tr>
					<tr align="center">
						<td style="background:#fff">E-mail</td>
						<td style="background:#fff">{$totEmailSub}</td>
						<td style="background:#fff">(&#163;) {$costPerEmail}</td>
						<td style="background:#fff">(&#163;) {$totEmailAmt}</td>
					</tr>
					<tr align="center">
						<td style="background:#fff">Both</td>
						<td style="background:#fff">{$totBothSub}</td>
						<td style="background:#fff">----</td>
						<td style="background:#fff">(&#163;) {$totBothAmt}</td>
					</tr>
				</table>
        </div>
        </li>
        <li>
        <label>Send As<span class="red"> *</span> :</label>
        <div class="fl">
        <input type="radio" name="send_as" id="send_as_sms" value="SMS"  onchange="javascript:setAmt({$totSmsAmt});" checked="true" > &nbsp; <strong>SMS</strong> &nbsp;&nbsp;
        <input type="radio" name="send_as" id="send_as_email" value="EMAIL" onchange="javascript:setAmt({$totEmailAmt});"> &nbsp; <strong>Email</strong> &nbsp;&nbsp;
        <input type="radio" name="send_as" id="send_as_sms_email" value="BOTH" onchange="javascript:setAmt({$totBothAmt});"> &nbsp; <strong>Both</strong>
        </div>
        </li>
        <li>
        <label>Total Amount : (&#163;)</label>
        <div class="fl">
        <strong style="font-size:15px; color:#E10000;">{$totSmsAmt}</strong>
        </div>
     	<div id="totAmtHTML" style="margin:10px 0px;"> 
        <div style="display:none; padding-left:100px;" htmlfor="final_value" generated="true" class="error"></div>
        </div>
        </li>
        </ul>
        
		<section class="categoryright">
					<div class="infobox">Billing Address</div>
					<div class="infobox2 ovfl-hidden">
						<div class="billings_div fl">
							<ul class="reset">
								<li><label>First Name:</label>
									<div class="sel fl">
										<input type="text" value="{$userData.first_name}" name="fname" id="fname" class="sel_input" />
									</div>
									<div style="clear:both;"></div><div class="error" htmlfor="fname" generated="true" style="display:none; padding-left:150px;"></div><div style="clear:both;"></div>
								</li>
								<li><label>Address Line1:</label>
									<div class="sel fl">
										<input type="text" value="{$userData.address1}" name="address1" id="address1" class="sel_input" />
									</div>
									<div style="clear:both;"></div><div class="error" htmlfor="address1" generated="true" style="display:none; padding-left:150px;"></div><div style="clear:both;"></div>
								</li>
								<li><label>Town/City:</label>
									<select class="sel2" name="city" id="city">
										<option value="">Select City</option>
									{section name=i loop=$city}
										<option value="{$city[i].city_id}" {if $userData.city eq $city[i].city_id} selected="selected" {/if}>
											{$city[i].city_name}
										</option>
									{/section}
									</select>
									<div style="clear:both;"></div><div class="error" htmlfor="city" generated="true" style="display:none; padding-left:150px;"></div><div style="clear:both;"></div>
								</li>
								<li>
									<label>County/State:</label>
										<select class="sel2" name="state" id="state">
											<option value="">Select State</option>
										{section name=i loop=$state}
											<option value="{$state[i].id}" {if $userData.state_id eq $state[i].id} selected="selected" {/if}>
												{$state[i].state_name}
											</option>
										{/section}
										</select>
									<div style="clear:both;"></div><div class="error" htmlfor="state" generated="true" style="display:none; padding-left:150px;"></div><div style="clear:both;"></div>
								</li>
							</ul>
						</div>
						<div class="billings_div fl">
							<ul class="reset">
								<li><label>Last Name:</label>
									<div class="sel fl">
										<input type="text" value="{$userData.last_name}" name="lname" id="lname" class="sel_input" />
									</div>
									<div style="clear:both;"></div><div class="error" htmlfor="lname" generated="true" style="display:none; padding-left:150px;"></div><div style="clear:both;"></div>
								</li>
								<li><label>Address Line 2:</label>
									<div class="sel fl">
										<input type="text" value="{$userData.address2}" name="address2" id="address2" class="sel_input" />
									</div>
									<div style="clear:both;"></div><div class="error" htmlfor="address2" generated="true" style="display:none; padding-left:150px;"></div><div style="clear:both;"></div>
								</li>
								<li><label>Post:</label>
									<div class="sel fl">
										<input type="text" value="{$userData.postalcode}" name="postcode" id="postcode" class="sel_input" />
									</div>
									<div style="clear:both;"></div><div class="error" htmlfor="postcode" generated="true" style="display:none; padding-left:150px;"></div><div style="clear:both;"></div>
								</li>
							</ul>
						</div>
					</div>
				</section>
				<section class="categoryright">
					<div class="infobox">Payment Info</div>
					<div class="infobox2 ovfl-hidden">
						<div class="billings_div fl">
							<ul class="reset">
								<li><label>Cardholder First Name:</label>
									<div class="sel fl">
										<input type="text" value="{$userData.p_card_holder_f_name}" name="ccfname" id="ccfname" class="sel_input" />
									</div>
									<div style="clear:both;"></div><div class="error" htmlfor="ccfname" generated="true" style="display:none; padding-left:150px;"></div><div style="clear:both;"></div>
								</li>
								<li><label>Card Type:</label>
									<div class="col1 fl">
										<select class="sel2" name="cctype" id="cctype" onchange="javascript: $('#ccnumber').valid();">
											<option {if $userData.p_credit_card_type eq 'Visa'} selected="selected" {/if} value="Visa">Visa</option>
											<option {if $userData.p_credit_card_type eq 'Discover'} selected="selected" {/if} value="Discover">Discover</option>
											<option {if $userData.p_credit_card_type eq 'American Express'} selected="selected" {/if} value="American Express">American Express</option>
											<option {if $userData.p_credit_card_type eq 'MasterCard'} selected="selected" {/if} value="MasterCard">MasterCard</option>
										</select>
									</div>
									<div style="clear:both;"></div><div class="error" htmlfor="cctype" generated="true" style="display:none; padding-left:150px;"></div><div style="clear:both;"></div>
								</li>
								<li><label>Card Number:</label>
									<div class="sel fl">
										<input type="text" value="{$userData.p_credit_card_no}" name="ccnumber" id="ccnumber" class="sel_input" />
									</div>
									<div style="clear:both;"></div><div class="error" htmlfor="ccnumber" generated="true" style="display:none; padding-left:150px;"></div><div style="clear:both;"></div>
								</li>
							</ul>
						</div>
						<div class="billings_div fl">
							<ul class="reset">
								<li><label>Cardholder Last Name:</label>
									<div class="sel fl">
										<input type="text" value="{$userData.p_card_holder_l_name}" name="cclname" id="cclname" class="sel_input" />
									</div>
									<div style="clear:both;"></div><div class="error" htmlfor="cclname" generated="true" style="display:none; padding-left:150px;"></div><div style="clear:both;"></div>
								</li>
								<li><label>Expiration Date </label>
									<div class="expdatediv fl" style="width:44px">
										<select class="exp_date" style="width:55px;" name="ccexpmonth" id="ccexpmonth">
										{section name=month start=1 loop=13 step=1}
											<option value="{$smarty.section.month.index}" {if $userData.p_exp_month eq $smarty.section.month.index} selected="selected" {/if}> {$smarty.section.month.index}</option>
										{/section}
										</select>
									</div>
									<div class="expdatediv fl">
										<select class="exp_date2" name="ccexpyear" id="ccexpyear">
										{section name=year start=$smarty.now|date_format:"%Y" loop=3000 step=1}
											<option value="{$smarty.section.year.index}" {if $userData.p_exp_year eq $smarty.section.year.index} selected="selected" {/if} >{$smarty.section.year.index}</option>
										{/section}
										</select>
									</div>
								</li>
								<li><label>Security Code </label>
									<div class="sel fl">
										<input type="text" value="{$userData.p_sec_code}" name="cccode" id="cccode" class="sel_input" />
									</div>
									<div style="clear:both;"></div><div class="error" htmlfor="cccode" generated="true" style="display:none; padding-left:150px;"></div><div style="clear:both;"></div>
								</li>
							</ul>
						</div>
					</div>
				
					<div class="infobox2 ovfl-hidden">
						<ul class="form_div">
							<li>
								<div class="fl">
									<input name="terms" id="terms" type="checkbox" value="" style="width:auto; border:0px;">
									I agree to the <a href="{$siteroot}/terms" style="color:blue;" target="_blank">terms &amp; Conditions</a> and <a href="{$siteroot}/privacy-policy" style="color:blue;" target="_blank">Privacy Policy.*</a>
								</div>
								<div style="clear:both;"></div><div class="error" htmlfor="terms" generated="true" style="display:none; padding-left:150px;"></div><div style="clear:both;"></div>
							</li>
							<li class="margin_bottom">
								<div class="fl btnmain" style="margin-right:15px;">
									<input type="submit" value="Send" name="submit" class="buybtn2"/>
                                    </div>
                                    <div class="fl btnmain">
									<input type="button" value="Cancel" onclick="javascript: location='manage_deal.php';" class="buybtn2"/>
									</div>
								<div class="fl" style="padding-left:15px"><img src="{$siteimg}/paypalable.jpg" width="150" height="60" alt="img"></div>
							</li>
						</ul>
					</div>
				</section>
    </form>
</div>

</div>
</section>
</section>
{include file=$footer_seller}