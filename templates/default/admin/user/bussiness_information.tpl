{include file=$header1}
<script type="text/javascript" src="{$siteroot}/js/jquery.validate.pack.js"></script>
<script type="text/javascript">
{literal}
$(document).ready(function() {
	// validate signup form on keyup and submit
	var business_id = document.getElementById('business_id').value;
	var validator = $("#frmUserProfile").validate({
		errorElement:'div',
		rules: {
        Bname:{
				required: true
			},
			//website:{
		//		required: true
			//},
			area_code:{
				required: true
			},
			phone:{
				required: true
			},
			email: {
				required: true,
				email: true,
				remote: {url:SITEROOT + "/admin/user/ajax_check_user.php?business_id="+business_id , type:"post"}
			},
			categoryid: "required",
		},
		messages: {
			Bname:{
				required: "Enter Bussiness name"
			},
			//website:{
			//	required: "Enter Website"
			//},
			area_code:{
				required: "Enter Area code."
			},
			phone:{
				required: "Enter Phone Number"
			},
			add1:{
				required: "Enter Address"
			},
			email: {
				required: "Please enter email address",
				email: "Please enter a valid email address",
				remote: jQuery.format("{0} is already in use or marked as spam.")
			},
			categoryid: "Please Select Bussiness Category.",
			
		},

		// set this class to error-labels to indicate valid fields
		success: function(label) {
			// set &nbsp; as text for IE
			label.hide();
		}
	});
	// propose username by combining first- and lastname
	/*$("#username").focus(function() {
		var Bname = $("#Bname").val();
		var last_name = $("#last_name").val();
		if(Bname && last_name && !this.value) {
			this.value = Bname + "." + last_name;
			this.value = this.value.toLowerCase();
		}
	});*/
});

	function changeit(val){
// 		alert(val);
		if(val == 4 || val == 6){
			//document.getElementById('hidden_id').style.display='';
			//ajax.sendrequest("GET", SITEROOT+"/admin/user/get_city.php", {val:val}, '', 'replace');
		}else{
			//document.getElementById('hidden_id').style.display='none';
		}
	}
	function getCity(val){
		ajax.sendrequest("GET", SITEROOT+"/admin/user/get_city.php", {val:val,bussiness:1}, '', 'replace');
	}

	function add_cities(){
		var city = document.getElementById('city').value;
		if(city != ''){
			var state = document.getElementById('state').value;
			ajax.sendrequest("POST", SITEROOT+"/admin/user/add_city.php", {city:city,state:state}, '', 'display_cities');
		}else{
			alert("Please select city");
			return false;
		}
	}
	
	function removecity(val){
		var val1 = 'add_city_'+val;
		var val2 = 'name_city_'+val;
		var val_city = document.getElementById(val2).innerHTML;
		var state_id = "id_state_"+val;
		var stateid = document.getElementById(state_id).value;
		document.getElementById(val1).style.display = 'none';
		ajax.sendrequest("POST", SITEROOT+"/admin/user/add_city.php", {remove_city:val_city,stateid:stateid}, '', 'display_cities');
	}
{/literal}
</script>
{include file=$header2}
<!--<div class="breadcrumb">
  <a href="{$siteroot}/admin/index.php">Home</a> &gt;
  <a href="{$siteroot}/admin/user/bussiness_view.php?business_id={$row.business_id}">Bussiness view</a> &gt; Bussiness Details
