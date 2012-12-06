{include file=$header_start} 

{if $smarty.session.csUserId neq ''}
{include file=$profile_header2}
{else}
{include file=$header_end}
{/if}

{strip}
<script type="text/javascript" src="{$siteroot}/js/validation/edituser.js"></script>
<script language="javascript" type="text/javascript" src="{$siteroot}/js/calendarDateInput.js"> </script>
{/strip}
{literal}
<script language="javascript" type="text/javascript">

$(document).ready(function(){

	var fb_flag='{/literal}{$smarty.get.flagfb}{literal}';
	
	if(fb_flag=='fb')
	{
	alert("Please select your favorite categories to check out relevant deals");
	window.location.href=SITEROOT+"/editprofile";
	}
});

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

function terminate_account(val)
{

	cmt_url = SITEROOT+"/modules/my-account/ajax_terminate_account.php";
		jQuery.get(cmt_url,{userid:val},function(data)
		{
			window.location.href=SITEROOT;	
		})
}
</script>
{/literal}
  <!-- Header ends -->
  <!-- Maincontent starts -->
  <div id="maincont" class="ovfl-hidden">
    <table width="1000" border="0" cellpadding="0" cellspacing="0" class="profile-tbl">
      <tr>
        <!-- Profile Left Section Start -->
         {include file=$profile_left}

        <!-- Profile Left Section End -->
        <!-- Profile Middle Section Start -->
        <td width="560" valign="top"><!-- Profile Comment Section Start -->
          <div class="maincont-inner-mid fl">
            <div class="edit-profile-form">
              <h1 class=" form-title">Edit Profile</h1>
			 <form name="frmUserProfile" id="frmUserProfile" action="" method="post">
