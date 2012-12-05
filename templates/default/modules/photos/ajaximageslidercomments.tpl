{strip}
<!--<script type="text/javascript" src="{$sitejs}/jquery.timeago.js"></script>-->
{/strip}
{literal}
<script type="text/javascript">
 jQuery(document).ready(function()
    {
	showdate();
    });
function showdate()
{
var trs = document.getElementsByTagName("abbr");

	for(var i=0;i<trs.length;i++)
	{
		j=i+1;
  		jQuery("#timeago_"+j+"").timeago(); 
	}

}
function showdelete(commentid){

    $(".dlteimg"+commentid).show();

}

function hidedelete(commentid){
      $(".dlteimg"+commentid).hide();
}

</script>
{/literal}
<input type="hidden" name="pageid" id="pageid" value="1" />
{if $count_record gt '0'}

{section name=i loop=$photo_comments}
<li id="li_{$photo_comments[i].comment_id}" style="padding:3px;border-bottom:solid 1px #DBDCDE; width:255px; overflow:hidden;" onmouseover="showdelete({$photo_comments[i].comment_id})" onmouseout="hidedelete({$photo_comments[i].comment_id})" >
<a href="{$siteroot}/my-account/{$photo_comments[i].userid}/my_profile_home" class="fl">
{if $photo_comments[i].photo neq ''}
<img width="43" height="42" alt="" title="" src="{$siteroot}/uploads/user/{$photo_comments[i].photo}"/>
{else}
<img width="43" height="42" alt="" title="" src="{$siteroot}/uploads/user/nophoto.jpeg"/>
{/if}
</a>
<span style="margin-left:10px; float:left; width:180px"><span style="color:#2B587A"><b>{$photo_comments[i].fullname|ucfirst}</b></span>
<br/>{$photo_comments[i].comment}<br />
 
<p class="time">{$photo_comments[i].posted_on}<!--<abbr id="timeago_{$smarty.section.i.iteration}" title="{$photo_comments[i].posted_on}">{$photo_comments[i].posted_on}</abbr>--></p>
</span>
{if $smarty.session.csUserId eq $photo_comments[i].posted_by}
<span style="float:right" class="cmnt"><a href="javascript:;" onclick="delcomments('{$photo_comments[i].comment_id}');" class="dlteimg{$photo_comments[i].comment_id}" style="display:none" name="here">X</a></span>
{/if}
</li>
{sectionelse}
<li class="error" style="margin-left:200px">
No records found
<li>

{/section}

{if $photo_comments neq ''}
<!--<div>
{if $total_page gt '1'}
      <input type="hidden" name="pageno" id="pageno" value="{$smarty.get.page}">
      <input type="hidden" name="total_page" value="{$total_page}">
<br>
<div style="margin-left:395px;">
	<strong><a href="javascript:;" {if $smarty.get.page eq ''} style="display:none;"  {else}  {if $smarty.get.page eq '1'}  style="display:none;"  {/if} {/if} onclick="sortOrder('Prev','{$smarty.get.page}','{$imageid}');">Prev</a> &nbsp;
	<a href="javascript:;"  {if $smarty.get.page eq $total_page} style="display:none;" {/if} onclick="sortOrder('Next','{$smarty.get.page}','{$imageid}');">Next</a></strong>
</div>
      {/if}
</div>-->
{/if}

{else}
      <div align="center" class="error"><strong>No Record Found</strong></div>
{/if}