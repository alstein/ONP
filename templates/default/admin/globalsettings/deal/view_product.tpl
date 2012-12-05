{include file=$header1}
{include file=$header2}

<div class="breadcrumb">
<table width="100%">
<tr><Td width="80%">
<td width="5%">
<a href="{$url}">Back</a></td>
</tr>
</table></div>

<div id="maincont1">

{if $msg neq ''}<div align="center" class="success">{$msg}</div>{/if}

  <table width="90%" class="brdall" border="0" align="center">
    <tr>
      <td align="right" width="23%" valign="top"><h3 style="color:#0981BE; font-size:24px">Deal:<span style="color:#000"></span></h3></td>
      <td align="left" width="77%"><h3><span style="color:#000">{$dealinfoarr.title|ucwords}</span></h3></td>
    </tr>
    <tr> <td colspan="2">&nbsp;</td></tr>
    <tr>
      <td align="right"  valign="top"><strong>Deal Category:&nbsp;&nbsp;&nbsp;</strong></td>
      <td align="left">{$dealinfoarr.category|ucfirst}</td>
    </tr>
    <tr> <td colspan="2">&nbsp;</td></tr>
    <tr>
      <td align="right"  valign="top"><strong>City:&nbsp;&nbsp;&nbsp;</strong></td>
      <td align="left">{$dealinfoarr.deal_city}</td>
    </tr>
    <tr> <td colspan="2">&nbsp;</td></tr>
    <tr>
      <td align="right"  valign="top"><strong>Start Date:&nbsp;&nbsp;&nbsp;</strong></td>
      <td align="left">{$dealinfoarr.start_date|date_format:"%e %b %Y"}</td>
    </tr>
    <tr> <td colspan="2">&nbsp;</td></tr>
    <tr>
      <td align="right"  valign="top"><strong>End Date:&nbsp;&nbsp;&nbsp;</strong></td>
      <td align="left">{$dealinfoarr.end_date|date_format:"%e %b %Y"}</td>
    </tr>

    <tr> <td colspan="2">&nbsp;</td></tr>
	
    <tr>
      <td align="right"  valign="top"><strong>Title:&nbsp;&nbsp;&nbsp;</strong></td>
      <td align="left">{$dealinfoarr.title|ucfirst}</td>
    </tr>
    <tr> <td colspan="2">&nbsp;</td></tr>
    <tr>
      <td align="right" width="23%" valign="top"><strong>Description:&nbsp;&nbsp;&nbsp;</strong></td>
      <td align="left" width="77%">{$dealinfoarr.description|html_entity_decode}</td>
    </tr>

    <tr> <td colspan="2">&nbsp;</td></tr>

    <tr>
      <td align="right" width="23%" valign="top"><strong>Highlight:&nbsp;&nbsp;&nbsp;</strong></td>
      <td align="left" width="77%">{$dealinfoarr.highlight|html_entity_decode}</td>
    </tr>

    <tr> <td colspan="2">&nbsp;</td></tr>

    <tr>
      <td align="right" width="23%" valign="top"><strong>Terms Fine print:&nbsp;&nbsp;&nbsp;</strong></td>
      <td align="left" width="77%">{$dealinfoarr.fineprint|html_entity_decode}</td>
    </tr>
    <tr> <td colspan="2">&nbsp;</td></tr>

    <tr>
      <td align="right" width="23%" valign="top"><strong>Sub Delivery cost:&nbsp;&nbsp;&nbsp;</strong></td>
      <td align="left" width="77%">{$dealinfoarr.sub_delivery_cost}</td>
    </tr>
    <tr> <td colspan="2">&nbsp;</td></tr>
    <tr>
      <td align="right" width="23%" valign="top"><strong>Sub Payment Methods Accepted:&nbsp;&nbsp;&nbsp;</strong></td>
      <td align="left" width="77%">{$dealinfoarr.payment_method}</td>
    </tr>
    <tr> <td colspan="2">&nbsp;</td></tr>
    <tr>
      <td align="right" width="23%" valign="top"><strong>Sub Refund Policy:&nbsp;&nbsp;&nbsp;</strong></td>
      <td align="left" width="77%">{$dealinfoarr.refund_policy}</td>
    </tr>
    <tr> <td colspan="2">&nbsp;</td></tr>
    <tr>
      <td align="right"  valign="top"><strong>Photo:&nbsp;&nbsp;&nbsp;</strong></td>
      <td align="left">
	{section name=j loop=$deal_img}
	    <img src="{$siteroot}/uploads/product/thumb122X145/{$deal_img[j]}" />{if $smarty.section.j.index eq 3}<br/><br/>{else}&nbsp;&nbsp;{/if}
	{/section}
      </td>
    </tr>
    <tr> <td colspan="2">&nbsp;</td></tr>
    <tr>
      <td align="right"  valign="top"><strong>Video Link:&nbsp;&nbsp;&nbsp;</strong></td>
      <td align="left">{$dealinfoarr.vedio_link}</td>
    </tr>
    <tr> <td colspan="2">&nbsp;</td></tr>
    <tr>
      <td align="right"  valign="top"><strong>Group Buy Price:&nbsp;&nbsp;&nbsp;</strong></td>
      <td align="left">{$dealinfoarr.groupbuy_price}</td>
    </tr>
    <tr> <td colspan="2">&nbsp;</td></tr>
    <tr>
      <td align="right"  valign="top"><strong>Original Price:&nbsp;&nbsp;&nbsp;</strong></td>
      <td align="left">&#163;{$dealinfoarr.orignal_price}</td>
    </tr>
    <tr> <td colspan="2">&nbsp;</td></tr>
   <tr>
      <td align="right"  valign="top"><strong>Quantity:&nbsp;&nbsp;&nbsp;</strong></td>
      <td align="left">{$dealinfoarr.quantity}</td>
    </tr>
    <tr> <td colspan="2">&nbsp;</td></tr>
   <tr>
      <td align="right"  valign="top"><strong>Minimum Buyers Required:&nbsp;&nbsp;&nbsp;</strong></td>
      <td align="left">{$dealinfoarr.min_buyer}</td>
    </tr>
    <tr> <td colspan="2">&nbsp;</td></tr>
    <tr>
   <tr>
      <td align="right"  valign="top"><strong>Maximum Buyers:&nbsp;&nbsp;&nbsp;</strong></td>
      <td align="left">{$dealinfoarr.max_buyer}</td>
    </tr>
    <tr> <td colspan="2">&nbsp;</td></tr>
   <tr>
      <td align="right"  valign="top"><strong>Shipping Assistance:&nbsp;&nbsp;&nbsp;</strong></td>
      <td align="left">{$dealinfoarr.shipping_assitance}</td>
    </tr>
    <tr> <td colspan="2">&nbsp;</td></tr>
    <tr><td align="right" valign="top"></td><td colspan="2" height="15" align="left"><input type="button" name="cancel" id="cancel" value="Back" onclick="javascript: document.location.href='manage_deal.php'"></td></tr>
  </table>
</div>
</div>
</div>

{include file=$footer}