<input type="hidden" name="userid" id="userid" value="{$user.userid}" />
              <ul class="reset user-edit-form">
				<div align="center" class="success">{$msg}</div>
                <li>
                  <label style="width:155px;">I am<span>*</span></label>
                  <div >
                   <input class="fl" name="gender" type="radio" id="gender" value="Male"  {if $user.gender eq Male } checked=checked {/if} size="25" />Male<input name="gender" type="radio" id="gender" value="Female"  {if $user.gender eq Female } checked=checked {/if}  size="25"/>Female
                  </div>
                  <div class="clr"></div>
                </li>
                <li>
                  <label>First Name<span>*</span></label>
                  <div class="fl form-textbox">
                  <input class="signinput" name="first_name" type="text" id="first_name" value="{$user.first_name}"  />
                  </div>
                  <div class="clr"></div>
                </li>
                <li>
                  <label>Last Name<span>*</span></label>
                  <div class="fl form-textbox">
                   <input class="signinput" name="last_name" type="text" id="last_name" value="{$user.last_name}"  />
                  </div>
                  <div class="clr"></div>
                </li>
                <li>
                  <label style="width:155px;">Birthday<span>*</span></label>
                  <div class="fl">
                    <div >
					{if $birthdate}
					<script type="text/javascript">DateInput('birthday', true, 'YYYY-MM-DD','{$birthdate}');</script>
					{else}
					<script type="text/javascript">DateInput('birthday', true, 'YYYY-MM-DD');</script>
					{/if}
                    </div>
                    
                    
                    <div class="clr"></div>
                  </div>
                  <div class="clr"></div>
                </li>
                <li>
                  <label>I am:</label>
                  <div class="fl">
                    <div class="radio fl"  style="margin-left:30px">
               <input class="styled" name="rel_status" type="radio" id="rel_status" value="Married" {if $user.rel_status eq Married} checked="checked" {/if}  />
              </div>
                    <p class="fl forminntxt"> Married </p>
                  </div>
                  <div class="fl">
                    <div class="radio fl"  style="margin-left:30px">
               <input name="rel_status" class="styled" type="radio" id="rel_status" value="Unmarried" {if $user.rel_status eq Unmarried} checked="checked" {/if}  />
              </div>
                    <p class="fl forminntxt">Unmarried </p>
                  </div>
                  <div class="clr"></div>
                </li>
                <li>
                  <div>
                    <label> Category Preferance: <span>*</span></label>
				{section name=i loop=$category}
					{if $smarty.section.i.iteration neq 1}
                    <label> &nbsp;</label>
					{/if}
                    <div>
                      <div class="check fl">
                      <input name="chk_category[]" id="chk_category"  type="checkbox" value="{$category[i].id}" {if in_array($category[i].id, $cat_preferance)} checked='checked' {/if} >
                      </div>
                      <p class="fl forminntxt" style="line-height:22px">{$category[i].category}</p>
                      <div class="clr"></div>
                    </div>
				{/section}
					<div id="div_cat" class="error" style="display:none;" >Please select atleast one category which you want to prefer. </div>
                    <div class="clr"></div>
                  </div>

  
                </li>
				<li>
				<div>
				<input name="deal_thr_email" id="deal_thr_email" type="checkbox"  class="boxcheck fl" {if $user.deal_by_email eq 'yes'} checked="true" {/if}
                 class="fl" style="margin-right:4px;!important; margin-top:4px">
             <div class="fl interested-cont" style="width:292px;"> <div class="profile-name" style="width:400px">You would like to receive offers through emails as well?
				</div>
				</li>
                <li>
                  <label> Email Address:<span>*</span></label>
                  <div class="fl form-textbox">
                   <input type="text" maxlength="50" size="25" value="{$user.email}" name="email" id="email"  />
                  </div>
                  <div class="clr"></div>
                </li>
                <li>
                  <label> Change Password:<span>*</span></label>
                  <div class="fl form-textbox">
                     <input  type="password" maxlength="15" size="25" name="password" id="password" />
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
              <label>City:</label>
              <div class="fl form-textbox">
                <input  type="text" name="tcity" id="tcity"  readonly="true" value="Singapore"/>
				<input type="hidden" name="cityid" id="cityid" value="1">
              </div>
              <div class="clr"></div>
            </li>
            <li>
                  <label>Grad College: </label>
                  <div class="fl form-textbox">
                    <input name="grad_college" id="grad_college" value="{$user.grad_college}" type="text" />
                  </div>
                  <div class="clr"></div>
                </li>
                <li>
                  <label>Under Grad College :</label>
                  <div class="fl form-textbox">
                  <input  name="under_grad_college" type="text" id="under_grad_college" value="{$user.under_grad_college}"   />
                  </div>
                  <div class="clr"></div>
                </li>
                <li>
                  <label> Music:</label>
                  <div class="fl form-textbox">
                    <input  name="music" type="text" id="music" value="{$user.music}"   />
                  </div>
                  <div class="clr"></div>
                </li>
                <li>
                  <label>  Activities: :</label>
                  <div class="fl form-textbox">
                   <input name="activities" type="text" id="activities" value="{$user.activities}"  />
                  </div>
                  <div class="clr"></div>
                </li>
				<li style="display:none;">
				  <label>Membership<span>*</span></label>
				 <div class="dis-bg fl">
                       <select name="membertype" style=" width: 220px;color: #2B587A;" onChange="return setflag(this.value)" class="select">
							<option value="2" selected="selected">Buyer</option>
							<option value="3">Seller</option>
						</select>
                 </div>
				</li>
				<li style="display:none;">
				  <label>Status<span>*</span></label>
				 <div class="dis-bg fl">
                      <select name="status" id="status" style=" width: 220px;color: #2B587A;" class="select">
						<option value="active" {if $user.status=="Active"} selected="selected"{/if} >Active</option>
						<option value="inactive"  {if $user.status=="Suspended"} selected="selected"{/if}>Inactivate</option>
						</select>
                 </div>
				</li>
                <li>
                <label>&nbsp;</label>
                <div class="fl" style="margin:15px 0 0 30px">
			<input type="submit"  style="width:72px" class="previe-btn" value="Save" name="Submit"  onclick="return show_div();"/>
      
     		 </div>
      			<div class="fl" style="margin:15px 0 0 10px">
			<input style="width:82px" class="previe-btn"   type="button" value="Cancel" onclick="javascript: location='{$siteroot}/my-account/my_profile_home/'"/>
      
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
        
  {include file=$profile_right}
        <!-- Profile Right Section End -->
      </tr>
    </table>
  </div>
  <!-- Maincontent ends -->
</div>
<!-- Footer starts -->
 {include file=$footer}
