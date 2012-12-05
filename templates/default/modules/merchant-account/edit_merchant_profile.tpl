{include file=$header_start}
{strip}
<script type="text/javascript" src="{$sitejs}/jquery.validate.pack.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/edit_merchant.js"></script>
<script language="javascript" type="text/javascript" src="{$siteroot}/js/calendarDateInput.js"> </script>
{/strip}
{literal}
<script language="JavaScript">
$(document).ready(function(){
	if($("#temp_addr").val()=='NA'){

	}else{
		$("#add2").show();
		$("#add3").show();
		$("#add4").show();
		$("#add5").show();
	}
});

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
	$("#subcategory").width('200px');	
	}
}


function show_address()
{

	if(!(document.getElementById('chk_outlet').checked))
	{
		$("#add2").hide();
		$("#add3").hide();
		$("#add4").hide();
		$("#add5").hide();
	}
	else  
	{   
		$("#add2").show();
		$("#add3").show();
		$("#add4").show();
		$("#add5").show();
	}

}
function terminate_account(val)
{

	cmt_url = SITEROOT+"/modules/merchant-account/ajax_terminate_account.php";
		jQuery.get(cmt_url,{userid:val},function(data)
		{
			window.location.href=SITEROOT;	
		})
}
</script>
{/literal}
{if $smarty.session.csUserId neq ''}
{include file=$profile_header2}
{else}
{include file=$header_end}
{/if}

  <!-- Header ends -->
  <!-- Maincontent starts -->
  <div id="maincont" class="ovfl-hidden">
    <table width="1000" border="0" cellpadding="0" cellspacing="0" class="profile-tbl">
      <tr>
        <!-- Profile Left Section Start -->
         {include file=$merchant_home_left}

        <!-- Profile Left Section End -->
        <!-- Profile Middle Section Start -->
        <td width="560" valign="top"><!-- Profile Comment Section Start -->
          <div class="maincont-inner-mid fl">
            <div class="edit-profile-form">
              <h1 class=" form-title">Edit Profile</h1>
<form name="frmRegistration" id="frmRegistration" action="" method="post" enctype="multipart/form-data" >
<input type="hidden" name="userid" id="userid" value="{$smarty.session.csUserId}" />
<input type="hidden" name="uid" id="uid" value="{$smarty.session.csUserId}" />
              <ul class="reset user-edit-form">
				<div align="center" class="success" style="margin:10px">{$msg}</div>
               
                <li>
                  <label>Email<span>*</span></label>
                  <div class="fl form-textbox">
                  <input type="text" maxlength="70" size="25" name="email" id="email" class="signinput" value="{$user.email}" />
                  </div>
                  <div class="clr"></div>
                </li>

                <li>
                  <label>Change Password<span></span></label>
                  <div class="fl form-textbox">
                   <input type="password" maxlength="15" size="25" name="password" id="password" class="signinput"/>
                  </div>
                  <div class="clr"></div>
                </li>
				<li>
                  <label> Re-type New Password:<span>*</span></label>
                  <div class="fl form-textbox">
                     <input  type="password" maxlength="15" size="25" name="new_password" id="new_password" />
                  </div>
					
                  <div class="clr"></div>
				<div style="width: 500px; margin-left: 166px;" generated="true" htmlfor="new_password" class="error"></div>
                </li>
  				<li>
                  <label>Business Name:<span></span></label>
                  <div class="fl form-textbox">
                   <input type="text" maxlength="70" size="25" value="{$user.business_name}" name="business_name" id="business_name" class="signinput" />
                  </div>
                  <div class="clr"></div>
                </li>

				<li>
                  <label>Contact Person Name:<span></span></label>
                  <div class="fl form-textbox">
                  <input type="text" maxlength="70" size="25" value="{$user.contact_person}" name="contact_person" id="contact_person" class="signinput" />
                  </div>
                  <div class="clr"></div>
                </li>

				<li>
                  <label style="width:127px">&nbsp;</label>
                  <div class="fl" style="margin-left:30px;">
                <input type="checkbox" name="chk_outlet" id="chk_outlet" value="yes" onClick="javascript:show_address();" {if $user.address2 neq ''} checked="checked"{/if} style="margin-right:10px;"><span>We have multiple outlets</span>
                  </div>
                  <div class="clr"></div>
                </li>



				<li>
                  <label>Address 1 (Street):<span></span></label>
                  <div class="fl form-textbox">
                  <input type="text" maxlength="70" size="25" value="{$user.address1}" name="address1" id="address1" class="signinput" />
                  </div>
                  <div class="clr"></div>
                </li>


				<li>
                  <label>Address 2 (Building/Unit):<span></span></label>
                  <div class="fl form-textbox">
                		<input type="text" maxlength="70" size="25" value="{$user.concat_address}" name="concat_address" id="concat_address" class="signinput" />
                  </div>
                  <div class="clr"></div>
                </li>





