        <div class="deal-tbl-main">
          <table width="953" border="0" cellspacing="0" cellpadding="0" class="deal-tbl">
            <tr>
              <th scope="col" width="188" align="left"><span style="padding-left:15px">Deal Name</span></th>
              <th scope="col" width="109">coupon Number</th>
			  <th scope="col" width="90">coupon Code</th>
              <th scope="col" width="104" class="last">Coupons</th>
            </tr>
{section name=i loop=$view_voucher}
            <tr>
              <td align="left"><span style="padding-left:15px; display:block"><strong>{$view_voucher[i].deal_title} </strong></span></td>
              <td align="center">{$smarty.section.i.iteration}</td>
			  <td align="center">{$view_voucher[i].coupon_id}</td>
              <td class="last" style="padding-left:15px"><a href="javascript:void(0)"  onclick="view_voucher({$view_voucher[i].uniqueid})" class="download-cupon">Download <br>
                Coupons</a></td>
            </tr>
{sectionelse}
			<tr><td colspan="7" align="center">No deals Found</td></tr>
{/section}
          </table>
        </div>
