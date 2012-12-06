{include file=$header1}
{strip}
<script type="text/javascript" src="{$sitejs}/jquery.validate.pack.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/editseller.js"></script>
<script language="javascript" type="text/javascript" src="{$siteroot}/js/calendarDateInput.js"> </script>
{/strip}
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

function getsubcat(str)
{
//alert(str);
	xmlHttp=GetXmlHttpObject()
    if (xmlHttp==null)
    {
          alert ("Your browser does not support AJAX!");
          return;
      }

	var url = SITEROOT+"/comman/show_category.php";
    url=url+"?cnid="+str;
    xmlHttp.onreadystatechange=state_value;
    xmlHttp.open("GET",url,true);
    xmlHttp.send(null);
}
function state_value(){
    if (xmlHttp.readyState==4){
      var response=xmlHttp.responseText;
		document.getElementById('city_div').innerHTML=response;
	}
}
function getsubsubcat(str)
{
//alert(str);
	xmlHttp=GetXmlHttpObject()
    if (xmlHttp==null)
    {
          alert ("Your browser does not support AJAX!");
          return;
      }

	var url = SITEROOT+"/comman/show_subsubcategory.php";
    url=url+"?cnid="+str;
    xmlHttp.onreadystatechange=subcat_value;
    xmlHttp.open("GET",url,true);
    xmlHttp.send(null);
}
function subcat_value(){
    if (xmlHttp.readyState==4){
      var response=xmlHttp.responseText;
		document.getElementById('sub_div').innerHTML=response;
	}
}

function getsubsubsubcat(str)
{
//alert(str);
	xmlHttp=GetXmlHttpObject()
    if (xmlHttp==null)
    {
          alert ("Your browser does not support AJAX!");
          return;
      }

	var url = SITEROOT+"/comman/show_subsubsubcategory.php";
    url=url+"?cnid="+str;
    xmlHttp.onreadystatechange=subsubcat_value;
    xmlHttp.open("GET",url,true);
    xmlHttp.send(null);
}
function subsubcat_value(){
    if (xmlHttp.readyState==4){
      var response=xmlHttp.responseText;
		document.getElementById('subsub_div').innerHTML=response;
	}
}
 


</script>
{/literal}

{include file=$header2}

<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; <a href="{$siteroot}/admin/user/seller_list.php">Seller List</a>
 &gt;Add Seller</div>
<br />

