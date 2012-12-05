{include file=$header1}
{strip}
<script type="text/javascript" src="{$siteroot}/js/validation/admin/manageaggregatedeals.js"></script>
<script type="text/javascript" src="{$sitejs}/remote.js"></script>
<script type="text/javascript" src="{$sitejs}/jquery.validate.pack.js"></script>
{literal}
<script type="text/javascript" language="JavaScript">

$(document).ready(function()
{
	$("#checkall").click(function()
	{
		var checked_status = this.checked;
		$("input[@type=checkbox]").each(function()
		{
					this.checked = checked_status;
					change(this);
		});
	});
	$("input[@type=checkbox]").click(function()
	{
			change(this);
	});
	function change(chk)
	{
		var $tr = $(chk).parent().parent();
		if($tr.attr('id'))
		{
			if($tr.attr('class')=='selectedrow' && !chk.checked)
				$tr.removeClass('selectedrow').addClass('grayback');
			else
				$tr.removeClass('grayback').addClass('selectedrow');
		}
	}

	var flag = false;
	$("#frmAction").submit(function()
	{
		if($("#action").attr('value')=='')
		{
			$("#acterr").text("Please Select Action.").show().fadeOut(3000);
			return false;
		}
		$("input[@type=checkbox]").each(function()
		{
			var $tr = $(this).parent().parent();
			if($tr.attr('id'))
				if(this.checked == true)
					flag = true;
		});
	
		if (flag == false)
		{
			$("#acterr").text("Please Select Checkbox.").show().fadeOut(3000);
			return false;
		}
		if(confirm('Are you sure to perform "'+$("#action").attr('value')+'" action?'))
			return true;
		else
			return false;
	});
	$("#msg").fadeOut(5000);
});

function uncheckMainCheckbox()
{
	document.getElementById('checkall').checked = false;
}

</script>
{/literal}

{/strip}
{include file=$header2}
<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; Aggregate Deals Report</div><br/>
<div class="holdthisTop">
	<h3 align="left"><b>Aggregate Deals Report</b></h3>
	<div>
		<form name="frmSearch" id="frmSearch" method="GET">
			<table  align="right" cellpadding="0" cellspacing="0" border="0" style="margin-right:80px">
				<tr>
					<td valign="top">
						<strong>Merchant Name: </strong>
						<select name="iMerchantId" id="iMerchantId" onchange="javascript:this.form.submit();">
									<option value="all">All</option>
							{section name=i loop=$deal_from_seller_names}
									<option value="{$deal_from_seller_names[i].marchant_id}" {if $deal_from_seller_names[i].marchant_id eq $smarty.get.iMerchantId} selected="selected" {/if} >{$deal_from_seller_names[i].marchant_name}</option>
							{/section}
						</select>
					</td>
				</tr>
			</table>
		</form>
	</div>
	<br />



	<div align="center" id="msg">{$msg}</div>
	<table cellpadding="2" cellspacing="0" width="100%" style="vertical-align:top;">
		<tr><TD colspan="12"><img align="top" src="{$siteroot}/templates/default/images/icons/excel.gif">&nbsp;<a href="{$siteroot}/admin/modules/affiliate-marchant/deal/aggregate_deals_report.php?view=excel&iMerchantId={$smarty.get.iMerchantId}"><strong>Deal Report</strong></a></TD></tr>
		<tr>
			<td colspan="2" valign="top" align="center">
				<form name="frmAction" id="frmAction" method="post" action="" >
					<table cellpadding="6" cellspacing="2" border="0" width="100%" class="listtable">
						<tr class="headbg">
							<td width="1%" align="center" valign="top"><!--{*<input type="checkbox" id="checkall" />*}-->Sr. No.</td>
							<td width="*%" align="left" valign="top">Deal Name</td>
							<td width="5%" align="left" valign="top">Deal Id</td>
							<td width="12%" align="left" valign="top">Merchant Name</td>
							<td width="8%" align="left" valign="top">Start Date</td>
							<td width="8%" align="left" valign="top">End Date</td>
							<td width="8%" align="left" valign="top">Deal Type</td>
							<td width="6%" align="left" valign="top">fPrice</td>
							<td width="6%" align="left" valign="top">fRrpPrice</td>
							<td width="5%" align="left" valign="top">Deal View Counts</td>
							<td width="5%" align="left" valign="top">Image</td>
							<td width="10%" align="left" valign="top">Action</td>
						</tr>
					{section name=i loop=$reportdata}
						<tr class="grayback" id="tr_{$reportdata[i].deal_unique_id}">
							<td align="center" valign="top">
								<!--{*<input type="checkbox" name="deal_id[]" value="{$reportdata[i].deal_unique_id}" />*}-->
								{$smarty.section.i.iteration}
							</td>
							<td align="left" valign="top">{$reportdata[i].sName|ucfirst|html_entity_decode}</td>
							<td align="left" valign="top">{$reportdata[i].iId}</td>
							<td align="left" valign="top">{$reportdata[i].sBrand}</td>
							<td align="left" valign="top">{$reportdata[i].dValidFrom}</td>
							<td align="left" valign="top">{$reportdata[i].dValidTo}</td>
							<td valign="top">{$reportdata[i].dealtype}</td>
							<td valign="top">{$reportdata[i].sCurrency}{$reportdata[i].fPrice}</td>
							<td valign="top">{$reportdata[i].sCurrency}{$reportdata[i].fRrpPrice}</td>
							<td valign="top">{if $reportdata[i].hitCount}<a href="{$siteroot}/admin/modules/affiliate-marchant/deal/deal_viewers.php?id={$reportdata[i].deal_unique_id}">{$reportdata[i].hitCount}</a>{else}0{/if}</td>
							<td valign="top"><img src="{$reportdata[i].sAwThumbUrl}" alt="img" width="70" height="70"></td>
							<td align="left" valign="top">
							<img align="top" src="{$siteroot}/templates/default/images/icons/excel.gif">&nbsp;<a href="{$siteroot}/admin/modules/affiliate-marchant/deal/aggregate_deals_report.php?view=excel&exel_id={$reportdata[i].deal_unique_id}"><strong>Deal Report</strong></a>&nbsp;|&nbsp;<br>
							<!--{*<img align="top" src="{$siteroot}/templates/default/images/icons/film.png">&nbsp;<a href="{$siteroot}/admin/modules/affiliate-marchant/deal/view_deal.php?id={$reportdata[i].deal_unique_id}&back=report"><strong>View Deal</strong></a>&nbsp;|&nbsp;<br>*}-->
							<img align="top" src="{$siteroot}/templates/default/images/icons/film.png">&nbsp;<a href="{$siteroot}/admin/modules/affiliate-marchant/deal/deal_viewers.php?id={$reportdata[i].deal_unique_id}"><strong>Deal Viewers</strong></a>
							</td>
						</tr>
					{sectionelse}
						<tr><td colspan="11" align="center" height="25" class="error">Deal not found.</td></tr>
					{/section}

					{if $reportdata}
						<tr>
							<!--{*<td align="left">
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
							</td>*} -->
							{if $showpaging eq "yes"}<td colspan="8" align="right"> {$pgnation} </td>{/if}
						</tr>
					{/if}
					</table>
				</form>
			</td>
		</tr>
	</table>
	<div class="clr">&nbsp;</div>
</div>
{include file=$footer}
