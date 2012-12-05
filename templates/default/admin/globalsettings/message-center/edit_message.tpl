
<script type="text/javascript" src="{$sitejs}/jquery-1.2.6.pack.js"></script>
<script type="text/javascript" src="{$sitejs}/jquery.validate.pack.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/addnewpage.js"></script>
<!--<script type="text/javascript" src="{$siteroot}/ckeditor/ckeditor.js"></script>-->
<!--<script type="text/javascript" src="{$siteroot}/js/addnewpage.js"></script>-->

<div id="msg" align="center">{$msg}</div>
<h2>{if $nl_id}Edit{else}Add{/if}  Message Content</h2><br>

<div Id="Content">
<form name="frm" method="post" action="" id="frm"  enctype="multipart/form-data">
<input type="hidden" id="nl_id" name="nl_id" value="{$nl_id}">
<input type="hidden" id="did" name="did" value="{$smarty.session.demorec.nl_name}">


<div id="demo"></div>

<table width="100%"  border="0" cellspacing="0" cellpadding="5" class="Greenback">
	<tr>
		<td colspan="2"> <label for="Indicate Required Fields"><span style="color:red">*</span> Indicates Required Fields</lable></td>
	</tr>
	<tr>
		<TD></TD>
		<TD colspan="2"><div id="users"></div></TD>
	</tr>
	<tr>
      		<td  align="right" valign="top"><span style="color:red">*</span> Name: </td>
      		<td style="color:red"><input name="pagename" type="text" class="frmtxt" id="pagename" size="55" value="{if $row.nl_name}{$row.nl_name}{else}{$demoid.nl_name}{/if}"></td>
    	</tr>
    	<tr>
      		<td align="right" valign="top"><span style="color:red">*</span> Title: </span></td>
      		<td style="color:red"><input name="pagetitle" type="text" class="frmtxt" id="pagetitle" size="55" value="{if $row.nl_title}{$row.nl_title}{else}{$demoid.nl_title}{/if}"></td>
    	</tr>
	<tr>
		<td valign="top" align="right"><span style="color:red">*</span> Message Content: </td>
		<td valign="top" style="color:red">{*oFCKeditor->Create*}{$oFCKeditorDesc}</td>
	</tr>
	<tr>
	<td></td>
	<td><div align="left">
		<input name="Submit2" type="submit" value="{if $nl_id}Update{else}Add{/if} message">
	</div></td>
    </tr>
  </table>
</form>
<!-- Edit Content Panel -->

</div>
