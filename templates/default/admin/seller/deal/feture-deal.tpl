{include file=$header_seller1}
{include file=$header_seller2}
<script type="text/javascript">
{literal}
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
	$("#frmAction").submit(function(){
		
//		if($("#action").attr('value')=='')
//		{
//			$("#acterr").text("Please Select Action.").show().fadeOut(3000);
//			return false;
//		}
		$("input[@type=checkbox]").each(function()
		{
			var $tr = $(this).parent().parent();
			if($tr.attr('id'))
				if(this.checked == true)
					flag = true;
		});
		
//		if (flag == false) {
//			$("#acterr").text("Please Select Checkbox.").show().fadeOut(3000);
//			return false;
//		}
//		if(confirm('Are you sure to perform "'+$("#action").attr('value')+'" action'))
//			return true;
//		else
//			return false;
    });
	$("#msg").fadeOut(5000);
});
{/literal}
</script>
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
                <a href="{$siteroot}/admin/seller/deal/featured_deal.php"  class="active">Featured Deals ({$deal_notice_info_seller.tot_fea})</a> &nbsp;&nbsp;|&nbsp;&nbsp; 
                <a href="{$siteroot}/admin/seller/deal/rejected-deals.php">Rejected Deals ({$deal_notice_info_seller.tot_rej})</a>&nbsp;&nbsp;|&nbsp;&nbsp; 
                <a href="{$siteroot}/admin/seller/deal/upcoming_deal.php">Upcoming Deals ({$deal_notice_info_seller.tot_upcom})</a> &nbsp;&nbsp;|&nbsp;&nbsp; 
                <a href="{$siteroot}/admin/seller/deal/expired_deal.php">Expired Deals ({$deal_notice_info_seller.tot_exp})</a>
                </div>
			
           
			</div>
		</div>
		<div class="innerdesc">
    <!--<form name="frmSearch" id="frmSearch" method="GET">	
    <table  align="right" cellpadding="0" cellspacing="0" border="0" style="margin-right:80px">

      <tr>
	<td valign="top">	
	  <strong>Slider: </strong>
	  <select name="slid" id="slid">
	      <option value="">Select Option</option> 
	      <option value="on" {if $slid eq 'on'} selected="selected" {/if} onclick="window.location.href='{$siteroot}/admin/seller/deal/featured_deal.php?slider=on'">Slider On</option>
	     <option value="off" {if $slid eq 'off'} selected="selected" {/if} onclick="window.location.href='{$siteroot}/admin/seller/deal/featured_deal.php?slider=off'">Slider Off</option>
	  </select>			
	  </td>	
      </tr>
    </table>
    </form>

<br />-->
<h3 class="pagehead2 fl">Featured Deals</h3>
<div >
<form name="frmSearch" id="frmSearch" method="GET">	
    <table  align="right" cellpadding="0" cellspacing="0" border="0">
<!--      <tr>
	<td valign="top">	-->
<div class="pagehead2 fl">
	  <span style="color:#000">Deal Type: </span>
	  <select name="dltype" id="dltype" onchange="javascript:this.form.submit();">
	      <!--<option value="all">All</option>-->
		{section name=i loop=$dltypes}
	      		<option value="{$dltypes[i].typeid}" {if $dltypes[i].typeid eq $smarty.get.dltype} selected="selected" {else} {if $smarty.section.i.index eq 0} selected="selected" {/if}{/if}>{$dltypes[i].dealtype}</option>
		{/section}
	  </select>			
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
<!--<br />
<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; Featured Deals
</div><br/>-->

{if $msg}
<div align="center" class="success"  id="msg">{$msg}</div>
{/if}
<div class="holdthisTop">

 <form name="frmAction" id="frmAction" method="post" action="">
<!--<input type="hidden" value="{$smarty.get.product}" name="product"/>-->
<table  class="listtable" width="100%">


<tr class="headbg">
      
			<td width="12%" align="left" valign="top">Deal Name</td>
			<td width="9%" align="left" valign="top">Added By</td>
			<td width="9%" align="left" valign="top">Seller Name</td>
			<td width="6%" align="left" valign="top">Start Date</td>	
			<td width="6%" align="left" valign="top">End Date</td>
			<td width="8%" align="left" valign="top">Deal Type</td>	
			<!--<td width="8%" align="left" valign="top">Deal Type</td>-->
			<td width="8%" align="left" valign="top">City</td>
			<td width="6%" align="left" valign="top">Price</td>
			<td width="8%" align="left" valign="top">Original Price</td>
			<td width="6%" align="left" valign="top">% Saved</td>		
                        <td width="9%" align="right" valign="top">Action</td>
          </tr>

{section name=i loop=$deal}
		      <tr class="grayback" id="tr_{$deal[i].deal_unique_id}">
			
			<td align="left" valign="top">{$deal[i].title|ucfirst|html_entity_decode}</td>
			<td align="left" valign="top">{$deal[i].s_firstname} {$deal[i].s_lastname}</td>
			<td align="left" valign="top">{$deal[i].deal_from_seller_name}</td>
			<td align="left" valign="top">{$deal[i].start_date}</td>
			<td align="left" valign="top">{$deal[i].end_date}</td>
			<td  valign="top">{$deal[i].deal_main_type}</td>
			<!--<td  valign="top">{*$deal[i].deal_type|ucfirst*}</td>-->
			<td valign="top">{if $deal[i].city_name}{$deal[i].city_name}{else}-----{/if}</td>
			<td  valign="top">{$deal[i].deal_currency_type}{$deal[i].groupbuy_price}</td>
			<td valign="top">{$deal[i].deal_currency_type}{$deal[i].orignal_price}</td>
			<td valign="top">{$deal[i].quantity} %</td>		
<td align="right">
Order
<input type="text" size="2" name="{$deal[i].deal_unique_id}" id="{$deal[i].deal_unique_id}" value="{$deal[i].sizeorder}" />

</td>

</tr>
{/section}
{if $deal}
   <tr>
       

             <td colspan="11" align="right">
<div class="fr btnmain"><input type="submit" name="submit"  value="update" class="buybtn2" /></div></td>
      
          
   </tr>
{else}
	<tr>
		<td colspan="11" class="success" align="center"><b>No records found for selected deal type</b></td>
	</tr>
{/if}
   
  </table>
</form>
</div>
</div>
</section>
</section>
{include file=$footer_seller}