{literal}
<script type="text/javascript">
function goto_docapture(dstatus,id,authorisation_id,currency_code,amt,userid)
{

var val=$("#txt_val").val();
if(val=='accept')
{
//alert("ok");
window.location = SITEROOT+"/php_nvp_samples/DoCapture.php?status=yes&id="+id+"&authorisation_id="+authorisation_id+"&currency_code="+currency_code+"&amt="+amt;


}
else if(val=='reject')
{
//alert("ok2352356");

// alert(SITEROOT+"/modules/merchant-account/offer_deal_request.php?status=rejected&id="+id);
 window.location = SITEROOT+"/merchant-account/"+userid+"/rejected/"+id+"/offer_deal_request";
}
}
function get_val(val)
{
document.getElementById("txt_val").value=val;
}
function openPDF(val)
{

	window.open(SITEROOT+'/modules/merchant-account/coupon_pdf.php?id='+val,'PrintDocument','scrollbars=yes, resizable=yes, copyhistory=yes, width=800, height=600, left=300, top=250');
	window.location.reload();
}
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

	jQuery.post(SITEROOT+"/modules/merchant-account/deal_offered.php?page="+pack+"&id1="+id1, function(data)
	{
		jQuery("#show_thread").html(data);
	});
}
function view_coupans_bk(userid,deal_id){
// alert(userid);alert(deal_id);
	$.post(SITEROOT+'/modules/merchant-account/ajax_view_coupans.php',{userid:userid,deal_id:deal_id},function(data){
		$("#show_thread").html(data);
		$("#1").addClass("active");
		$("#2").removeClass("active");
	});
}

function view_coupans(val)
{
	//alert(val);
	window.open(SITEROOT+'/modules/merchant-account/view_coupon_details.php?deal_id='+val,'PrintDocument','scrollbars=yes, resizable=yes, copyhistory=yes, width=800, height=600, left=300, top=250');
	//window.location.reload();
}
</script>

{/literal}



<div class="inbox-tbl">
          <table width="940" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <th width="170" valign="top" height="35">Offer Headline</th>
                <th width="110" valign="top" height="35">Date Offered  </th>
                <th width="150" valign="top" height="35">Original Price</th>
                <th width="80" valign="top" height="35">Offer Price</th>
                <th width="80" valign="top" height="35">Discount</th>
                <th width="100" valign="top" height="35">Active/Expired</th>
                <th width="90" valign="top" height="35">Redeemption Till</th>
                <th  width="80"  valign="top" height="35">Number Brought</th>
				 <th width="80" valign="top" height="35">Coupons</th>
                
            </tr>
		 {section name=i loop=$offer_deal}
            <tr>
              <td width="170" align="center"  height="30"><a href="{$siteroot}/buy/{$offer_deal[i].deal_unique_id}/" target="_blank">{$offer_deal[i].deal_title}</a> </td>
              <td width="110" align="center">{$offer_deal[i].posted_date|date_format} </td>
              <td width="150" align="center">${$offer_deal[i].original_price} </td>
              <td width="80" align="center">${$offer_deal[i].offer_price}</td>
			  <td width="80" align="center"  height="30">{$offer_deal[i].discount_in_per}%</td>
              <td width="100" align="center">{if $offer_deal[i].deal_end_date lt $date} Expired {else}Active{/if}</td>
              <td width="90" align="center"> {$offer_deal[i].redeem_to|date_format}</td>
              <td width="80" align="center">{$offer_deal[i].count}</td>
			<td  width="80" align="center"><a href="javascript:void(0)" class="download-cupon" onclick="view_coupans({$offer_deal[i].deal_unique_id})">View<br>Details</a></td>

			
            </tr>
		{sectionelse}
		<tr><TD colspan="9"><div align="center" class="error">No Records Found.</div></TD></tr>
		{/section}

{if $total_page gt '1'}
<tr><TD colspan="11"><div style="padding-left:850px">
	<strong><a href="javascript:;" {if $smarty.get.page eq ''} style="display:none;"  {else}  {if $smarty.get.page eq '1'}  style="display:none;"  {/if} {/if} onclick="sortOrder('Prev','{$smarty.get.page}','{$smarty.get.id1}');">Prev</a>&nbsp;
	<a href="javascript:;"  {if $smarty.get.page eq $total_page} style="display:none;" {/if} onclick="sortOrder('Next','{$smarty.get.page}','{$smarty.get.id1}');">Next</a></strong>
</div></TD></tr>
{/if}
          </table>

          
           <div class="clr"></div>
        </div>

