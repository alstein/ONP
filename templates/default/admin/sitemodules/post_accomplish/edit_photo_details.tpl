{include file=$header1}
{literal}
<script type="text/javascript">
jQuery(document).ready(function()
{
	jQuery("#msg").fadeOut(5000);
});

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
            <input type="hidden" name="image" value="{$record.image}">
                 <tr>
		  <td width="25%" valign="top" rowspan="2"><img src="{$siteroot}/uploads/post_accomplish/145X145/{$record.image}">
		  <br><br><input type="radio" name="album_cover" id="album_cover_{$record.photoid}" value="{$record.photoid}" {if $record.album_cover eq '1'} checked="true" {/if}>&nbsp;Album Cover Photo
		  <br><input type="checkbox" name="trophy_case" id="trophy_case_{$record.photoid}" value="{$record.photoid}" {if $record.trophy_case eq '1'} checked="true" {/if}>&nbsp;Trophy Case Photo
		  <br><input type="checkbox" name="delete" id="delete_{$record.photoid}" value="{$record.photoid}">&nbsp;Delete Photo
		  </td>
		  <td width="17%" valign="top">Description:</td><td valign="top"><textarea name="description" id="description_{$record.photoid}" cols="35" rows="4">{$record.description}</textarea></td>
		</tr>
		<tr>
		  <td valign="top">Tag others in Photo:</td><td valign="top"><textarea name="tag" id="tag_{$record.photoid}" cols="35" rows="4">{$record.tag}</textarea></td>
		</tr>
		<tr>
		  <TD colspan="3" style="border-bottom-color : #c6c6c6; border-bottom-style : solid; border-bottom-width : 1px;"></TD>
		</tr>
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