</div>-->
<div class="holdthisTop">
  <div align="center">{$msg}</div>
  <div><table width="100%" border="0" ><TR><TD align="right"><A href="javascript:history.go(-1);">Back&nbsp;&nbsp;&nbsp;</A></TD></TR></table>

    <form name="frmUserProfile" id="frmUserProfile" action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="business_id" id="business_id" value="{$row.business_id}" />
     <table cellspacing="1" cellpadding="1" width="100%" border="0" align="center">
 		<tr><td colspan="2"><h2>Business Information</h2></td></tr>
      <tr><td colspan="2" height="5"></td></tr>
      <tr>
        <td align="right" width="30%" valign="top" >Bussiness name: </td>
		  <td align="left" width="70%" ><input name="Bname" type="text" id="Bname" value="{$row.name}" size="50" class="textbox" />
        </td>
      </tr>
      <tr>
        <td align="right" valign="top" >Website: </td>
		  <td align="left" ><input name="website" type="text" id="website" value="{$row.website}" class="textbox" />
        </td>
      </tr>
	<tr>
          <td align="right" valign="top"> Telephone no: </td>
          <td>
	    <input type="text" value="{$row.area_code}" name="area_code" id="area_code" class="textbox" style="width:55px"/>-	
            <input type="text" value="{$row.phone}" name="phone" id="phone" class="textbox"/>
          </td>
      </tr>		
	<tr>
	<td align="right" valign="top" >Category: </td>
	<td align="left" >
	{assign var='cnt' value='1'}
	<select name="categoryid" id="categoryid" style='width:150px' >
	{section name=i loop=$BCategory}
	<!--<input name="categoryid" id="categoryid" type="radio" value="{$BCategory[i].categoryid}"{if $row.bussiness_cat_id eq $BCategory[i].categoryid} checked="true" {/if}  >{$BCategory[i].category}-->