<div class="holdthisTop">
    <h3>Add New Seller</h3><br/><br/>

    {if $msg}<div align="center" id="msg"><br/>{$msg}<br/></div>{/if}

    <form name="frmRegistration" id="frmRegistration" method="POST" action="" enctype="multipart/form-data">
        <input type="hidden" id="uid" name="uid" value="{$user.userid}"/>
        <table width="100%" border="0" cellspacing="2" cellpadding="3">
            <tr>
                <td align="right" valign="top"><span style="color:red">*</span> Email:</td>
                <td><input type="text" maxlength="70" size="25" name="email" id="email" class="textbox fl" value="{$user.email}" />
                 
                                            <div class="clr"></div>
                                            <div class="error" htmlfor="email" generated="true"></div>
                 </td>
            </tr>
            <tr>
                <td align="right" valign="top"> Password: </td>
                <td><input type="password" maxlength="15" size="25" name="password" id="password" class="textbox fl"/>
 
                
                                            <div class="clr"></div>
                                            Only enter if you want to reset pass.
                                            <div class="error" htmlfor="password" generated="true"></div>
                </td>
            </tr>
            <tr>
                <td align="right" valign="top" width="40%"><span style="color:red">*</span> First Name:</td>
                <td align="left" width="60%"><input name="first_name" type="text" id="first_name"  value="{$user.first_name}"  size="25" class="textbox fl"/>
                         
                            <div class="clr"></div>
                            <div class="error" htmlfor="first_name" generated="true"></div>
                </td>
            </tr>
		<tr>
			<td align="right" valign="top" width="40%"><span style="color:red">*</span> Last Name:</td>
			<td align="left" width="60%"><input name="last_name" type="text" id="last_name" value="{$user.last_name}"  size="25" class="textbox fl"/>
				
					<div class="clr"></div>
					<div class="error" htmlfor="last_name" generated="true"></div>
			</td>
		</tr>

            <tr>
			<td align="right" valign="top"><span style="color:red">*</span> Account Name:</td>
			<td><input type="text" maxlength="70" size="25" value="{$user.username}" name="username" id="username" class="textbox fl" />
				
				<div class="clr"></div>
				<div class="error" htmlfor="username" generated="true"></div>
			</td>
            </tr>


		<!--<tr>
			<td align="right" valign="top"><span style="color:red">*</span> Account Name:</td>
			<td><input type="text" maxlength="70" size="25" value="" name="username" id="username" class="textbox" /></td>
		</tr>
		<tr>
			<td align="right" valign="top"><span style="color:red">*</span> Business Name:</td>
			<td><input type="text" maxlength="70" size="25" value="" name="business_name" id="business_name" class="textbox fl" />
					<a class="tooltip_css fl" href="javascript:void(0);">
								<span class="classic_css">{tooltip label_id=61}</span>
					</a>
					<div class="clr"></div>
					<div class="error" htmlfor="business_name" generated="true"></div>
			</td>
		</tr>-->
           <!-- 
            <tr>
                <td align="right" valign="top" width="40%"> Title: </td>
                <td align="left" width="60%"><input name="title" type="text" id="title" value="" maxlength="50" size="25" class="textbox"/></td>
            </tr>-->
		<tr>
			<td align="right" valign="top"><span style="color:red">*</span> Business Name:</td>
			<td><input type="text" maxlength="70" size="25" value="" name="business_name" id="business_name" class="textbox fl" />
					<a class="tooltip_css fl" href="javascript:void(0);">
								<span class="classic_css">{tooltip label_id=61}</span>
					</a>
					<div class="clr"></div>
					<div class="error" htmlfor="business_name" generated="true"></div>
			</td>
		</tr>
            <tr>
                <td align="right" valign="top" width="40%"><span style="color:red">*</span> Address 1: </td>
                <td align="left" width="60%"><textarea id="address1" class="textbox fl" cols="33" rows="4" name="address1">{$user.address1}</textarea>
                  
                                        <div class="clr"></div>
                                        <div class="error" htmlfor="address1" generated="true"></div>
                   <!-- <input name="address" type="text" id="address" value="" maxlength="50" size="25" class="textbox"/>-->
                </td>
            </tr>

 <tr>
                <td align="right" valign="top" width="40%"><span style="color:red">*</span> Address 2: </td>
                <td align="left" width="60%"><textarea id="address2" class="textbox fl" cols="33" rows="4" name="address2">{$user.address2}</textarea>
                    
                                        <div class="clr"></div>
                                        <div class="error" htmlfor="address2" generated="true"></div>
                   <!-- <input name="address" type="text" id="address" value="" maxlength="50" size="25" class="textbox"/>-->
                </td>
            </tr>
            <!--<tr>
                <td align="right" valign="top" width="40%"> Address2: </td>
                <td align="left" width="60%"><input name="address2" type="text" id="address2" value="" maxlength="50" size="25" class="textbox"/></td>
            </tr>-->
            <tr>
                <td align="right" valign="top" ><span style="color:red">*</span>Town/City:</td>
                <td align="left" >
                <input name="city" type="text" id="city" maxlength="15" size="25" class="textbox fl"  value="{$user.city}"/> 
                    <!--<select name="city" id="city"  style='width:230px'>
                        <option value="">Please select</option>
                        {*if $city}
                        {section name=i loop=$city}
                        <option value="{$city[i].city_name}">{$city[i].city_name}</option>
                        {/section}
                        {else}
                        <option value="">Select City</option>
                        {/if*}
                    </select>-->
                   
                            <div class="clr"></div>
                            <div class="error" htmlfor="city" generated="true"></div>
                </td>
            </tr>
            <tr>
                <td align="right" valign="top" ><span style="color:red">*</span>Country:</td>
                <td align="left" >
                    <select name="county" id="county"   style="width:230px;" class="selectbox fl">
                        <option value="">Please select</option>
                        {if $country}
                        {section name=i loop=$country}
                        <option value="{$country[i].countryid}" {if $country[i].countryid eq $user.countryid} selected="selected"{/if} >{$country[i].country}</option>
                        {/section}
                        {else}
                        <option value="">Select Country</option>
                        {/if}
                    </select>
                  
                            <div class="clr"></div>
                            <div class="error" htmlfor="county" generated="true"></div>
                </td>
            </tr>
            <tr>
                <td align="right" valign="top" width="40%"><span style="color:red">*</span> Zip Code:</td>
                <td align="left" width="60%"><input name="zipcode" type="text" id="zipcode" value="" size="25"
                 maxlength="15" class="textbox fl"/>
                <a class="tooltip_css fl" href="javascript:void(0);">
                                            <span class="classic_css">{tooltip label_id=65}</span>
                            </a>
                            <div class="clr"></div>
                            <div class="error" htmlfor="zipcode" generated="true"></div>
                </td>
            </tr>
		 <tr>
                <td align="right" valign="top" width="40%"><span style="color:red">*</span>Phone Number:</td>
                <td align="left" width="60%"><input name="contact_detail" type="text" id="contact_detail" value="{$user.contact_detail}" size="25" maxlength="15" class="textbox fl"/>
               
                            <div class="clr"></div>
                            <div class="error" htmlfor="contact_detail" generated="true"></div>
                </td>
            </tr>

             <tr>
                <td align="right" valign="top" width="40%"><span style="color:red">*</span> Website URL: </td>
                <td align="left" width="60%"><input name="business_webURL" type="text" id="business_webURL" value="{$user.business_webURL}" maxlength="50" size="25" class="textbox fl"/>
               
                            <div class="clr"></div>
                            <div class="error" htmlfor="business_webURL" generated="true"></div>
                </td>
            </tr>


 <tr>
                <td align="right" valign="top" width="40%"><span style="color:red">*</span> About Us: </td>
                <td align="left" width="60%"><input name="about_us" type="text" id="about_us" value="{$user.about_us}" maxlength="50" size="25" class="textbox fl"/>
              
                            <div class="clr"></div>
                            <div class="error" htmlfor="about_us" generated="true"></div>
                </td>
            </tr>

