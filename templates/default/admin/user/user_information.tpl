{include file=$header1}
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


function isValidDate(value) {
  try {
        //Change the below values to determine which format of date you wish to check. It is set to dd/mm/yyyy by default.
        var DayIndex = 0;
        var MonthIndex = 1;
        var YearIndex = 2;
 
        value = value.replace(/-/g, "/").replace(/\./g, "/"); 
        var SplitValue = value.split("/");
        var OK = true;
        if (!(SplitValue[DayIndex].length == 1 || SplitValue[DayIndex].length == 2)) {
            OK = false;
        }
        if (OK && !(SplitValue[MonthIndex].length == 1 || SplitValue[MonthIndex].length == 2)) {
            OK = false;
        }
        if (OK && SplitValue[YearIndex].length != 4) {
            OK = false;
        }
        if (OK) {
            var Day = parseInt(SplitValue[DayIndex], 10);
            var Month = parseInt(SplitValue[MonthIndex], 10);
            var Year = parseInt(SplitValue[YearIndex], 10);
 
            if (OK = ((Year >= 1900) && (Year < new Date().getFullYear()))) {
                if (OK = (Month <= 12 && Month > 0)) {
                    var LeapYear = (((Year % 4) == 0) && ((Year % 100) != 0) || ((Year % 400) == 0));
 
                    if (Month == 2) {
                        OK = LeapYear ? Day <= 29 : Day <= 28;
                    }
                    else {
                        if ((Month == 4) || (Month == 6) || (Month == 9) || (Month == 11)) {
                            OK = (Day > 0 && Day <= 30);
                        }
                        else {
                            OK = (Day > 0 && Day <= 31);
                        }
                    }
                }
            }
        }
        return OK;
    }
    catch (e) {
        return false;
    }

}

function show_div()
{
	$("#frmUserProfile").validate();
	if($("#frmUserProfile").valid()){
		date = $("#sel_dd").val() +"/"+$("#sel_mm").val()+"/"+$("#sel_yy").val(); 
		var vdat = isValidDate(date);
		if(vdat){
			var cat_checked = $("input[id=cat_ref]:checked").length;
			
			if(cat_checked==0){ 
				$("#div_cat").show();
				$("#div_cat1").hide();	
				return false;
			}else if(cat_checked<2){
				$("#div_cat1").show();
				$("#div_cat").hide();
				return false;
			}else{
				return true;
			}


		}
		else
		{
			alert("Select proper birth date");
			return false; 
		}

		
	}
	else return false;
}

</script>
{/literal}
{include file=$header2}

<div align="center" id="msg">{$msg}</div>
<div class="holdthisTop">
	<h3>Edit {if $smarty.get.userid eq '1'}Admin{else}Consumer{/if} Information</h3><br/><br/>
    <form name="frmUserProfile" id="frmUserProfile" action="" method="post"  onsubmit="return show_div()" enctype="multipart/form-data">
    
      <table cellspacing="5" cellpadding="5" width="100%" border="0">

			<tr>
                <td align="right" valign="top" width="40%"><span style="color:red">*</span> I am: </td>
                 <td align="left" width="60%"><input name="gender" type="radio" id="gender" value="Male"  {if $user.gender eq Male } checked=checked {/if} size="25" />Male
											  <input name="gender" type="radio" id="gender" value="Female"  {if $user.gender eq Female } checked=checked {/if}  size="25"/>Female
                      
                                            <div class="clr"></div>
                                            <div class="error" htmlfor="gender" generated="true"></div>
                 </td>
            </tr>


      <tr>
        <td align="right" valign="top" width="40%"><input type="hidden" name="userid" id="userid" value="{$user.userid}" />
        <span style="color:red">*</span> First Name:</td>
        <td align="left" width="60%"><input name="first_name" type="text" id="first_name" value="{$user.first_name}" 
         size="25" class="textbox fl"/>
         
                                            <div class="clr"></div>
                                            <div class="error" htmlfor="first_name" generated="true"></div>
        </td>
      </tr>
      <tr>
        <td align="right" valign="top" ><span style="color:red">*</span> Last Name:</td>
        <td align="left" ><input name="last_name" type="text" id="last_name" value="{$user.last_name}"  size="25"
         class="textbox fl"/>
        
                                            <div class="clr"></div>
                                            <div class="error" htmlfor="last_name" generated="true"></div>
        </td>
