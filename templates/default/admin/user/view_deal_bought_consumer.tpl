{include file=$header1}

{strip}
<script type="text/javascript" src="{$siteroot}/js/ajax.js"></script>
<script type="text/javascript" src="{$siteroot}/js/ajax_user_search.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/userlist.js"></script>
{/strip}
{include file=$header2}


<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; Deal History Of Consumer Bought List</div>
<br />
<div class="holdthisTop">
	<div>
	  <div class="fl width50">
		  <h3>{$sitetitle} Deal History Of {$firstname|ucfirst} Bought</h3>
	  </div>
          <div class="clr">&nbsp;</div>

     	  {if $msg}<div align="center" id="msg">{$msg}</div>{/if}

	  
  	</div>
	<div class="fr">
	   <form name="frmSearch" action="" method="get">
		  <table width="50%" align="right" cellpadding="0" cellspacing="0" border="0">
			<input type="hidden" name="userid" id="userid" value="{$userid}">
		    <tr>
				<td width="200px"></td>
		      <td align="right" width="5%" >
			<label>
			    <input name="searchuser" type="text" id="searchuser" value="{$smarty.get.searchuser}"  class="search" style="float:left;"/> 
			</label>
		      </td>
		      <td width="20%" align="left">
			<input type="submit" name="button" id="button" value="Search" class="searchbutton"  style="float:left;"/>
		    </td>
		  </tr>
	      </table>
	    </form>
      </div>

    <br><br>
    <div id="UserListDiv" name="UserListDiv">
      <form name="frmAction" id="frmAction" method="post" action="">
	<table cellspacing="2" cellpadding="3" class="listtable" width="100%">	
	    <tr class="headbg">			
		<input type="hidden" name="userid" id="userid" value="{$userid}">
<!-- 		<td width="1%" align="center"><input type="checkbox" id="checkall"/></td> -->
		<td width="15%" align="left">Deals Tag</td>
		<td width="15%" align="left">Merchant Name</td>
		<td width="15%" align="left">Date-Bought</td>
		<td width="15%" align="center">Redeem Till</td>
		<td width="15%" align="center">Original Price</td>
		<td width="15%" align="center">Offer Price</td>
		<td width="15%" align="center">Savings</td>
		<td width="25%" align="center">Coupons</td>
	    </tr>
		{section name=i loop=$deals}
		<tr class="grayback" id="chk{$smarty.section.i.iteration}">
		<!--  <td rowspan="2" valign="top"><input type="checkbox" value="{$deals[i].deal_unique_id}" name="deal_id[]"/></td>-->
		  <td rowspan="2" valign="top">	  <img src="{$siteimg}/icons/{if $users[i].status  eq 'Inactive'}award_star_silver_1.png
		  {else}award_star_silver_2.png{/if}" align="absmiddle" />{$deals[i].discount_in_per}% on {$deals[i].deal_title} at {$deals[i].merchant_name}</td>
		 
		  <td valign="top" rowspan="2">
		
			{$deals[i].merchant_name}
                   </td>
		  <td valign="top" rowspan="2">{$deals[i].buy_date|date_format:"%Y-%m-%d %H:%M:%S"}</td>
		  <td rowspan="2" align="left">{$deals[i].redeem_to|date_format:"%Y-%m-%d %H:%M:%S"} </td>
		  <td rowspan="2" align="left">${$deals[i].original_price} </td>
			<td rowspan="2" align="left">${$deals[i].offer_price} </td>
		  <td rowspan="2" align="left"><abbr>{$deals[i].discount_in_per}%</abbr></td>
			<td rowspan="2" align="left"><a href="{$siteroot}/admin/user/view_voucher.php?userid={$smarty.get.userid}&deal_id={$deals[i].deal_unique_id}">View Coupons</a> </td>
		</tr>
		<tr>
			<td colspan="7" align="center"><b><!--Seller Unique URL :--> </b>
				<!--<a style="color:blue" href="{$siteroot}/seller/{$users[i].username}/{$users[i].userid}" target="_blank">{$siteroot}/seller/{$users[i].username}/{$users[i].userid}</a>-->
			</td>
		</tr>
		{sectionelse}
		    <tr><td colspan="12" class="error" align="center">No Records Found.</td></tr>
		{/section}

	<tr> <td align="right" colspan="11">{$pagenation}</td></tr>
		<!--{if $deals}
		<tr>
		    <td align="left"> <img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"  /></td>
		    <td align="left" colspan="3">
			<select name="action" id="action">
			  <option value="">--Action--</option>
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