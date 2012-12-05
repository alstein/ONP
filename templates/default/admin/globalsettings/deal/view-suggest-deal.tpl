{include file=$header1}
{include file=$header2}

<div class="breadcrumb">
    <a href="{$siteroot}/admin/globalsettings/deal/suggest-deal.php">Manage Suggest Deal</a> &nbsp;&gt;&nbsp;View Suggest Deal
</div><br/>

<h3> &nbsp;View Suggest Deal</h3>

{if $msg}<div align="center">{$msg}</div>{/if}

<div class="holdthisTop">
  <div style="margin-left:94%;"><a href="javascript: void(0);" onclick="javascript:history.go(-1);"><b>Back</b></a></div>
  <table width="97%" class="conttableDkBg conttable" border="0" style="border:1px solid #000000;" cellspacing="5" cellpadding="5">
    <tr>
      <td align="right"  valign="top"><strong>Username:&nbsp;</strong></td>
      <td align="left">{$user_msg_info.user_name|capitalize}</td>
    </tr>
    <tr>
      <td align="right"  valign="top"><strong>Product Name:&nbsp;</strong></td>
      <td align="left">{$user_msg_info.product_name|ucfirst}</td>
    </tr>
    <tr>
      <td align="right" width="20%" valign="top"><strong>Posted Date: </strong></td>
      <td align="left" width="80%">{$user_msg_info.posted_date|date_format:"%A, %B %e, %Y"}</td>
    </tr>
    <tr>
      <td align="right"  valign="top"><strong>Comment:&nbsp;</strong></td>
      <td align="left">{$user_msg_info.comment|stripslashes|html_entity_decode}</td>
    </tr>

  </table>
</div>
{include file=$footer}