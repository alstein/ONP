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

function showBySeller()
{
    var sellerid = document.getElementById("seller").value;
    var dealtype = document.getElementById("dealtype").value;
    if(dealtype == "gbi")
    {
        query = "type="+dealtype;
        //document.getElementById("seller").style.display = "none";
        window.location = SITEROOT+"/admin/globalsettings/deal/manage_complete_deal.php?"+query;
        return;
    }
    else if(sellerid != "")
    {
        var query = "seller_id="+sellerid;
        if(dealtype != "")
        {
            query = "seller_id="+sellerid+"&type="+dealtype;
        }
        window.location = SITEROOT+"/admin/globalsettings/deal/manage_complete_deal.php?"+query;
        return;
    }
    else if(dealtype != "")
    {
        var query = "type="+dealtype;
        window.location = SITEROOT+"/admin/globalsettings/deal/manage_complete_deal.php?"+query;
        return;
    }
    else
    {
        window.location = SITEROOT+"/admin/globalsettings/deal/manage_complete_deal.php";
        return;
    }
}

</script>
{/literal}
{include file=$header2}
<h3 align="left"><b>Manage Completed Deals</b></h3>
<div align="center" id="msg">{$msg}</div>
<table cellpadding="2" cellspacing="2" border="0" width="82%">
  <tr>
  	<td></td>
    <td align="right">
	<form name="form1" method="get" id="form1" action="">
	<table width="100%" align="right" cellpadding="0" cellspacing="0">
        <tr>
            <td width="40%" align="right"><strong> Deal Status: </strong>
                <select name="dealstatus" id="dealstatus" onchange="javascript:document.form1.submit();" >
                    <option value="completed">Completed</option>
                    <option value="not-completed" {if $smarty.get.dealstatus eq 'not-completed'} selected="selected" {/if}>Not Completed</option>
                    <option value="all" {if $smarty.get.dealstatus eq 'all'} selected="selected" {/if}>All</option>
                </select>
            </td>
            <td align="right" width="10%">&nbsp;</td>
            <td align="right" width="10%"><b>Select Usertype: </b></td>
            <td width="15%" align="right">
                <select name="dealtype" id="dealtype" onchange="showBySeller();" >
                    <option value="">All</option>
                    <option value="service" {if $smarty.get.type eq 'service'} selected="selected" {/if}>Seller Voucher</option>
                    <option value="product" {if $smarty.get.type eq 'product'} selected="selected" {/if}>Seller Product</option>
                    <option value="gbi" {if $smarty.get.type eq 'gbi'} selected="selected" {/if}>Group Buy It</option>
                </select>
            </td>
            <td align="right" width="15%" {if $smarty.get.type eq "gbi"} style="display:none;" {/if}><b>Select Seller:&nbsp;</b></td>
            <td width="15%" align="right" {if $smarty.get.type eq "gbi"} style="display:none;" {/if}>
                <select name="seller" id="seller" onchange="showBySeller();" >
                    <option value="">Seller</option>
                    {section name=i loop=$seller}
                    <option value="{$seller[i].userid}" {if $seller[i].userid eq $smarty.get.seller_id} selected="selected" {/if}>{$seller[i].username}</option>
                    {/section}
                </select>
            </td>
        </tr>
        </table>
        </form>
    </td>
    </tr>
    <tr>
    <td colspan="2" valign="top" align="center"><form name="frmAction" id="frmAction" method="post" action="" onsubmit="">
        <table cellpadding="6" cellspacing="2" border="0" width="100%" class="listtable">
          <tr class="headbg">
            <td width="1%" align="center" valign="top"><input type="checkbox" id="checkall" /></td>
	    <!--<td width="5%" align="center" valign="top">Sr.No</td>	-->
