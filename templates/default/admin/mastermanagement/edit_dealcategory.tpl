{include file=$lbheader}

{literal}
<script type="text/javascript">
$(document).ready(function(){

	jQuery("#frmCountry").validate({
		errorElement:'div',
		rules: {
			category: {
				required: true,
		 	}
		},
		messages: {
			category: {
					required: "Please enter category name",
			}
		},
});
});
</script>
{/literal}

<form name="frmCountry" id="frmCountry" action="" method="post">
<input type="hidden" name="categoryid" value="{$category.id}" />
<table width="100%" border="0" cellspacing="2" cellpadding="6" align="left">
  <tr>
    <td>Category Name:</td>
  </tr>
	<tr><td><input type="text" id="category" class="input" name="category" value="{$category.category}"/></td></tr>
  <tr>
    <td><input type="submit" value="Save" class="button"/> <input type="button" value="Cancel" onclick="javascript: window.parent.tb_remove();" class="button"/>
    </td>
  </tr>
</table>
</form>