</tr>

<tr>
                <td align="right" valign="top" width="40%"><span style="color:red">*</span> Birthday: </td>
                 <td align="left" width="60%">


			<div class="selectfield fl eastspace-1">
			<select name="sel_dd" id="sel_dd" class="select" >
			
			{section name=day start=1 loop=32 step=1}
			<option value="{$smarty.section.day.index}"  {if $dd eq $smarty.section.day.index} selected="selected" {/if} >{$smarty.section.day.index}</option>
			{/section}
			</select>
			<div class="clr"></div>
			<div class="error" htmlfor="birthday" generated="true"></div>
			</div>

			
			<div class="error" htmlfor="sel_dd" generated="true"></div>
			<div class="selectfield fl eastspace-1">
			<select name="sel_mm" id="sel_mm" class="select" >
			
			{section name=month start=1 loop=13 step=1}
			<option value="{$smarty.section.month.index}" {if $mm eq $smarty.section.month.index} selected="selected" {/if}>{$smarty.section.month.index}</option>
			{/section}
			</select>
			<div class="clr"></div>
			<div class="error" htmlfor="sel_mm" generated="true"></div>
			</div>


			<div class="selectfield fl ">
			<select name="sel_yy" id="sel_yy" class="select" >
			
			{section name=year start=1900 loop=2016 step=1}
			<option value="{$smarty.section.year.index}" {if $yy eq $smarty.section.year.index} selected="selected" {/if}>{$smarty.section.year.index}</option>
			{/section}
			</select>
			<div class="clr"></div>
			<div class="error" htmlfor="sel_yy" generated="true" style="margin-left:91px;"></div>
			</div>

		</td>
            </tr>


		<tr>
                <td align="right" valign="top" width="40%"><span style="color:red">*</span> Relationship Status: </td>
                 <td align="left" width="60%"><input name="rel_status" type="radio" id="rel_status" value="Married" {if $user.rel_status eq Married} checked="checked" {/if} size="25" />Married
											  <input name="rel_status" type="radio" id="rel_status" value="Unmarried" {if $user.rel_status eq Unmarried} checked="checked" {/if}  size="25"/>Unmarried

											 <div class="clr"></div>
                                              <div class="error" htmlfor="rel_status" generated="true"></div>
                 </td>
            </tr>

{$intrest1}

			<tr>
                <td valign="top" width="40%" colspan="3" align="center" style="padding-right:340px;"><span style="color:red">*</span><b> Category Preferance: </b></td>
				<td>&nbsp;</td>

            </tr>



