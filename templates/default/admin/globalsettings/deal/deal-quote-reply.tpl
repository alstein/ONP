{include file=$header1}
{include file=$header2}

<h3>Quote Comment</h3>

<div class="holdthisTop" style="float:left">
	{if $msg}<div align="center" style="color:green">{$msg}</div>{/if}
      <span style="float:right;"> <h4><a href="javascript:history.go(-1);">Back</a> | <img align="absmiddle" src="{$siteroot}/templates/default/images/icons/add.png" alt="add" /><a href="{$siteroot}/admin/globalsettings/deal/deal-quote.php?id={$dealid}" > Re-Quote </a> | <img align="absmiddle" src="{$siteroot}/templates/default/images/icons/add.png" alt="add" />  <a  href="seller-reply-popup.php?id={$smarty.get.id}&amp;placeValuesBeforeTB_=savedValues&amp;TB_iframe=true&amp;height=350&amp;width=600&amp;modal=false" class="thickbox" title="Reply Seller" linkindex="2" set="yes"><strong>Reply seller</strong></a> </h4> </span>

      <table width="100%" cellpadding="1" cellspacing="5" class="conttableDkBg conttable">
	  {section name=i loop=$comment}
          <tr><td width="25%" align="right" style="vertical-align:top" ><strong>Comment: </strong></td><td  align="left"> {$comment[i].comment} </td></tr>
          <tr><td align="right"><strong>Posted Date: </strong></td><td align="left">{$comment[i].posted_date}</td></tr>
	  <tr><TD>&nbsp;</TD></tr>
          {sectionelse}
          <tr><TD colspan="2" align="center"><strong>No record(s) found.</strong></TD></tr>    
          {/section}
      </table>
  </div>
{include file=$footer}