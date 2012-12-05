{literal}
<script type="text/javascript">
function goto_docapture(dstatus,id,authorisation_id,currency_code,amt,userid)
{

var val=$("#txt_val").val();

if(val=='accept')
{

window.location = SITEROOT+"/php_nvp_samples/DoCapture.php?status=yes&id="+id+"&authorisation_id="+authorisation_id+"&currency_code="+currency_code+"&amt="+amt;


}
else if(val=='reject')
{
var r=confirm("You want to reject this deal.")
if (r==true)
  {
 window.location = SITEROOT+"/php_nvp_samples/DoVoid.php?userid="+userid+"&status=rejected&id="+id+"&authorisation_id="+authorisation_id+"&currency_code="+currency_code+"&amt="+amt;
  }
else
  {
  window.location = SITEROOT+"/merchant-account/"+userid+"/offer_deal_request";
  }

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

	jQuery.post(SITEROOT+"/modules/merchant-account/incoming_deal.php?page="+pack+"&id1="+id1, function(data)
	{
		jQuery("#show_thread").html(data);
	});
}
function view_voucher(val)
{
	//alert(val);
	window.open(SITEROOT+'/modules/merchant-account/view_voucher.php?id='+val,'PrintDocument','scrollbars=yes, resizable=yes, copyhistory=yes, width=800, height=600, left=300, top=250');
	//window.location.reload();
}

function view_voucher1(val)
{

	window.open(SITEROOT+'/modules/my-account/voucher-merchant.php?id='+val,'PrintDocument','scrollbars=yes, resizable=yes, copyhistory=yes, width=800, height=600, left=300, top=250');
	//window.location.reload();
}

</script>

{/literal}
<form method="POST" name="form" id="form" >
		<input  type="hidden" name="txt_val" id="txt_val" value="">

<div class="inbox-tbl">
          <table width="940" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <th width="150" valign="top" height="35">From</th>
                <th width="100" valign="top" height="35">Date Offered  </th>
                <th width="150" valign="top" height="35">Value Original</th>
                <th width="70" valign="top" height="35">Discount </th>
                <th width="80" valign="top" height="35">Net value</th>
                <th width="100" valign="top" height="35">Approve Till</th>
                <th width="80" valign="top" height="35">Status</th>
                <th  width="80"  valign="top" height="35">Show Offer</th>
				 <th width="50" valign="top" height="35">Action</th>
                <th  width="80"  valign="top" height="35">Coupons</th>
            </tr>
		 {section name=i loop=$offer_deal}
            <tr>
              <td width="150" align="center"  height="30">{$offer_deal[i].fullname}</td>
              <td width="100" align="center">{$offer_deal[i].offerdate|date_format}</td>
              <td width="150" align="center">${$offer_deal[i].amount_spend}</td>
              <td width="70" align="center">{$offer_deal[i].discount}%</td>
			  <td width="80" align="center"  height="30">${$offer_deal[i].outflow}</td>
              <td width="100" align="center">{$offer_deal[i].bid_validity|date_format}</td>
              <td width="80" align="center"> {if $offer_deal[i].status neq 'yes'}<abbr>{/if}{if $offer_deal[i].status eq 'yes'}<b> Approved</b> {elseif $offer_deal[i].status eq 'rejected'} Rejected{else}<b>Pending</b>{/if}{if $offer_deal[i].status neq 'yes'}</abbr>{/if} </td>
              <td width="80" align="center"><a href="{$siteroot}/merchant-account/{$offer_deal[i].offer_deal_id}/view_deal/" target="_blank">View Offer</a></td>
			<td  width="50" align="center">  {if $offer_deal[i].status eq 'yes'} Accepted {elseif $offer_deal[i].status eq 'rejected'} Rejected{elseif $offer_deal[i].allow eq 'no'} Closed {else} 
	

					<select name="action" id="action" onchange="get_val(this.value);" >
						<option value="">Select</option>
						<option value="accept" >Accept</option>
						<option value="reject">Reject</option>
					</select>
	
                  <input type="button" name="" value="GO" class="go-btn" onclick="javascript:goto_docapture('yes',{$offer_deal[i].offer_deal_id},'{$offer_deal[i].authorisation_id}','{$offer_deal[i].currency_code}',{$offer_deal[i].amt_to_pin},{$smarty.session.csUserId});"/>{/if}</td>

			<td  width="80" align="center">{if $offer_deal[i].status eq 'yes'}<a href="javascript:void(0)"  onclick="view_voucher1({$offer_deal[i].offer_deal_id})" class="download-cupon">Download <br>
                Coupons</a>{elseif $offer_deal[i].status eq 'rejected'} Rejected{else}Pending{/if}</td>
            </tr>
			{sectionelse}
		<tr><TD colspan="10"><div align="center" class="error">No Records Found.</div></TD></tr>
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

	</form>