<tr>
		<td align="right" valign="top"><span class="red">*</span> Select Category: </td>
		<td colspan="2" align="left">
			<!--<input type="text" name="category" id="category" class="textbox" autocomplete="off" onblur="setCat(this.value)"/>-->
			<select name="maincategory" id="maincategory" style="width:225px;" class="selectbox fl" onchange="javascript: getsubcat(this.value);">
			<!--<select name="maincategory" id="maincategory" style="width:180px;" class="selectbox">-->
				<option value="">--Select Main Category--</option>
				{section name=i loop=$category}
				<option value="{$category[i].id}" {if $user.deal_cat eq $category[i].id} selected='selected'{/if}>{$category[i].category}</option>
				{/section}
			</select>
			
                                             <div class="clr"></div>
                                              <div class="error" htmlfor="maincategory" generated="true"></div>
	      </td>
	  </tr>




















<tr>
	      <td align="right" valign="top"> Sub Category: </td>
	      <td colspan="2" align="left">
		 <!-- <input type="text" name="subcategory" id="subcategory" class="textbox" autocomplete="off" />-->
			<div id="city_div">
				<!--<select name="subcategory" id="subcategory"  class="selectbox fl" style="width:225px;" onchange="javascript: getsubsubcat(this.value);" >-->
			<select name="subcategory" id="subcategory"  class="selectbox fl" style="width:225px;">
					<option value="">--Select Sub Category--</option>
					{section name=i loop=$state_con}
						<option value="{$state_con[i].id}" {if $user.deal_subcat eq $state_con[i].id} selected='selected'{/if}>{$state_con[i].category}</option>
					{sectionelse}
					
					{/section}
				</select>
			</div>
			
                                             <div class="clr"></div>
                                             <div class="error" htmlfor="subcategory" generated="true"></div>
	      </td>
	  </tr>

	  <!--/////////////////////start-->
