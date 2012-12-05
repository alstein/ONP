{include file=$header1}
{strip}
<script type="text/javascript" src="{$siteroot}/js/validation/admin/manageaggregatedeals.js"></script>
{/strip}
{include file=$header2}
<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; Manage Expired Aggregate Deals

</div><br/>

<div class="holdthisTop">
 <h3 align="left"><b>Manage Expired Aggregate Deals</b></h3>
<!--	<div class="fr">
		<form name="frmSearch" action="" method="get">
			<table width="50%" align="right" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td align="right">
						<label>
							<input name="search" type="text" id="search" value="{$smarty.get.search}" size="35" class="search"/> 
						</label>
					</td>
					<td width="20%" align="left">
						<input type="submit" name="button" id="button" value="Search" class="searchbutton" />
					</td>
				</tr>
			</table>
		</form>
	</div>-->
 <div>
<form name="frmSearch" id="frmSearch" method="GET">
    <table  align="right" cellpadding="0" cellspacing="0" border="0" style="margin-right:80px">
        
      <tr>
<!--      <div class="fl">-->
	<td valign="top">
	  <strong>Merchant Name: </strong>
	  <select name="iMerchantId" id="iMerchantId" onchange="javascript:this.form.submit();">
	                <option value="all">All</option>
		{section name=i loop=$deal_from_seller_names}
				<option value="{$deal_from_seller_names[i].marchant_id}" {if $deal_from_seller_names[i].marchant_id eq $smarty.get.iMerchantId} selected="selected" {/if} >{$deal_from_seller_names[i].marchant_name}</option>
		{/section}
	  </select>
<!--	</div>	-->
	  </td>	
      </tr>
    </table>
    </form>
</tr>
<br />



    <div align="center" id="msg">{$msg}</div>
    <table cellpadding="2" cellspacing="0" width="100%" style="vertical-align:top;">
	  <tr><TD colspan="12"><img align="top" src="{$siteroot}/templates/default/images/icons/excel.gif">&nbsp;<a href="{$siteroot}/admin/modules/affiliate-marchant/deal/expired_deal.php?view=excel&iMerchantId={$smarty.get.iMerchantId}"><strong>Deal Report</strong></a></TD></tr>
	  <tr>
	     <td colspan="2" valign="top" align="center">
		<form name="frmAction" id="frmAction" method="post" action="" onsubmit="">
		<table cellpadding="6" cellspacing="2" border="0" width="100%" class="listtable">
		    <tr class="headbg">
			<td width="1%" align="center" valign="top"><input type="checkbox" id="checkall" /></td>
			<td width="*%" align="left" valign="top">Deal Name</td>
			<td width="5%" align="left" valign="top">Deal Id</td>
			<td width="12%" align="left" valign="top">Merchant Name</td>
			<td width="8%" align="left" valign="top">Start Date</td>	
			<td width="8%" align="left" valign="top">End Date</td>		
			<td width="8%" align="left" valign="top">Deal Type</td>
			<td width="6%" align="left" valign="top">fPrice</td>
			<td width="6%" align="left" valign="top">fRrpPrice</td>
			<td width="5%" align="left" valign="top">Image</td>
			<td width="10%" align="left" valign="top">Action</td>
		    </tr>
		    {section name=i loop=$deal}
		      <tr class="grayback" id="tr_{$deal[i].deal_unique_id}">
			<td align="center" valign="top">
			<input type="checkbox" name="deal_id[]" value="{$deal[i].deal_unique_id}" />
			</td>
			<td align="left" valign="top">
			 {*<img src="{$siteimg}/icons/{if $deal[i].status  eq 'Inactive'}award_star_silver_1.png{else}award_star_silver_2.png{/if}" align="absmiddle" />{if $deal[i].featured}<span style="color:red;">F</span>{/if}*}
			 {$deal[i].sName|ucfirst|html_entity_decode}</td>
			<td align="left" valign="top">{$deal[i].iId}</td>
			<td align="left" valign="top">{$deal[i].deal_from_seller_name}</td>
			<td align="left" valign="top">{$deal[i].start_date}</td>
			<td align="left" valign="top">{$deal[i].end_date}</td>
			<td  valign="top">{$deal[i].deal_main_type}</td>
			<td  valign="top">{$deal[i].deal_currency_type}{$deal[i].fPrice}</td>
			<td valign="top">{$deal[i].deal_currency_type}{$deal[i].fRrpPrice}</td>
			<td valign="top"><img src="{$deal[i].sAwThumbUrl}" alt="img" width="70" height="70"></td>
			<td align="left" valign="top">
			<!--<img src="{$siteroot}/templates/default/images/icons/application_edit.png" align="absmiddle" />&nbsp;<a href="{$siteroot}/admin/globalsettings/deal/edit_product.php?id={$deal[i].deal_unique_id}"><strong>Edit</strong></a>
			|<br>--><img align="top" src="{$siteroot}/templates/default/images/icons/excel.gif">&nbsp;<a href="{$siteroot}/admin/modules/affiliate-marchant/deal/expired_deal.php?view=excel&exel_id={$deal[i].deal_unique_id}"><strong>Deal Report</strong></a>&nbsp;|&nbsp;<br>
			<img align="top" src="{$siteroot}/templates/default/images/icons/film.png">&nbsp;<a href="{$siteroot}/admin/modules/affiliate-marchant/deal/view_deal.php?id={$deal[i].deal_unique_id}&back=exp"><strong>View Deal</strong></a>
			</td>
		    </tr>
		    {sectionelse}
		    <tr><td colspan="11" align="center" height="25" class="error">Deal not found.</td></tr>
		    {/section}
    
		    {if $deal}
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
		</form>
	      </td>
	  </tr>
	</table>
    <div class="clr">&nbsp;</div>
</v>
{include file=$footer} 
