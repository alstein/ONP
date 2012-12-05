{include file=$header1}
<script type="text/javascript" src="{$siteroot}/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="{$siteroot}/js/forum.js"></script>
{include file=$header2}
<div class="holdthisTop">
<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; <a href="{$siteroot}/admin/modules/forum/index.php">Discussion</a> &gt; {if $forum.forumid}Edit{else}Add{/if} Discussion </div>
<div id="msg" align="center">{$msg}</div><br/>
<form action="" method="post" name='frmForum' id="frmForum">
  <input type="hidden" name="forumid" value="{$forum.forumid}" />
  <table width="80%" border="0" cellspacing="5" cellpadding="5" class="conttableDkBg conttable">
  
  <tr>
      <td align="right">Deal Name: </td>
      <td align="left">
       <select name="dealname" style="width:250px;">
        
                {section name=i loop=$deal}
                <option value="{$deal[i].deal_unique_id}" {if $forum.deal_id eq $deal[i].deal_unique_id}selected="selected"
                {elseif $smarty.get.deal_id eq $deal[i].deal_unique_id}selected="selected"{/if}>{$deal[i].title|html_entity_decode}</option>
                {/section}
       
      </select>
      </td>
    </tr> 
    <tr>
      <td align="right">Discussion Category: </td>
      <td align="left">
        {if $forum.forumid}
                {section name=i loop=$categories}
                    {if $forum.categoryid eq $categories[i].categoryid}
                        <input type="hidden" name="categoryid" id="categoryid" value="{$categories[i].categoryid}" />
                        <h3>{$categories[i].category}</h3>
                    
                    {/if}
                 {/section}
        {else}
           <!-- <select name="categoryid" style="width:250px;">
            {*section name=i loop=$categories}
                 <option value="{$categories[i].categoryid}" {if $forum.categoryid eq $categories[i].categoryid} selected="selected"{elseif $smarty.get.categoryid eq $categories[i].categoryid} selected="selected"{/if}>{$categories[i].category}</option>
            {/section*}
            </select>-->
             {section name=i loop=$categories}
                {if $smarty.get.categoryid eq $categories[i].categoryid}
                    <input type="hidden" name="categoryid" id="categoryid" value="{$categories[i].categoryid}"/>
                        <h3>{$categories[i].category}</h3>
                {/if}
            {/section}
       {/if}
      </td>
    </tr>
    <tr>
      <td align="right">Title: </td>
      <td align="left"><input type="text" size="60" maxlength="100" name="title" id="title" value="{$forum.title}" /></td>
    </tr>
    <tr  valign="top" >
      <td align="right">Description: </td>
      <td><textarea name="description" id="description" rows="10" cols="60">{$forum.description}</textarea></td>
    </tr>
    <tr align="left" >
      <td>&nbsp;</td>
      <td><input type="submit" onclick="" value="Save" name="submit"/>
      </td>
  </table>
</form>
</div>
{include file=$footer}