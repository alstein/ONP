{include file=$header1}
{strip}
<script type="text/javascript" src="{$siteroot}/js/validation/admin/managedeals.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/managedeals.js"></script>
{/strip}

{literal}
<script type="text/javascript">
function sort_all(s_name,s_type)
{
    var str_url = SITEROOT+"/admin/globalsettings/deal/manage_deal.php?sortby="+s_name+"&sorttype="+s_type;

//     var srch=document.getElementById('searchuser').value;
// 
//     if(srch)
//         str_url = str_url+"&searchuser="+srch;
    var pg=document.getElementById('pg').value;
    if(pg)
        str_url = str_url+"&page="+pg;

    window.location=str_url;
}
</script>
<script>
function generatexls(id){ 
  //jQuery.post(SITEROOT+"/admin/globalsettings/deal/manage_deal.php",{xlsid:id},function(data){
				
		//});
location.href=SITEROOT+"/admin/globalsettings/deal/manage_deal.php?xlsid="+id;
}
</script>

{/literal}
{include file=$header2}
<!--<div class="breadcrumb">--><p class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; Manage Active Deals</p>
</div><br/>

<div class="holdthisTop">
 <div>
 <h3 align="left"><b>Manage Active Deals</b></h3>
 	  </div>
          <div class="clr">&nbsp;</div>
	<div class="fr">
		<form name="frmSearch" action="" method="get">
			<table  align="right" cellpadding="0" cellspacing="0" border="0">
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
<input type="hidden" id="pg" name="pg" value="{if $smarty.get.page}{$smarty.get.page}{else}1{/if}">
    <table  align="right" cellpadding="0" cellspacing="0" border="0" style="margin-right:80px" class="fl">

<tr>
	<td valign="top">
	  <strong>Seller Name: </strong>
	  <select name="deal_from_seller_name" id="deal_from_seller_name" onchange="javascript:this.form.submit();">
	                <option value="all">All</option>
		{section name=i loop=$deal_from_seller_names}
				<option value="{$deal_from_seller_names[i].userid}" {if $deal_from_seller_names[i].userid eq $smarty.get.deal_from_seller_name} selected="selected" {/if} >{$deal_from_seller_names[i].business_name}</option>
		{/section}
	  </select>
	  <input type="hidden" name="dltype" id="dltype" value="{$smarty.get.dltype}">
	</td>
</tr>

    </table>
    </form>
   <!-- <form name="frmSearch" id="frmSearch" method="GET">
    <table  align="right" cellpadding="0" cellspacing="0" border="0" style="margin-right:80px" class="fl">
<tr>
       <td valign="top">
			<strong>Deal Type: </strong>
			<select name="dltype" id="dltype" onchange="javascript:this.form.submit();" style="display:nonee;">
				<option value="all">All</option>
			{section name=i loop=$dltypes}
				<option value="{$dltypes[i].typeid}" {if $dltypes[i].typeid eq $smarty.get.dltype} selected="selected" {/if}>{$dltypes[i].dealtype}</option>
			{/section}
			</select>
			<input type="hidden" name="deal_from_seller_name" id="deal_from_seller_name" value="{$smarty.get.deal_from_seller_name}">
	</td>
</tr>
    </table>
    </form>-->

