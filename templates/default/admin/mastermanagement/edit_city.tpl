{include file=$header1}
{strip}
<script type="text/javascript" src="{$siteroot}/js/get_country_state_city.js"></script>
<script type="text/javascript" src="{$siteroot}/js/colorpicker.js"></script>
{/strip}

{literal}
<script type="text/javascript">
$(document).ready(function(){

	jQuery("#frmCity").validate({
		errorElement:'div',
		rules: {
			countries: {
				required: true,
		 	},
			states: {
				required: true,
		 	},
			city_nm: {
				required: true,
		 	},
			city_image: {
				accept : "jpg|JPG|jpeg|JPEG|gif|GIF",
		 	},
			color: {
				maxlength: 20,
		 	}
		},
		messages: {
			countries: {
					required: "Please select country",
			},
			states: {
				required: "Please select state",
		 	},
			city_nm: {
				required: "Please enter city name",
		 	},
			city_image: {
				accept: "Please provide valid file format",
		 	},
			color: {
				maxlength: jQuery.format("Enter At most {0} characters"),
		 	}
		},
});
});
</script>
{/literal}
{include file=$header2}

<h2>{if $city}Edit{else}Add{/if} City</h2><br>

<form name="frmCity" id="frmCity" action="" method="post" enctype="multipart/form-data">
<input type="hidden" name="cityid" value="{$city.city_id}" />
<table width="100%" border="0" cellspacing="2" cellpadding="6">
	<tr>
      	<td colspan="2" align="right"><a href="city_list.php"><strong>Back</strong></a></td>
    	</tr>
	 <tr>
    <td width="20%" align="right">Country Name :</td>
    <td><select name="countries" id="countries" style="width:180px;" class="selectbox" onchange="javascript: getState(this.value,'{$siteroot}');">
			<option value="">Select Country</option>
			{section name=i loop=$country}
			<option value="{$country[i].id}" {if $city.con_id eq $country[i].id} selected="true" {/if} >{$country[i].country}</option>
			{/section}
	</select>
	</td>
  </tr>
	 <tr>
    <td width="20%" align="right">State Name :</td>
    <td><div id="city_div"><select name="states" id="states"  class="selectbox" style="width:180px;" >
			
			{section name=i loop=$state_con}
				<option value="{$state_con[i].id}" {if $city.state_id eq $state_con[i].id} selected="true" {/if} >{$state_con[i].state_name}</option>
			{sectionelse}
			<option value="">Select</option>
			{/section}
	</select></div>
	</td>
  </tr>
  <tr>
    <td width="20%" align="right">City Name :</td>
    <td><input type="text" id="city_nm" class="input" name="city_nm" value="{$city.city_name}"/></td>
  </tr>
 
  <tr>
    <td width="20%" align="right" valign="top">City Image :</td>
    <td><input type="file" name="city_image" id="city_image" value="">
								{if $city.city_image}
									<br><img src="{$siteroot}/uploads/city/{$city.city_image}" width="200" height="150" >
								{/if}</td>
  </tr>
 <tr>
    <td width="20%" align="right">Color :</td>
    <td><input type="text" id="color" class="input" name="color" value="{$city.color}"/>&nbsp;<a href="javascript:TCP.popup(document.forms['frmCity'].elements['color'])"><img width="15" height="13" border="0" alt="Pick-up color" src="{$siteimg}/icons/sel.gif"></a></td>
  </tr>
  <tr>
    <td width="20%" align="right" valign="top">Landing Page City Image :</td>
    <td><input type="file" name="landing_page_image" id="landing_page_image" value="">
								{if $city.landing_page_image}
									<br><img src="{$siteroot}/uploads/city/{$city.landing_page_image}" width="200" height="150" >
								{/if}</td>
  </tr>
 <tr>
    <td width="20%" align="right">Landing Page Color :</td>
    <td><input type="text" id="landing_page_color" class="input" name="landing_page_color" value="{$city.landing_page_color}"/>&nbsp;<a href="javascript:TCP.popup(document.forms['frmCity'].elements['landing_page_color'])"><img width="15" height="13" border="0" alt="Pick-up color" src="{$siteimg}/icons/sel.gif"></a></td>
  </tr>

 <tr>
    <td width="20%" align="right">Status :</td>
    <td><select name="status" class="combo_box">
        <option value="1" {if $state.active eq "1"}selected="selected"{/if}}>Active</option>
        <option value="0" {if $state.active eq "0"}selected="selected"{/if}>Inactive</option>
      </select></td>
  </tr>
  <tr>
    <td></td>
    <td><input type="submit" name="submit" value="Save" class="button1"/> &nbsp; &nbsp; <input type="button" value="Cancel" onclick="history.go(-1)" class="button1"/>
    </td>
  </tr>
</table>
</form>
{include file=$footer}