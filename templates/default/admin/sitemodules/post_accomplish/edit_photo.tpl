{include file=$header1}
{literal}
<script type="text/javascript">
jQuery(document).ready(function()
{
	jQuery("#msg").fadeOut(5000);
});

function toggle(id)
{
	var checked_status = false;//this.checked;
	jQuery("input[name=trophy_case]").each(function()
	{ 
		this.checked = checked_status;
	});
	$('#'+id).attr('checked', true);
	
}
function untoggle(id)
{
	$('#'+id).attr('checked', false);
}
</script>
{/literal}
{include file=$header2}
{include file=$menu}
<div class="middel_panel">
<h1 class="type2">{$album[0].album_title}</h1>
<div class="breadcrumb"><a href="{$siteroot}/admin/home.php">Home</a>&nbsp;&raquo;&nbsp;<a href="{$siteroot}/admin/sitemodules/post_accomplish/award.php">Accomplishment</a>&nbsp;&raquo;&nbsp;Album&nbsp;&raquo;&nbsp;Edit Photo</div>
<div style="margin-left:770px"><a href="javascript:void(0);" onclick="javascript:history.go(-1);"> <strong>Back </strong></a></div>
	<div class="holdthisTop">
	{if $msg}
	<div align="center" class="error" id="msg">{$msg}</div>
	{/if}
<table width="100%" border="0" align="center" cellspacing="2" cellpadding="6" class="datagrid">
<tr>
<td>
            <table width="100%" cellpadding="3" cellspacing="2"  border="0">
            <form name="frmPhoto" id="frmPhoto" method="POST" target="" action="">
            {section name=i loop=$record}
            <input type="hidden" name="userid" value="{$record[i].userid}">
            <input type="hidden" name="photoid[]" value="{$record[i].photoid}">
            <input type="hidden" name="image[{$record[i].photoid}]" value="{$record[i].image}">
                 <tr>
		  <td width="25%" valign="top" rowspan="2"><img src="{$siteroot}/uploads/post_accomplish/145X145/{$record[i].image}">
		  <br><br><input type="radio" name="album_cover[]" id="album_cover_{$record[i].photoid}" value="{$record[i].photoid}" {if $record[i].album_cover eq '1'} checked="true" {/if}>&nbsp;Album Cover Photo
		  <br><input type="checkbox" name="trophy_case" id="trophy_case_{$record[i].photoid}" value="{$record[i].photoid}" onclick="if(!this.checked) untoggle('trophy_case_{$record[i].photoid}'); else toggle('trophy_case_{$record[i].photoid}'); " {if $record[i].trophy_case eq '1'} checked="true" {/if}>&nbsp;Trophy Case Photo
		  <br><input type="checkbox" name="delete[]" id="delete_{$record[i].photoid}" value="{$record[i].photoid}">&nbsp;Delete Photo
		  </td>
		  <td width="17%" valign="top">Description:</td><td valign="top"><textarea name="description[]" id="description_{$record[i].photoid}" cols="35" rows="4">{$record[i].description}</textarea></td>
		</tr>
		<tr>
		  <td valign="top">Tag others in Photo:</td><td valign="top"><textarea name="tag[]" id="tag_{$record[i].photoid}" cols="35" rows="4">{$record[i].tag}</textarea></td>
		</tr>
		<tr>
		  <TD colspan="3" style="border-bottom-color : #c6c6c6; border-bottom-style : solid; border-bottom-width : 1px;"></TD>
		</tr>
		<!--<tr>
		  <td width="25%" valign="top" rowspan="2"><img src="{$siteroot}/uploads/post_accomplish/145X145/{$record[i].image}"></td>
		  <td width="17%" valign="top">Description:</td><td><textarea name="description[]" id="description_{$record[i].photoid}" cols="35" rows="4">{$record[i].description}</textarea></td>
		</tr>
		<tr>
		  <td valign="top">Tag others in Photo:</td><td><textarea name="tag[]" id="tag_{$record[i].photoid}" cols="35" rows="4">{$record[i].tag}</textarea></td>
		</tr>
		<tr>
		  <TD colspan="3"><input type="radio" name="album_cover[]" id="album_cover_{$record[i].photoid}" value="{$record[i].photoid}" {if $record[i].album_cover eq '1'} checked="true" {/if}>&nbsp;Album Cover Photo</TD>
		</tr>
		<tr>
		  <TD colspan="3"><input type="checkbox" name="trophy_case" id="trophy_case_{$record[i].photoid}" value="{$record[i].photoid}" onclick="if(!this.checked) untoggle('trophy_case_{$record[i].photoid}'); else toggle('trophy_case_{$record[i].photoid}'); " {if $record[i].trophy_case eq '1'} checked="true" {/if}>&nbsp;Trophy Case Photo</TD>
		</tr>
		<tr>
		  <TD colspan="3"><input type="checkbox" name="delete[]" id="delete_{$record[i].photoid}" value="{$record[i].photoid}">&nbsp;Delete Photo</TD>
		</tr>-->
	   {/section}
		<tr>
			<td>&nbsp;</td>
			<td align="left" colspan="2"><div class="buttons"><input type="submit" name="submit" value="Save" class="button1"/></div>
			<div class="buttons">
			<input type="button" name="Cancel" id="Cancel" value="Cancel" class="button1" onclick="Javascipt: window.location = 'view-album.php?acc_id={$smarty.get.acc_id}&album_id={$smarty.get.album_id}'" />
			</div></td>
		</tr>
		</form>
	   </table>
</td>
</tr>
</table>
</div>
</div>
</div>
<!--main content ends -->

</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
{include file=$footer}