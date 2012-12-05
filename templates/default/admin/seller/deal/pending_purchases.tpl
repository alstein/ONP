{include file=$header_seller1}
{literal}
<!--<link rel="stylesheet" href="{$siteroot}/templates/default/css/AdminLayout.css" type="text/css">-->
<script type="text/javascript">
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
		
		if (flag == false) {
			$("#acterr").text("Please Select Checkbox.").show().fadeOut(3000);
			return false;
		}
		if(confirm('Are you sure to perform "'+$("#action").attr('value')+'" action ?'))
			return true;
		else
			return false;
    });
	$("#msg").fadeOut(5000);
});
</script>

<script type="text/javascript">
function redirect_deal(url,deal_id)
{
	//alert("url: "+url+" DEal id: "+deal_id);
	window.location = url+"/admin/seller/deal/pending-deal.php?prod_deal_id="+deal_id;
}

</script>

{/literal}

{include file=$header_seller2}
<!--<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; Pending Deals

</div><br/>
-->
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
                <a href="{$siteroot}/admin/seller/deal/pending-deal.php"  class="active">Pending Deals ({$deal_notice_info_seller.tot_pending})</a> &nbsp;&nbsp;|&nbsp;&nbsp; 
                <a href="{$siteroot}/admin/seller/deal/manage_deal.php">Active Deals ({$deal_notice_info_seller.tot_actv1})</a> &nbsp;&nbsp;|&nbsp;&nbsp; 
                <a href="{$siteroot}/admin/seller/deal/featured_deal.php">Featured Deals ({$deal_notice_info_seller.tot_fea})</a> &nbsp;&nbsp;|&nbsp;&nbsp; 
                <a href="{$siteroot}/admin/seller/deal/rejected-deals.php">Rejected Deals ({$deal_notice_info_seller.tot_rej})</a>&nbsp;&nbsp;|&nbsp;&nbsp; 
                <a href="{$siteroot}/admin/seller/deal/upcoming_deal.php">Upcoming Deals ({$deal_notice_info_seller.tot_upcom})</a> &nbsp;&nbsp;|&nbsp;&nbsp; 
                <a href="{$siteroot}/admin/seller/deal/expired_deal.php">Expired Deals ({$deal_notice_info_seller.tot_exp})</a>
                </div>
			
           
			</div>
		</div>
		<div class="innerdesc">
<form name="frmSearch" id="frmSearch" method="GET">	
    <table  align="right" cellpadding="0" cellspacing="0" border="0" style="margin-right:80px">
      <tr style="display:none">
	<td valign="top">	
	  <strong>Seller Name: </strong>
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
    
    
<h3 class="pagehead2 fl">Pending Deals</h3>

<div >
<form name="frmSearch" id="frmSearch" method="GET">	
	  <span style="color:#000">Deal Type: </span>
	  <select name="dltype" id="dltype" onchange="javascript:this.form.submit();">
	                <option value="all">All</option>
		        {section name=i loop=$dltypes}
	      		<option value="{$dltypes[i].typeid}" {if $dltypes[i].typeid eq $smarty.get.dltype} selected="selected" {/if}>{$dltypes[i].dealtype}</option>
		{/section}
	  </select>
	  <input type="hidden" name="deal_from_seller_name" id="deal_from_seller_name" value="{$smarty.get.deal_from_seller_name}">		
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
            <!--<tr>
    			<tr><td></td></tr>	
    			<td align="right">
				<div id="replace">Deal Title: 
					<select name="prod_title" id="prod_title" onchange="javascript: redirect_deal('{$siteroot}',this.value);" style="width=250;">
          					<option value="">--Select--</option>
          					{section name=t loop=$deal_title_arr}
          					<option value="{$deal_title_arr[t].deal_product_id}" {if $smarty.get.prod_deal_id eq $deal_title_arr[t].deal_product_id} selected="selected" {/if}>{$deal_title_arr[t].title|@ucfirst}</option>
          					{/section}
      						</option>
					</select>
				</div>	
  			</td>

  		</tr>-->
			<div align="center" id="msg">{$msg}</div>
			{if $smarty.get.prod_deal_id neq ""}
			  <div align="left"><strong>Deal:</strong> <strong class="success">{$deal_arr[0].product_name|@ucfirst}</strong></div>
			  <div align="right" class="success" style="padding-bottom:5px;"></div>
			{/if}

      			<form name="frmAction" id="frmAction" method="post" action="">
			  <table cellpadding="6" cellspacing="2" align="center" width="100%" border="0" class="listtable">
                <tr class='headbg' align="center">
                <td width="1%" align="center"><input type="checkbox" id="checkall" /></td>
                <td width="10%" align="left" valign="top">Deal Name</td>
                <td width="9%" align="left" valign="top">Added By</td>
                <td width="9%" align="left" valign="top">Seller Name</td>
                <td width="6%" align="left" valign="top">Start Date</td>	
                <td width="6%" align="left" valign="top">End Date</td>		
                <td width="8%" align="left" valign="top">Deal Type</td>	
                <!--<td width="8%" align="left" valign="top">Deal Type</td>-->	
                <!--<td width="20%" align="left" valign="top">Description</td>-->
                <td width="8%" align="left" valign="top">City</td>
                <td width="5%" align="left" valign="top">Price</td>
                <td width="8%" align="left" valign="top">Original Price</td>
                <td width="6%" align="left" valign="top">% Saved</td>	
                <td width="10%" align="left" valign="top">Action</td>
							
					<!--            <td width="8%" align="left">Close Date</td>-->
			    </tr>
			    {section name=i loop=$deal}
			    <tr class="grayback" id="tr_{$gift[i].id}">
				<td align="center"><input type="checkbox" name="deal_id[]" value="{$deal[i].deal_unique_id}" /></td>
				<td align="left" valign="top">{if $deal[i].recommend eq '1'}<font color="red" style="weight:bold;font-size:10px">R</font>{else}{/if}{if $deal[i].featured eq '1'} <font color="red" style="weight:bold;font-size:10px">F</font>{/if}{$deal[i].title|ucfirst|html_entity_decode}</td>
				<td align="left" valign="top">{$deal[i].ad_name}
							<br/>
				<!--<a href="{$siteroot}/admin/user/ad-user-info.php?userid={$deal[i].admin_userid}">-->( Seller )<!--</a>-->
				</td>

				<td align="left" valign="top">{$deal[i].deal_from_seller_name}</td>

				<td align="left" valign="top">{$deal[i].start_date}</td>
				<td align="left" valign="top">{$deal[i].end_date}</td>
				<td  valign="top">{$deal[i].deal_main_type}</td>
				<!--<td  valign="top">{*$deal[i].deal_type|ucfirst*}</td>-->
