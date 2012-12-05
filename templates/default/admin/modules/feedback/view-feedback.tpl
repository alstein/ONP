{include file=$header1}
{include file=$header2}

<div class="breadcrumb">
    <a href="{$siteroot}/admin/modules/feedback/feedback.php">Manage Feedback</a> &nbsp;&gt;&nbsp;View Feedback Details
</div><br/>

<h3> &nbsp;View Feedback </h3>

{if $msg}<div align="center">{$msg}</div>{/if}

<div class="holdthisTop">
  <div style="margin-left:94%;"><a href="{$siteroot}/admin/modules/feedback/feedback.php"><b>Back</b></a></div>
  <table width="97%" class="conttableDkBg conttable" border="0" style="border:1px solid #000000;" cellspacing="5" cellpadding="4">
    <tr>
      <td align="right" width="20%" valign="top"><strong>Username :&nbsp;</strong></td>
      <td align="left" width="80%">{$f_info.user_name|capitalize}</td>
    </tr>
    <tr>
      <td align="right"  valign="top"><strong>Deal Name :&nbsp;</strong></td>
      <td align="left">{$f_info.deal_name|capitalize}</td>
    </tr>
    <tr>
      <td align="right"  valign="top"><strong>Feedback Received :&nbsp;</strong></td>
      <td align="left">{$f_info.total}%</td>
    </tr>
    <tr>
      <td align="right" width="20%" valign="top"><strong>Posted Date : </strong></td>
      <td align="left" width="80%">{$f_info.posted_date|date_format:"%A, %B %e, %Y"}</td>
    </tr>
    <tr>
      <td align="right"  valign="top"><strong>Review : </strong></td>
      <td align="left">{$f_info.review|html_entity_decode}</td>
    </tr>

  </table>
</div>
{include file=$footer}