{include file=$header1}
{literal}
<script type="text/javascript">
	function getCity(val)
	{
		ajax.sendrequest("GET", SITEROOT+"/admin/sitemodules/deal/get_city.php", {val:val}, '', 'replace');
	}
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
			$("#acterr").text("Please select atleast one record.").show().fadeOut(3000);
			return false;
		}
		if(confirm('Are you sure to perform "'+$("#action").attr('value')+'" action?'))
			return true;
		else
			return false;
    });
	$("#msg").fadeOut(5000);
});
</script>
{/literal}
{include file=$header2}
<div class="breadcrumb"><table border="0"><tr><a colspan="3" align="left"><a href="{$siteroot}">Home</a> > <a href="{$siteroot}/admin/sitemodules/deal/manage_complete_deal.php">Completed deal</a> > View deal</td></tr><tr><td colspan="3">&nbsp;</td></tr></table></div>
<h3 align="left">Deal Payment Info</h3>
<div align="center" id="msg">{$msg}</div>
<table cellpadding="2" cellspacing="2" border="0" width="100%">
  <tr>
  	<td></td>
	<td align="right">
		<form name="form1" method="post" id="form1" action="">
		<table width="100%" align="right" cellpadding="0" cellspacing="0">
	<tr>
	<td width="10%" align="left">&nbsp;</td>
        <td width="40%" valign="top" align="right">&nbsp;</td>
        <td width="40%" align="center" valign="top">	
		<div id="replace"> 
			<select name="city">
			{if $city_arr}
				{section name=i loop=$city_arr}
				<option {if $smarty.post.city eq $city_arr[i].city_name} selected="selected" {/if} value="{$city_arr[i].city_name}">{$city_arr[i].city_name}</option>
				{/section}
			{else}
				<option value="">Select City</option>
				<option value="all" selected="selected">All</option>
			{/if}
			</select>
		</div>
	</td>
	<td><input type="submit" name="submit" id="button" value="Search" /></td>
      </tr>
    </table></form></td>
  </tr>
  <tr>
    <td colspan="2" valign="top" align="center"><form name="frmAction" id="frmAction" method="post" action="" onsubmit="">
        <table cellpadding="6" cellspacing="2" border="0" width="100%" class="listtable">
          <tr class="headbg">
            <td width="1%" align="center" valign="top"><input type="checkbox" id="checkall" /></td>
	    <!--<td width="5%" align="center" valign="top">Sr.No</td>	-->
<!--             <td width="15%" align="center" valign="top">User</td> -->
		<td width="23%" align="center" valign="top">Deal name</td>	
		<td width="17%" align="center" valign="top">City</td>
		<td width="7%" align="center" valign="top">Price</td>
            <td width="10%" align="center" valign="top">Buyer</td>
            <td width="7%" align="center" valign="top">Quantity</td>	
            <td width="6%" align="center" valign="top">Total</td>
            <td width="10%" align="center" valign="top">Pay Done</td>
	   <td width="10%" align="center" valign="top">Cancel Order</td>
	   <td width="10%" align="center" valign="top">View deal</td>
          </tr>
          {section name=i loop=$deal}
          <tr class="grayback" id="tr_{$deal[i].id}">
            <td align="center" valign="top"><input type="checkbox" name="deal_id[]" value="{$deal[i].payid}" /></td>
            <td align="left" valign="top">{$deal[i].deal}</td>
           <!-- <td align="left" valign="top">{$deal[i].sales_user}</td>  -->
				<td align="left" valign="top">{$deal[i].product_city}</td>	
            <td align="left" valign="top">{$deal[i].product_price}</td>
            <td align="left" valign="top">{$deal[i].buyer}</td>
            <td align="center" valign="top">{$deal[i].ordered}</td>
            <td align="center" valign="top">{$deal[i].total_price}</td>
            <td align="center" valign="top">{$deal[i].pay_status}</td>
	    <td align="center" valign="top">
		{if $deal[i].pay_status eq no}
		<a href="{$siteroot}/admin/sitemodules/deal/deal_pay_info.php?payid={$deal[i].payid}&cancel={$deal[i].cancel_order}"><strong>{if $deal[i].pay_status eq 'no'}{if $deal[i].cancel_order eq 'no'}yes{else}no{/if}{else}{$deal[i].cancel_order}{/if}</strong></a>{else}Not Done{/if}
           </td>
         <td align="center" valign="top"><img src="{$siteroot}/templates/default/images/icons/film.png" align="absmiddle" />&nbsp;<a href="{$siteroot}/admin/sitemodules/deal/view_deal.php?id={$deal[i].product_id}"><strong>View</strong></a></td>
          </tr>
          {sectionelse}
          <tr>
            <td colspan="9" align="center" height="25" class="error">deal payment information not available.</td>
          </tr>
          {/section}
	{if $deal}
          <tr>
            <td align="right"><img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"  /></td>
            <td align="left" colspan="3"><select name="action" id="action">
                <option value="">--Action--</option>
                <option value="delete">Delete</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
              </select>
              <input type="submit" name="submit" id="submit" value="Go"  class="headbg"/>
              <span id="acterr" class="error"></span></td>
            <td colspan="5" align="right">{if $showpaging eq "yes" }{$pgnation}{/if}</td>
          </tr>
	{/if}
        </table>
      </form></td>
  </tr>
</table>
<div class="clr"></div>
{include file=$footer}