<!--            			<td align="left" valign="top">{$deal[i].description|strip_tags|substr:0:40|html_entity_decode}</td>-->
	   	 		<td align="left" valign="top">{if $deal[i].city_name}{$deal[i].city_name}{else}-----{/if}</td>	
            			<td align="left" align="left" valign="top">{$deal[i].deal_currency_type}{$deal[i].groupbuy_price}</td>
            			<td align="left" valign="top">{$deal[i].deal_currency_type}{$deal[i].orignal_price}</td>
				<td valign="top">{$deal[i].quantity} %</td>	
	    		         <td align="left" valign="top">
				    <img src="{$siteroot}/templates/default/images/icons/film.png" align="absmiddle" />
<strong><a href="{$siteroot}/admin/seller/deal/edit_product.php?back=pend&id={$deal[i].deal_unique_id}">Edit</a> |<strong>
<!--<a target="_blank" href="{$siteroot}/deal/{$deal[i].url_title}/deal-preview/">--><a href="javascript:void(0);" onclick="javascript:alert('comming soon');"><strong>Preview</strong></a>{if $number eq '4'||$deal[i].featured eq '0'}<a href="{$siteroot}/admin/seller/deal/pending-deal.php?id={$deal[i].deal_unique_id}&typid={$deal[i].deal_main_type_id}" style="text-decoration:none;">{else}<a href="{$siteroot}/admin/seller/deal/pending-deal.php?id={$deal[i].deal_unique_id}&agree=yes" style="text-decoration:none;">{/if}<br><strong>{if $deal[i].featured eq '0'}&nbsp;| Set featured{else}&nbsp;| Unset featured{/if}</strong></a>  <!--{*if $deal[i].deal_unique_id|@in_array:$autho}| 
				    <img src="{$siteroot}/templates/default/images/icons/film.png" align="absmiddle" /><a target="_blank" href="{$siteroot}/admin/globalsettings/deal/get_autho_release.php?id={$deal[i].deal_unique_id}"><strong>Release</strong></a>
				    {/if*}-->
				</td>
			     </tr>
			    {sectionelse}
			    <tr align="center" class="trbgprj02">
				    <td colspan="12" class="success" align="center"><b>No record found</b></td>
			    </tr>
			    {/section}
                            {if $deal}
			    <tr>
				<td align="left"><img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"  /></td>
				<td align="left" colspan="2">
                                    <select name="action" id="action">
				      <option value="">--Action--</option>
				      <!--<option value="approve">Approve</option>
				      <option value="reject">Reject</option>-->
				      <option value="delete">Delete</option>
				      <!--<option value="Unrecommended">Unrecommended</option>
				      <option value="recommended">Recommended</option>-->
				    </select>
				    <input type="submit"  value="Go" class="" />&nbsp;
				    <br><span id="acterr" class="error"></span>
				</td> 
				{if $showpgnation eq 'yes' }
				<td colspan="9" align="right">{$pagenation}</td>
				{/if}
			    </tr>
                            {/if}
        		</table>
		        </form>
	           
</div>

</div>
</section>
</section>

{include file=$footer_seller}