<input type="hidden" name="temp_addr" id="temp_addr" value="{if $user.address2 neq ''}{$user.address2}{else}NA{/if}">
<div id="div_address" style="display:block;">
				<li style="display:none" id="add2">
                  <label>Address2:<span></span></label>
                  <div class="fl form-textbox">
                		<input type="text" maxlength="70" size="25" value="{$user.address2}" name="address2" id="address2" class="signinput" />
                  </div>
                  <div class="clr"></div>
                </li>
				<li style="display:none" id="add3">
                  <label>Address 3:<span></span></label>
                  <div class="fl form-textbox">
                		<input type="text" maxlength="70" size="25" value="{$user.address3}" name="address3" id="address3" class="signinput" />
                  </div>
                  <div class="clr"></div>
                </li>

				<li style="display:none" id="add4">
                  <label>Address 4:<span></span></label>
                  <div class="fl form-textbox">
                		<input type="text" maxlength="70" size="25" value="{$user.address4}" name="address4" id="address4" class="signinput" />
                  </div>
                  <div class="clr"></div>
                </li>

				<li style="display:none" id="add5">
                  <label>Address 5:<span></span></label>
                  <div class="fl form-textbox">
                		<input type="text" maxlength="70" size="25" value="{$user.address5}" name="address5" id="address5" class="signinput" />
                  </div>
                  <div class="clr"></div>
                </li>
</div>



			<li>
                  <label>Country:<span></span></label>
                  <div class="fl form-textbox">
                		<input type="text" maxlength="70" size="25" value="Singapore" class="signinput"  readonly="true" id="countryid" name="countryid"/>
                  </div>
                  <div class="clr"></div>
                </li>


			<li>
                  <label>city:<span></span></label>
                  <div class="fl form-textbox">
                		<input type="text" maxlength="70" size="25" value="Singapore" class="signinput"  readonly="true" name="cityid" id="cityid"/>
                  </div>
                  <div class="clr"></div>
                </li>


			<li>
                  <label>Phone:<span></span></label>
                  <div class="fl form-textbox">
                		<input name="contact_detail" type="text" id="contact_detail" value="{$user.contact_detail}" size="25" maxlength="15" class="signinput"/>
                  </div>
                  <div class="clr"></div>
                </li>


			<li>
                  <label>Website:<span></span></label>
                  <div class="fl form-textbox">
                		<input name="business_webURL" type="text" id="business_webURL" value="{$user.business_webURL}" maxlength="50" size="25" class="signinput"/>
                  </div>
                  <div class="clr"></div>
                </li>

			<li>
                  <label> About Your Business: <span></span></label>
                  <div class="fl add-txt ">
                		<textarea name="about_us" id="about_us" cols="30" rows="4" class="add-txt-in">{$user.about_us}</textarea>
                  </div>
                  <div class="clr"></div>
                </li>

			<li>
                  <label> Category: <span></span></label>
                  <div class="category-bg  fl">
                		<select name="maincategory" id="maincategory" onChange="javascript: getsubcat(this.value);" class="select">
								<option value="">--Select Main Category--</option>
								{section name=i loop=$category}
										<option value="{$category[i].id}" {if $user.deal_cat eq $category[i].id }  selected="selected" {/if} >{$category[i].category}</option>
								{/section}
						</select>
                  </div>				
                  <div class="clr"></div>
					<div htmlfor="maincategory" generated="true" class="error" style="display: block;"></div>
           </li>

			<li>
                  <label> Sub Category:  <span></span></label>
                  <div class="category-bg  fl" id="city_div">
                		<select name="subcategory" id="subcategory"  class="select">
							{section name=i loop=$state_con}
								<option value="{$state_con[i].id}" {if $user.deal_subcat eq $state_con[i].id} selected='selected'{/if}>{$state_con[i].category}</option>
							{sectionelse}
							{/section}
						</select>
                  </div>
                  <div class="clr"></div>
				<div htmlfor="subcategory" generated="true" class="error" style="display: block;"></div>
           </li>


			<li>
                  <label>Specility:<span></span></label>
                  <div class="fl form-textbox">
                		<input name="specility" type="text" id="specility" value="{$user.specility}" size="25"
                 maxlength="15" class="signinput"/>
                  </div>
                  <div class="clr"></div>
                </li>



