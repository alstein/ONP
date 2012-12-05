{include file=$header_start}
{strip}

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
{literal}
<script language="JavaScript" type="text/javascript" >

function show_div()
{

	if($('input[@name=right_now_deal]:checked').size() == 2 && $('input[@name=usual_deal]:checked').size() == 2){
		$("#div_deal").show();
		return false;
	}

	else{
		var cat_checked = $("input[id=chk_category]:checked").length;
		if(cat_checked==0){
			$("#div_cat").show();
			return false;
		}else{
			return true;
		}
	}
}
</script>
{/literal}
  {include file=$profile_header2}
  <!-- Maincontent starts -->
  <div id="maincont" class="ovfl-hidden">
<form name="frmUserProfile" id="frmUserProfile" action="" method="post">
    <table width="1000" border="0" cellpadding="0" cellspacing="0" class="profile-tbl">
      <tr>
        <!-- Profile Left Section Start -->
        <td width="208" valign="top" style="border-right:none"> {include file=$profile_left}</td>
        <!-- Profile Left Section End -->
        <!-- Profile Middle Section Start -->
        <td width="560" valign="top"><!-- Profile Comment Section Start -->
          <div class="maincont-inner-mid fl">
            <div class="edit-profile-form">
              <h1 class=" form-title">Settings</h1>
              <ul class="reset user-edit-form">
                <li>
                  <label style="width:240px">Photos<span>*</span></label>
                  <div class="fl">
                    	<input class="fl" name="photos" type="radio" id="photos" value="private"  {if $setting.photo_setting eq 'private' } checked=checked {/if} size="25" />Private&nbsp;&nbsp;
		 				<input name="photos" type="radio" id="photos" value="public"  {if $setting.photo_setting eq 'public' } checked=checked {/if}  size="25"/>Public
                  </div>
                  <div class="clr"></div>
                </li>
                <li>
                  <label style="width:240px">Show Profile Feeds :<span>*</span></label>
                  <div class="fl">
                    	<input class="fl" name="profile_feeds" type="radio" id="profile_feeds" value="private"  {if $setting.profile_feed_setting eq 'private' } checked="true" {/if} size="25" />Private&nbsp;&nbsp;
		 				<input name="profile_feeds" type="radio" id="profile_feeds" value="public"  {if $setting.profile_feed_setting eq 'public' } checked="true" {/if}  size="25"/>Public
                  </div>
                  <div class="clr"></div>
                </li>
                <li>
                  <label style="width:240px">Allow Favorite Merchants To See Profile :<span>*</span></label>
                  <div class="fl">
                    	<input class="fl" name="merchant_setting" type="radio" id="merchant_setting" value="private"  {if $setting.merchant_setting eq 'private' } checked=checked {/if} size="25" />Private&nbsp;&nbsp;
		 				<input name="merchant_setting" type="radio" id="merchant_setting" value="public"  {if $setting.merchant_setting eq 'public' } checked=checked {/if}  size="25"/>Public
                  </div>
                  <div class="clr"></div>
                </li>
            
     
               
              
                <li>
                <label>&nbsp;</label>
                <div class="fl" style="margin:15px 0 0 30px">
        
		<input class="previe-btn"  type="submit" value="Save" name="Submit" id="Submit" style="width:72px"/>
      </div>
      			<div class="fl" style="margin:15px 0 0 10px">
        
<input class="previe-btn" type="button"  style="width:82px" value="Cancel"  onclick="javascript: location='{$siteroot}'"/>
      </div>
                </li>
                
             
              </ul>
            </div>
            <div class="clr" style="height:30px"></div>
          </div>
          <!-- Profile Comment Section End --></td>
        <!-- Profile Middle Section End -->
        <!-- Profile Right Section Start -->
        <td width="192" valign="top" style="border:none">{include file=$profile_right}</td>
        <!-- Profile Right Section End -->
      </tr>
    </table>
</form>
  </div>
  <!-- Maincontent ends -->
</div>
 {include file=$footer}