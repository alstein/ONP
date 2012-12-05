{include file=$header1}
{strip}
	<meta content="text/html; charset=utf-8" http-equiv="content-type"/>
	<script type="text/javascript" src="{$siteroot}/ckeditor/ckeditor.js"></script>
	<script src="{$siteroot}/ckeditor/sample.js" type="text/javascript"></script>
	<link href="{$siteroot}/ckeditor/sample.css" rel="stylesheet" type="text/css"/>
{/strip}

{strip}
<script language="javascript" src = "{$siteroot}/js/addnewpage.js"></script>
<script language="javascript" src = "{$siteroot}/js/common.js"></script>
{/strip}
{include file=$header2}
<h2 class="txt13 padingTop">Add newsletter</h2>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="1">
	<tr>
		<TD>&nbsp;</TD>
		<TD align="right"><a href="newsletter.php"><b>Back</b></a></TD>
	</tr>
	<tr>
		<td colspan="2"> <label for="Indicate Required Fields"><span class="red" >*</span> Indicates Required Fields</lable></td>
	</tr>

</table>
<!-- Edit Content Panel -->
<div id="Content">
<form name="frm" method="post" action="nl_success.php" onSubmit ="javascript:return checkfrm();">
<input type="hidden" id="mode" name="mode" value="add">

	<tr>
		<td>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="1" class="listtable" >
	<tr class="txtwhitebld" >
		<td colspan='4' class='txtwhitebld'></TD>
	</tr>
	<tr>
      	<td>&nbsp;</td>
	</tr>
	<tr>
		<td align="left" valign="top" ><label for="pagename"><span class="red">*</span>Newsletter Name:</span></td>
		<td><input name="pagename" type="text" class="frmtxt" id="pagename" size="55"></td>
	</tr>
	<tr>
		<td align="left" valign="top"><span class="red">*</span>Newsletter Title:</span></td>
		<td><input name="pagetitle" type="text" class="frmtxt" id="pagetitle" size="55"></td>
	</tr>
	<tr>
		<td valign="top" align="left"><span class="red">*</span>Newsletter Content: :</td>
		<td valign="top">{oFCKeditor->Create}</td>
	</tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
      	<td><div align="left"><input name="Submit2" type="submit" class="button1" value="Add Newsletter"></div></td>
	</tr>
</table>
		</td>	
	</tr>

</table>
</form>
</div>
{include file=$footer}