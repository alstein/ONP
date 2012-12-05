{include file=$header_start}
{strip}
<script type="text/javascript" src="{$siteroot}/js/validation/admin/edituser.js"></script>
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
<body class="inner_body">
<!-- main continer of the page -->
<div id="wrapper">
  <!-- header container starts here-->
  {include file=$profile_header2}
  <!-- / header container ends here-->
  <!-- main container with changing content -->
  <div id="maincont">
    <!-- Left content Start here -->
      {include file=$profile_left}
    <!-- Middel content Start here -->
    <div class="profile-middel">
	<h2 style="margin-left:20px;color: #2B587A" >Edit Profile</h2><br>
         <form name="frmUserProfile" id="frmUserProfile" action="" method="post">
    
      <table cellspacing="5" cellpadding="5" width="100%" border="0" align="center">

	<tr>
                <td align="right" valign="top" class="profile-name" style="width: 118px;" ><span style="color:red">*</span> Photos: </td>
                 <td align="left"  style="width: 310px;">
		<input class="fl" name="photos" type="radio" id="photos" value="private"  {if $setting.photo_setting eq 'private' } checked=checked {/if} size="25" />Private&nbsp;&nbsp;
		 <input name="photos" type="radio" id="photos" value="public"  {if $setting.photo_setting eq 'public' } checked=checked {/if}  size="25"/>Public

		<div class="clr"></div>
		<div class="error" htmlfor="photos" generated="true" ></div>
                 </td>
            </tr>
	<tr>
                <td align="right" valign="top" class="profile-name" style="width: 118px;" ><span style="color:red">*</span> Live Wire: </td>
                 <td align="left"  style="width: 310px;">
		<input class="fl" name="live_wires" type="radio" id="live_wires" value="private"  {if $setting.live_wire_setting eq 'private' } checked=checked {/if} size="25" />Private&nbsp;&nbsp;
		 <input name="live_wires" type="radio" id="live_wires" value="public"  {if $setting.live_wire_setting eq 'public' } checked=checked {/if}  size="25"/>Public

		<div class="clr"></div>
		<div class="error" htmlfor="photos" generated="true" ></div>
                 </td>
            </tr>
	<tr>
                <td align="right" valign="top" class="profile-name" style="width: 118px;" ><span style="color:red">*</span> Deals: </td>
                 <td align="left"  style="width: 310px;">
		<input class="fl" name="deal" type="radio" id="deal" value="private"  {if $setting.deal_setting eq 'private' } checked=checked {/if} size="25" />Private&nbsp;&nbsp;
		 <input name="deal" type="radio" id="deal" value="public"  {if $setting.deal_setting eq 'public' } checked=checked {/if}  size="25"/>Public

		<div class="clr"></div>
		<div class="error" htmlfor="photos" generated="true" ></div>
                 </td>
            </tr>


      <tr>
        <td></td>
        <td>
		<div class="fl"><span class="sitesub-btn-lft"><span class="sitesub-btn-right">
		<input class="loc_busines fl" type="submit" value="Save" name="Submit" id="Submit"/>
		</span></span> </div>
		<div class="fl"><span style="margin-left:10px;" class="sitesub-btn-lft"><span class="sitesub-btn-right">
		<input  class="loc_busines fl" type="button" value="Cancel" {if $user.userid eq '1'} onclick="javascript: location='manage_admin.php'" {else} onclick="javascript: location='users_list.php'" {/if}/>
		</span></span></div>
        </td>
      </tr>
    </table>
 
  </form>
    </div>
    <!-- Right content Start here -->
      {include file=$profile_right}
    <!-- footer container Start-->
  {include file=$footer}
    <!-- footer container End-->
  </div>
</div>
</body>