<option value="{$BCategory[i].categoryid}" {if $row.bussiness_cat_id eq $BCategory[i].categoryid} selected="selected" {/if}>{$BCategory[i].category}</option>	
	<!--{if ($cnt%3)==0}<br>{/if}
	{assign var='cnt' value=$cnt+1}-->
	{/section}
	</select>
        </td>
      </tr>
      <tr>
        <td align="right" valign="top" >Address: </td>
	<td align="left" ><input name="add1" type="text" id="add1" value="{$row.add1}" size="50" class="textbox" />
        </td>
      </tr>
		<tr>
        <td align="right" valign="top" >Address1: </td>
	<td align="left" ><input name="add2" type="text" id="add2" value="{$row.add2}" size="50" class="textbox"/>
        </td>
      </tr>
		<tr>
        <td align="right" valign="top" >State: </td>
	<td align="left" ><!--<input name="state" type="text" id="state" value="{$row.state}" size="15" />-->
	<select name="state" id="state" onchange="javascript: getCity(this.value);" style="width:150px" >
		<option value="">Select State</option>
		{section name=i loop=$state}
		<option value="{$state[i].id}" {if $row.state eq $state[i].id} selected="selected" {/if}>{$state[i].state_name}</option>
		{/section}
	</select>
        </td>
      </tr>	
		<tr>
        <td align="right" valign="top" >City: </td>
	<td align="left" ><!--<input name="city" type="text" id="city" value="{$row.city}" size="15" />-->
	<div id="replace">
		<select name="city" id="city"style='width:150px' ><!--{$row.city}onchange="javscript: add_cities();"-->
		{if $city}
		{section name=i loop=$city}
		<option value="{$city[i].city_name}" {if $row.city eq $city[i].city_name} selected="selected" {/if}>{$city[i].city_name}</option>	
		{/section}
		{else}
		<option value="">Select City</option>
		{/if}
		</select>
	</div>
        </td>
      </tr>
		
		<tr>
        <td align="right" valign="top" >Zip code: </td>
	<td align="left" ><input name="zip" type="text" id="zip" value="{$row.zip}" size="15" class="textbox"/>
        </td>
      </tr>
      <tr>
        <td align="right" valign="top">Bussiness image: </td>
	<td align="left"><input name="photo" type="file" id="photo"/></td>
      </tr>
 {if $row.bussiness_picture neq ''}
	<tr>
	<td align="right" valign="top" >&nbsp;</td>
	<td><img src="{$siteroot}/uploads/bussiness_photo/thumbnail/{$row.bussiness_picture}" class="BrdGrey1" width="200px" height="200px"/> </td>
	</tr>
	{else}{/if}
	
	
	<tr><td colspan="2" height="5"></td></tr>
        <tr>
	<td align="right" valign="top">Logo: </td>
	<td align="left"><input name="logo" type="file" id="logo1"/></td>
	</tr>
 	{if $row.logo neq ''}
	<tr>
		<td align="right" valign="top" >&nbsp;</td>
		<td><img src="{$siteroot}/uploads/bussiness_photo/logo/thumbnail/{$row.logo}"  class="BrdGrey1" /></td>
	</tr>
	{/if}
		<tr><td colspan="2"><h2>Contact information: </h2></td></tr>
      <tr><td colspan="2" height="5"></td></tr>
	<tr>
		<td align="right" valign="top">First name: </td>
		<td align="left" ><input type="text" maxlength="15" value="{$row.first_name}" name="first_name" id="first_name" class="textbox"/></td>
	</tr>	
	<tr>
		<td  align="right" valign="top">Last name: </td>
		<td align="left" ><input type="text" maxlength="15" value="{$row.last_name}" name="last_name" id="last_name" class="textbox"/></td>
	</tr>
	<tr>
		<td   align="right" valign="top">Title / Position: </td>
		<td align="left" ><input type="text" maxlength="15" value="{$row.position}" name="position" id="position" class="textbox"/></td>
	</tr><!---->
	<tr>
		<td   align="right" valign="top">Email address: </td>
		<td align="left" ><input type="text" maxlength="70" value="{$row.email}" name="email" id="email" class="textbox"/></td>
	</tr>
	<!--<tr>
		<td  align="right" valign="top">Telephone Number:</td>
		<td align="left" ><input maxlength="15" type="text" value="{$row.contactno}" name="contactno" id="contactno" class="textbox"/></td>
	</tr>--><!---->	


	<!--<tr>
	<td valign="top" ><h3>Select School Donation Percentage</h3></td>
	<td align="left" >
	{assign var='cnt0' value='1'}
	{section name=i loop=$don_per}
	<input name="school_donation_percentage" id="school_donation_percentage" type="radio" value="{$don_per[i].percentage}"{if $row.school_donation_percentage eq $don_per[i].percentage} checked="true" {/if}  >{$don_per[i].percentage}
	{if ($cnt0%3)==0}<br>{/if}
	{assign var='cnt0' value=$cnt0+1}
	{/section}
        </td>
      </tr>		
	<tr>
	<td  valign="top" ><h3>Select Fine Prints</h3></td>
	<td align="left" >
	{assign var='cnt1' value='1'}
	{section name=i loop=$fine_prints}
	<input name="fine_prints" id="fine_prints" type="radio" value="{$fine_prints[i].fine_prints_id}"{if $row.fine_prints eq $fine_prints[i].fine_prints_id} checked="true" {/if}  >{$fine_prints[i].fine_prints}
	{if ($cnt1%3)==0}<br>{/if}
	{assign var='cnt1' value=$cnt1+1}
	{/section}
        </td>
      </tr>
		<tr><td align="right" valign="top" colspan="2" height="5" ></td></tr>
		<tr><td colspan="2">Enter any additional items or restrictions that apply to your offer<h3></h3></td></tr>
		<tr>
		<td align="right" valign="top" ></td>
		<td align="left" >
		<textarea name="items_resctriction" rows="2" cols="50" id="items_resctriction" class="textbox" > {$row.items_resctriction}</textarea>
        </td>
      </tr>-->

		<tr><td valign="top" align="right">Comment: <strong></strong></td>
                    <td align="left"><textarea name="comment" rows="2" cols="50" id="comment" class="textbox" > {$row.comment}</textarea></td>
                </tr>
		<tr>
		<td align="right" valign="top" ></td>
		<td align="left" >
		
        </td>
      </tr>


		<tr>
			<td>&nbsp;</td>
			<td>
			<input type="submit" value="Save"  name="Submit"/> &nbsp; &nbsp; <input type="button" value="Cancel" onclick="javascript: location='bussiness_list.php'"  />
			</td>
		</tr>
     </table>
    </form>
  </div>
  </td>
  <div class="clr">
  </div>
</div>
 {include file=$footer} 
