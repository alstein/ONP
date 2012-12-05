{include file=$header1}
{strip}
<script type="text/javascript" src="{$siteroot}/js/admin/common.js"></script>
{/strip}
{include file=$header2}
{include file=$menu}
<div class="middel_panel">
<h1 class="type2">Accomplishment</h1>
<div class="breadcrumb"><a href="{$siteroot}/admin/home.php">Home</a>&nbsp;&raquo;&nbsp;Accomplishment</div>
<!-- <div style="margin-left:770px"><a href="javascript:void(0);" onclick="javascript:history.go(-1);"> <strong>Back </strong></a></div> -->
	<table cellpadding="6" cellspacing="2" align="center" width="100%" border="0">
  		<tr>
    		<td align="left">
				<img src="{$siteroot}/templates/default/images/icons/add.png"  align="absmiddle"/> 
				<a href="add_award.php"> Add Accomplishment</a>
			</td>
    			<td align="right">
				<form name="form1" method="get" id="form1" action="">
					<table cellspacing="3" cellpadding="1">
						<tr>
							<td align="center">
								<input name="search" type="text" id="search" value="{$smarty.get.search}" size="35" class="search" />
							</td>
							<td>
								<div class="buttons"><input type="submit" value="Search" class="searchbutton" /></div>
							</td>
						</tr>
					</table>
				</form>
			</td>
		</tr>
	</table>
     	<div id="ManageFaqDiv">
	{if $msg}
	<div align="center" id="msg"><strong class="successMsg">{$msg}</strong></div>
	{/if}
	<div class="holdthisTop">
		<form name="frmAction" id="frmAction" method="post" action="">
  			<table cellpadding="5" cellspacing="2" align="center" width="100%" border="0" class="datagrid">
    			<tr class='headbg'>
					<th width="1%" align="center"><input type="checkbox" id="checkall" /></th>
                    			<th width="2%" align="left">Ids</th>
					<th width="22%" width="15%" align="left">Accomplishment Owner</th>
					<th width="22%" align="left">Award/Trophy</th>
					<th width="22%" align="left">Event</th>
					<!--<th width="10%" align="left">Start Date</th>-->
					<th width="12%" align="left">End Date</th>
					<th width="19%" align="left">Action</th>
				</tr>
    			{section name=i loop=$cat}
   				<tr class="grayback" id="tr_{$cat[i].award_id}">
					<td align="center" width="1%" valign="top"><input type="checkbox" name="acc_id[]" value="{$cat[i].acc_id}" /></td>
					<td  align="left">{$cat[i].acc_id}</td>
					<td align="left" valign="top"><img src="{$siteroot}/templates/{$templatedir}/images/icons/{if $cat[i].status  eq 'Inactive'}award_star_silver_1.png{else}award_star_silver_2.png{/if}" align="absmiddle" alt="{$cat[i].status}" title="{$cat[i].status}"/>{$cat[i].o_fname|ucfirst} {$cat[i].o_lname|ucfirst}</td>
					<td align="left" valign="top">{$cat[i].admin_award_title|ucfirst}</td>
					<td align="left" valign="top">{$cat[i].admin_title|ucfirst}</td>
					<!--<td align="left" valign="top">{$cat[i].start_date|date_format:"%Y-%m-%d"}</td>-->
					<td align="left" valign="top">{$cat[i].end_date|date_format:"%Y-%m-%d"}</td>
					<td align="left" valign="top"><img src="{$siteroot}/templates/default/images/icons/edit.png" align="absmiddle" /><a href="add_award.php?act=edit&amp;id={$cat[i].acc_id}" class="frmtxt">Edit</a> |
					<img src="{$siteroot}/templates/default/images/icons/film.png" align="absmiddle" />&nbsp;<a href="view_award.php?id={$cat[i].acc_id}" class="frmtxt">View</a>
					</td>
				</tr>
				{sectionelse}
				<tr>
      				<td colspan="6" align="center" class="error">No Accomplishment added yet.</td>
				</tr>
				{/section}
				{if $cat neq ''}
				<tr>
					<td align="left"><img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif" /></td>
					<td align="left" colspan="3">
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
								<td><div class="buttons"><input type="submit" name="submit" id="submit" value="Go" /></div><span id="acterr" class="error"></span>
								</td>
							</tr>
						</table>
				        
					</td>
					<td colspan="3" align="right">{if $showpgnation eq 'yes'} {$pgnation} {/if} 
					</td>
				</tr>
				{/if}
<!--				<tr>
					<td colspan="5" align="right" >
					{if $showpgnation eq 'yes'} {$pgnation} {/if} 
					</td>
				</tr>-->
			</table>
		</form>
	</div>
	</div>
</div>
</div>
<!--main content ends -->

{include file=$footer}