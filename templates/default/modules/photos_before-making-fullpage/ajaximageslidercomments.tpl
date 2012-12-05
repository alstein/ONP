<input type="hidden" name="pageid" id="pageid" value="1" />
{if $count_record gt '0'}	

{section name=i loop=$photo_comments max=3}
<li id="li_{$photo_comments[i].comment_id}" style="padding:3px">
<a href="{$siteroot}/my-account/{$photo_comments[i].userid}/my_profile_home">
{if $photo_comments[i].photo neq ''}
<img width="43" height="42" alt="" title="" src="{$siteroot}/uploads/user/{$photo_comments[i].photo}"/>
{else}
<img width="43" height="42" alt="" title="" src="{$siteroot}/uploads/user/nophoto.jpeg"/>
{/if}
</a>
<span style="position:absolute;margin-left:10px;">{$photo_comments[i].fullname|ucfirst}
<br/>{$photo_comments[i].comment}
</span>
{if $smarty.session.csUserId eq $photo_comments[i].posted_by}
<span style="position:absolute;margin-left:350px;"><a href="javascript:;" onclick="delcomments('{$photo_comments[i].comment_id}');">X</a></span>
{/if}
</li>
{sectionelse}
<li class="error" style="margin-left:200px">
No records found
<li>
{/section}
{if $photo_comments neq ''}
<div>
{if $total_page gt '1'}
      <input type="hidden" name="pageno" id="pageno" value="{$smarty.get.page}">
      <input type="hidden" name="total_page" value="{$total_page}">

<div style="margin-left:400px;">
	<strong><a href="javascript:;" {if $smarty.get.page eq ''} style="display:none;"  {else}  {if $smarty.get.page eq '1'}  style="display:none;"  {/if} {/if} onclick="sortOrder('Prev','{$smarty.get.page}','{$imageid}');">Prev</a>&nbsp;
	<a href="javascript:;"  {if $smarty.get.page eq $total_page} style="display:none;" {/if} onclick="sortOrder('Next','{$smarty.get.page}','{$imageid}');">Next</a></strong>
</div>
      {/if}
</div>
{/if}

{else}
      <div align="center" class="error"><strong>No Record Found</strong></div>
{/if}