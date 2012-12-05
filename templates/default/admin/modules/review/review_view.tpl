{include file=$header1}
{include file=$header2}

<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> <a href="{$siteroot}/admin/modules/review/review_list.php">&gt; Review List </a>
&gt; Review Information
</div>
<br/>

<h3>{if $smarty.get.userid eq 1}Admin{else}Review{/if} Information</h3>

<div class="holdthisTop">
      <span style="float:right;"> <h3><a href="{$siteroot}/admin/modules/review/review_list.php">Back</a></h3> </span>
     
      <table width="100%" cellpadding="5" cellspacing="5" class="conttableDkBg conttable">
          <tr><td width="25%" align="right"><strong>Deal Name: </strong></td><td align="left"> {$dealname} </td></tr>
          <tr><td width="25%" align="right"><strong>Reviewer Name :</strong></td><td  align="left">{$reviewname}   </td></tr>
          <tr><td align="right"><strong>Review Date: </strong></td><td align="left">{$reviewdate|date_format:$smarty_date_format}</td></tr>
          <tr><td align="right" valign="top"><strong>Review Text:</strong> </td><td align="left">{$reviewtext}</td> </tr>
    </table> 
  </div>
{include file=$footer}
