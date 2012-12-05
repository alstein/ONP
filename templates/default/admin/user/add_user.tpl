{include file=$header1}
{strip}

<script type="text/javascript" src="{$sitejs}/jquery.validate.pack.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/adduserlist.js"></script>

{/strip}
{include file=$header2}
{literal}
<script language="JavaScript">
/*	$(document).ready(function(){
			$('#frmRegistration').submit(function(){
                    if ($('div.error').is(':visible')){
           			 } 
					else { 
						$('#Submit').hide(); 
						$('#buttonregister').append("<input type='button' name='Submit' id='Submit' value='Save' />"); 
					}
      	  });
	});*/
	
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
	$("#frmRegistration").validate();
	if($("#frmRegistration").valid()){
		$("#1").hide();
		$("#2").show();
		date = $("#sel_dd").val() +"/"+$("#sel_mm").val()+"/"+$("#sel_yy").val(); 
		var vdat = isValidDate(date);
		if(!vdat){ alert("Select proper birth date");return false}


		var cat_checked = $("input[id=cat_ref]:checked").length;
				
		if(cat_checked<2){
			$("#div_cat1").show();
			//$("#div_cat").hide();
			return false;
		}else{
			$('#Submit').val("Submitting, please wait..");
			$("#frmRegistration").submit();
			return true;
		}
	}else{
			return false;
	}
}

</script>
{/literal}

<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt;<a href="{$siteroot}/admin/user/users_list.php"> Consumer List</a>
 &gt; Add New Consumer</div>
<br />
<div class="holdthisTop">
    <h3>Add New Buyer</h3>
    <input type="hidden" id="siteroot" value="{$siteroot}" />
    <div align="center" id="msg">{$msg}</div>
    <form name="frmRegistration" id="frmRegistration" method="post" action="" enctype="multipart/form-data">
        <table width="100%" border="0" cellspacing="2" cellpadding="5" align="center">
            <tr>
                <td colspan="2" align="right"><a href="javascript:history.go(-1);"><strong>Back</strong></a></td>
            </tr>
			<tr>
                <td align="right" valign="top" width="40%"><span style="color:red">*</span> I am: </td>
                 <td align="left" width="60%"><input name="gender" type="radio" id="gender" value="Male"  size="25" />Male
											  <input name="gender" type="radio" id="gender" value="Female"  size="25"/>Female
                      
                                            <div class="clr"></div>
                                            <div class="error" htmlfor="gender" generated="true"></div>
                 </td>
            </tr>

            <tr>
                <td align="right" valign="top" width="40%"><span style="color:red">*</span> First Name: </td>
                <td align="left" width="60%"><input name="first_name" type="text" id="first_name" value=""  size="25" class="textbox fl"/>
                    
                                            <div class="clr"></div>
 											<div class="error" htmlfor="first_name" generated="true"></div>
                                           
                </td>
            </tr>
            <tr>
                <td align="right" valign="top" width="40%"><span style="color:red">*</span> Last Name: </td>
                 <td align="left" width="60%"><input name="last_name" type="text" id="last_name" value=""  size="25" class="textbox fl"/>
                      
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
			
			{section name=year start=1900 loop=$year step=1}
			<option value="{$smarty.section.year.index}" {if $yy eq $smarty.section.year.index} selected="selected" {/if}>{$smarty.section.year.index}</option>
			{/section}
			</select>
			<div class="clr"></div>
			<div class="error" htmlfor="sel_yy" generated="true" style="margin-left:-92px;"></div>
			</div>

		</td>
            </tr>

			<tr>
                <td align="right" valign="top" width="40%"><span style="color:red">*</span> Relationship Status: </td>
                 <td align="left" width="60%"><input name="rel_status" type="radio" id="rel_status" value="Married"  size="25" />Married
											  <input name="rel_status" type="radio" id="rel_status" value="Unmarried"  size="25"/>Unmarried

											 <div class="clr"></div>
                                              <div class="error" htmlfor="rel_status" generated="true"></div>
                 </td>
            </tr>

			<tr>
                <td valign="top" width="40%" colspan="3" align="center" style="padding-right:340px;"><span style="color:red">*</span><b> Category Preferance: </b></td>
				<td>&nbsp;</td>

            </tr>