<!--	   <tr>
	      <td align="right" valign="top"> Sub Sub Category: </td>
	      <td colspan="2" align="left">
		
			<div id="sub_div">
				<select name="subsubcategory" id="subsubcategory"  class="selectbox fl" style="width:225px;" >
					<option value="">--Select Sub Sub-Category--</option>
					{section name=i loop=$state_con}
						<option value="{$state_con[i].id}"  selected="true" >{$state_con[i].state_name}</option>
					{sectionelse}
					
					{/section}
				</select>
			</div>
			<a class="tooltip_css fl" href="javascript:void(0);">
                                            <span class="classic_css">{tooltip label_id=8}</span></a>
                                             <div class="clr"></div>
                                             <div class="error" htmlfor="subsubcategory" generated="true"></div>
	      </td>
	  </tr>-->
	  
<!--	  <tr>
	      <td align="right" valign="top"> Sub Sub Sub Category: </td>
	      <td colspan="2" align="left">
		
			<div id="subsub_div">
				<select name="subsubsubcategory" id="subsubsubcategory"  class="selectbox fl" style="width:225px;" >
					<option value="">--Select SubSubSub-Category--</option>
					{section name=i loop=$state_con}
						<option value="{$state_con[i].id}"  selected="true" >{$state_con[i].state_name}</option>
					{sectionelse}
					
					{/section}
				</select>
			</div>
			<a class="tooltip_css fl" href="javascript:void(0);">
                                            <span class="classic_css">{tooltip label_id=9}</span></a>
                                             <div class="clr"></div>
                                             <div class="error" htmlfor="subsubsubcategory" generated="true"></div>
	      </td>
	  </tr>-->


	  <!--/////////////////////end-->

		<tr>
                <td align="right" valign="top" width="40%"><span style="color:red">*</span> Specility: </td>
                <td align="left" width="60%"><input name="specility" type="text" id="specility" value="{$user.specility}" maxlength="50" size="25" class="textbox fl"/>
               
                            <div class="clr"></div>
                            <div class="error" htmlfor="specility" generated="true"></div>
                </td>
            </tr>


			<tr height="25">
					<td valign="top" align="right"><span class="red">*</span> Business: </td>
					<td align="left" valign="top" style="float:left;">

				<span  style="float:left;">From
						<select name="start_hour" id="start_hour">
							{section name=i loop=$hr}
							<option value="{$hr[i]}" {if $s_hr eq $hr[i]} selected="selected" {/if}>{$hr[i]}</option>
							{/section}
							</select>&nbsp;&nbsp;&nbsp;
							<select name="start_min" id="start_min">
							{section name=i loop=$min}
							<option value="{$min[i]}" {if $s_min eq $min[i]} selected="selected" {/if}>{$min[i]}</option>
							{/section}
						</select>
				</span>
		

				<span  style="float:left;">To
						<select name="end_hour" id="end_hour">
							{section name=i loop=$rev_hr}
							<option value="{$rev_hr[i]}" {if $e_hr eq $rev_hr[i]} selected="selected" {/if}>{$rev_hr[i]}</option>
							{/section}
							</select>&nbsp;&nbsp;&nbsp;
							<select name="end_min" id="end_min">
							{section name=i loop=$rev_min}
							<option value="{$rev_min[i]}" {if $e_min eq $rev_min[i]} selected="selected" {/if}>{$rev_min[i]}</option>
							{/section}
						</select>
				</span>Week Days
					 
                            <div class="clr"></div>
					</td>

				</tr>


			<tr height="25">
					<td valign="top" align="right">  </td>
					<td align="left" valign="top" style="float:left;"> 				

				<span  style="float:left;">From
						<select name="start_hour1" id="start_hour1">
							{section name=i loop=$hr}
							<option value="{$hr[i]}" {if $s_hr1 eq $hr[i]} selected="selected" {/if}>{$hr[i]}</option>
							{/section}
							</select>&nbsp;&nbsp;&nbsp;
							<select name="start_min1" id="start_min1">
							{section name=i loop=$min}
							<option value="{$min[i]}" {if $s_min1 eq $min[i]} selected="selected" {/if}>{$min[i]}</option>
							{/section}
						</select>
				</span>

				<span  style="float:left;">To
						<select name="end_hour1" id="end_hour1">
							{section name=i loop=$rev_hr}
							<option value="{$rev_hr[i]}" {if $e_hr1 eq $rev_hr[i]} selected="selected" {/if}>{$rev_hr[i]}</option>
							{/section}
							</select>&nbsp;&nbsp;&nbsp;
							<select name="end_min1" id="end_min1">
							{section name=i loop=$rev_min}
							<option value="{$rev_min[i]}" {if $e_min1 eq $rev_min[i]} selected="selected" {/if}>{$rev_min[i]}</option>
							{/section}
						</select>
				</span>Sat/Sun
					 

                            <div class="clr"></div>

					</td>

				</tr>
			

