<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Admin Control Panel</title>
</head>
<body>
<link rel="stylesheet" href="{$siteroot}/templates/{$templatedir}/css/AdminLayout.css" type="text/css">
{strip}<script language="javascript" src="{$siteroot}/js/add_to_sub2.js"></script>{/strip}
<div id="contentBox">
	<table width="98%"  border="0" align="center" cellpadding="1" cellspacing="1" class="listtable">
	<form name="frm_add_to" method="post" action="" onSubmit="javascript:return add_checked(frm_add_to.check)">
		<tr class="backgroundtd">
		 <td align="left" colspan="2" ><b>List Of Subscribed Users</b></td>
		</tr>
		<tr class="backgroundtd">
			<td align="left" colspan="2"><b>Select Email Address</b></td>
			</tr>
		<tr class="backgroundtd">
			<td colspan="3">
			</td></tr>
	        <tr class="headbg">
		   <td width="7%" ><input name="maincheck" type="checkbox" value="checked" onClick="javascript:checkAll(frm_add_to.check)"></td>
		   <td width="60%">Email</td>
		   <td width="33%">City</td>
		 </tr>

			{section name=sec1 loop=$user}
		 <tr class="grayback bgOver">
			<td ><input name="menucheck" type="checkbox" value="{$user[sec1].nuemail}" /></td>
			<td>{$user[sec1].nuemail}</td>
			<td>{section name=i loop=$city_arr}{$city_arr[i].city_name}{/section}</td>
		  </tr>
		{sectionelse}
			<tr>
					<td colspan="3" class="error" align="center">No Records Found.</td>
			</tr>
		 	{/section}
		  
		  <tr>
			<td>&nbsp;</td>
				<td colspan="1"><input name="Submit" type="submit" value="Submit" onsubmit="javascript:return add_checked(frm_add_to.check)"  class="button">
			      <input name="close" type="button" value="Close" onClick="javascript:window.close()"  class="button"></td>
		  </tr>
		</form>
	</table>
</div>					
</body></html>