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
<h1 class="type2">{$cat.album_title|ucfirst}</h1>
<div class="breadcrumb"><a href="{$siteroot}/admin/home.php">Home</a>&nbsp;&raquo;&nbsp;<a href="{$siteroot}/admin/sitemodules/albums/album.php">Album</a>&nbsp;&raquo;&nbsp;Album Photos</div>
<div style="margin-left:770px"><a href="javascript:void(0);" onclick="javascript:window.location='{$siteroot}/admin/sitemodules/albums/album.php'"> <strong>Back </strong></a></div>
	<table cellpadding="6" cellspacing="2" align="center" width="85%" border="0">
		<tr><td>&nbsp;</td></tr>
  		<tr>
    		<td align="left">
				<img src="{$siteroot}/templates/default/images/icons/add.png"  align="absmiddle"/> 
				 <a href="add-photo1.php?id={$cat.album_id}">Upload Photo </a>
				<br>{if $rows}<img src="{$siteroot}/templates/default/images/icons/edit.png"  align="absmiddle"/> 
				 <a href="edit-album.php?album_url={$cat.url_title}&amp;userid={$cat.user_id}&amp;roleid={$cat.role_id}&amp;view=old">Edit Photo </a>{/if}
			</td>
		</tr>
		<tr><td>&nbsp;</td></tr>
	</table>
     	<div id="ManageFaqDiv">
	{if $msg}
	<div align="center"  id="msg"><strong class="successMsg">{$msg}</strong></div>
	{/if}
	<div class="holdthisTop">
		<form name="frmAction" id="frmAction" method="post" action="">
  			<table cellpadding="5" cellspacing="2" align="center" width="100%" border="0" class="datagrid">
    			<tr class='headbg'>
					<th width="1%" align="center"><input type="checkbox" id="checkall" /></th>
           				<th width="5%" align="left">Status</th>
					<th width="20%" align="left">Photo</th>
            				<th width="20%" align="left">Date</th>
            				<th width="40%" align="left">&nbsp;</th>
					<th width="14%" align="center">Action</th>
				</tr>
    			 {section name=i loop=$rows}
   				<tr class="grayback" id="tr_{$rows[i].photoid}">
					<td align="center" valign="top"><input type="checkbox" name="photo_id[]" value="{$rows[i].photoid}" /></td>
            				<td align="left" valign="top"><img src="{$siteroot}/templates/{$templatedir}/images/icons/{if $rows[i].status  eq 'Inactive'}award_star_silver_1.png{else}award_star_silver_2.png{/if}" align="absmiddle" alt="{$rows[i].status}" title="{$rows[i].status}"/>{$rows[i].photo_title|capitalize}</td>
					<td align="left" valign="top" width="34" valign="top">
					   <a href="view-photo.php?vid={$rows[i].photoid}" class="frmtxt"><img src="{$siteroot}/uploads/post_accomplish/thumbnail/{$rows[i].image}" width="100px;" height="100px;"></a></td>
           				<td align="left" valign="top">{$rows[i].added_date}</td>
           				<td align="left" valign="top">{if $rows[i].album_cover eq '1'}Album Cover{/if}</td>
            				<td align="center" width="10%" valign="top">
					<img src="{$siteroot}/templates/default/images/icons/film.png" align="absmiddle" />&nbsp;<a href="view-photo.php?vid={$rows[i].photoid}" class="frmtxt">View</a>
					</td>
				</tr>
				{sectionelse}
				<tr>
      				<td colspan="6" align="center" class="error">No photos added yet.</td>
				</tr>
				{/section}
				{if $rows neq ''}
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