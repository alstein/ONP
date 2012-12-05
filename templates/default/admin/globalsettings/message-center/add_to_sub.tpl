<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Admin Control Panel</title>
<link rel="stylesheet" href="{$siteroot}/templates/{$templatedir}/css/AdminLayout.css" type="text/css">

{strip}
<script language="javascript" src="{$siteroot}/js/add_to_sub2.js"></script>
{/strip}
</head>
<body>
<div id="contentBox">
	<form name="frm_add_to" method="post" action="" onSubmit="javascript:return add_checked(frm_add_to.check)">
	<table width="80%"  border="0" align="center" cellpadding="1" cellspacing="1" class="listtable" id="listtable">
		<tr class="backgroundtd"> <td align="left" colspan="2" ><b>List Of Subscribed Users</b></td></tr>
		<tr class="backgroundtd"><td align="left" colspan="2"><b>Select Email Address</b></td></tr>
		<tr class="backgroundtd"><td colspan="3">&nbsp;</td></tr>
	        <tr class="headbg">
		   <td width="2%" ><input name="maincheck" type="checkbox" value="checked" onClick="javascript:checkAll(frm_add_to.check)"></td>
		   <td width="60%">Email</td>
		 </tr>

		{section name=i loop=$user}
                {if $user[i].email}
		 <tr class="grayback bgOver">
			<td ><input name="menucheck" id="menucheck" type="checkbox" value="{$user[i].email}" /></td>
			<td>{$user[i].email}</td>
		  </tr>
                {/if}
		{sectionelse}
		<tr><td colspan="3" class="error" align="center">No Records Found.</td></tr>
		{/section}
		<tr>
		    <td>&nbsp;</td>
		    <td colspan="1">
			<input name="Submit" type="submit" value="Submit"  class="button">
			<input name="close" type="button" value="Close" onClick="javascript:window.close()"  class="button">
		    </td>
		</tr>
	</table>
	</form>
</div>					
</body></html>