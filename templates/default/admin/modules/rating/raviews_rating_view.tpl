{include file=$header1}
{include file=$header2}

<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a>
<a href="{$siteroot}/admin/modules/rating/raviews_rating_deals_list.php?deal_id={$deal}">&gt; Review And Rating Deals List
 <a href="{$siteroot}/admin/modules/rating/raviews_rating_list.php?deal_id={$deal}">&gt;  Review And Rating List </a>
&gt; Review And Rating Information
</div>
<br/>
<h3>{if $smarty.get.userid eq 1}Admin{else}Rating{/if} Information</h3>

<div class="holdthisTop">
            <span style="float:right;"> <h3><a href="{$siteroot}/admin/modules/rating/raviews_rating_list.php?deal_id={$deal}">Back</a></h3> </span> 
                    <table width="100%" cellpadding="5" cellspacing="5" class="conttableDkBg conttable">
                        {if $emptyblog}
                         <tr>
                                <td width="25%" align="right">No Deals Rating Found </td>
                        </tr>
                        {else}
                        <tr>
                                <td width="25%" align="right" ><strong>Deal Name: </strong></td><td  align="left"> {$dealname|html_entity_decode} </td>
                        </tr>
                        <tr>
                                <td width="25%" align="right"><strong>User Name: </strong></td><td  align="left"> {$fristname}  {$lastname} </td>
                        </tr>
                        <tr>
                                <td width="25%" align="right" ><strong>Review Text: </strong></td><td  align="left">{$feedback_text} </td>
                        </tr>
                         <tr>
                                <td align="right" valign="top"><strong>Rating Mark: </strong></td><td align="left">
                                            <table>
                                            {section name=i loop=$subprofile}
                                            <tr>
                                             <td>{$subprofile[i].rating_question}</td>
                                                {section name=loop start=1 loop=6}
                                                                <td>   {if $smarty.section.loop.index <=  $subprofile[i].rating_mark}
                                                                                <img src="{$siteroot}/templates/default/images/admin/rating.png" align="absmiddle"/>
                                                                        {else}
                                                                            <img src="{$siteroot}/templates/default/images/admin/star-empty.png" align="absmiddle">  
                                                                        {/if}
                                                                </td>
                                                {/section}
                                                </tr>
                                            {sectionelse}
                                            <tr>
                                                <td></td>
                                                <td>-----</td>
                                            </tr>
                                             {/section}
                                            </table>
                                 </td>
                        </tr>
                        <tr>
                            <td align="right"><strong>Rating Date:</strong> </td><TD  align="left">{$ratingdate|date_format:$smarty_date_format}</td>
                        </tr>
                        {/if}
    </table> 
  </div>
{include file=$footer}
