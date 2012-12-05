{include file=$header1}
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
		$("input[@type=checkbox]").each(function()
		{
			var $tr = $(this).parent().parent();
			if($tr.attr('id'))
				if(this.checked == true)
					flag = true;
		});
    });
	$("#msg").fadeOut(5000);
});
{/literal}
</script>
{include file=$header2}
<br />
<!--<div class="breadcrumb">--><p class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; Featured Deals</p></div>
<br/>
<div class="holdthisTop">
<div>
 <h3 align="left"><b>Featured Deals</b></h3>
 	  </div>
          <div class="clr">&nbsp;</div>
<div align="center" id="msg">{$msg}</div>
 <tr>
    <td align="right">
	<form name="form1" method="get" id="form1" action="">
	<table width="100%" align="right" cellpadding="0" cellspacing="0">
        <tr>
            <td width="40%" align="right">
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
<div>
<form name="frmSearch" id="frmSearch" method="GET">	
    <table  align="right" cellpadding="0" cellspacing="0" border="0" style="margin-right:80px">

    </table>
    </form>
    <form name="frmSearch" id="frmSearch" method="GET">	
    <table  align="right" cellpadding="0" cellspacing="0" border="0" style="margin-right:80px" class="fl">
    <tr>       
	<td>
	  <strong>Deal Type: </strong>
	  <select name="dltype" id="dltype" onchange="javascript:this.form.submit();">
	                <option value="all">All</option>
		        {section name=i loop=$dltypes}
	      		<option value="{$dltypes[i].typeid}" {if $dltypes[i].typeid eq $smarty.get.dltype} selected="selected" {/if}>{$dltypes[i].dealtype}</option>
		{/section}
	  </select>
	  <input type="hidden" name="deal_from_seller_name" id="deal_from_seller_name" value="{$smarty.get.deal_from_seller_name}">		
	  </td>
    </tr>
    </table>
    </form>
   </td>
  </tr>
	<table cellpadding="6" cellspacing="2" align="center" width="100%" border="0">
	{if $msg}
	<div align="center" class="success"  id="msg">{$msg}</div>
	{/if}
<div>

 <form name="frmAction" id="frmAction" method="post" action="">
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
		<input type="submit" name="submit"  value="update" /></td>
   </tr>
{else}
	<tr>
		<td colspan="11" class="success" align="center"><b>No records found for selected deal type</b></td>
	</tr>
{/if}
   
  </table>
</form>

</div>
{include file=$footer}