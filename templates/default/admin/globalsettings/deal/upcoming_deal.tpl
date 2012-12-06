{include file=$header1}
{strip}
<script type="text/javascript" src="{$siteroot}/js/validation/admin/upcoming_deals.js"></script>
{/strip}
{include file=$header2}
<!--<div class="breadcrumb">--><p class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; Manage Upcoming Deals</p>
</div><br/>
<div class="holdthisTop">
<div>

 <h3 align="left"><b>Manage Upcoming Deals</b></h3>
 	  </div>
          <div class="clr">&nbsp;</div>
	<div class="fr">
		<form name="frmSearch" action="" method="get">
			<table align="right" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td align="right">
						<label>
							<input name="search" type="text" id="search" value="{$smarty.get.search}" size="35" class="search"/> 
						</label>
					</td>
					<td align="left">
						<input type="submit" name="button" id="button" value="Search" class="searchbutton" />
					</td>
				</tr>
			</table>
		</form>
	</div>
	<div class="clr">&nbsp;
<div>
<form name="frmSearch" id="frmSearch" method="GET">	
    <table  align="right" cellpadding="0" cellspacing="0" border="0" style="margin-right:80px" class="fl">
  
      <tr>
	<td valign="top">	
	  <strong>Seller Name: </strong>
	  <select name="deal_from_seller_name" id="deal_from_seller_name" onchange="javascript:this.form.submit();">
	                <option value="all">All</option>
			{section name=i loop=$deal_from_seller_names}
				<option value="{$deal_from_seller_names[i].userid}" {if $deal_from_seller_names[i].userid eq $smarty.get.deal_from_seller_name} selected="selected" {/if} >{$deal_from_seller_names[i].fullname}</option>
			{/section}
	  </select>
	   <input type="hidden" name="dltype" id="dltype" value="{$smarty.get.dltype}">
	  </td>
	</tr>	
    </table>
    </form>
   
</div>
  <div class="clr">&nbsp;</div>
<!--	<table cellpadding="6" cellspacing="2" align="center" width="100%" border="0">-->
    <div align="center" id="msg">{$msg}</div>
    <table cellpadding="2" cellspacing="0" width="100%" style="vertical-align:top;">
	  <tr>
	     <td colspan="2" valign="top" align="center">
		<form name="frmAction" id="frmAction" method="post" action="" onsubmit="">
		<table cellpadding="6" cellspacing="2" border="0" width="100%" class="listtable">
		    <tr class="headbg">
			<td width="1%" align="center" valign="top"><input type="checkbox" id="checkall" /></td>
			<td width="10%" align="left" valign="top">Deal Name</td>
			
			<td width="10%" align="left" valign="top">Seller Name</td>
			<td width="6%" align="left" valign="top">Start Date</td>	
			<td width="6%" align="left" valign="top">End Date</td>		
			<!--<td width="8%" align="left" valign="top">Deal Type</td>	-->
			<!--<td width="8%" align="left" valign="top">Deal Type</td>-->
			<!--<td width="8%" align="left" valign="top">City</td>-->
			<td width="6%" align="left" valign="top">Price</td>
			<td width="8%" align="left" valign="top">Original Price</td>
			<td width="6%" align="left" valign="top">% Saved</td>	
			<td width="9%" align="left" valign="top">Action</td>
		    </tr>
		    {section name=i loop=$deal}
		      <tr class="grayback" id="tr_{$deal[i].deal_unique_id}">
			<td align="center" valign="top">
			<input type="checkbox" name="deal_id[]" value="{$deal[i].deal_unique_id}" />
			</td>
			<td align="left" valign="top"><!--{if $deal[i].recommend eq '1'}<img align="absmiddle" src="{$siteimg}/icons/bullet-fingerpoint.gif"/>{/if}-->
			 <img src="{$siteimg}/icons/{if $deal[i].status  eq 'Inactive'}award_star_silver_1.png{else}award_star_silver_2.png{/if}" align="absmiddle" />
			{if $deal[i].recommend eq '1'}<font color="red" style="weight:bold;font-size:10px">R</font>{else}{/if}{if $deal[i].featured eq '1'} <font color="red" style="weight:bold;font-size:10px">F</font>{else}{/if} {$deal[i].title|ucfirst|html_entity_decode}</td>
			
			<td align="left" valign="top">{$deal[i].deal_from_seller_name}</td>
			<td align="left" valign="top">{$deal[i].start_date}</td>
			<td align="left" valign="top">{$deal[i].end_date}</td>
			<!--<td  valign="top">{$deal[i].deal_main_type}</td>-->
			<!--<td  valign="top">{*$deal[i].deal_type|ucfirst*}</td>-->
			<!--<td valign="top">{if $deal[i].city_name}{$deal[i].city_name}{else}-----{/if}</td>-->
			<td  valign="top">{$deal[i].deal_currency_type}{$deal[i].groupbuy_price}</td>
			<td valign="top">{$deal[i].deal_currency_type}{$deal[i].orignal_price}</td>
			<td valign="top">{$deal[i].quantity} %</td>	
			<td align="left" valign="top">
			<img src="{$siteroot}/templates/default/images/icons/application_edit.png" align="absmiddle" />&nbsp;<a href="{$siteroot}/admin/globalsettings/deal/edit_product.php?back=up&id={$deal[i].deal_unique_id}"><strong>Edit</strong></a>
			<!--{*
			<br>
			{if $number eq '4'||$deal[i].featured eq '0'}| <a href="{$siteroot}/admin/globalsettings/deal/upcoming_deal.php?id={$deal[i].deal_unique_id}" style="text-decoration:none;">{else}<a href="{$siteroot}/admin/globalsettings/deal/upcoming_deal.php?id={$deal[i].deal_unique_id}&agree=yes" style="text-decoration:none;">{/if}<strong>{if $deal[i].featured eq '0'}Set Featured{else}| Unset Featured{/if}</strong></a>
			*}-->
			</td>
		    </tr>
		    {sectionelse}
		    <tr><td colspan="12" align="center" height="25" class="error">Deal not found.</td></tr>
		    {/section}
    
		    {if $deal}
		    <tr>
		      <td align="left">
			  <img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"  />
		      </td>
		      <td align="left" colspan="2">
			  <select name="action" id="action" style="width:100px;">
			      <option value="">--Action--</option>
				<option value="active">Active</option>
			      <option value="inactivate">Inactive</option>
			      <option value="delete">Delete</option>
			  </select>
			  <input type="submit" name="submit" id="submit" value="Go"/>
			  <br><span id="acterr" class="error"></span>
			</td>
			{if $showpaging eq "yes"}<td colspan="9" align="right"> {$pgnation} </td>{/if}
		    </tr>
		    {/if}
	    </table>
		</form>
	      </td>
	  </tr>
	</table>
</div>
</div>
{include file=$footer} 