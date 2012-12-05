{include file=$header1}
{strip}
<script type="text/javascript" src="{$siteroot}/js/admin/common.js"></script>
{/strip}
{literal}
<script type="text/javascript">
jQuery(document).ready(function()
{
	jQuery("#msg").fadeOut(5000);
});
</script>
{/literal}
{include file=$header2}
{include file=$menu}
<div class="middel_panel">
<h1 class="type2">Albums</h1>
<div class="breadcrumb"><a href="{$siteroot}/admin/home.php">Home</a>&nbsp;&raquo;&nbsp;Albums</div>
	<table cellpadding="6" cellspacing="2" align="center" width="80%" border="0">
  		<tr>
    		<td align="left">
				<!--<img src="{$siteroot}/templates/default/images/icons/add.png"  align="absmiddle"/> 
				<a href="add-album.php"> Add Album </a>-->
			</td>
    			<td align="right">
				<form name="form1" method="get" id="form1" action="">
					<table cellspacing="3" cellpadding="1">
						<tr>
							<td align="center">
								<input name="search" type="text" id="search" value="{$smarty.get.search}" size="35" class="search" />
							</td>
							<td>
								<div class="buttons"><input type="submit" value="Submit" class="searchbutton" /></div>
							</td>
						</tr>
					</table>
				</form>
			</td>
		</tr>
	</table>
     	<div id="ManageFaqDiv">
	{if $msg}
	<div align="center" class="successMsg" id="msg">{$msg}</div>
	{/if}
	<div class="holdthisTop">
		<form name="frmAction" id="frmAction" method="post" action="">
  			<table cellpadding="5" cellspacing="2" align="center" width="100%" border="0" class="datagrid">
    			<tr class='headbg'>
					<th width="1%" align="center"><input type="checkbox" id="checkall" /></th>
					<th width="20%" align="left">Filtered Title</th>
					<th width="20%" align="left">Original Title</th>
					<th width="20%" align="left">Owner</th>
					<th width="20%" align="left">Date</th>
					<th width="19%" align="left">Action</th>
				</tr>
    			{section name=i loop=$cat}
   				<tr class="grayback" id="tr_{$cat[i].album_id}">
					<td align="center" width="1%" valign="top"><input type="checkbox" name="album_id[]" value="{$cat[i].album_id}" /></td>
					<td align="left" valign="top"><img src="{$siteroot}/templates/{$templatedir}/images/icons/{if $cat[i].status  eq 'Inactive'}award_star_silver_1.png{else}award_star_silver_2.png{/if}" align="absmiddle" alt="{$cat[i].status}" title="{$cat[i].status}"/><a href="view-album.php?id={$cat[i].album_id}&uid={$cat[i].userid}">{$cat[i].album_title|ucfirst}</a></td>
					<td align="left" valign="top">{$cat[i].admin_album_title|ucfirst}</td>
					<td align="left" width="34" valign="top"><a href="../../user/view-user-info.php?act=view&amp;user_id={$cat[i].userid}">{$cat[i].admin_first_name} {$cat[i].admin_last_name}</a>
					</td>
					<td align="left" width="34" valign="top">{$cat[i].added_date}</td>
					<td align="left" width="10%" valign="top"><img src="{$siteroot}/templates/default/images/icons/edit.png" align="absmiddle" /><a href="add-album.php?act=edit&amp;id={$cat[i].album_id}" class="frmtxt">Edit</a> |
					<img src="{$siteroot}/templates/default/images/icons/film.png" align="absmiddle" />&nbsp;<a href="view-album.php?id={$cat[i].album_id}" class="frmtxt">View</a>
					</td>
				</tr>
				{sectionelse}
				<tr>
      				<td colspan="6" align="center" class="error">No album added yet.</td>
				</tr>
				{/section}
				{if $cat neq ''}
				<tr>
					<td align="left"><img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif" /></td>
					<td align="left" colspan="2">
						<table width="100%">
							<tr>
								<td align="left" width="5%">
									<select name="action" id="action">
									<option value="">--Action--</option>
									<option value="active">Active</option>
									<option value="inactive">Inactive</option>
									<option value="delete">Delete</option>
									</select>
								</td>
								<td><div class="buttons"><input type="submit" name="submit" id="submit" value="Go" />
								</td>
							</tr>
						</table>
				        <span id="acterr" class="error"></span>
					</td>
				</tr>
				{/if}
				<tr>
					<td colspan="5" align="right" >
					{if $total_pages gt 1}
					{if $page gt 1} 
							<a href="{$pgurl}?{$url}page={$page-1}" class='frmtxt'> Previous</a> 
					{/if}
							{section name=sec1 loop=$total_pages}
					{if $page eq $smarty.section.sec1.iteration}
							{$smarty.section.sec1.iteration}
					{else} 
							<a href="{$pgurl}?{$url}page={$smarty.section.sec1.iteration}" class='frmtxt'> {$smarty.section.sec1.iteration}</a> 
					{/if}
					{/section}
					{if $page lt $total_pages} 
							<a href="{$pgurl}?{$url}page={$page+1}" class='frmtxt'>Next</a> {/if}
					{/if} 
					</td>
				</tr>
			</table>
		</form>
	</div>
	</div>
</div>
<!--main content ends -->
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
{include file=$footer}