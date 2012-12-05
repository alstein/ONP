{include file=$header1}
{literal}
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
		if(confirm('Are you sure to perform "'+$("#action").attr('value')+'" action'))
			return true;
		else
			return false;
    });
	$("#msg").fadeOut(5000);
});
</script>
{/literal}
{include file=$header2}
<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; <a href="{$siteroot}/admin/user/users_list.php">Users list</a> &gt;User Deal Listing </div>
<br />
<table cellpadding="6" cellspacing="2" align="center" width="100%" border="0">
  <tr>
    <td colspan="2"><h3>Manage user Deal Listing</h3></td> 
  </tr>
  <tr>
    <td align="left"></td>
    <td align="right">{*<!--<form name="form1" method="get" id="form1" action="">
        <input name="search" type="text" id="search" value="{$smarty.get.search}" size="35" class="search"/><input type="submit" value="Search" class="searchbutton" />
    </form>-->*}</td>
  </tr>
  <tr>
    <td  colspan="2">
      <div align="center" class="success" >{$msg}</div>
      <form name="frmAction" id="frmAction" method="post" action="">
	<input type="hidden" name="userid" value="{$smarty.get.userid}">
        <table cellpadding="6" cellspacing="2" align="center" width="100%" border="0" class="listtable">
          <tr class='headbg' align="center">
            <td width="1%" align="center"><input type="checkbox" id="checkall" /></td>
            <td width="15%" align="left">Product</td>
            <td width="10%" align="left">Full Name</td>
            <td width="7%" align="left">Quantity</td>
            <td width="10%" align="left">Price</td>
         	  <td width="12%" align="left">Payment Made?</td>
            <td width="15%" align="left">Purchase Date</td>
            <td width="10%" align="left">Canceled?</td>
            <td width="10%" align="left">Used</td>
            <td width="10%" align="left">Referrals</td>
          </tr>
          {section name=i loop=$gift}
          <tr class="grayback" id="tr_{$gift[i].payid}">
            <td align="center"><input type="checkbox" name="giftid[]" value="{$gift[i].payid}" /></td>
            <!--<td align="left" width="20%"> <img src="{$siteroot}/templates/{$templatedir}/images/icons/{if $gift[i].status eq 'Inactive'}award_star_silver_1.png {else}award_star_silver_2.png{/if}" align="absmiddle" />  {$gift[i].f_cat|capitalize}</td>-->
	    		<td align="left">{$gift[i].deal}</td>
           <!-- <td align="left">{if $gift[i].pay_done == 'yes'} Done {else} Not Done {/if}</td>-->
            <td align="left">{$gift[i].buyer}</td>
		      <td align="left">{$gift[i].ordered}</td>
		 		<td align="left">{$gift[i].total_price}</td>
         	<td align="left">{$gift[i].pay_status|ucfirst}</td>
            <td align="left">{$gift[i].order_date|date_format}</a></td>
            <td align="left">{if $gift[i].pay_status eq no}<a href="{$siteroot}/admin/user/view_deal.php?userid={$smarty.get.userid}&payid={$gift[i].payid}&cancel={$gift[i].cancel_order}" title="Cancel Order"><strong>{if $gift[i].pay_status eq 'no'}{if $gift[i].cancel_order eq 'no'}yes{else}no{/if}{else}{$gift[i].cancel_order}{/if}</strong></a> 
            {else} 
            <a href="{$siteroot}/admin/user/view_deal.php?userid={$smarty.get.userid}&payid={$gift[i].payid}&cancel={$gift[i].cancel_order}" title="Cancel Order"><strong>{if $gift[i].cancel_order eq 'no'}yes{else}no{/if}</strong></a> 
            {/if}</td>
         	<td align="left">{$gift[i].used}</td>
         	<td align="left">{$gift[i].nums}</td>
          </tr>
          {sectionelse}
          <tr align="center" class="trbgprj02">
            <td colspan="10" class="success" align="center"><b>No record found</b></td>
          </tr>
          {/section}
          <tr>
            <td align="right"><img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"  /></td>
            <td align="left" colspan="2"><select name="action" id="action">
                <option value="">--Action--</option>
                <option value="delete">Delete</option>
              </select>
              <input type="submit"  value="Go" class="button1" />&nbsp;
            <span id="acterr" class="error"></span></td> 
            {if $showpgnation eq 'yes' }
            <td colspan="5" align="right">{$pagenation}</td>
            {/if}
          </tr>
        </table>
      </form></td>
  </tr>
</table>
{include file=$footer}