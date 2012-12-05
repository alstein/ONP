{include file=$header_start}
{strip}
<script type="text/javascript" src="{$sitejs}/jquery.validate.pack.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/editseller.js"></script>
<script language="javascript" type="text/javascript" src="{$siteroot}/js/calendarDateInput.js"> </script>
{/strip}
{literal}
<script language="javascript" type="text/javascript">
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

    var url = SITEROOT+"/admin/globalsettings/deal/show_states_admin.php";
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

    var url = SITEROOT+"/admin/globalsettings/deal/show_cities_admin.php";
    url=url+"?stid="+str;
    xmlHttp.onreadystatechange=city_value;
    xmlHttp.open("GET",url,true);
    xmlHttp.send(null);
}

function city_value(){
    if (xmlHttp.readyState==4){
      var response=xmlHttp.responseText;
		document.getElementById('city').innerHTML=response;
	}
}


function setflag(values)
{
   
 if(values==3)
 {
       document.getElementById("sellerflag1").style.display='block';
    document.getElementById("sellerflag2").style.display='block';

 }
 if(values==2)
 {
       document.getElementById("sellerflag1").style.display='none';
    document.getElementById("sellerflag2").style.display='none';

 }

}
</script>
{/literal}
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
	<h2 style="margin-left:20px;color: #2B587A" >Edit Profile</h2><br>
         <form name="frmRegistration" id="frmRegistration" action="" method="post">
  
    <table width="100%" border="0" cellspacing="2" cellpadding="3">
            <tr>
                <td align="right" valign="top"  style="width:175px;" class="profile-name"><span style="color:red">*</span> Email:</td>
                <td><input type="text" maxlength="70" size="25" name="email" id="email" class="textbox fl" value="{$user.email}" />
                 
                                            <div class="clr"></div>
                                            <div class="error" htmlfor="email" generated="true"></div>
                 </td>
            </tr>
            <tr>
                <td align="right" valign="top"  style="width:175px;" class="profile-name" > Password: </td>
                <td><input type="password" maxlength="15" size="25" name="password" id="password" class="textbox fl"/>
 
                
                                            <div class="clr"></div>
                                            Only enter if you want to reset pass.
                                            <div class="error" htmlfor="password" generated="true"></div>
                </td>
            </tr>
            <tr>
                <td align="right" valign="top" width="40%"  style="width:175px;" class="profile-name"><span style="color:red">*</span> First Name:</td>
                <td align="left" width="60%"><input name="first_name" type="text" id="first_name"  value="{$user.first_name}"  size="25" class="textbox fl"/>
                         
                            <div class="clr"></div>
                            <div class="error" htmlfor="first_name" generated="true"></div>
                </td>
            </tr>
		<tr>
			<td align="right" valign="top" width="40%"  style="width:175px;" class="profile-name"><span style="color:red">*</span> Last Name:</td>
			<td align="left" width="60%"><input name="last_name" type="text" id="last_name" value="{$user.last_name}"  size="25" class="textbox fl"/>
				
					<div class="clr"></div>
					<div class="error" htmlfor="last_name" generated="true"></div>
			</td>
		</tr>

            <tr>
			<td align="right" valign="top"  style="width:175px;" class="profile-name"><span style="color:red">*</span> Account Name:</td>
			<td><input type="text" maxlength="70" size="25" value="{$user.username}" name="username" id="username" class="textbox fl" />
				
				<div class="clr"></div>
				<div class="error" htmlfor="username" generated="true"></div>
			</td>
            </tr>

		<tr>
			<td align="right" valign="top"  style="width:175px;" class="profile-name" ><span style="color:red">*</span> Business Name:</td>
			<td><input type="text" maxlength="70" size="25" value="" name="business_name" id="business_name" class="textbox fl" />
					
					<div class="clr"></div>
					<div class="error" htmlfor="business_name" generated="true"></div>
			</td>
		</tr>
            <tr>
                <td align="right" valign="top" width="40%"  style="width:175px;" class="profile-name"><span style="color:red">*</span> Address 1: </td>
                <td align="left" width="60%"><textarea id="address1" class="textbox fl" cols="33" rows="4" name="address1">{$user.address1}</textarea>
                  
                                        <div class="clr"></div>
                                        <div class="error" htmlfor="address1" generated="true"></div>
                  </td>
            </tr>

 <tr>
                <td align="right" valign="top" width="40%"  style="width:175px;" class="profile-name" ><span style="color:red">*</span> Address 2: </td>
                <td align="left" width="60%"><textarea id="address2" class="textbox fl" cols="33" rows="4" name="address2">{$user.address2}</textarea>
                    
                                        <div class="clr"></div>
                                        <div class="error" htmlfor="address2" generated="true"></div>
                   </td>
            </tr>
          
            <tr>
                <td align="right" valign="top"  style="width:175px;" class="profile-name"><span style="color:red">*</span>Town/City:</td>
                <td align="left" >
                <input name="city" type="text" id="city" maxlength="15" size="25" class="textbox fl"  value="{$user.city}"/> 
                  <div class="clr"></div>
                            <div class="error" htmlfor="city" generated="true"></div>
                </td>
            </tr>
            <tr>
                <td align="right" valign="top"  style="width:175px;" class="profile-name"><span style="color:red">*</span>Country:</td>
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
                <td align="right" valign="top" width="40%"  style="width:175px;" class="profile-name"><span style="color:red">*</span> Zip Code:</td>
                <td align="left" width="60%"><input name="zipcode" type="text" id="zipcode" value="" size="25"
                 maxlength="15" class="textbox fl"/>
              
                            <div class="clr"></div>
                            <div class="error" htmlfor="zipcode" generated="true"></div>
                </td>
            </tr>
		 <tr>
                <td align="right" valign="top" width="40%"  style="width:175px;" class="profile-name"><span style="color:red">*</span>Phone Number:</td>
                <td align="left" width="60%"><input name="contact_detail" type="text" id="contact_detail" value="{$user.contact_detail}" size="25" maxlength="15" class="textbox fl"/>
               
                            <div class="clr"></div>
                            <div class="error" htmlfor="contact_detail" generated="true"></div>
                </td>
            </tr>

             <tr>
                <td align="right" valign="top" width="40%"  style="width:175px;" class="profile-name"><span style="color:red">*</span> Website URL: </td>
                <td align="left" width="60%"><input name="business_webURL" type="text" id="business_webURL" value="{$user.business_webURL}" maxlength="50" size="25" class="textbox fl"/>
               
                            <div class="clr"></div>
                            <div class="error" htmlfor="business_webURL" generated="true"></div>
                </td>
            </tr>


 <tr>
                <td align="right" valign="top" width="40%"  style="width:175px;" class="profile-name"><span style="color:red">*</span> About Us: </td>
                <td align="left" width="60%"><input name="about_us" type="text" id="about_us" value="{$user.about_us}" maxlength="50" size="25" class="textbox fl"/>
              
                            <div class="clr"></div>
                            <div class="error" htmlfor="about_us" generated="true"></div>
                </td>
            </tr>

