{include file=$header1}
<!--<META HTTP-EQUIV=Refresh CONTENT="3"> -->
{include file=$header2}

<div class="breadcrumb">
    <a href="{$siteroot}/admin/modules/admin-message/admin-message.php">Manage Admin Messages</a> &nbsp;&gt;&nbsp;View Admin Message
</div><br/>

<h3> &nbsp;View Admin Message Details</h3>

{if $msg}<div align="center">{$msg}</div>{/if}

<div class="holdthisTop">
  <div style="margin-left:94%;"><a href="javascript: void(0);" onclick="javascript:history.go(-1);"><b>Back</b></a></div>
  <table width="97%" class="conttableDkBg conttable" border="0" style="border:1px solid #000000;" cellspacing="5" cellpadding="5">
   <!-- <tr><td>&nbsp;</td></tr>-->
    <tr>
      <td align="right" width="20%" valign="top"><strong>To:&nbsp;</strong></td>
      <td align="left" width="80%">{$user_msg_info.revever_name|capitalize}</td>
    </tr>
    <tr>
      <td align="right"  valign="top"><strong>From:&nbsp;</strong></td>
      <td align="left">{$user_msg_info.from_name|capitalize}</td>
    </tr>
    <tr>
      <td align="right"  valign="top"><strong>Subject:&nbsp;</strong></td>
      <td align="left">{$user_msg_info.subject}</td>
    </tr>
    <tr>
      <td align="right" width="20%" valign="top"><strong>Posted Date: </strong></td>
      <td align="left" width="80%">{$user_msg_info.posted_date|date_format:"%A, %B %e, %Y"}</td>
    </tr>
    <tr>
      <td align="right"  valign="top"><strong>Message: </strong></td>
      <td align="left"><br/>{$user_msg_info.message|html_entity_decode}</td>
    </tr>
  </table>
</div>
{include file=$footer}