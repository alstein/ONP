{include file=$header_start}
<script language="JavaScript" type="text/javascript" src="{$siteroot}/js/validation/registration.js"></script>
{include file=$header_end}
{literal}
<script language="JavaScript">
// JavaScript Document
var xmlHttp
function GetXmlHttpObject(){
var xmlHttp=null;
try{
  // Firefox, Opera 8.0+, Safari
  xmlHttp=new XMLHttpRequest();
  }
catch (e)
  {
  // Internet Explorer
  try
    {
    xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
    }
  catch (e)
    {
    xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
  }
return xmlHttp;
}

function fillStates(str)
{
//alert(str);
	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null)
	{
			alert ("Your browser does not support AJAX!");
			return;
	}
	
	var url = SITEROOT+"/comman/show_states_front.php";
	url=url+"?cnid="+str;
	xmlHttp.onreadystatechange=states_value;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}
function states_value(){
    if (xmlHttp.readyState==4){
      var response=xmlHttp.responseText;
		document.getElementById('state_div').innerHTML=response;
	}
}

function fillCities(str)
{
//alert(str);
	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null)
	{
		alert ("Your browser does not support AJAX!");
		return;
	}

	var url = SITEROOT+"/comman/show_cities_front.php";
	url=url+"?stid="+str;
	xmlHttp.onreadystatechange=city_value;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}

function city_value(){
	if (xmlHttp.readyState==4){
		var response=xmlHttp.responseText;
		document.getElementById('city_div').innerHTML=response;
	}
}

