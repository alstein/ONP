{include file=$header1}
<script type="text/javascript" src="{$siteroot}/js/ajax.js"></script>
<script type="text/javascript" src="{$siteroot}/js/ajax_user_search.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/userlist.js"></script>

{include file=$header2}

<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; SEO</div>
<br />

<div class="holdthisTop">
    <div>
	<div class="fl width50">
		<h3>{$sitetitle} SEO</h3>
	</div>
	<div class="clr">&nbsp;</div>
	{if $msg}<div align="center" id="msg">{$msg}</div>{/if}
    </div>
    <div class="clr">&nbsp;</div>
    <div id="UserListDiv" name="UserListDiv">
      <form name="frmAction" id="frmAction" method="post" action="">
	<table cellspacing="2" cellpadding="3" class="listtable" width="100%">	
		<tr class="headbg">			
		  <!--<td width="1%" align="center"><input type="checkbox" id="checkall"/></td>-->
		  <td width="10%" align="left">Pagename</td>
		  <td width="10%" align="left">Meta Title</td>
		 
		  <td width="10%" align="left">Metatag Description</td>
		  <td width="10%" align="left">Metatag Keyword</td>
		  <td width="8%" align="center">Action</td>
		</tr>
		{section name=i loop=$list}
		<tr class="grayback" id="chk{$smarty.section.i.iteration}">
		 <!-- <td>{if $list[i].id eq 1}#{else}<input type="checkbox" value="{$list[i].id}" name="id[]"/>{/if}</td>-->
		  <td valign="top">
                      <!--<img src="{$siteimg}/icons/{if $users[i].status  eq 'inactive'}award_star_silver_1.png{else}award_star_silver_2.png{/if}" align="absmiddle" />
                      <a href="user_view.php?userid={$users[i].userid}" title="Show Admin Details">-->{$list[i].page_name}</td>
		  <td valign="top">{$list[i].meta_title}</td>
		 <!-- <td valign="top">{$list[i].meta_title}</td>-->
		  <td valign="top" align="left">{$list[i].meta_tag_description}</td>
                 
		  <td valign="top">{$list[i].meta_tag_keyword}</td>
		  <td align="center">
                      <img src="{$siteroot}/templates/default/images/icons/application_edit.png" align="absmiddle" />
		      <a href="edit_seo.php?editid={$list[i].id}" title="Edit SEODetails"><strong>Edit</strong></a>
		  </td>
		</tr>
		{sectionelse}
			<tr><td colspan="6" class="error" align="center">No Records Found.</td></tr>
		{/section}
					
		{if $list}
		<tr>
		    <td align="left">
		    </td>
		    <td align="left" colspan="2">			 
		    </td>
		    <td align="right" colspan="7">{if $showpgnation eq "yes"}{$pagenation}{/if}{$pgnation}</td>
		</tr>
		{/if}
            </table>

</form></div>
</div>
{include file=$footer}
