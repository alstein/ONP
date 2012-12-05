{include file=$header1}
{strip}
<script type="text/javascript" src="{$siteroot}/js/admin/common.js"></script>
{/strip}
{literal}
<script type="text/javascript">
jQuery(document).ready(function()
{
	jQuery("#msg").fadeOut(5000);
	jQuery("#photomsg").fadeOut(5000);
	
});
</script>
{/literal}
{include file=$header2}
{include file=$menu}
<div class="middel_panel">
<h1 class="type2">Accomplishment Details</h1>
<div class="breadcrumb"><a href="{$siteroot}/admin/home.php">Home</a>&nbsp;&raquo;&nbsp;<a href="{$siteroot}/admin/sitemodules/post_accomplish/award.php">Accomplishment</a></div>
<div style="margin-left:770px"><a href="javascript:void(0);" onclick="javascript:history.go(-1);"> <strong>Back</strong></a></div>
	<div class="holdthisTop">
	{if $msg}
	<div align="center" class="error" id="msg">{$msg}</div>
	{/if}
<table width="100%" border="0" align="center" cellspacing="2" cellpadding="6" class="datagrid">
<tr>
<td>
            <table width="100%" cellpadding="3" cellspacing="2"  border="0">
		<tr>
		<td width="25%" align="right" valign="top"><b>Accomplishment Owner:</b></td>
			<td>{$awards.o_fname|ucfirst} {$awards.o_lname|ucfirst}</td>
		</tr>
		{if $awards.award}
		<tr>
		<td width="25%" align="right" valign="top"><b>Accomplishemnt:</b></td>
			<td>{$awards.admin_award_title}</td>
		</tr>
		{/if}
		{if $awards.category}
		<tr>
		<td width="25%" align="right" valign="top"><b>Category:</b></td>
			<td>{$awards.category|ucfirst}</td>
					</tr>
		{/if}
		{if $awards.subcategory}
		<tr>
		<td width="25%" align="right" valign="top"><b>Subcategory:</b></td>
			<td>{$awards.subcategory}</td>
		</tr>
		{/if}
		{if $awards.location}
		<tr>
		<td width="25%" align="right" valign="top"><b>Where:</b></td>
			<td>{$awards.school_name|ucfirst}</td>
		</tr>
		{/if}
		{if $awards.current eq '1'}
		<tr>
		<td width="25%" align="right" valign="top"><b>When:</b></td>
			<td>{$awards.start_date} To Present</td>
		</tr>
		{else}
		{if $awards.end_date}
		<tr>
		<td width="25%" align="right" valign="top"><b>End date:</b></td>
			<td>{$awards.end_date}</td>
		</tr>
		{/if}
		{/if}
		{if $awards.event_name}
		<tr>
		<td width="25%" align="right" valign="top"><b>Event Name:</b></td>
			<td>{$awards.admin_event_title}</td>
		</tr>
		{/if}
		{if $team neq ''}
		<tr>
		<td width="25%" align="right" valign="top"><b>Teammates:</b></td>
			<td>{section name=i loop=$team} {$team[i].first_name|ucfirst} {$team[i].last_name|ucfirst}, {/section}</td>
		</tr>
		{/if}
		<tr>
			<td align="right" valign="top"><b>Added By:</b></td>
			<td>{$awards.a_fname|ucfirst} {$awards.a_lname|ucfirst}</td>
		</tr>
		<tr>
			<td align="right" valign="top"><b>Added Date:</b></td>
			<td>{$awards.added_date}</td>
		</tr>
	</table>
</td>
</tr>
<tr>
  <TD><hr></TD>
</tr>
<tr>
<td>
	<table width="100%" cellpadding="3" cellspacing="2"  border="0">
		<tr>
		  <TD align="right">{if $photo}
		  	<img src="{$siteroot}/templates/default/images/icons/edit.png"  align="absmiddle"/> 
			<a href="{$siteroot}/admin/sitemodules/albums/edit-album.php?accid={$smarty.get.id}&userid={$userid}&roleid={$roleid}&view=acc">Edit Photos</a>{/if}</TD>
		</tr>
	</table>
	<ul class="reset">
		{section name=i loop=$photo}
		<li style="width:160px; height:160px; float:left; padding-left:10px;">
		<a href="{$siteroot}/admin/sitemodules/albums/view-photo.php?vid={$photo[i].photoid}&amp;accid={$smarty.get.id}"><img src="{$siteroot}//uploads/post_accomplish/thumbnail/{$photo[i].image}"/></a>
		</li>
		{sectionelse}
		<li style="width:160px; height:160px;">
		No Photos assigned to this accomplishment yet.
		</li>
		{/section}
	</ul>
	
</td>
</tr>
<tr><TD><br>{if $showpgnation}{$pgnation}{/if}</TD></tr>
</table>
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
{include file=$footer}