</script>
{/literal}

  <!-- Maincontent starts -->
  <section id="maincont" class="ovfl-hidden">
    <section class="grybg">
      <div class="pagehead">
        <div class="grpcol">

		<h1 class="sing_up headingmain">Buyer Sign Up</h1>
                {if $msg_succ}<p><div class="successMsg" align="center">{$msg_succ}</div></p>{/if}
                {if $msg}<p><div class="errorMsg" align="center">{$msg}</div></p>{/if}
        </div>
      </div>
      <div class="innerdesc">
		<form name="frmregistration" id="frmregistration" action="" method="POST">
			<ul class="form_div2">
				<li><label>First Name:</label>
					<div class="sel fl">
						<input type="text" name="first_name" id="first_name" class="sel_input" value="{$smarty.post.first_name}"/>
					</div>
                    <a class="tooltip_css fl" href="javascript:void(0);">
                    <span class="classic_css">{tooltip label_id=45}</span></a>
					<div class="clr"></div>
					<div class="error" htmlfor="first_name" generated="true" style="padding-left:152px;"></div>
				</li>
				<li><label>Last Name:</label>
					<div class="sel fl">
						<input type="text" name="last_name" id="last_name" class="sel_input" value="{$smarty.post.last_name}"/>
					</div>
					<a class="tooltip_css fl" href="javascript:void(0);">
                                         <span class="classic_css">{tooltip label_id=46}</span></a>
					<div class="clr"></div>
                    <div class="error" htmlfor="last_name" generated="true" style="padding-left:152px;"></div>
				</li>
				<li>
					<label >Address:</label>
					<div class="sel_textarea fl">
						<textarea name="address" id="address" class="sel_input2">{$smarty.post.address}</textarea>
					</div>
					<a class="tooltip_css fl" href="javascript:void(0);">
                    <span class="classic_css">{tooltip label_id=47}</span></a>
					<div class="clr"></div>
                    <div class="error" htmlfor="address" generated="true" style="padding-left:152px;"></div>
					
				</li>
				<li><label>Email:</label>
					<div class="sel fl">
						<input type="text" name="email" id="email" class="sel_input" value="{$smarty.post.email}"/>
					</div>
					<a class="tooltip_css fl" href="javascript:void(0);">
                    <span class="classic_css">{tooltip label_id=48}</span></a>
					<div class="clr"></div>
                    <div class="error" htmlfor="email" generated="true" style="padding-left:152px;"></div>
				</li>
				<li><label>Password:</label>
					<div class="sel fl">
						<input type="Password" name="password" id="password" class="sel_input"/>
					</div>
					<a class="tooltip_css fl" href="javascript:void(0);">
                    <span class="classic_css">{tooltip label_id=49}</span></a>
					<div class="clr"></div>
                    <div class="error" htmlfor="password" generated="true" style="padding-left:152px;"></div>
				</li>
				<li><label>Confirm Password:</label>
					<div class="sel fl">
						<input type="Password" name="re_password" id="re_password" class="sel_input"/>
					</div>
					<a class="tooltip_css fl" href="javascript:void(0);">
                    <span class="classic_css">{tooltip label_id=50}</span></a>
					<div class="clr"></div>
                    <div class="error" htmlfor="re_password" generated="true" style="padding-left:152px;"></div>
				</li>
				<li><label>Country:</label>
					<select name="countryid" id="countryid" style="width:230px;" class="sel fl" onchange="javascript:fillStates(this.value);">
						<option value="">---Select Country---</option>
					   {section name=i loop=$country}
						<option value="{$country[i].countryid}">{$country[i].country}</option>
					   {/section}
					</select>
					<a class="tooltip_css fl" href="javascript:void(0);"><span class="classic_css">{tooltip label_id=51}</span></a>
				<div class="clr"></div>
                    <div class="error" htmlfor="countryid" generated="true" style="padding-left:152px;"></div>
				</li>
				<li><label>County State:</label>
					<div id="state_div" style="width: 235px;" class="fl">
						<select name="state" id="state" style="width:230px;" class="sel fl" onchange="javascript:fillCities(this.value);">
							<option value="">---Select County/State---</option>
						{*section name=i loop=$state}
							<option value="{$state[i].id}">{$state[i].state_name}</option>
						{/section*}
						</select>
					</div>
					<a class="tooltip_css fl" href="javascript:void(0);"><span class="classic_css">{tooltip label_id=52}</span></a>
					<div class="clr"></div>
					<div class="error" htmlfor="state" generated="true" style="padding-left:152px;"></div>
				</li>
				<!--
				<li><label>Town/City:</label>
					<select name="city" id="city" style="width:185px;" class="sel fl">
						<option value="">Select City</option>
						{$cityCombo}
					</select>
					<div class="clr"></div>
                                        <div class="error" htmlfor="city" generated="true" style="padding-left:152px;"></div>
				</li>-->
				<li>
					<label>Town City:</label>
					<div id="city_div" style="width: 235px;" class="fl">
						<select name="city" id="city" style="width:230px;" class="sel fl">
							<option value="">---Select Town/City---</option>
							{*section name=i loop=$city}
							<option value="{$city[i].city_id}">{$city[i].city_name}</option>
							{/section*}
						</select>
					</div>
					<a class="tooltip_css fl" href="javascript:void(0);"><span class="classic_css">{tooltip label_id=53}</span></a>
					<div class="clr"></div>
					<div class="error" htmlfor="city" generated="true" style="padding-left:152px;"></div>
					<!--<input name="city" type="text" id="city" maxlength="15" size="25" class="textbox"/></td>-->
				</li>
				<!--<li><label>Town/City:</label>
					<div class="sel fl">
						<input type="text" name="city" id="city" class="sel_input" value="{$smarty.post.city}"/>
					</div>
					<div class="clr"></div>
                                        <div class="error" htmlfor="city" generated="true" style="padding-left:152px;"></div>
				</li>-->
				<li><label>Post Code:</label>
					<div class="sel fl">
						<input type="text" name="postalcode" id="postalcode" class="sel_input sel fl" value="{$smarty.post.postalcode}"/>
					</div>
					<a class="tooltip_css fl" href="javascript:void(0);">
                    <span class="classic_css">{tooltip label_id=54}</span></a>
					<div class="clr"></div>
					<div class="error" htmlfor="postalcode" generated="true" style="padding-left:152px;"></div>
				</li>
				<li><label>Contact Number:</label>
					<div class="sel fl">
						<input type="text" name="contact_detail" id="contact_detail" class="sel_input sel fl" value="{$smarty.post.contact_detail}"/>
					</div>
					<a class="tooltip_css fl" href="javascript:void(0);"><span class="classic_css">{tooltip label_id=55}</span></a>
					<div class="clr"></div>
					<div class="error" htmlfor="contact_detail" generated="true" style="padding-left:152px;"></div>
				</li>
				<li>
					<label>&nbsp;</label>
					<div class="fl">
						<input name="terms" id="terms" type="checkbox" value="" style="width:auto; border:0px;">
						&nbsp;&nbsp; I have read and accept the <a href="{$siteroot}/terms" target="_blank">Terms and Conditions</a> and the <a href="{$siteroot}/privacy-policy" target="_blank">Privacy Policy</a>.
					</div>
					<div class="clr"></div>
					<div class="error" htmlfor="terms" generated="true" style="padding-left:152px;"></div>
				</li>
				<li class="margin_bottom">
					<label>&nbsp;</label>
					<div class="fl btnmain">
						<input type="submit" name="submit" id="submit" value="Submit" class="buybtn2">
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