{section name=i loop=$category}
            <tr>
                <td align="right" valign="top" width="40%"> <input name="cat_ref[]" id="cat_ref" type="checkbox" value="{$category[i].id}" class="fr boxcheck"> </td>
                <td align="left" width="60%" class="fl">{$category[i].category}
                    
                                            <div class="clr"></div>
                                            
                </td>
            </tr>
{/section}
<tr><TD colspan="2" style="padding-left:400px;">
				<div  class="error" id="div_cat"  style="display:none;">Please select category which you want to prefer. </div>
				<div class="error" id="div_cat1"  style="display:none;">Please select atleast Two categories which you want to prefer. </div>

</TD></tr>

            <tr style="display:none;">
                <td align="right" valign="top" width="40%"><span style="color:red">*</span> Username: </td>
                 <td align="left" width="60%"><input name="username" type="text" id="username" value=""  size="25" class="textbox fl"/>
                     
                                            <div class="clr"></div>
                                            <div class="error" htmlfor="username" generated="true"></div>
                 </td>
            </tr>
             <tr>
                <td align="right" valign="top"><span style="color:red">*</span> Email Address: </td>
                <td><input type="text" maxlength="70" size="25" value="" name="email" id="email" class="textbox fl" />
                    
                                            <div class="clr"></div>
                                            <div class="error" htmlfor="email" generated="true"></div>
                </td>
            </tr>

             <tr>
                <td align="right" valign="top"><span style="color:red">*</span>Reenter Email Address: </td>
                <td><input type="text" maxlength="70" size="25" value="" name="reenter_email" id="reenter_email" class="textbox fl" />
                    
                                            <div class="clr"></div>
                                            <div class="error" htmlfor="reenter_email" generated="true"></div>
                </td>
            </tr>


            <tr>
                <td align="right" valign="top"><span style="color:red">*</span> Password: </td>
                <td><input type="password" maxlength="15" size="25" name="password" id="password" class="textbox fl"/>
                
                                            <div class="clr"></div>
                                            <div class="error" htmlfor="password" generated="true"></div>
                </td>
            </tr>

	<tr>
		<td align="right" valign="top" width="40%"><span style="color:red">*</span>Current City : </td>
		<td align="left" width="60%">
				<input type="text" name="cityid" id="cityid" value="Singapore" readonly="true">	
				<input type="hidden" name="city" id="city" value="1">			
		<div class="clr"></div>
		<div class="error" htmlfor="cityid" generated="true"></div>
		</tr>

	<tr>
		<td align="right" valign="top" width="40%" c>Grad College Attended : </td>
		<td align="left" width="60%">
				<input name="grad_collage" id="grad_collage" type="text" class="textbox" value="" />
		<div class="clr"></div>
		<div class="error" htmlfor="grad_collage" generated="true"></div>
		</tr>
          

	<tr>
		<td align="right" valign="top" width="40%">Under Grad College Attended : </td>
		<td align="left" width="60%">
				 <input name="under_grad_collage" id="under_grad_collage" type="text" class="textbox" value="" />
		<div class="clr"></div>
		<div class="error" htmlfor="under_grad_collage" generated="true"></div>
		</tr>
 	<tr>
		<td align="right" valign="top" width="40%">Music : </td>
		<td align="left" width="60%">
				  <input name="music" id="music" type="text" class="textbox" value="" />
		<div class="clr"></div>
		<div class="error" htmlfor="music" generated="true"></div>
		</tr>

	<tr>
		<td align="right" valign="top" width="40%">Activities : </td>
		<td align="left" width="60%">
				  <input name="activity" id="activity" type="text" class="textbox" value="" />
		<div class="clr"></div>
		<div class="error" htmlfor="activity" generated="true"></div>
		</tr>

	<tr>
		<td align="right" valign="top" width="40%"><span style="color:red">*</span>Profile Picture : </td>
		<td align="left" width="60%">
				 <input type="file"  name="photo" id="photo" contentEditable="false">
		<div class="clr"></div>
		<div class="error" htmlfor="activity" generated="true"></div>
		</tr>

            <tr id="1">
                <td>&nbsp;</td>
                <td align="left">
                   <span id="buttonregister"> <input type="button" name="Submit" id="Submit" value="Save" class="" onclick="return show_div()" /></span>&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="button" value="Cancel" onclick="javascript: document.location.href='users_list.php'" class="" />
                </td>
            </tr>

		<tr id="2" style="display:none">
                <td>&nbsp;</td>
                <td align="left">
                   <span id="buttonregister"> <input type="button" name="Submit123" id="Submit123" value="Save" /></span>&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="button" value="Cancel" onclick="javascript: document.location.href='users_list.php'" class="" />
                </td>
            </tr>
        </table>
    </form>
</div>
{include file=$footer}