<li>
        <label>Business Hours:</label>
        <div class="fl" >
          <table width="400" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="50" style="border-right:none"> from </td>
              <td width="50"  style="border-right:none"><div class="date-bg fl">
                 <select name="start_hour" id="start_hour" style="width:42px" class="select">
						{section name=i loop=$hr}
							<option value="{$hr[i]}" {if $s_hr eq $hr[i]} selected="selected" {/if}>{$hr[i]}</option>
						{/section}
				</select>
                </div></td>
              <td width="50"  style="border-right:none"><div class="date-bg fl">
					<select name="start_min" id="start_min" style="width:42px;" class="select">
							{section name=i loop=$min}
									<option value="{$min[i]}" {if $s_min eq $min[i]} selected="selected" {/if}>{$min[i]}</option>
							{/section}
					</select>
                </div></td>
              <td width="50" align="center" style="border-right:none"> to </td>
              <td width="50"  style="border-right:none"><div class="date-bg fl">
                 <select name="end_hour" id="end_hour" style="width:42px;" class="select">
						{section name=i loop=$rev_hr}
							<option value="{$rev_hr[i]}" {if $e_hr eq $rev_hr[i]} selected="selected" {/if}>{$rev_hr[i]}</option>
						{/section}
				</select>
                </div></td>
              <td width="50"  style="border-right:none"><div class="date-bg fl">
                  <select name="end_min" id="end_min" style="width:42px;" class="select">
							{section name=i loop=$rev_min}
									<option value="{$rev_min[i]}" {if $e_min eq $rev_min[i]} selected="selected" {/if}>{$rev_min[i]}</option>
							{/section}
					</select>
                </div></td>
              <td width="300" align="center" style="border-right:none"> Monday To Friday </td>
            </tr>
            <tr>
              <td width="30" style="border-right:none"> from </td>
              <td width="50"  style="border-right:none"><div class="date-bg fl">
                 <select name="start_hour1" id="start_hour1" style="width:42px;" class="select">
					{section name=i loop=$hr}
							<option value="{$hr[i]}" {if $s_hr1 eq $hr[i]} selected="selected" {/if}>{$hr[i]}</option>
					{/section}
				</select>
                </div></td>
              <td width="50"  style="border-right:none"><div class="date-bg fl">
                  <select name="start_min1" id="start_min1" style="width:42px;" class="select">
					{section name=i loop=$min}
							<option value="{$min[i]}" {if $s_min1 eq $min[i]} selected="selected" {/if}>{$min[i]}</option>
					{/section}
				</select>
                </div></td>
              <td width="50" align="center" style="border-right:none"> to </td>
              <td width="50"  style="border-right:none"><div class="date-bg fl">
                <select name="end_hour1" id="end_hour1" style="width:42px;" class="select"> 
						{section name=i loop=$rev_hr}
							<option value="{$rev_hr[i]}" {if $e_hr1 eq $rev_hr[i]} selected="selected" {/if}>{$rev_hr[i]}</option>
						{/section}
				</select>
                </div></td>
              <td width="50"  style="border-right:none"><div class="date-bg fl">
                  <select name="end_min1" id="end_min1" style="width:42px;" class="select">
					{section name=i loop=$rev_min}
							<option value="{$rev_min[i]}" {if $e_min1 eq $rev_min[i]} selected="selected" {/if}>{$rev_min[i]}</option>
					{/section}
					</select>
                </div></td>
              <td width="300" align="center" style="border-right:none"> Saturday & Sunday </td>
            </tr>
          </table>
        </div>
        <div class="clr"></div>
      </li>



			<li>
                  <label>Upload menu/price list:<span></span></label>
                  <div class="fl" style="margin-left:32px;">
                		<input name="price_menu_list" type="file" id="price_menu_list" value="" class="signinput" contentEditable="false"/>
                  </div>
                  <div class="clr"></div>
                </li>






                <li>
                <label>&nbsp;</label>
                <div class="fl" style="margin:15px 0 0 30px">
					<input class="previe-btn" style="width:72px" type="submit" name="Submit" id="Submit" value="Save"/>
           		 </div>
      			<div class="fl" style="margin:15px 0 0 10px">
					<input  class="previe-btn"  type="button" value="Cancel" onclick="javascript: location='{$siteroot}'"/>
     			 </div>
                </li>

 				<li>
					<label>&nbsp;</label>
					<a href="javascript:void(0);" onclick="javascript:terminate_account('{$smarty.session.csUserId}');" class="fl termi-txt">Terminate Account</a>
                </li>

              </ul>
		</form>
            </div>
            <div class="clr" style="height:30px"></div>
          </div>
          <!-- Profile Comment Section End --></td>
        <!-- Profile Middle Section End -->
        <!-- Profile Right Section Start -->
        
 {include file=$merchant_home_right}
        <!-- Profile Right Section End -->
      </tr>
    </table>
  </div>
  <!-- Maincontent ends -->

<!-- Footer starts -->
 {include file=$footer}
