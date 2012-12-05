{include file=$header_start}
<script language="JavaScript" type="text/javascript" src="{$siteroot}/js/validation/seller_registration.js"></script>
<!--<script language="JavaScript" type="text/javascript" src="{$siteroot}/js/validation/seller_payment.js"></script>-->
{include file=$header_end}
  <!-- Maincontent starts -->
  <section id="maincont" class="ovfl-hidden">
    <section class="grybg">
      <div class="pagehead">
        <div class="grpcol">

		<h1 class="sing_up headingmain">Seller Sign Up</h1>
                {if $msg_succ}<p><div class="successMsg" align="center">{$msg_succ}</div></p>{/if}
                {if $msg}<p><div class="errorMsg" align="center">{$msg}</div></p>{/if}
        </div>
      </div>
      <div class="innerdesc">
		<form name="frmregistration" id="frmregistration" action="" method="post">
			<ul class="form_div2">
				<li><label>Email:</label>
					<div class="sel fl">
						<input type="text" name="email" id="email" class="sel_input" value="{$smarty.post.email}"/>
					</div>
					<a class="tooltip_css fl" href="javascript:void(0);">
                                            <span class="classic_css">{tooltip label_id=56}</span></a>
					<div class="clr"></div>
					<div class="error" htmlfor="email" generated="true" style="padding-left:152px;"></div>
				</li>
				<li><label>Password:</label>
					<div class="sel fl">
						<input type="Password" name="password" id="password" class="sel_input"/>
					</div>
					<a class="tooltip_css fl" href="javascript:void(0);">
                                            <span class="classic_css">{tooltip label_id=57}</span></a>
					<div class="clr"></div>
					<div class="error" htmlfor="password" generated="true" style="padding-left:152px;"></div>
				</li>
				<li><label>Confirm Password:</label>
					<div class="sel fl">
						<input type="Password" name="re_password" id="re_password" class="sel_input"/>
					</div>
					<a class="tooltip_css fl" href="javascript:void(0);">
                                            <span class="classic_css">{tooltip label_id=58}</span></a>
					<div class="clr"></div>
					<div class="error" htmlfor="re_password" generated="true" style="padding-left:152px;"></div>
				</li>
				<li><label>First Name:</label>
					<div class="sel fl">
						<input type="text" name="first_name" id="first_name" class="sel_input" value="{$smarty.post.first_name}"/>
					</div>
					<a class="tooltip_css fl" href="javascript:void(0);">
                                          <span class="classic_css">{tooltip label_id=59}</span></a>
					<div class="clr"></div>
					<div class="error" htmlfor="first_name" generated="true" style="padding-left:152px;"></div>
				</li>
				<li><label>Last Name:</label>
					<div class="sel fl">
						<input type="text" name="last_name" id="last_name" class="sel_input" value="{$smarty.post.last_name}"/>
					</div>
					<a class="tooltip_css fl" href="javascript:void(0);">
                                             <span class="classic_css">{tooltip label_id=60}</span></a>
					<div class="clr"></div>
					<div class="error" htmlfor="last_name" generated="true" style="padding-left:152px;"></div>
				</li>
				<li><label>Business Name:</label>
					<div class="sel fl">
						<input type="text" name="business_name" id="business_name" class="sel_input" value="{$smarty.post.business_name}"/>
					</div>
					<a class="tooltip_css fl" href="javascript:void(0);">
                    <span class="classic_css">{tooltip label_id=61}</span></a>
					<div class="clr"></div>
					<div class="error" htmlfor="business_name" generated="true" style="padding-left:152px;"></div>
				</li>
				<li>
					<label >Address:</label>
					<div class="sel_textarea fl">
						<textarea name="address" id="address" class="sel_input2">{$smarty.post.address}</textarea>
					</div>
					<a class="tooltip_css fl" href="javascript:void(0);">
                                            <span class="classic_css">{tooltip label_id=62}</span></a>
					<div class="clr"></div>
					<div class="error" htmlfor="address" generated="true" style="padding-left:152px;"></div>
				</li>
				<li><label>Town/City:</label>
					<div class="sel fl">
						<input type="text" name="city" id="city" class="sel_input" value="{$smarty.post.city}"/>
					</div>
					<a class="tooltip_css fl" href="javascript:void(0);">
                                             <span class="classic_css">{tooltip label_id=63}</span></a>
					<div class="clr"></div>
					<div class="error" htmlfor="city" generated="true" style="padding-left:152px;"></div>
				</li>
				<li><label>County/State:</label>
					<select name="countryid" id="countryid" style="width:185px;" class="sel fl">
						<option value="">---Select State---</option>
						{section name=i loop=$state}
							<option value="{$state[i].id}">
								{$state[i].state_name}
							</option>
						{/section}
					</select>
					<a class="tooltip_css fl" href="javascript:void(0);">
                                            <span class="classic_css">{tooltip label_id=68}</span></a>
					<div class="clr"></div>
					<div class="error" htmlfor="state" generated="true" style="padding-left:152px;"></div>
				</li>
				<li><label>Country:</label>
					<select name="countryid" id="countryid" style="width:185px;" class="sel fl">
					        <option value="">---Select Country---</option>
						{section name=i loop=$country}
			                           <option value="{$country[i].countryid}">{$country[i].country}</option>
				                {/section}
						<!--<option value="">Select Country</option>
						{*$countryCombo*}-->
					</select>
					<a class="tooltip_css fl" href="javascript:void(0);">
                                            <span class="classic_css">{tooltip label_id=64}</span></a>
					<div class="clr"></div>
					<div class="error" htmlfor="countryid" generated="true" style="padding-left:152px;"></div>
				</li>
				<li><label>Post Code:</label>
					<div class="sel fl">
						<input type="text" name="postalcode" id="postalcode" class="sel_input" value="{$smarty.post.postalcode}"/>
					</div>
					<a class="tooltip_css fl" href="javascript:void(0);">
                                            <span class="classic_css">{tooltip label_id=65}</span></a>
					<div class="clr"></div>
					<div class="error" htmlfor="postalcode" generated="true" style="padding-left:152px;"></div>
				</li>
				<li><label>Website URL:</label>
					<div class="sel fl">
						<input type="text" name="business_webURL" id="business_webURL" class="sel_input" value="{$smarty.post.business_webURL}"/>
					</div>
					<a class="tooltip_css fl" href="javascript:void(0);">
                                             <span class="classic_css">{tooltip label_id=66}</span></a>
					<div class="clr"></div>
					<div class="error" htmlfor="business_webURL" generated="true" style="padding-left:152px;"></div>
				</li>
				<li><label>Phone Number:</label>
					<div class="sel fl">
						<input type="text" name="contact_detail" id="contact_detail" class="sel_input" value="{$smarty.post.contact_detail}"/>
					</div>
					<a class="tooltip_css fl" href="javascript:void(0);">
                                            <span class="classic_css">{tooltip label_id=67}</span></a>
					<div class="clr"></div>
					<div class="error" htmlfor="contact_detail" generated="true" style="padding-left:152px;"></div>
				</li>
				<li><div style="color:red; font-size:15px"><strong>Subscription Packages:</strong></div></li>
				<li>
                <div class="packegname">
					<table class="packages">
						<tr>
							<td width="300"><strong>Package Name</strong></td>
							{section name=i loop=$subscriptionData}
							<td width="100">
								<strong>{$subscriptionData[i].pack_name}</strong>
								<input type="hidden" name="pack_name_{$subscriptionData[i].id}" id="pack_name_{$subscriptionData[i].id}" value="{$subscriptionData[i].pack_name}">
							</td>
							{/section}
						</tr>
						<tr>
							<td><strong>Type of Package<br/>(allow to post No. # deals per month)</strong></td>
							{section name=i loop=$subscriptionData}
							<td>{$subscriptionData[i].allow_deals_per_month}</td>
							{/section}
						</tr>
						<tr>
							<td><strong>Pack Price (&#163;)</strong></td>
							{section name=i loop=$subscriptionData}
							<td>
								{$subscriptionData[i].pack_price}
								<input type="hidden" name="pack_price_{$subscriptionData[i].id}" id="pack_price_{$subscriptionData[i].id}" value="{$subscriptionData[i].pack_price}">
							</td>
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
							<td><strong>Pack Duration (Months)</strong></td>
							{section name=i loop=$subscriptionData}
							<td>
								{$subscriptionData[i].pack_duration}
								<input type="hidden" name="pack_duration_{$subscriptionData[i].id}" id="pack_duration_{$subscriptionData[i].id}" value="{$subscriptionData[i].pack_duration}">
							</td>
							{/section}
						</tr>
						<tr>
							<td><strong>Select Any One :</strong></td>
							{section name=i loop=$subscriptionData}
							<td><span class="radiobtn"><input type="radio" value="{$subscriptionData[i].id}" id="subscription" name="subscription"/></span></td>
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
				</li>
				<li>
					<label>&nbsp;</label>
					<div class="fl">
						<input name="terms" id="terms" type="checkbox" value="" style="width:auto; border:0px;">
						&nbsp;&nbsp; I have read and accept the <a href="{$siteroot}/terms" target="_blank">Terms and Conditions</a> and the <a href="{$siteroot}/privacy-policy" target="_blank">Privacy Policy</a>
					</div>
					<div class="clr"></div>
					<div class="error" htmlfor="terms" generated="true" style="padding-left:152px;"></div>
				</li>
				<li class="margin_bottom">
					<label>&nbsp;</label>
					<div class="fl btnmain">
						<input type="submit" name="submit" id="submit" value="Pay Safely With Paypal" class="buybtn2">
					</div>
					<label style="width:10px;">&nbsp;</label>
					<div class="fl btnmain">
						<input type="button" value="cancel" onclick="javascript:history.back(1);" class="buybtn2">
					</div>
				</li>
			</ul>
		</form>
      </div>
      <div class="clr">&#x00A0;</div>
    </section>
    <section class="grybg">
      <div class="tphwrks">
	{include file=$footer_free_coupons}
      </div>
    </section>
  </section>
  <!-- Maincontent ends -->
{include file=$footer}