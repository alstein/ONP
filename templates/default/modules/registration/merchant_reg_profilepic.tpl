{include file=$header_start}
{strip}
<script type="text/javascript" src="{$sitejs}/validation/merchant_profile_pic.js"></script>
<script type="text/javascript" src="{$sitejs}/lightbox.js"></script>
<link rel="stylesheet" type="text/css" href="{$siteroot}/templates/default/css/lightbox.css" >
{/strip}
{literal}
<script type="text/javascript" language="JavaScript">
$(function(){
$('.select1').customStyle();
});
</script>
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
$('.select1').customStyle();
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


</script>
{/literal}
<!-- main continer of the page -->
{include file=$header_end}
<!-- Header ends -->
<!-- Maincontent starts -->
<form method="POST" name="frm_profilepic" id="frm_profilepic" enctype="multipart/form-data">
<div id="maincont" class="ovfl-hidden">
<div class="creat-deal">
<h1>Local Business Registration</h1>
<div class="profile-thumb1">
  <div class="profile-thumb1-lft fl">
    <h1>Step 1</h1>
    <p>Profile Info</p>
  </div>
  <div class="profile-thumb1-lft fl tabs">
    <h1 style=" color: #FFFFFF;font-size: 18px;margin: 5px 0;">Step 2</h1>
    <p style=" font: 13px Arial,Helvetica,sans-serif;text-align: center;color:#fff">Business Info</p>
  </div>
  <!--<div class="profile-thumb1-lft fl">
    <h1>Step 3</h1>
    <p>Deal Eligibility</p>
  </div>-->
  <div class="clr"></div>
