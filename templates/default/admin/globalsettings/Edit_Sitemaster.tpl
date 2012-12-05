{include file=$header1}
<!--<script type="text/javascript" src="{$siteroot}/js/common1.js"></script>-->
<script type="text/javascript" src="{$siteroot}/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/validate_sitesetting.js"></script>
{literal}
<script type="text/javascript">


// function chkvali()
// {
// 	var frm=document.frmEdit;
// 	if(frm.parameter.value.length < 1)
// 	{
// 		alert("Please enter parameter.");
// 		frm.parameter.focus();
// 		return false;
// 	}
// 	if(frm.desc.value.length < 1)
// 	{
// 		alert("Please enter description.");
// 		frm.desc.focus();
// 		return false;
// 	}
// 	return true;
// }
</script>
{/literal}

<form name ="frmEdit"  id="frmEdit" action = "" method="post" >
  <input type="hidden" name="id" id="id" value="{$row.id}">
  <table width="100%" border="0" cellpadding="6" cellspacing="2">
    <tr class="tblRowBkClr_1">
      <td align="right" valign="top">Parameter:</td>
      <td align="left" ><input type="text" name="parameter" id="parameter" value="{$row.type}" readonly size="50" class="textbox" />
      </td>
    </tr>
    <tr class="tblRowBkClr_1">
	<td align="right" valign="top">Description: </td>
	<td align="left" valign="top" >
	       {if $row.id eq '36'} 
	       <textarea name="desc" id="desc" class="textbox" rows="5" cols="57">{$row.value}</textarea>
	       {else}
	      <input type="text" name="desc" id="desc" value="{$row.value}" class="textbox" size="50" />
	       {/if}
	</td>
    </tr>
    <tr  class="tblRowBkClr_1">
      <td></td>
      <td align="left"><input type="submit" value="Update" name="submit"/><input type="hidden" name="txt_id" id="txt_id" value="{$smarty.get.id}">
        </td>
    </tr>
  </table>
</form>