{section name=i loop=$category}
            <tr>
                <td align="right" valign="top" width="40%"> <input name="cat_ref[]" id="cat_ref" type="checkbox" value="{$category[i].id}" class="fr boxcheck" {if in_array($category[i].id,$cc)} checked="true" {/if}> </td>
                <td align="left" width="60%" class="fl">{$category[i].category}
                    
                                            <div class="clr"></div>
                                            
                </td>
            </tr>
{/section}


      </tr>
      <tr style="display:none;">
        <td align="right" valign="top" ><span style="color:red">*</span> User Name:</td>
        <td align="left" ><input name="username" type="text" id="username" value="{$user.username}"  size="25" class="textbox fl"/>
       
        </td>
      </tr>

      <tr>
          <td align="right" valign="top"> <span style="color:red">*</span> Email Address:</td>
          <td>
            <input type="text" maxlength="50" size="25" value="{$user.email}" name="email" id="email" class="textbox fl" />
           
                                            <div class="clr"></div>
                                            <div class="error" htmlfor="email" generated="true"></div>
          </td>
      </tr>
      <tr>
          <td align="right" valign="top"> Password: </td>
          <td>
            <input type="password" maxlength="15" size="25" name="password" id="password" class="textbox fl"/>
           
                                            <div class="clr"></div>
                                             Only enter if you want to reset pass.
                                            <div class="error" htmlfor="password" generated="true"></div>
           
          </td>
        </tr>
	<tr>
		<td align="right" valign="top" width="40%"><span style="color:red">*</span>Current City : </td>
		<td align="left" width="60%">
				<input type="text" name="city" id="city" value="Singapore" readonly="true">	
				<input type="hidden" name="cityid" id="cityid" value="1">			
		<div class="clr"></div>
		<div class="error" htmlfor="cityid" generated="true"></div>
		</tr>



	<tr>
		<td align="right" valign="top" width="40%">Grad College Attended : </td>
		<td align="left" width="60%">
				<input name="grad_collage" id="grad_collage" type="text" class="textbox" value="{$user.grad_college}" />
		<div class="clr"></div>
		<div class="error" htmlfor="grad_collage" generated="true"></div>
		</tr>
          

	<tr>
		<td align="right" valign="top" width="40%">Under Grad College Attended : </td>
		<td align="left" width="60%">
				 <input name="under_grad_collage" id="under_grad_collage" type="text" class="textbox" value="{$user.under_grad_college}" />
		<div class="clr"></div>
		<div class="error" htmlfor="under_grad_collage" generated="true"></div>
		</tr>
 	<tr>
		<td align="right" valign="top" width="40%">Music : </td>
		<td align="left" width="60%">
				  <input name="music" id="music" type="text" class="textbox" value="{$user.music}" />
		<div class="clr"></div>
		<div class="error" htmlfor="music" generated="true"></div>
		</tr>

	<tr>
		<td align="right" valign="top" width="40%">Activities : </td>
		<td align="left" width="60%">
				  <input name="activity" id="activity" type="text" class="textbox" value="{$user.activities}" />
		<div class="clr"></div>
		<div class="error" htmlfor="activity" generated="true"></div>
		</tr>
	<tr>
		<td align="right" valign="top" width="40%"><span style="color:red">*</span>Profile Picture : </td>
		<td align="left" width="60%">
				 <input type="file"  name="photo" id="photo">
		<div class="clr"></div>
		<div class="error" htmlfor="activity" generated="true"></div>
		</tr>


	<tr>
		<td align="right" valign="top" width="40%"><span style="color:red">*</span>Previous Profile Picture : </td>
		<td align="left" width="60%">
				 <img src="{$siteroot}/uploads/user/{$user.photo}" width="100" height="100">
		<div class="clr"></div>
		<div class="error" htmlfor="activity" generated="true"></div>
		</tr>


    <tr style="display:none;">
        <td align="right" valign="top" width="40%"><span style="color:red">*</span> Membership: </td>
	<td>
	      <select name="membertype" style="width:100px;" onchange="return setflag(this.value)">
		    <option value="2" selected="selected">Buyer</option>
		    <option value="3">Seller</option>
	      </select>
	      
        </td>
      </tr>

   <tr style="display:none;"> 
        <td align="right" valign="top">Status: </td>
        <td><select name="status" id="status" style="width:100px;">
            <option value="active" {if $user.status=="Active"} selected="selected"{/if} >Active</option>
            <option value="inactive"  {if $user.status=="Suspended"} selected="selected"{/if}>Inactivate</option>
            </select>
        </td>
    </tr>

      <tr>
        <td></td>
        <td><input type="submit" value="Save" name="Submit"/> &nbsp; &nbsp; <input type="button" value="Cancel" {if $user.userid eq '1'} onclick="javascript: location='manage_admin.php'" {else} onclick="javascript: location='users_list.php'" {/if}/>
        </td>
      </tr>
    </table>
 
  </form>
</div>
{include file=$footer}
