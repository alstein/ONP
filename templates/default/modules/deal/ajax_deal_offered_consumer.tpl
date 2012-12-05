{literal}       
<script type="text/javascript" >
function sortOrder(page,pageno,id1)
{	
	var newpage = page;
        if(pageno=="")
	{
	pageno=1;
	}
	if(newpage == 'Next')
	{
		var pack = parseInt(pageno) + 1;
	}
	else
	{
		var pack = parseInt(pageno) - 1;
	}

	jQuery.post(SITEROOT+"/modules/deal/ajax_deal_offered_consumer.php?page="+pack, function(data)
	{
		jQuery("#deals_consumer_bought").html(data);
	});
}

function view_voucher1(val)
{
	//alert(val);
	window.open(SITEROOT+'/modules/my-account/voucher-merchant.php?id='+val,'PrintDocument','scrollbars=yes, resizable=yes, copyhistory=yes, width=800, height=600, left=300, top=250');
	//window.location.reload();
}

</script>
{/literal}  
        <div class="inbox-tbl">
          <div class="deal-tbl-main">
			
            <table width="940" cellpadding="0" cellspacing="0" border="0"  class="deal-tbl-main">
              <tr>
                 <th scope="col" width="188" align="left"><span style="padding-left:15px">Vendor Name</span></th>
				<!-- <th scope="col" width="109">Deal Title</th>-->
				<th scope="col" width="107">Date Offered </th>
				<th scope="col" width="107">Redeem Till</th>
				<th scope="col" width="80">Status</th>
				<th scope="col" width="80">Value Original</th>
				<th scope="col" width="100">Advance Amount Paid/Authorized</th>
				<th scope="col" width="70">Savings</th>
				<th scope="col" width="70">Show Offer</th>
				<th scope="col" width="104" class="last">Coupons</th>
              </tr>
{section name=i loop=$deals}
              <tr>
              <td align="left"  {if $deals[i].status eq 'no'} {if $deals[i].days eq 'yes' } style="border: medium solid red;border-width:2px;" {else} style="border:none" {/if} {/if}><span style="padding-left:15px; display:block"><strong>{$deals[i].business_name|ucfirst} </strong></span></td>
              <!--<td align="center">{$deals[i].product_name}</td>-->
			  <td align="center">{$deals[i].offerdate|date_format:"%e %B %Y"}</td>
              <td align="center">{if $deals[i].redeemtype eq '1'}On {$deals[i].redeem_from|date_format:"%e %B %Y"}{else if $deals[i].redeemtype eq '0'}{$deals[i].redeem_to|date_format:"%e %B %Y"}{/if}</td>
              <td align="center">{if $deals[i].status eq 'yes'}Accepted {elseif  $deals[i].status eq 'no'} Pending {else} Rejected{/if}</td>
              <td align="center">${$deals[i].amount_spend}</td>
              <td align="center"><strong>${$deals[i].amt_to_pin} </strong></td>
              <td align="center">{$deals[i].discount}%</td>
				 <td align="center"><a href="{$siteroot}/merchant-account/{$deals[i].offer_deal_id}/view_deal/" target="_blank">View Offer</a></td>
              <td class="last" style="padding-left:15px">{if $deals[i].status eq 'yes'}<a href="javascript:void(0)" class="download-cupon" onclick="view_voucher1({$deals[i].offer_deal_id})">Download 
                Coupons</a>{else}<a href="javascript:void(0)" class="download-cupon">Not 
                Available</a>{/if}</td>
              </tr>
{sectionelse}
			<tr><td colspan="7" align="center">No deals Found</td></tr>
{/section}
            </table>
          </div>
        </div>
<!--<div>
{if $total_page gt '1'}
		<tr><TD colspan="11"><div style="padding-left:850px">
	<strong><a href="javascript:;" {if $smarty.get.page eq ''} style="display:none;"  {else}  {if $smarty.get.page eq '1'}  style="display:none;"  {/if} {/if} onclick="sortOrder('Prev','{$smarty.get.page}');">Prev</a>&nbsp;
	<a href="javascript:;"  {if $smarty.get.page eq $total_page} style="display:none;" {/if} onclick="sortOrder('Next','{$smarty.get.page}');">Next</a></strong>
</div></TD></tr>
{/if}
</div>-->