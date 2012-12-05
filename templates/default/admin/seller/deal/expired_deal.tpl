{include file=$header_seller1}
{strip}
<script type="text/javascript" src="{$siteroot}/js/validation/admin/expired_deals.js"></script>
{/strip}
{include file=$header_seller2}
<!--<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; Manage Expired Deals
</div><br/>-->
<section id="maincont" class="ovfl-hidden">

	<section class="grybg">
		<div class="pagehead">
			<div class="grpcol">
				<ul class="reset ovfl-hidden tab1">
					<li><a href="{$siteroot}/admin/seller/my-profile-view.php">My Account</a> </li>
					<li><a href="{$siteroot}/admin/seller/deal/add_product.php" class="active">Deal Management</a> </li>
					<li><a href="{$siteroot}/admin/seller/rating/raviews_rating_deals_list.php">Masters</a> </li>
					<li><a href="{$siteroot}/admin/seller/login-log.php">Tools</a> </li>
				</ul>
                <div class="SubNav">
                <a href="{$siteroot}/admin/seller/deal/add_product.php">Add New Deal</a> &nbsp;&nbsp;|&nbsp;&nbsp; 
                <a href="{$siteroot}/admin/seller/deal/pending-deal.php">Pending Deals ({$deal_notice_info_seller.tot_pending})</a> &nbsp;&nbsp;|&nbsp;&nbsp; 
                <a href="{$siteroot}/admin/seller/deal/manage_deal.php">Active Deals ({$deal_notice_info_seller.tot_actv1})</a> &nbsp;&nbsp;|&nbsp;&nbsp; 
                <a href="{$siteroot}/admin/seller/deal/featured_deal.php">Featured Deals ({$deal_notice_info_seller.tot_fea})</a> &nbsp;&nbsp;|&nbsp;&nbsp; 
                <a href="{$siteroot}/admin/seller/deal/rejected-deals.php">Rejected Deals ({$deal_notice_info_seller.tot_rej})</a>&nbsp;&nbsp;|&nbsp;&nbsp; 
                <a href="{$siteroot}/admin/seller/deal/upcoming_deal.php">Upcoming Deals ({$deal_notice_info_seller.tot_upcom})</a> &nbsp;&nbsp;|&nbsp;&nbsp; 
                <a href="{$siteroot}/admin/seller/deal/expired_deal.php" class="active">Expired Deals ({$deal_notice_info_seller.tot_exp})</a>
                </div>
			
           
			</div>
		</div>
		<div class="innerdesc">
        <h3 class="pagehead2 fl">Manage Expired Deals</h3>
<div >
<form name="frmSearch" id="frmSearch" method="GET">	
    <table  align="right" cellpadding="0" cellspacing="0" border="0">
      <tr style="display:none">
	<td valign="top">
	  <span style="color:#000">Seller Name: </span>
	  <select name="deal_from_seller_name" id="deal_from_seller_name" onchange="javascript:this.form.submit();">
	                <option value="all">All</option>
		        {section name=i loop=$deal_from_seller_names}
	      		<option value="{$deal_from_seller_names[i].deal_from_seller_name}" {if $deal_from_seller_names[i].deal_from_seller_name eq $smarty.get.deal_from_seller_name} selected="selected" {/if} >{$deal_from_seller_names[i].deal_from_seller_name}</option>
		{/section}
	  </select>
	   <input type="hidden" name="dltype" id="dltype" value="{$smarty.get.dltype}">			
	  </td>	
      </tr>
    </table>
    </form>
    <form name="frmSearch" id="frmSearch" method="GET">	
    <table  align="right" cellpadding="0" cellspacing="0" border="0">
        
<!--      <tr>
	<td valign="top">	-->
<div class="pagehead2 fl">
	  <span style="color:#000">Deal Type: </span>
	  <select name="dltype" id="dltype" onchange="javascript:this.form.submit();">
	                <option value="all">All</option>
		        {section name=i loop=$dltypes}
	      		<option value="{$dltypes[i].typeid}" {if $dltypes[i].typeid eq $smarty.get.dltype} selected="selected" {/if}>{$dltypes[i].dealtype}</option>
		{/section}
	  </select>
	  <input type="hidden" name="deal_from_seller_name" id="deal_from_seller_name" value="{$smarty.get.deal_from_seller_name}">		
<!--	  </td>	
      </tr>-->
</div>
    </table>
    </form>
</div>
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
<div class="clr">&nbsp;</div>
<div class="clr"></div>   
<div class="border"></div> 
    <div align="center" id="msg">{$msg}</div>
    <table cellpadding="2" cellspacing="0" width="100%" style="vertical-align:top;">
	  <tr>
	     <td colspan="2" valign="top" align="center">
		<form name="frmAction" id="frmAction" method="post" action="" onsubmit="">
		<table cellpadding="6" cellspacing="2" border="0" width="100%" class="listtable">
		    <tr class="headbg">
			<td width="1%" align="center" valign="top"><input type="checkbox" id="checkall" /></td>
			<td width="10%" align="left" valign="top">Deal Name</td>
			<td width="9%" align="left" valign="top">Added By</td>
			<td width="9%" align="left" valign="top">Seller Name</td>
			<td width="6%" align="left" valign="top">Start Date</td>	
			<td width="6%" align="left" valign="top">End Date</td>		
			<td width="8%" align="left" valign="top">Deal Type</td>	
			<!--<td width="8%" align="left" valign="top">Deal Type</td>-->
			<td width="8%" align="left" valign="top">City</td>
			<td width="6%" align="left" valign="top">Price</td>
			<td width="7%" align="left" valign="top">Original Price</td>
			<td width="6%" align="left" valign="top">% Saved</td>		
			<td width="4%" align="left" valign="top">Action</td>
		    </tr>
		    {section name=i loop=$deal}
		      <tr class="grayback" id="tr_{$deal[i].deal_unique_id}">
			<td align="center" valign="top">
			<input type="checkbox" name="deal_id[]" value="{$deal[i].deal_unique_id}" />
			</td>
			<td align="left" valign="top">{$deal[i].title|ucfirst|html_entity_decode}</td>
			<td align="left" valign="top">{$deal[i].ad_name}
                        <br/>
                         <!--<a href="{$siteroot}/admin/user/ad-user-info.php?userid={$deal[i].admin_userid}">-->( Seller )<!--</a>-->
               </td>
			<td align="left" valign="top">{$deal[i].deal_from_seller_name}</td>
			<td align="left" valign="top">{$deal[i].start_date}</td>
			<td align="left" valign="top">{$deal[i].end_date}</td>
			<td  valign="top">{$deal[i].deal_main_type}</td>
			<!--<td  valign="top">{*$deal[i].deal_type|ucfirst*}</td>-->
			<td valign="top">{if $deal[i].city_name}{$deal[i].city_name}{else}-----{/if}</td>
			<td  valign="top">{$deal[i].deal_currency_type}{$deal[i].groupbuy_price}</td>
			<td valign="top">{$deal[i].deal_currency_type}{$deal[i].orignal_price}</td>
			<td valign="top">{$deal[i].quantity} %</td>		
			<td align="left" valign="top">
			<img src="{$siteroot}/templates/default/images/icons/application_edit.png" align="absmiddle" />&nbsp;<a href="{$siteroot}/admin/seller/deal/edit_product.php?back=ex&id={$deal[i].deal_unique_id}"><strong>Edit</strong></a>
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
    <div class="clr">&nbsp;</div>
</div>
</section>
</section>
{include file=$footer_seller}
