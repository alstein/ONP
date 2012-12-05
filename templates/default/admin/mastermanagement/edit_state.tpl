{include file=$lbheader}
{literal}
<script type="text/javascript">
$(document).ready(function(){

	jQuery("#frmState").validate({
		errorElement:'div',
		rules: {
			countries: {
				required: true,
		 	},
			states: {
				required: true,
		 	}
		},
		messages: {
			countries: {
					required: "Please select country",
			},
			states: {
				required: "Please enter state name",
		 	}
		},
});
});
</script>
{/literal}

<form name="frmState" id="frmState" action="" method="post">
<input type="hidden" name="stateid" value="{$state.id}" />
<table width="100%" border="0" cellspacing="2" cellpadding="6">
	 <tr>
    <td>Country Name</td>
    <td><select name="countries" id="countries">
			{section name=i loop=$country}
			<option value="{$country[i].id}" {if $state.country_id eq $country[i].id} selected="true" {/if} >{$country[i].country}</option>
			{/section}
	</select>
	</td>
  </tr>
  <tr>
    <td>State Name</td>
    <td><input type="text" id="states" class="input" name="states" value="{$state.state_name}"/></td>
  </tr>
  <tr>
    <td>Status</td>
    <td><select name="status" class="combo_box">
        <option value="1" {if $state.active eq "1"}selected="selected"{/if}}>Active</option>
        <option value="0" {if $state.active eq "0"}selected="selected"{/if}>Inactive</option>
      </select></td>
  </tr>
  <tr>
    <td></td>
    <td><input type="submit" value="Save" class="button"/> <input type="button" value="Cancel" onclick="javascript: window.parent.tb_remove();" class="button"/>
    </td>
  </tr>
</table>
</form>
{include file=$lbfooter}