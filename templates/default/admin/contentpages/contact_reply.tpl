{include file=$header1}
	<script language="javascript" src = "{$siteroot}/js/addreply.js"></script>
{literal}
<script language="JavaScript">
	$(document).ready(function()
{
$('#frm').submit(function(){
                    if ($('div.error').is(':visible'))
            {
            } 
            else 
            { 
                $('#submit').hide(); 
                $('#buttonregister').append("<input type='button' name='submit' id='submit' value='Submit' />"); 
            }
        });
});
</script>
{/literal}
{include file=$header2}
<div class="breadcrumb">
  <a href="{$siteroot}/{$AdminFolderName}/index.php">Home</a> &gt; <a href="{$siteroot}/admin/contentpages/contact_us.php">Contact Us</a> &gt; <a href="{$siteroot}/admin/contentpages/view_reply.php?id={$smarty.get.cid}">View Reply</a> &gt; Contact reply
</div>
<div>&nbsp;</div>
<div style="float:left;">
<form name="frm" id="frm" method="POST" action="">
<input type="hidden" name="cid" value="{$smarty.get.cid}">
<table width="100%" border="0" cellspacing="2" cellpadding="6">
	<tr>
		<td colspan="2" align="right"><a href="view_reply.php?id={$smarty.get.cid}"><strong>Back</strong></a></td>
	</tr>
	<TR>
		<td width="20%" align="right">To :</td>
		<td>{$email.emailId}</td>
	</TR>
	<tr>	
		<td width="20%" align="right">Subject :</td>
		<td><input type="text" name="subject" id="subject" value="Re : {$email.subject}" size="50"></td>
	</tr>
	<tr>
		<td width="20%" align="right">Message :</TD>
		<td>
			<textarea rows="5" cols="60" name="message" id="message">Message : {$email.message} </textarea>
		</td>
	</tr>
	<tr>
		<TD>&nbsp;</TD>
		<td><span id="buttonregister"><input type="submit" name="submit" id="submit" value="Submit"></span></td>
	</tr>
</table>
</form>
</div>
{include file=$footer}