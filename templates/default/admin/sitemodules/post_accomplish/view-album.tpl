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

function goPage()
{
	var s = $('#search').val();
	window.location.href= SITEROOT+'/admin/sitemodules/post_accomplish/view-album.php?acc_id={/literal}{$smarty.get.acc_id}{literal}&album_id={/literal}{$smarty.get.album_id}{literal}&search='+s;
}
</script>
{/literal}
{include file=$header2}
{include file=$menu}
<div class="middel_panel">
<h1 class="type2">{$album[0].album_title}</h1>
<div class="breadcrumb"><a href="{$siteroot}/admin/home.php">Home</a>&nbsp;&raquo;&nbsp;<a href="{$siteroot}/admin/sitemodules/post_accomplish/award.php">Accomplishment</a>&nbsp;&raquo;&nbsp;Album&nbsp;</div>
<div style="margin-left:770px"><a href="javascript:void(0);" onclick="window.location = 'view_award.php?id={$smarty.get.acc_id}'"> <strong>Back </strong></a></div>
	<table cellpadding="6" cellspacing="2" align="center" width="100%" border="0">
		<tr><td align="right">
           <!--  <form name="form1" method="get" id="form1" action="" >-->
          <table cellspacing="3" cellpadding="1">
          <TR><TD align="center">
          <input name="search" type="text" id="search" value="" size="35" class="search"/></TD>
          <td>
          <div class="buttons">
          <input type="button" value="search" class="searchbutton" onclick="goPage();"/></div></td>
           </TR>
           </table>
         <!--  </form>--></td></tr>
  		<tr>
    		<td align="left">
				<img src="{$siteroot}/templates/default/images/icons/add.png"  align="absmiddle"/><a href="add_photo.php?acc_id={$smarty.get.acc_id}&album_id={$smarty.get.album_id}">&nbsp;Add Photo</a>
			</td>
		</tr>
		<tr><td>&nbsp;</td></tr>
	</table>
     	<div id="ManageFaqDiv">
	{if $msg}
	<div align="center" class="error" id="msg">{$msg}</div>
	{/if}
	<div class="holdthisTop">
		<form name="frmAction" id="frmAction" method="post" action="">
  			<table cellpadding="5" cellspacing="2" align="center" width="100%" border="0" class="datagrid">
    			<tr class='headbg'>
					<th width="1%" align="center"><input type="checkbox" id="checkall" /></th>
					<th width="1%">&nbsp;</th>
           				<th width="20%" align="left">Photo</th>
					<th width="20%" align="left">Description</th>
            				<th width="20%" align="left">Tag</th>
            				<th width="12%" align="left">Album Cover</th>
            				<th width="12%" align="left">Trophy Case</th>
					<th width="15%" align="left">Action</th>
				</tr>
    			 {section name=i loop=$rows}
   				<tr class="grayback" id="tr_{$rows[i].photoid}">
					<td align="center" width="1%" valign="top"><input type="checkbox" name="photoid[]" value="{$rows[i].photoid}" /></td>
					<td align="center" valign="top"><img src="{$siteroot}/templates/{$templatedir}/images/icons/{if $rows[i].status  eq 'Inactive'}award_star_silver_1.png{else}award_star_silver_2.png{/if}" align="absmiddle" alt="{$rows[i].status}" title="{$rows[i].status}"/></td>
            				<td align="left" valign="top"><img src="{$siteroot}/uploads/post_accomplish/90X90/{$rows[i].image}" alt="{$rows[i].image}"></td>
					<td align="left" valign="top">{$rows[i].description|truncate:100}</td>
           				<td align="left" valign="top">{$rows[i].tag|truncate:100}</td>
           				<td align="left" valign="top">{if $rows[i].album_cover eq '1'}Yes{else}No{/if}</td>
           				<td align="left" valign="top">{if $rows[i].trophy_case eq '1'}Yes{else}No{/if}</td>
            				<td align="left" valign="top"><img src="{$siteroot}/templates/default/images/icons/edit.png" align="absmiddle" /> <a href="edit_photo_details.php?acc_id={$smarty.get.acc_id}&album_id={$smarty.get.album_id}&photoid={$rows[i].photoid}" class="frmtxt">Edit</a>
					<!--<img src="{$siteroot}/templates/default/images/icons/film.png" align="absmiddle" />&nbsp;<a href="view-photo.php?vid={$rows[i].photo_id}" class="frmtxt">View</a>-->
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
								<td colspan="2"><div class="buttons"><input type="submit" name="submit" id="submit" value="Go" /></div>
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