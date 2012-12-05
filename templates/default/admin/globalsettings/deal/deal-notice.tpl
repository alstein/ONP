{include file=$header1}
{include file=$header2}

<h3>Deal Counters / Notices </h3>

<div class="holdthisTop">

      <table width="100%" cellpadding="2" cellspacing="5" border="0" class="conttableDkBg conttable">
      <tr><td >
        <table width="90%" cellpadding="5" cellspacing="10" border="0">
          <tr>
              <td align="right" width="35%"><strong>Total Reviewed Deals: </strong></td>
              <td  align="left">{if $deal.tot_reviewed}<a href="{$siteroot}/admin/globalsettings/deal/view-deal.php" target="_blank">{$deal.tot_reviewed}</a>{else}0{/if}</td>
          </tr>
          <tr>
              <td align="right" width="30%" valign="top"><strong>Total Scheduled Deals: </strong></td>
              <td  align="left">{if $deal.tot_actv}{$deal.tot_actv}{else}0{/if}<br/>
              <p style="margin-top:10px;">{if $deal.tot_actv1}<a href="{$siteroot}/admin/globalsettings/deal/manage_complete_deal.php" target="_blank">{$deal.tot_actv1}</a>{else}0{/if} (Active Deals)</p><br/>
              <p>{if $deal.tot_pending}<a href="{$siteroot}/admin/globalsettings/deal/pending-deal.php" target="_blank">{$deal.tot_pending}</a>{else}0{/if} (Pending Deals)</p>
          </td>
          </tr>

          <tr>
              <td align="right" width="30%" valign="top"><strong>Total Completed GB Product: </strong></td>
              <td  align="left">{if $deal.GB_PRO}{$deal.GB_PRO}{else}0{/if}<br/>
              <p style="margin-top:10px;">{if $deal.GB_PRO_COM}<a href="{$siteroot}/admin/globalsettings/deal/manage_complete_gb_product.php" target="_blank">{$deal.GB_PRO_COM}</a>{else}0{/if} (Successful Deals)</p><br/>
              <p>{if $deal.GB_PRO_NCOM}<a href="{$siteroot}/admin/globalsettings/deal/manage_complete_gb_product.php?dealstatus=not-completed" target="_blank">{$deal.GB_PRO_NCOM}</a>{else}0{/if} (Not Successful Deals)</p>
          </td>
          </tr>

           <tr>
              <td align="right" width="30%" valign="top"><strong>Total Completed GB Voucher: </strong></td>
              <td  align="left">{if $deal.GB_SER}{$deal.GB_SER}{else}0{/if}<br/>
              <p style="margin-top:10px;">{if $deal.GB_PRO_SER}<a href="{$siteroot}/admin/globalsettings/deal/manage_complete_gb_voucher.php" target="_blank">{$deal.GB_SER_COM}</a>{else}0{/if} (Successful Deals)</p><br/>
              <p>{if $deal.GB_SER_NCOM}<a href="{$siteroot}/admin/globalsettings/deal/manage_complete_gb_voucher.php?dealstatus=not-completed" target="_blank">{$deal.GB_SER_NCOM}</a>{else}0{/if} (Not Successful Deals)</p>
          </td>
          </tr>
          
         <tr>
              <td align="right" width="30%" valign="top"><strong>Total Completed Seller Product: </strong></td>
              <td  align="left">{if $deal.SELL_PRO}{$deal.SELL_PRO}{else}0{/if}<br/>
              <p style="margin-top:10px;">{if $deal.SELL_PRO_COM}<a href="{$siteroot}/admin/globalsettings/deal/manage_complete_seller_product.php" target="_blank">{$deal.SELL_PRO_COM}</a>{else}0{/if} (Successful Deals)</p><br/>
              <p>{if $deal.SELL_PRO_NCOM}<a href="{$siteroot}/admin/globalsettings/deal/manage_complete_seller_product.php?dealstatus=not-completed" target="_blank">{$deal.SELL_PRO_NCOM}</a>{else}0{/if} (Not Successful Deals)</p>
          </td>
          </tr>

           <tr>
              <td align="right" width="30%" valign="top"><strong>Total Completed Seller Voucher: </strong></td>
              <td  align="left">{if $deal.SELL_SER}{$deal.SELL_SER}{else}0{/if}<br/>
              <p style="margin-top:10px;">{if $deal.SELL_SER_COM}<a href="{$siteroot}/admin/globalsettings/deal/manage_complete_seller_voucher.php" target="_blank">{$deal.SELL_SER_COM}</a>{else}0{/if} (Successful Deals)</p><br/>
              <p>{if $deal.SELL_SER_NCOM}<a href="{$siteroot}/admin/globalsettings/deal/manage_complete_seller_voucher.php?dealstatus=not-completed" target="_blank">{$deal.SELL_SER_NCOM}</a>{else}0{/if} (Not Successful Deals)</p>
          </td>
          </tr>

          <tr>
              <td align="right" width="30%"><strong>Total Rejected Deals: </strong></td>
              <td  align="left">{if $deal.tot_rej}<a href="{$siteroot}/admin/globalsettings/deal/rejected-deals.php" target="_blank">{$deal.tot_rej}</a>{else}0{/if}</td>
          </tr>
          <tr>
              <td align="right" width="30%"><strong>Total Deals: </strong></td>
              <td  align="left">{if $deal.tot_deals}{$deal.tot_deals}{else}0{/if}</td>
          </tr>
        </table>
      </TD></TR>
      </table> 

</div>
{include file=$footer}