</div>

    <div align="center" id="msg">{$msg}</div>
    <table cellpadding="2" cellspacing="0" width="100%" style="vertical-align:top;">
	  <tr><TD colspan="12"><img align="top" src="{$siteroot}/templates/default/images/icons/excel.gif">&nbsp;<a href="{$siteroot}/admin/globalsettings/deal/manage_deal.php?view=excel&dltype={$smarty.get.dltype}&deal_from_seller_name={$smarty.get.deal_from_seller_name}"><strong>Deal Report</strong></a></TD></tr>

	  <tr>
	     <td colspan="2" valign="top" align="center">
		<form name="frmAction" id="frmAction" method="post" action="" onsubmit="">
		<table cellpadding="6" cellspacing="2" border="0" width="100%" class="listtable">
			<tr class="headbg">
				<td width="3%" align="center" valign="top"><input type="checkbox" id="checkall" /></td>
				<td width="10%" align="left" valign="top"><a href="javascript:void(0)" onclick="sort_all('deal_title',document.getElementById('sorttype_title').value);">Deal Name</a><input type="hidden" name="sorttype_title" id="sorttype_title" value="{if $sorttype_title}{$sorttype_title}{else}ASC{/if}"/></td>
				<td width="8%" align="left" valign="top"><a href="javascript:void(0)" onclick="sort_all('business_name',document.getElementById('sorttype_seller').value);">Merchant Name</a><input type="hidden" name="sorttype_seller" id="sorttype_seller" value="{if $sorttype_seller}{$sorttype_seller}{else}ASC{/if}"/></td>
				<td width="8%" align="left" valign="top"><a href="javascript:void(0)" onclick="sort_all('business_name',document.getElementById('sorttype_seller').value);">Merchant Category</a><input type="hidden" name="sorttype_seller" id="sorttype_seller" value="{if $sorttype_seller}{$sorttype_seller}{else}ASC{/if}"/></td>
				<td width="10%" align="left" valign="top"><a href="javascript:void(0)" onclick="sort_all('deal_end_date 	',document.getElementById('sorttype_end_date').value);">Deal End Date</a><input type="hidden" name="sorttype_end_date" id="sorttype_end_date" value="{if $sorttype_end_date}{$sorttype_end_date}{else}ASC{/if}"/></td>		
				<!--<td width="8%" align="left" valign="top">Deal Type</td>	-->
				<!--<td width="8%" align="left" valign="top">Deal Type</td>-->
				<!--<td width="8%" align="left" valign="top">Cities</td>-->
				<td width="10%" align="left" valign="top"><a href="javascript:void(0)" onclick="sort_all('	deal_category',document.getElementById('sorttype_category').value);">Deal Type</a><input type="hidden" name="sorttype_category" id="sorttype_category" value="{if $sorttype_category}{$sorttype_category}{else}ASC{/if}"/></td>
				<td width="10%" align="left" valign="top">
<a href="javascript:void(0)" onclick="sort_all('original_price',document.getElementById('sorttype_original_price').value);"> Original Price</a><input type="hidden" name="sorttype_original_price" id="sorttype_original_price" value="{if $sorttype_original_price}{$sorttype_original_price}{else}ASC{/if}"/></td>
				<td width="10%" align="left" valign="top">
<a href="javascript:void(0)" onclick="sort_all('discount_in_per',document.getElementById('sorttype_saved').value);"> Discount In %</a><input type="hidden" name="sorttype_saved" id="sorttype_saved" value="{if $sorttype_saved}{$sorttype_saved}{else}ASC{/if}"/>
</td>	
	<td width="10%" align="left" valign="top">
<a href="javascript:void(0)" onclick="sort_all('offer_price',document.getElementById('sorttype_offer_price').value);"> Offer Price</a><input type="hidden" name="sorttype_offer_price" id="sorttype_offer_price" value="{if $sorttype_offer_price}{$sorttype_offer_price}{else}ASC{/if}"/>
</td>	
	<td width="10%" align="left" valign="top">
