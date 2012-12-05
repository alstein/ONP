{include file=$header1}
{include file=$header2}


<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; <a href="{$siteroot}/admin/modules/affiliate-marchant/deal/aggregate_deals_report.php"> Manage Aggregate Deal Report</a>
 &gt; <a href="{$siteroot}/admin/modules/affiliate-marchant/deal/deal_viewers.php?id={$smarty.get.id}"> Deal Viewers </a> &gt; Deal Viewed User Details</div>	
<br />

<h3>View Aggregate Deal</h3>

<div class="holdthisTop">
      <span style="float:right;">
            <h3><a href="{$siteroot}/admin/modules/affiliate-marchant/deal/deal_viewers.php?id={$smarty.get.id}"><strong>Back</strong></a></h3>
      </span>

<table width="100%" cellpadding="2" cellspacing="5" border="0" class="conttableDkBg conttable">
	<tr>
		<td>
			<table width="100%" cellpadding="4" cellspacing="5" border="0">
				<tr>
					<td width="25%" align="left" valign="top"><strong>User Name:</strong> </td>
					<TD  align="left">{$userDetails.fullname|ucfirst}</td>
				</tr>
				<tr>
					<td width="25%" align="left" valign="top"><strong>Email Id: </strong></td>
					<TD  align="left">{$userDetails.email}</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<br><br>

<table cellpadding="6" cellspacing="2" border="0" width="100%" class="listtable">
	<tr class="headbg">
		<td width="10%" align="left" valign="top">Sr. No.</td>
		<td width="*%" align="left" valign="top">View Date</td>
	</tr>
{section name=i loop=$userCountDetails}
	<tr class="grayback">
		<td align="left" valign="top">{$smarty.section.i.iteration}</td>
		<td align="left" valign="top">{$userCountDetails[i].added_date|date_format:"%d-%m-%Y"}</td>
	</tr>
{sectionelse}
	<tr><td colspan="11" align="center" height="25" class="error">User not found.</td></tr>
{/section}

{if $reportdata}
	<tr>
		<td align="left">
			<img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif" />
			</td>
			<td align="left" colspan="2">
			<select name="action" id="action">
				<option value="">--Action--</option>
			{*<option value="active">Active</option>
				<option value="inactivate">Inactive</option>*}
			<option value="delete">Delete</option>
			</select>
			<input type="submit" name="submit" id="submit" value="Go" />
			<br><span id="acterr" class="error"></span>
		</td>
	{if $showpaging eq "yes"}<td colspan="8" align="right"> {$pgnation} </td>{/if}
	</tr>
{/if}
</table>
<br><br>
</div>
{include file=$footer}