<!--             <td width="15%" align="center" valign="top">User</td> -->
	    <td width="15%" valign="top">Deal Name</td>	
	    <td width="15%" align="left" valign="top">Seller Name</td>	
            <td width="8%" align="left" valign="top">Deal Type</td>
	    <td width="8%" align="center" valign="top">No Of Buyers</td>
	    <td width="8%" align="center" valign="top">Price In &#163;</td>
            <td width="8%" align="cener" valign="top"> Original Price In &#163;</td>	
	    <td width="8%" align="center" valign="top">End Deal Date</td>	
	    <td width="20%" align="center" valign="top">Action</td>
          </tr>
          {section name=i loop=$deal}
          <tr class="grayback" id="tr_{$deal[i].deal_unique_id}">
            <td align="center" valign="top"><input type="checkbox" name="deal_id[]" value="{$deal[i].deal_unique_id}" /></td>
            <td align="left" valign="top">{if $deal[i].status eq 'Active'}<span style="color:green">P</span>{/if} {$deal[i].title|ucfirst}</td>
            <td align="left" valign="top"><a href="{$siteroot}/admin/user/seller_view.php?userid={$deal[i].seller_id}" >{$deal[i].username}</a></td>  
            <td align="left" valign="top">{$deal[i].deal_type|ucfirst}</td>
            <td align="center" valign="top">{if $deal[i].no_buyer gt 0}{$deal[i].no_buyer} {else} 0 {/if}</td>	
            <td align="center" valign="top">{$deal[i].groupbuy_price}</td>
            <td align="center" valign="top">{$deal[i].orignal_price}</td>
            <td align="center" valign="top">{$deal[i].end_date|date_format:"%d-%b-%Y at %I:%M %p"}</td>		
	    <td align="center" valign="top">
                <img src="{$siteroot}/templates/default/images/icons/film.png" align="absmiddle" />
                <a href="{$siteroot}/admin/globalsettings/deal/reset_product.php?id={$deal[i].deal_unique_id}">
                <strong>Reset</strong></a> |
                <img src="{$siteroot}/templates/default/images/icons/film.png" align="absmiddle" />
                <a href="{$siteroot}/admin/globalsettings/deal/view_product.php?{if $smarty.get.dealtype eq ''}id1={$deal[i].deal_unique_id}&type={if $deal[i].seller_id eq '1'}service {elseif $deal[i].deal_type eq 'service'}seller{else}product{/if}{else}id1={$deal[i].deal_unique_id}{/if}{if $smarty.get.dealtype eq 'product'||$smarty.get.dealtype eq 'seller'||$smarty.get.dealtype eq 'admin'}&type={$smarty.get.dealtype}{elseif $deal[i].deal_type eq 'service' && $smarty.get.dealtype eq 'all'}&type=seller{elseif $deal[i].deal_type eq 'product' && $smarty.get.dealtype eq 'all'}&type=product{/if}&act=view">

                <strong>Buyers</strong></a> |
                <img src="{$siteroot}/templates/default/images/icons/film.png" align="absmiddle" />
                <a href="{$siteroot}/admin/modules/feedback/deal-feedback.php?id={$deal[i].deal_unique_id}">
                <strong>Feedback</strong></a>
	    </td>
          </tr>
          {sectionelse}
          <tr>
            <td colspan="5" align="center" height="25" class="error">Deals not found.</td>
          </tr>
          {/section}
	{if $deal}
          <tr>
            <td align="left" colspan="3"><img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"  />
           <select name="action" id="action">
                <option value="">--Action--</option>
                <option value="Past">Past</option>
                <option value="Not-Past">Not Past</option>
                <option value="delete">Delete</option>
              </select>
              <input type="submit" name="submit" id="submit" value="Go"  class="headbg"/>
              <span id="acterr" class="error"></span></td>
            <td colspan="6" align="right">{if $showpaging eq "yes" }{$pgnation}{/if}</td>
          </tr>
	{/if}
        </table>
      </form></td>
  </tr>
</table>
<div class="clr"></div>
{include file=$footer} 