<a href="javascript:void(0)"> Number Of Bought</a>
</td>	

				<td width="13%" align="left" valign="top">Action</td>
			</tr>
		{section name=i loop=$deal}
			<tr class="grayback" id="tr_{$deal[i].deal_unique_id}">
				<td rowspan="2" align="center" valign="top">
					<input type="checkbox" name="deal_id[]" value="{$deal[i].deal_unique_id}" id="deal_id" class="deal-data" onclick="generatexls({$deal[i].deal_unique_id})"/>
				</td>
				<td rowspan="2" align="left" valign="top"><!--{if $deal[i].recommend eq '1'}<img align="absmiddle" src="{$siteimg}/icons/bullet-fingerpoint.gif"/>{/if}-->
					<img src="{$siteimg}/icons/{if $deal[i].status  eq 'inactive'}award_star_silver_1.png{else}award_star_silver_2.png{/if}" align="absmiddle" />
				{if $deal[i].recommend eq '1'}<font color="red" style="weight:bold;font-size:10px"><strong>R -</strong></font>{else}{/if}{if $deal[i].featured eq '1'} <font color="red" style="weight:bold;font-size:10px"><strong>F -</strong></font>{else}{/if} {$deal[i].deal_title|ucfirst|html_entity_decode}</td>
				
				<td align="left" valign="top" rowspan="2">{$deal[i].business_name}</td>
				<td align="left" valign="top" rowspan="2">{$deal[i].category}</td>
				<td align="left" valign="top" rowspan="2">{$deal[i].deal_end_date|date_format}</td>
				<!--<td  valign="top">{$deal[i].deal_main_type}</td>-->
				<!--<td  valign="top">{*$deal[i].deal_type|ucfirst*}</td>-->
				<!--<td valign="top">{if $deal[i].city_name}{$deal[i].city_name}{else}-----{/if}</td>-->
				
				<td  valign="top" rowspan="2">{if $deal[i].deal_category eq 'deal_as_usual'}Deal As Usual{else}Right Now Deal{/if}</td>
				<td  valign="top" rowspan="2">{$deal[i].original_price}</td>
				<td valign="top" rowspan="2">{$deal[i].discount_in_per}%</td>
				<td rowspan="2" valign="top">{$deal[i].offer_price}</td>
				<td rowspan="2" valign="top">{$deal[i].count_deal}</td>	
				<td rowspan="2" align="left" valign="top">
					<!--<img src="{$siteroot}/templates/default/images/icons/application_edit.png" align="absmiddle" />&nbsp;<a href="{$siteroot}/admin/globalsettings/deal/edit_product.php?id={$deal[i].deal_unique_id}"><strong>Edit</strong></a>-->
					<!--<strong>{if $deal[i].featured eq '0'}|<a href="{$siteroot}/admin/globalsettings/deal/manage_deal.php?id={$deal[i].deal_unique_id}&featured=set" style="text-decoration:none;">Set Featured</a>
					{else}|<a href="{$siteroot}/admin/globalsettings/deal/manage_deal.php?id={$deal[i].deal_unique_id}&featured=unset" style="text-decoration:none;"> Unset Featured</a>{/if}
					</strong>-->|<img align="top" src="{$siteroot}/templates/default/images/icons/excel.gif">&nbsp;<a href="{$siteroot}/admin/globalsettings/deal/manage_deal.php?view=excel&exel_id={$deal[i].deal_unique_id}"><strong>Deal Report</strong></a>
				</td>
			</tr>
			<tr>
				<td colspan="4"><!--<b>Deal Unique URL : </b> <a style="color:blue" href="{$deal[i].deal_unique_url}" target="_blank">{$deal[i].deal_unique_url}</a>--></td>
			</tr>
		{sectionelse}
		    <tr><td colspan="12" align="center" height="25" class="error">Deal not found.</td></tr>
		{/section}

		    {if $deal}
		    <tr>
		      <td align="left">
			  <img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif" />
		      </td>
		      <td align="left" colspan="2">
			  <select name="action" id="action">
			      <option value="">--Action--</option>
			      <!--<option value="active">Publish</option>-->
			      <!--<option value="unrecommended">Unrecommended</option>
			      <option value="recommended">Recommended</option>-->
				<!--<option value="active">Active</option>
			        <option value="inactivate">Inactive</option>-->
				<option value="delete">Delete</option>
			  </select>
			  <input type="submit" name="submit" id="submit" value="Go" />
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
