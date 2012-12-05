{include file=$header1}

{strip}
<script type="text/javascript" src="{$siteroot}/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/chk_compose.js"></script>
{/strip}

{include file=$header2}

<div class="breadcrumb">
    <a href="{$siteroot}/admin/modules/member-message/member-message.php">Manage Messages</a> &nbsp;&gt;&nbsp;Compose Message
</div><br/>

<h3> &nbsp;Compose Message</h3>

{if $msg}<div align="center">{$msg}</div>{/if}

<div class="holdthisTop">
    <div style="margin-left:94%;"><a href="{$siteroot}/admin/modules/member-message/member-message.php"><b>Back</b></a></div>
    <form name="frmAction" id="frmAction" method="post">
	<table cellpadding="0" cellspacing="3" align="center">
	  <tr><td>&nbsp;</td></tr>
	  <tr>
	    <td align="right" valign="top"><strong>To: </strong></td>
	    <td><input type="text" name="email_id" id="email_id" value="{$getuser.first_name} {$getuser.last_name} ({$getuser.email})" readonly="true" size="41"/></td>
	  </tr>
	  <tr><td>&nbsp;</td></tr>
	  <tr>
	      <td align="right" valign="top"><strong>Subject: </strong></td>
	      <td><input type="text" name="message_subject" id="message_subject" value="" size="41"/></td>
	  </tr>
	  <tr><td>&nbsp;</td></tr>
	  <tr>
	      <td align="right" valign="top"><strong> Message: </strong></td> 
	      <td><textarea  cols="47" rows="5" name="msg_details" id="msg_details"> </textarea></td>
	  </tr> 
	  <tr><td>&nbsp;</td></tr>
	  <tr>
	    <td>&nbsp;</td> 
	    <td><input type="submit" name="send" class="deletebtn" value="Send"/> </textarea></td>
	  </tr>
	  <tr><td>&nbsp;</td></tr>
	</table>
  
</form>
</div>
{include file=$footer}