{include file=$header1}
{include file=$header2}

<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> <a href="{$siteroot}/admin/modules/rating/rating_list.php">&gt; Rating List </a>
&gt; Rating Information
</div>
<br/>
<h3>{if $smarty.get.userid eq 1}Admin{else}Rating{/if} Information</h3>

<div class="holdthisTop">
      <span style="float:right;"> <h3><a href="{$siteroot}/admin/modules/rating/rating_list.php">Back</a></h3> </span>
     
      <table width="100%" cellpadding="5" cellspacing="5" class="conttableDkBg conttable">
          <tr><td width="25%" align="right"><strong>Deal Name: </strong></td><td  align="left"> {$dealname} </td></tr>
          <tr><td width="25%" align="right"><strong>User Name: </strong></td><td  align="left"> {$fristname}  {$lastname} </td></tr>
          <tr><td align="right"><strong>Rating Mark: </strong></td><td align="left">
           {assign var=j value=1}
		 {section name=j loop=$ratingmark}
		  <img src="{$siteroot}/templates/default/images/admin/rating.png" align="absmiddle"/>
		 {/section}
         <!-- {$ratingmark}--></td></tr>
          <tr><td align="right"><strong>Rating Date:</strong> </td><TD  align="left">{$ratingdate|date_format:$smarty_date_format}</td> </tr>
    </table> 
  </div>
{include file=$footer}
