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

	jQuery.post(SITEROOT+"/modules/deal/ajax_deal_bought_consumer.php?page="+pack, function(data)
	{
		jQuery("#deals_consumer_bought").html(data);
	});
}
function view_voucher(val)
{
	//alert(val);
	window.open(SITEROOT+'/modules/deal/view_voucher.php?id='+val,'PrintDocument','scrollbars=yes, resizable=yes, copyhistory=yes, width=800, height=600, left=300, top=250');
	//window.location.reload();
}
</script>
{/literal}       
      
         <!-- <div>--><!-- for other design uncomment this and comment below two <div class="inbox-tbl"> <div class="deal-tbl-main">-->

<div class="inbox-tbl">
<div class="deal-tbl-main">

            <table width="940" cellpadding="0" cellspacing="0" border="0"  class="deal-tbl-main">
              <tr>
                <th width="250" align="center"> Offers Headline</th>
                <th width="150" scope="col" align="center">Merchant </th>
                <th width="100" scope="col" align="center">Date Bought</th>
                <th width="100" scope="col" align="center">Redeem Till </th>
                <th width="100" scope="col" align="center">Original Price</th>
                <th width="100" scope="col" align="center">Offer Price</th>
                <th width="80" scope="col" align="center">Savings</th>
                <th class="last" width="127" scope="col" align="center" >Coupons</th>
              </tr>
{section name=i loop=$deals}
              <tr>
                <td width="250" align="center"> <a href="{$siteroot}/buy/{$deals[i].deal_unique_id}" target="_blank">{$deals[i].discount_in_per}% on {$deals[i].deal_title} at {$deals[i].merchant_name}</a></td>
                <td width="150" scope="col" align="center">{$deals[i].merchant_name} </td>
                <td width="100" scope="col" align="center">{$deals[i].buy_date|date_format:"%e %B %Y"}</td>
                <td width="100" scope="col" align="center">{$deals[i].redeem_to|date_format:"%e %B %Y"} </td>
                <td width="100" scope="col" align="center">${$deals[i].original_price}</td>
                <td width="100" scope="col" align="center">${$deals[i].offer_price}</td>
                <td width="80" scope="col" align="center">{$deals[i].discount_in_per}%</td>
                <td class="last" width="127" scope="col" align="center"><a href="javascript:void(0)" class="download-cupon" onclick="view_coupans({$smarty.session.csUserId},{$deals[i].deal_unique_id})">Coupons</a></td>
              </tr>
{sectionelse}
			<tr><td colspan="8" align="center">No deals Found</td></tr>
{/section}
            </table>

<!--          </div>--> <!-- for other design uncomment this and comment below two </div>-->

		</div>
	</div>
        
<div>
<!--{if $total_page gt '1'}
		<tr><TD colspan="11"><div style="padding-left:850px">
	<strong><a href="javascript:;" {if $smarty.get.page eq ''} style="display:none;"  {else}  {if $smarty.get.page eq '1'}  style="display:none;"  {/if} {/if} onclick="sortOrder('Prev','{$smarty.get.page}');">Prev</a>&nbsp;
	<a href="javascript:;"  {if $smarty.get.page eq $total_page} style="display:none;" {/if} onclick="sortOrder('Next','{$smarty.get.page}');">Next</a></strong>
</div></TD></tr>
{/if}
</div>-->