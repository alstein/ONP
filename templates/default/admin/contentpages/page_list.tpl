{include file=$header1}
<script type="text/javascript" src="{$siteroot}/js/validation/admin/pagelist.js"></script>

{include file=$header2}


<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; Content pages</div>
<br />


<div class="holdthisTop">

  <h3 class="fl width50">Content pages</h3>
  <div class="clr"></div>
  {if $msg}<div id="msg" align="center">{$msg}</div>{/if}
    <!--{*}<div align="right">
        <img src="{$siteimg}/icons/add.png" align="absmiddle" class="thickbox" /><a href="edit_page.php">Add Page</a>
    </div>{*}-->
  <table width="100%"  align="center" cellpadding="2" cellspacing="2" border="0">
    <tr>
      <td>
	<form name="frmAction" id="frmAction" method="post" action="">
        <table width="100%"  border="0" cellpadding="6" cellspacing="2" class="listtable">
          <tr class="headbg">
           <!-- <td width="1%" align="center" valign="top"><input type="checkbox" id="checkall" /></td>-->
            <td width="70%" align="left" valign="top">Title</td>
       <!--     <td width="20%" align="left" valign="top">Page Category</td>-->
            <td width="30%" align="center" valign="top">Action</td>
          </tr>
          {section name=i loop=$pages}
          <tr class="grayback" id="tr_{$pages[i].pageid}">
            <!--<td align="center" valign="top">
             <input type="checkbox" name="pageid[]" value="{$pages[i].pageid}" /></td>-->
            <td align="left" valign="top">
            <!--<img src="{$siteimg}/icons/{if $pages[i].status  eq 'Inactive'}award_star_silver_1.png
						{else}award_star_silver_2.png{/if}"
						align="absmiddle" />-->{$pages[i].title|ucwords}</td>
       <!--     <td align="left" valign="top" >{$pages[i].page_category}</td>-->
	    <td align="center" valign="top"><img src="{$siteimg}/icons/application_edit.png" align="absmiddle" /> <a href="{$siteroot}/admin/contentpages/edit_page.php?pageid={$pages[i].pageid}" class="admintxt"><strong>Edit</strong></a></td>
          </tr>
	  {sectionelse}
	     <tr><td colspan="4"><strong>No Pages Found.</strong></td></tr>
          {/section}
	  
        </table>
	</form>
      </td>
      </tr>
  </table>
<!--</div>-->
</div>
{include file=$footer}