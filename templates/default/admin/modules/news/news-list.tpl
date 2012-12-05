{include file=$header1}
<script type="text/javascript" src="{$siteroot}/js/validation/admin/news.js"></script>

{include file=$header2}
<div class="holdthisTop">

  <h3 class="fl width50">News</h3>
  <div class="clr"></div>
  {if $msg}<div id="msg" align="center">{$msg}</div>{/if}
    <div align="right">
        <img src="{$siteimg}/icons/add.png" align="absmiddle" class="thickbox" /><a href="edit-news.php">Add News</a>
    </div>
  <table width="100%"  align="center" cellpadding="2" cellspacing="2" border="0">
    <tr>
      <td>
	<form name="frmAction" id="frmAction" method="post" action="">
        <table width="100%"  border="0" cellpadding="6" cellspacing="2" class="listtable">
          <tr class="headbg">
            <td width="1%" align="center" valign="top"><input type="checkbox" id="checkall" /></td>
            <td width="30%" align="left" valign="top">Title</td>
            <td width="20%" align="left" valign="top">Description</td>
            <td width="10%"  valign="top">Start Date</td>
            <td width="10%"  valign="top">End Date</td>
            <td width="10%"  valign="top">User Type</td>
            <td width="10%"  valign="top">Action</td>
          </tr>
          {section name=i loop=$news}
          <tr class="grayback" id="tr_{$news[i].news_id}">
            <td align="center" valign="top"><input type="checkbox" name="news_id[]" value="{$news[i].news_id}" /></td>
            <td align="left" valign="top">{$news[i].news_title|ucfirst}</td>
            <td align="left" valign="top">{$news[i].description|truncate:30}</td>
            <td valign="top" >{$news[i].start_date}</td>
            <td valign="top" >{$news[i].end_date}</td>
            <td  valign="top" >{if $news[i].user_type eq 2}Buyer{else}Seller{/if}</td>
	    <td align="center" valign="top"><img src="{$siteimg}/icons/application_edit.png" align="absmiddle" /> <a href="{$siteroot}/admin/modules/news/edit-news.php?news_id={$news[i].news_id}" class="admintxt"><strong>Edit</strong></a></td>
          </tr>
	  {sectionelse}
	     <tr><td colspan="4" align="center"><strong>No news found.</strong></td></tr>
          {/section}
          {if $news}
	  <tr>
              <td align="right">  <img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"  /></td>
	      <td colspan="3" align="left">
		<select name="action" id="action"><option value="">--Action--</option><option value="delete">Delete</option></select>
		<input type="submit" name="submit" id="submit" value="Go" /><span id="acterr" class="error"></span>
	      </td>
	  </tr>
          {/if}
        </table>
	</form>
      </td>
      </tr>
  </table>
<!--</div>-->
</div>
{include file=$footer}