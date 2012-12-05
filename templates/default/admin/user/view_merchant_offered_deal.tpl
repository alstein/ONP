{include file=$header1}

{strip}
<script type="text/javascript" src="{$siteroot}/js/ajax.js"></script>
<script type="text/javascript" src="{$siteroot}/js/ajax_user_search.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/userlist.js"></script>
{/strip}
{include file=$header2}

{literal}
<script type="text/javascript">
function view_coupans(val)
{
	//alert(val);
	window.open(SITEROOT+'/modules/merchant-account/view_coupon_details.php?deal_id='+val,'PrintDocument','scrollbars=yes, resizable=yes, copyhistory=yes, width=800, height=600, left=300, top=250');
	//window.location.reload();
}
</script>
{/literal}
<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; Deal History Of Merchant Offered List</div>
<br />
<div class="holdthisTop">
	<div>
	  <div class="fl width50">
		  <h3>List of Deal Offered To {$firstname|ucfirst}</h3>
	  </div>
          <div class="clr">&nbsp;</div>

     	  {if $msg}<div align="center" id="msg">{$msg}</div>{/if}

	  
  	</div>
	<div class="fr">
	   <form name="frmSearch" action="" method="get">
		  <table width="50%" align="right" cellpadding="0" cellspacing="0" border="0">
		    <tr>
		      <td align="right">
			<label>
		<input type="hidden" name="userid" id="userid" value="{$userid}">

			    <input name="searchuser" type="text" id="searchuser" value="{$smarty.get.searchuser}" size="35" class="search"/> 
			</label>
		      </td>
		      <td width="20%" align="left">
			<input type="submit" name="button" id="button" value="Search" class="searchbutton" />
		    </td>
		  </tr>
	      </table>
	    </form>
      </div>

    <br><br>
    <div id="UserListDiv" name="UserListDiv">
      <form name="frmAction" id="frmAction" method="post" action="">
	<input type="hidden" name="userid" id="userid" value="{$userid}">

	<table cellspacing="2" cellpadding="3" class="listtable" width="100%">	
	    <tr class="headbg">			
<!-- 		<td width="1%" align="center"><input type="checkbox" id="checkall"/></td> -->
		<td width="15%" align="left">Deal Name</td>
		<td width="15%" align="left">Date Offered</td>
		<td width="15%" align="left">Active/Expired</td>
		<td width="15%" align="center">Redeemption Till</td>
		<td width="15%" align="left">Original Price</td>
		<td width="15%" align="left">Offered Price</td>
		<td width="15%" align="left">Number Of Brought</td>
		<td width="20%" align="center">Coupons</td>
	    </tr>
		{section name=i loop=$offer_deal}
		<tr class="grayback" id="chk{$smarty.section.i.iteration}">
		<!--  <td rowspan="2" valign="top"><input type="checkbox" value="{$deals[i].deal_unique_id}" name="deal_id[]"/></td>-->
		  <td rowspan="2" valign="top">	  <img src="{$siteimg}/icons/{if $users[i].status  eq 'Inactive'}award_star_silver_1.png
		  {else}award_star_silver_2.png{/if}" align="absmiddle" />{$offer_deal[i].deal_title}</td>
		 
		  <td valign="top" rowspan="2">
			{$offer_deal[i].redeem_from|date_format:"%Y-%m-%d %H:%M:%S"}
                 </td>
		  <td valign="top" rowspan="2">
			{$offer_deal[i].status|ucfirst}
                 </td>
		<td valign="top" rowspan="2">
			{$offer_deal[i].redeem_to|date_format:"%Y-%m-%d %H:%M:%S"}
                 </td>
		  <td valign="top" rowspan="2">
			${$offer_deal[i].original_price}
                 </td>
		<td valign="top" rowspan="2">
			${$offer_deal[i].offer_price}
                 </td>
			<td valign="top" rowspan="2">
			{$offer_deal[i].count}
                 </td>
		  
			<td rowspan="2" align="left"><a href="javascript:void(0)" class="download-cupon" onclick="view_coupans({$offer_deal[i].deal_unique_id})">View<br>Details</a> </td>
		</tr>
		<tr>
			<td colspan="7" align="center"><b><!--Seller Unique URL :--> </b>
				<!--<a style="color:blue" href="{$siteroot}/seller/{$users[i].username}/{$users[i].userid}" target="_blank">{$siteroot}/seller/{$users[i].username}/{$users[i].userid}</a>-->
			</td>
		</tr>
		{sectionelse}
		    <tr><td colspan="12" class="error" align="center">No Records Found.</td></tr>
		{/section}
	<tr><td align="right" colspan="7">{if $showpgnation eq 'yes'}{$pagenation}{/if}</td></tr>
		<!--{if $deals}
		<tr>
		    <td align="left"> <img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"  /></td>
		    <td align="left" colspan="3">
			<select name="action" id="action">
			  <option value="">-- Action--</option>
			  <option value="Active">Active</option>
			  <option value="inactivate">Inactive</option>
			  <option value="delete">Delete</option>
			</select>
			<input type="submit" name="submit" id="submit" value="Go"/>
		        <div id="acterr" class="error"></div>
		    </td>
		    <td align="right" colspan="9">{if $showpgnation eq "yes"}{$pagenation}{/if}</td>
		</tr>
		{/if}-->
	</table>
      </form>
  </div>
</div>
{include file=$footer}
