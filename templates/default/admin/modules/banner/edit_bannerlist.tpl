{include file=$header1}
{strip}
	<meta content="text/html; charset=utf-8" http-equiv="content-type"/>
	<script language="javascript" type="text/javascript" src="{$siteroot}/js/calendarDateInput.js"> </script>
	<script language="javascript" type="text/javascript" src="{$siteroot}/js/validation/admin/bannerlist.js"> </script>


{/strip}

{if $banner_id}

<input type="hidden" id="banner_id" name="banner_id" value="{$banner_id}">

{strip}
	<meta content="text/html; charset=utf-8" http-equiv="content-type"/>
	<script language="javascript" type="text/javascript" src="{$siteroot}/js/calendarDateInput.js"> </script>

{/strip}
{else}
{strip}
<meta content="text/html; charset=utf-8" http-equiv="content-type"/>
<script language="javascript" type="text/javascript" src="{$siteroot}/js/calendarDateInput.js"> </script>
<script language="javascript" src = "{$siteroot}/js/addbanner5.js"></script>
{/strip}
{/if}

{include file=$header2}

<h2>{if $banner_id}Edit{else}Add{/if} Advertisement categories</h2><br>
<!-- Edit Content Panel -->


<div Id="Content">
<form name="frm" id="frm" method="post" action="" enctype="multipart/form-data" >
<input type="hidden" id="charityid" name="charityid" value="{$charityid}">
   <table width="100%"  border="0" cellspacing="0" cellpadding="5" class="Greenback">
	<tr>
	</tr>
	<tr>
		<td colspan="100%" align="right"><a href="banner_list.php">
		<strong>Back</strong></a></td>
	</tr>

	<tr>
		<TD colspan="100%">&nbsp;</TD>
	</tr>

	<tr>
              <td width="20%" align="right"><span class="red"></span>
			<span class="frmtxt style1" >Name:</span></td>
              <td colspan="2" align="left" width="80%"><input type="text" name="name" class="textbox" id="name" value="{$banner.name}" maxlength="65">
              </td>
      </tr>

	<tr>
		<TD colspan="100%"></TD>
	</tr>

	<tr>
		<td>&nbsp;</td>
		<td colspan="100%">
			<div align="left" style="flote:left">
			<input name="Submit" type="submit" value="{if $banner_id}Update{else}Add{/if} Banner">&nbsp;&nbsp;&nbsp;&nbsp;	
			<input type="button" name="Cancel" value="Cancel" onclick="javascript: location='banner_list.php';" /></td>
		</div>
		</td>
	</tr>
  </table>
</form>
</div>
</div>
</div>
{include file=$footer}