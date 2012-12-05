{include file=$header_seller1}
{strip}
<script type="text/javascript" src="{$siteroot}/js/validation/admin/userlist.js"></script>
{/strip}

{include file=$header_seller2}
<!--<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; Manage Rejected Deals
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
                <a href="{$siteroot}/admin/seller/deal/rejected-deals.php" class="active">Rejected Deals ({$deal_notice_info_seller.tot_rej})</a>&nbsp;&nbsp;|&nbsp;&nbsp; 
                <a href="{$siteroot}/admin/seller/deal/upcoming_deal.php">Upcoming Deals ({$deal_notice_info_seller.tot_upcom})</a> &nbsp;&nbsp;|&nbsp;&nbsp; 
                <a href="{$siteroot}/admin/seller/deal/expired_deal.php">Expired Deals ({$deal_notice_info_seller.tot_exp})</a>
                </div>
			
           
			</div>
		</div>
		<div class="innerdesc">
        <h3 class="pagehead2 fl">Manage Rejected Deals</h3>
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
<div class="pagehead2 fl"> 
	 <span style="color:#000">Deal Type: </span>
	  <select name="dltype" id="dltype" onchange="javascript:this.form.submit();">
	                <option value="all">All</option>
		        {section name=i loop=$dltypes}
	      		<option value="{$dltypes[i].typeid}" {if $dltypes[i].typeid eq $smarty.get.dltype} selected="selected" {/if}>{$dltypes[i].dealtype}</option>
		{/section}
	  </select>
	  <input type="hidden" name="deal_from_seller_name" id="deal_from_seller_name" value="{$smarty.get.deal_from_seller_name}">			
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
<div class="clr"></div>   
<div class="border"></div>  
  {if $msg}<div align="left" id="msg">{$msg}</div>{/if}

  <div class="clr">&nbsp;</div>

 <!-- <div class="fr">
    <form id="frm" name="frm" method="GET">
	<table align="right">
	    <tr>
		<td>
		    <strong>Username: </strong> 
		      <select id="uname" name="uname" style="width:150px;" onchange="javascript:$('#frm').submit();">
			<option value="">Select</option>
			{section name=i loop=$user_list}
			{if $user_list[i].username}<option value="{$user_list[i].username}" {if $smarty.get.uname eq $user_list[i].username} selected="selected"{/if}>{$user_list[i].username}</option>{/if}
			{/section}
		      </select>
		</td>
	      </tr>
	  </table>
      </form>
  </div>-->
  <div class="clr">&nbsp;</div>
  <form name="frmAction" id="frmAction" method="post" action="">
	<table width="100%"  border="0" cellpadding="10" cellspacing="2" class="listtable">
	    <tr class="headbg">
	      <td width="1%" align="center"><input type="checkbox" id="checkall"/></td>
	      <td width="10%" align="left" valign="top">Deal Name</td>
	      <td width="9%" align="left" valign="top">Added By</td>
	      <td width="9%" align="left" valign="top">Seller Name</td>

	      <td width="6%" align="left" valign="top">Start Date</td>	
	      <td width="6%" align="left" valign="top">End Date</td>		
	      <td width="8%" align="left" valign="top">Deal Type</td>	
	      <!--<td width="8%" align="left" valign="top">Deal Type</td>-->
	      <td width="8%" align="left" valign="top">City</td>
	      <td width="6%" align="left" valign="top">Price</td>
	      <td width="9%" align="left" valign="top">Original Price</td>
	      <td width="6%" align="left" valign="top">% Saved</td>	

                <td width="8%"  valign="top">Rejected By</td>
	      <td width="8%" valign="top">Action</td>	 
	  </tr>
	  {section name=i loop=$product}
            {if $product[i].username}
	    <tr class="grayback" id="chk{$smarty.section.i.iteration}">
	      <td><input type="checkbox" value="{$product[i].deal_unique_id}" name="dealid[]"/></td>
	      <td align="left" valign="top">{$product[i].title|html_entity_decode}</td>
	      <td align="left" valign="top"><!--<a href="{$siteroot}/admin/user/seller_view.php?userid={$product[i].seller_id}" >-->{$product[i].username}<!--</a>--></td>
	      <td align="left" valign="top">{$product[i].deal_from_seller_name}</td>
	      <td align="left" valign="top">{$product[i].start_date}</td>
	      <td align="left" valign="top">{$product[i].end_date}</td>
	      <td  valign="top">{$product[i].deal_main_type}</td>
	      <!--<td  valign="top">{*$product[i].deal_type|ucfirst*}</td>-->
	      <td align="left" valign="top" >{if $product[i].city_name}{$product[i].city_name}{else}-----{/if}</td>
	      <td  valign="top">{$product[i].deal_currency_type}{$product[i].groupbuy_price}</td>
	      <td valign="top">{$product[i].deal_currency_type}{$product[i].orignal_price}</td>
	      <td valign="top">{$product[i].quantity} %</td>		
               <td align="left" valign="top" >{$product[i].rejected_name|ucfirst}</td> 
	      <td align="left" valign="top" ><img src="{$siteroot}/templates/default/images/icons/film.png" align="absmiddle" /><!--<a target="_blank" href="{$siteroot}/deal/{$product[i].url_title}/deal-preview/">--><a href="javascript:void(0);" onclick="javascript:alert('coming soon');"><strong>Preview</strong></a></td>
	     </tr>
            {/if}
	  {sectionelse}
	  <tr><td colspan="13" align="center"><strong>No rejected deal(s) found.</strong></td></tr>
	  {/section}
	  {if $product}
	  <tr>
	      <td align="left"><img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"  /></td>
	      <td align="left" colspan="2">
	      <select name="action" id="action">
		  <option value="">Action</option>
		  <option value="restore">Restore</option>
		  <option value="delete">Delete</option>
	      </select>
	      <input type="submit" name="submit" id="submit" value="Go"/>
	      <br><span id="acterr" class="error"></span>
	     </td>
            {if $showpaging eq 'yes'}<td colspan="10" align="right">{$pgnation}</td>{/if}
	  </tr>
          {/if}

       
	</table>
   </form>
</div>
</section>
</section>
{include file=$footer_seller}