<tr>
		<td align="right" valign="top"  style="width:175px;" class="profile-name"><span class="red">*</span> Select Category: </td>
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
	      <td align="right" valign="top"  style="width:175px;" class="profile-name"> Sub Category: </td>
	      <td colspan="2" align="left" >
		
			<div id="city_div">
				
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

		<tr>
                <td align="right" valign="top" width="40%"  style="width:175px;" class="profile-name" ><span style="color:red">*</span> Specility: </td>
                <td align="left" width="60%"><input name="specility" type="text" id="specility" value="{$user.specility}" maxlength="50" size="25" class="textbox fl"/>
               
                            <div class="clr"></div>
                            <div class="error" htmlfor="specility" generated="true"></div>
                </td>
            </tr>


			<tr height="25">
					<td valign="top" align="right" style="color: #2B587A;"><span class="red">*</span> <strong>Business:</strong> </td>
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
                <td align="right" valign="top" width="40%"  style="width:175px;" class="profile-name"><span style="color:red"></span> Upload menu/price list: </td>
                <td align="left" width="60%"><input name="price_menu_list" type="file" id="price_menu_list" value="" class="textbox fl"/>
              
                            <div class="clr"></div>
                            <div class="error" htmlfor="price_menu_list" generated="true"></div>
                </td>
            </tr>


		<tr>
                <td align="right" valign="top" width="40%"  style="width:175px;" class="profile-name" > Upload Photos: </td>
                <td align="left" width="60%"><!--<input name="photo" type="file" id="photo" value="" class="textbox fl"/>-->

<input type="button" style="float: left;" name="add" id="add" value="Upload Image(s)" onclick="javascript:tb_show('Upload Image(s)', '{$siteroot}/admin/user/uploadmain-admin.php?&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=500&width=720&modal=false', tb_pathToImage);">

               
                            <div class="clr"></div>
                            <div class="error" htmlfor="photo" generated="true"></div>
                </td>
            </tr>



            <tr>
                <td>&nbsp;</td>
                <td align="left">
		<span class="sitesub-btn-lft"><span class="sitesub-btn-right">
		<input class="loc_busines fl" type="submit" name="Submit" id="Submit" value="Save" class=""/>
		</span></span>
		<span style="margin-left:10px;" class="sitesub-btn-lft"><span class="sitesub-btn-right">
		<input  class="loc_busines fl" type="button" value="Cancel" onclick="javascript: location='seller_list.php'" class=""/>
		</span></span>
                   
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

