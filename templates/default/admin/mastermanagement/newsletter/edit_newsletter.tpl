{include file=$header1}
{strip}
	<meta content="text/html; charset=utf-8" http-equiv="content-type"/>
	<script type="text/javascript" src="{$siteroot}/ckeditor/ckeditor.js"></script>
	<script src="{$siteroot}/ckeditor/sample.js" type="text/javascript"></script>
	<link href="{$siteroot}/ckeditor/sample.css" rel="stylesheet" type="text/css"/>
<link href="{$siteroot}/js/timepicker/css/ui-lightness/jquery-ui-1.7.2.custom.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{$siteroot}/js/jquery-1.3.2.min.js"></script>

<script type="text/javascript" src="{$siteroot}/js/timepicker/js/jquery-ui-1.7.2.custom.min.js"></script>
<script type="text/javascript" src="{$siteroot}/js/timepicker/js/timepicker.js"></script>
<script language="javascript" src = "{$siteroot}/js/addnewpage.js"></script>
{literal}
<script type="text/javascript">
$(function() {
	
	$('#startdate').datepicker({
		duration: '',
		dateFormat:'yy-mm-dd',
		showTime: true,
		constrainInput: false,
		stepMinutes: 1,
		stepHours: 1,
		altTimeField: '',
		time24h: true
	});
});
</script>
{/literal}
{literal}
<script language="JavaScript" type="text/javascript">

function displayUsers(cityid){
		$.post("daily_emails_users.php",{cityid:cityid},function(data){
			$("#users").html(data);
	});
}
</script>
{/literal}
<!--{literal}
<script language="JavaScript" type="text/javascript">

function displayDeals(dealid){
		$.post(SITEROOT+"/admin/mastermanagement/newsletter/deal.php",{dealid:dealid},function(data){
			$("#deals").html(data);
	});
}
</script>
{/literal}-->

{/strip}
{include file=$header2}
<div id="msg" align="center">{$msg}</div>
<h2>{if $nl_id}Edit{else}Add{/if} Newsletter Content</h2><br>
{strip}
<script language="javascript" src = "{$siteroot}/js/addnewpage.js"></script>
<script language="javascript" src = "{$siteroot}/js/common.js"></script>
{/strip}
<!-- Edit Content Panel -->
<div Id="Content">
<form name="frm" method="post" action="" onSubmit="javascript:return checkfrm();" enctype="multipart/form-data">
<!--<input type="hidden" id="mode" name="mode" value="update">-->
<input type="hidden" id="nl_id" name="nl_id" value="{$nl_id}">
  <table width="100%"  border="0" cellspacing="0" cellpadding="5" class="Greenback">
	<tr>
		<td colspan="2"> <label for="Indicate Required Fields"><span class="red">*</span> Indicates Required Fields</lable></td>
	</tr>

{if $nl_id}
    <tr><td  colspan='2' align="right" class=''><a href="edit_newsletter.php?action=del&nl_id={$row.nl_id}" onClick="javascript:return confirm('Are you sure to delete Newsletter ?');"><b>Delete this newsletter</b></a></td>
</tr>
{ else}
    <tr>
      <td colspan="2" align="right"><a href="newsletter.php"><strong>Back</strong></a></td>
    </tr>
{/if}

	<tr>
		<td  align="left"><span class="red"></span>
		<span class="frmtxt style1" >City :</span></td>
		<td align="left" width="80%">
			<select name="cities" id="cities" onchange="javascript:displayUsers(this.value);">
				<option value="">-------Select One City-----</option>
				{section name=i loop=$categories1}
				<option value="{$categories1[i].city_id}" {if $categories1[i].city_id eq $row.city_id} selected="selected" {/if}>
				{$categories1[i].city_name}</option>
				{/section}
			</select>
		</td>
	</tr>
	<tr>
		<TD></TD>
		<TD colspan="2"><div id="users"></div></TD>
	</tr>

    <tr>
      <td  align="left" valign="top"><span class="red">*</span>&nbsp;<span class="frmtxt style1" >Name:</span></td>
      <td ><input name="pagename" type="text" class="frmtxt" id="pagename" size="55" value="{$row.nl_name}">
	   </td>
    </tr>
    <tr>
      <td align="left" valign="top"><span class="red">*</span>&nbsp;<span class="frmtxt style1" class="red">Title:</span></td>
      <td><input name="pagetitle" type="text" class="frmtxt" id="pagetitle" size="55" value="{$row.nl_title}">
	   </td>
    </tr>
	<tr>
		 <td valign="top" align="left"><span class="red">*</span>&nbsp;Newsletter Content: :</td>
		<td valign="top">
			{oFCKeditor->Create}
		</td>
	</tr>
	<tr>
	<td></td>
	<td><div align="left">
		<input name="Submit2" type="submit" class="button1" value="{if $nl_id}Update{else}Add{/if} Newsletter">
	</div></td>
    </tr>
  </table>
</form>
<!-- Edit Content Panel -->

</div>
{include file=$footer}