{include file=$header_seller1}
{strip}
<script type="text/javascript" src="{$sitejs}/jquery.validate.pack.js"></script>
<script language="javascript" type="text/javascript" src="{$siteroot}/js/validation/admin/my-profile-update.js"></script>
{/strip}

{include file=$header_seller2}

<!--<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> 
 &gt; My Profile</div>
<br />-->

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

    {if $msg}<div align="center" id="msg"><br/>{$msg}<br/> <br/></div>{/if}
    <form name="frmregistration" id="frmregistration" method="POST" action="" enctype="multipart/form-data">
	<h3 class="pagehead2">Personal/Company Information</h3>
				<div class="border"></div>
				<ul class="form_div">
					<li><label><span style="color:red">*</span> First Name:</label>
                    <div class="fl">
                    <input type="hidden" name="userid" id="userid" value="{$userData.userid}"/>
				<input type="text" name="first_name" id="first_name" class="textbox" value="{$userData.first_name}"/>
                    </div>
					</li>
                    
                    <li><label><span style="color:red">*</span> Last Name:</label>
                    <div class="fl">
                    <input type="text" name="last_name" id="last_name" class="textbox" value="{$userData.last_name}"/>
                    </div>
					</li>
                    
                    <li><label><span style="color:red">*</span> Account Name:</label>
                    <div class="fl">
                    <input type="text" name="username" id="username" class="textbox" value="{$userData.username}"/>
                    </div>
					</li>
                    <li><label><span style="color:red">*</span> Email:</label>
                    <div class="fl">
                    <input type="text" name="email" id="email" class="textbox" value="{$userData.email}"/>
                    </div>
					</li>
                    <li><label><span style="color:red">*</span> Street Address 1:</label>
                    <div class="fl">
                    <textarea name="address" id="address" class="textbox">{$userData.address1}</textarea>
                    </div>
					</li>
                    
                    <li><label>Street Address 2:</label>
                    <div class="fl">
                    <input type="text" name="b_add2" id="b_add2" class="textbox" value="{$userData.b_add2}"/>
                    </div>
					</li>
                    
                    <li><label><span style="color:red">*</span> City/Town:</label>
                    <div class="fl">
                    <input type="text" name="city" id="city" class="textbox" value="{$userData.city}"/>
                    </div>
					</li>
                    
                    <li><label><span style="color:red">*</span> County/State: </label>
                    <div class="fl">
                    <select name="b_state" id="b_state" style="width:185px;" class="textbox">
					<option value="">Select State</option>
				{section name=i loop=$state}
					<option value="{$state[i].id}" {if $userData.b_state eq $state[i].id} selected="selected" {/if}>
						{$state[i].state_name}
					</option>
				{/section}
				</select>
                    </div>
					</li>
                    
                    <li><label><span style="color:red">*</span> Country:</label>
                    <div class="fl">
                     <select name="countryid" id="countryid" style="width:185px;" class="textbox">
					<option value="">Select Country</option>
				{section name=i loop=$country}
					<option value="{$country[i].countryid}" {if $userData.countryid eq $country[i].countryid} selected="selected" {/if}>{$country[i].country}</option>
				{/section}
				</select>
                    </div>
					</li>
                    
                    <li><label><span style="color:red">*</span> Post/Zip Code:</label>
                    <div class="fl">
                     <input type="text" name="postalcode" id="postalcode" class="textbox" value="{$userData.postalcode}"/>
                    </div>
					</li>
                    
                    <li><label><span style="color:red">*</span> Website URL:</label>
                    <div class="fl">
                     <input type="text" name="business_webURL" id="business_webURL" class="textbox" value="{$userData.business_webURL}"/>
                    </div>
					</li>
                    
                    <li><label><span style="color:red">*</span> Phone No.: </label>
                    <div class="fl">
                     <input type="text" name="contact_detail" id="contact_detail" class="textbox" value="{$userData.contact_detail}"/>
                    </div>
					</li>
				</ul>

			<h3 class="pagehead2">Change Your Password</h3>
				<div class="border"></div>
				<ul class="form_div">
					<li><label>Password:</label>
                    <div class="fl">
						<input type="Password" name="password" id="password" class="textbox"/>
                    </div>
					</li>
                    <li><label>Confirm Password:</label>
                    <div class="fl">
						<input type="Password" name="re_password" id="re_password" class="textbox"/>
                    </div>
					</li>
                </ul>
                
                <h3 class="pagehead2">Payment Information</h3>
				<div class="border"></div>
				<ul class="form_div">
					<li><label>Cardholder's First Name:</label>
                    <div class="fl">
						<input type="text" name="p_card_holder_f_name" id="p_card_holder_f_name" class="textbox" value="{$userData.p_card_holder_f_name}"/>
                    </div>
					</li>
                    <li><label>Cardholder's Last Name:</label>
                    <div class="fl">
						<input type="text" name="p_card_holder_l_name" id="p_card_holder_l_name" class="textbox" value="{$userData.p_card_holder_l_name}"/>
                    </div>
					</li>
                    </li>
                    <li><label>Credit Card Type:</label>
                    <div class="fl">
					  <select name="p_credit_card_type" id="p_credit_card_type" class="textbox">
                        <option value="">Select Card Type</option>
                        <option value="Visa" {if $userData.p_credit_card_type eq 'Visa'} selected="selected" {/if} >Visa</option>
                        <option value="Discover" {if $userData.p_credit_card_type eq 'Discover'} selected="selected" {/if} >Discover</option>
                        <option value="American Express" {if $userData.p_credit_card_type eq 'American Express'} selected="selected" {/if} >American Express</option>
                        <option value="MasterCard" {if $userData.p_credit_card_type eq 'MasterCard'} selected="selected" {/if} >MasterCard</option>
                    </select>
                    </div>
					</li>
                    <li><label>Credit Card Number:</label>
                    <div class="fl">
					  <input type="password" name="p_credit_card_no" id="p_credit_card_no" class="textbox" value="{if $userData.p_credit_card_no neq 0}{$userData.p_credit_card_no}{/if}"/>
                    </div>
					</li>
                    <li><label>Expiry Date:</label>
                    <div class="fl">
					  <select name="p_exp_month"  id="p_exp_month" class="textbox" style="width:100px;">
				{section name=month start=1 loop=13 step=1}
					<option {if $userData.p_exp_month eq $smarty.section.month.index} selected="selected"
					{/if} value="{$smarty.section.month.index}"> {if $smarty.section.month.index lte '9'}0{$smarty.section.month.index}{else}{$smarty.section.month.index}{/if}</option>
					{/section}
				</select>
				&nbsp;&nbsp;
				<select name="p_exp_year"  id="p_exp_year" class="textbox" style="width:100px; margin-left: 5px;">
				{section name=year start=$smarty.now|date_format:"%Y" loop=3000 step=1}
					<option {if $userData.p_exp_year eq $smarty.section.year.index} selected="selected"
					{/if} value="{$smarty.section.year.index}">{$smarty.section.year.index}</option>
				{/section}
				</select>
                    </div>
					</li>
                    <li><label>Security Code:</label>
                    <div class="fl">
					  <input type="text" name="p_sec_code" id="p_sec_code" class="textbox" value="{if $userData.p_sec_code neq 0}{$userData.p_sec_code}{/if}"/>
                    </div>
					</li>
                </ul>

				<h3 class="pagehead2" style="float:left">Billing Address </h3>
				<h3 class="pagehead2" style="float:right; font-size:13px"><input id="chksameasbilladdr" type="checkbox" name="chksameasbilladdr" value="1" onclick="fun_shipaddrsameasbilladdr();" > Same as Company address</h3>
				<div style="clear:both;"></div>
				<div class="border"></div>
				<ul class="form_div">
					<li><label>Street Address 1:</label>
                    <div class="fl">
						<textarea name="s_add1" id="s_add1" class="textbox">{$userData.s_add1}</textarea>
                    </div>
					</li>
                    <li><label>Street Address 2:</label>
                    <div class="fl">
						<input type="text" name="s_add2" id="s_add2" class="textbox" value="{$userData.s_add2}"/>
                    </div>
					</li>
                    <li><label>City/Town:</label>
                    <div class="fl">
						<input type="text" name="s_city" id="s_city" class="textbox" value="{$userData.s_city}"/>
                    </div>
					</li>
                    <li><label>County/State:</label>
                    <div class="fl">
						<select name="s_state" id="s_state" style="width:185px;" class="textbox">
                        <option value="">Select State</option>
                    {section name=i loop=$state}
                        <option value="{$state[i].id}" {if $userData.s_state eq $state[i].id} selected="selected" {/if}>
                            {$state[i].state_name}
                        </option>
                    {/section}
                    </select>
                    </div>
					</li>
                    <li><label>Country:</label>
                    <div class="fl">
                        <select name="s_countryid" id="s_countryid" style="width:185px;" class="textbox">
                        <option value="">Select Country</option>
                        {section name=i loop=$country}
                        <option value="{$country[i].countryid}" {if $userData.s_countryid eq $country[i].countryid} selected="selected" {/if}>{$country[i].country}</option>
                        {/section}
                        </select>
                    </div>
					</li>
                    <li><label>Post/Zip Code:</label>
                    <div class="fl">
                        <input type="text" name="s_zip_code" id="s_zip_code" class="textbox" value="{$userData.s_zip_code}"/>
                    </div>
					</li>
                    <li><label>&nbsp;</label>
                    <div class="fl btnmain" style="margin-right:15px;">
                        <input type="submit" name="Submit" id="Submit" value="Save" class="buybtn2"/>
                    </div>
                    <div class="fl btnmain">
						<input type="button" value="Cancel" onclick="javascript: location='my-profile-view.php'" class="buybtn2" />
                    </div>
					</li>
                </ul>
</form>
</div>
		<div class="clr">&#x00A0;</div>
	</section>
</section>
{include file=$footer_seller}