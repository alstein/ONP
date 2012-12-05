{include file=$lbheader}

{literal}
<script type="text/javascript">
$(document).ready(function(){

	jQuery("#frmCountry").validate({
		errorElement:'div',
		rules: {
			country: {
				required: true,
		 	}
		},
		messages: {
			country: {
					required: "Please enter country",
			}
		},
});
});
</script>
{/literal}

<form name="frmCountry" id="frmCountry" action="" method="post">
<input type="hidden" name="countryid" value="{$country.id}" />
<table width="100%" border="0" cellspacing="2" cellpadding="6">
  <tr>
    <td>Country Name</td>
    <td><input type="text" id="country" class="input" name="country" value="{$country.country}"/></td>
  </tr>
  <tr>
    <td>Status</td>
    <td><select name="status" class="combo_box">
        <option value="1" {if $country.active eq "1"}selected="selected"{/if}}>Active</option>
        <option value="0" {if $country.active eq "0"}selected="selected"{/if}>Inactive</option>
      </select></td>
  </tr>
  <tr>
    <td></td>
    <td><input type="submit" name="submit" value="Save" class="button"/> <input type="button" value="Cancel" onclick="javascript: window.parent.tb_remove();" class="button"/>
    </td>
  </tr>
</table>
</form>
{include file=$lbfooter}