</div>
<form method="POST" name="frm" id="frm" action="">
  <div class="registration-form" style="width:624px">
    <ul class="reset deal-from">
      <li>
        <label>About Our Business:</label>
        <div class="fl add-txt " style="margin-left: 30px;">
          <textarea name="about_business" id="about_business" cols="25" rows="4" class="add-txt-in"></textarea>
          <br/>
          Max 800 Characters </div>
        <div class="clr"></div>
      </li>
      <li>
        <label>Category:</label>
        <div class="category-bg  fl">
          <select style="width:178px;" class="select"  name="maincategory" id="maincategory"  onchange="javascript: getsubcat(this.value);">
            <option value="">--Select Main Category--</option>
				{section name=i loop=$category}
            			<option value="{$category[i].id}">{$category[i].category}</option>
				{/section}
          </select>
        </div>
     
        <div class="clr"></div>
		<div htmlfor="maincategory" generated="true" class="error" style="text-align:center;padding-right:100px;"></div>
      </li>
      <li>
        <label>Sub Category:</label>
        <div id="city_div" class="category-bg fl" >
          <select style="width:178px; background:url(../images/select-arrow.png) no-repeat right center; display:block; height:19px; font-size:12px; color:#333333" class="select">
             <option value="">--Select Sub Category--</option>
			{section name=i loop=$state_con}						
          		  <option value="{$state_con[i].id}" >{$state_con[i].state_name}</option>
					{sectionelse}
					{/section}
          </select>
        </div>
  
        <div class="clr"></div>
      </li>
      <li>
        <label>Speciality:</label>
        <div class="fl textbox">
          <input name="speciality" id="speciality" type="text" style="width:220px;"/>
        </div>

  <ul class="reset icn-link" style="padding:0px; margin:20px 0 10px 50px">

        <li style="margin-left:15px;"><a href="javascript:void(0)" class="icn-link01 ">What's it?</a>

        <div class="tooltip">

        <span class="arrow">&nbsp;</span>

        <div class="top01"><div></div></div>

       <div class="mid" style="padding-bottom:5px">Tell people what you do best.</div>

       <div class="bot01"><div></div></div>

        </div>

        </li>

        

        </ul>
        <div class="clr"></div>
      </li>
      <li>
        <label>Business Hours:</label>
        <div class="fl" style="margin-left:30px">
          <table width="400" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="50"> from </td>
              <td width="50"><div class="date-bg fl">
                  <select class="select" name="start_hour" id="start_hour">
                  {section name=i loop=$hr}
						<option value="{$hr[i]}" {if $s_hr eq $hr[i]} selected="selected" {/if}>{$hr[i]}</option>
					{/section}
                  </select>
                </div></td>
              <td width="50"><div class="date-bg fl">
                  <select class="select"  name="start_min" id="start_min">
					{section name=i loop=$min}
						<option value="{$min[i]}" {if $s_min eq $min[i]} selected="selected" {/if}>{$min[i]}</option>
					{/section}
                  </select>
                </div></td>
              <td width="50" align="center"> to </td>
              <td width="50"><div class="date-bg fl">
                  <select class="select" name="end_hour" id="end_hour">
					{section name=i loop=$rev_hr}
						<option value="{$rev_hr[i]}" {if $e_hr eq $rev_hr[i]} selected="selected" {/if}>{$rev_hr[i]}</option>
					{/section}
                  </select>
                </div></td>
              <td width="50"><div class="date-bg fl">
                  <select class="select"  name="end_min" id="end_min">
					{section name=i loop=$rev_min}
						<option value="{$rev_min[i]}" {if $e_min eq $rev_min[i]} selected="selected" {/if}>{$rev_min[i]}</option>
					{/section}
                  </select>
                </div></td>
              <td width="300" align="center"> Monday To Friday </td>
            </tr>
            <tr>
              <td width="30"> from </td>
              <td width="50"><div class="date-bg fl">
                  <select class="select" name="start_hour1" id="start_hour1">
					{section name=i loop=$hr}
						<option value="{$hr[i]}" {if $s_hr eq $hr[i]} selected="selected" {/if}>{$hr[i]}</option>
					{/section}
                  </select>
                </div></td>
              <td width="50"><div class="date-bg fl">
                  <select class="select" name="start_min1" id="start_min1">
					{section name=i loop=$min}
							<option value="{$min[i]}" {if $s_min eq $min[i]} selected="selected" {/if}>{$min[i]}</option>
					{/section}
                  </select>
                </div></td>
              <td width="50" align="center"> to </td>
              <td width="50"><div class="date-bg fl">
                  <select class="select" name="end_hour1" id="end_hour1">
					{section name=i loop=$rev_hr}
							<option value="{$rev_hr[i]}" {if $e_hr eq $rev_hr[i]} selected="selected" {/if}>{$rev_hr[i]}</option>
					{/section}
                  </select>
                </div></td>
              <td width="50"><div class="date-bg fl">
                  <select class="select"  name="end_min1" id="end_min1">
					{section name=i loop=$rev_min}
							<option value="{$rev_min[i]}" {if $e_min eq $rev_min[i]} selected="selected" {/if}>{$rev_min[i]}</option>
					{/section}
                  </select>
                </div></td>
              <td width="300" align="center"> Saturday & Sunday </td>
            </tr>
          </table>
        </div>
        <div class="clr"></div>
      </li>
      <li>
        <label> Upload Menu/Price list:</label>
        <div class="fl" style="margin-left: 30px;">
          <input name="price_menu_list" type="file" id="price_menu_list" value="" size="22" contentEditable="false"/>
          <br>
          Accepts jpg,jpeg,png,gif,pdf,doc,xls,pdf. </div>
        <div class="clr"></div>
      </li>
      <li>
        <label> Upload Photo:</label>
        <div class="fl" style="margin-left: 30px;">
          <input name="upload_photo" type="file" id="upload_photo" value="" size="22" contentEditable="false"/>
          <br>
          Accepts jpg,jpeg,png,gif. </div>
        <div class="clr"></div>
      </li>
      <div id="div_address" style="display:none;">
        <li>
          <label> Address 2:</label>
          <div class="fl textbox">
            <input name="address2" id="address2" type="text" />
          </div>
          <div class="clr"></div>
        </li>
        <li>
          <label> Address 3:</label>
          <div class="fl textbox">
            <input name="address3" id="address3" type="text" />
          </div>
          <div class="clr"></div>
        </li>
        <li>
          <label> Address 4:</label>
          <div class="fl textbox">
            <input name="address4" id="address4" type="text" />
          </div>
          <div class="clr"></div>
        </li>
        <li>
          <label> Address 5:</label>
          <div class="fl textbox">
            <input name="address5" id="address5" type="text" />
          </div>
          <div class="clr"></div>
        </li>
      </div>
      <li>
        <p class="fl ters-txt">By clicking SIGN UP or using OffersnPals, you are indicating that you have read, understood, and agree to <a href="{$siteroot}/terms" target="_blank">Terms and Privacy Policy</a></p> 
      </li>
      <li>
        <label>&nbsp;</label>
        <div class="pre-btn fl" style="margin:0 0 30px 30px">
            <input type="submit" name="Submit" id="Submit" value="Signup"  class="previe-btn" style="width:130px"/>
        </div>
      </li>
    </ul>
  </div>
</form>
</div>
<!-- Maincontent ends -->
</div>
</div>
</form>
{include file=$footer}
</body></html>