<input type="hidden" name="uid" id="uid" value="{$user.userid}">
		<tr>
                <td align="right" valign="top" width="40%"><span style="color:red"></span> Upload menu/price list: </td>
                <td align="left" width="60%"><input name="price_menu_list" type="file" id="price_menu_list" value="" class="textbox fl"/>
              
                            <div class="clr"></div>
                            <div class="error" htmlfor="price_menu_list" generated="true"></div>
                </td>
            </tr>


		<tr>
                <td align="right" valign="top" width="40%"> Upload Photos: </td>
                <td align="left" width="60%"><!--<input name="photo" type="file" id="photo" value="" class="textbox fl"/>-->

<input type="button" style="float: left;" name="add" id="add" value="Upload Image(s)" onclick="javascript:tb_show('Upload Image(s)', '{$siteroot}/admin/user/uploadmain-admin.php?&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=500&width=720&modal=false', tb_pathToImage);">

               
                            <div class="clr"></div>
                            <div class="error" htmlfor="photo" generated="true"></div>
                </td>
            </tr>


	<!--<tr>
                <td align="right" valign="top" > Company Type:</td>
                <td align="left" >
                <div class="fl chksec">
                 {*section name=i loop=$seller1}
                   <label><input type="radio" name="company_type"  value="{$seller1[i].seller_type_id}" /> {$seller1[i].seller_type_name}</label> <br>
                 {/section*}
                </div>
                </td>
           </tr>-->
           <!-- <tr>
                <td align="right" valign="top" width="40%"> Limited Company Or PIC:</td>
                <td align="left" width="60%"><input name="limited_comp" type="text" id="limited_comp" value="" size="25" maxlength="100" class="textbox"/>
                </td>
            </tr>
            <tr>
                <td align="right" valign="top" width="40%"> Vat Registration No.:</td>
                <td align="left" width="60%"><input name="vat_reg" type="text" id="vat_reg" value="" size="25" maxlength="15" class="textbox"/>
                </td>
            </tr>
            <tr>
                <td align="right" valign="top" width="40%"> Describe Your Activities:</td>
                <td align="left" width="60%"><input name="activity" type="text" id="activity" value="" size="25" class="textbox" maxlength="100"/>
                </td>
            </tr>-->

           <!-- <tr>
                <td colspan="2" align="middle"><b style="color:black;"><b>Subscription Packages:</b></div></td>
            </tr>
            <tr>
               <td colspan="2" align="middle">
                                   <div class="packegname">
					<table class="packages">
						<tr>
							<td width="300"><strong>Package Name</strong></td>
							{*section name=i loop=$subscriptionData}
							<td width="100"><strong>{$subscriptionData[i].pack_name}</strong></td>
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
							<td>{$subscriptionData[i].pack_price}</td>
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
							<td>{$subscriptionData[i].pack_duration}</td>
							{/section}
						</tr>
						<tr>
							<td><strong>Select Any One :</strong></td>
							{section name=i loop=$subscriptionData}
							<td><span class="radiobtn"><input type="radio" value="{$subscriptionData[i].id}" id="subscription" name="subscription" /></span></td>
							{/section}
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td colspan="{$subscriptionData|@count*}">
								<div class="clr"></div>
								<div class="error" htmlfor="subscription" generated="true" ></div>
							</td>
						</tr>
					</table>
                                    </div>
               
               </td>
            </tr>-->
            <tr>
                <td>&nbsp;</td>
                <td align="left">
                    <input type="submit" name="Submit" id="Submit" value="Save" class="" />&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="button" value="Cancel" onclick="javascript: location='seller_list.php'" class="" />
                </td>
            </tr>
        </table>
    </form>
</div>
{include file=$footer}