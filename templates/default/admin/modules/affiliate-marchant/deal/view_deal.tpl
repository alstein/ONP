{include file=$header1}
{include file=$header2}


<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; <a href="{$siteroot}/admin/modules/affiliate-marchant/deal/{if $smarty.get.back eq 'exp'}expired_deal.php{else}manage_deal.php{/if}"> Manage {if $smarty.get.back eq 'exp'}Expired{else}Active{/if} Aggregate Deals</a>
 &gt; View Aggregate Deal</div>
<br />

<h3>View Aggregate Deal</h3>

<div class="holdthisTop">
      <span style="float:right;"> 
            <h3><a href="{$siteroot}/admin/modules/affiliate-marchant/deal/{if $smarty.get.back eq 'exp'}expired_deal.php{else}manage_deal.php{/if}"><strong>Back</strong></a></h3>
      </span>

      <table width="100%" cellpadding="2" cellspacing="5" border="0" class="conttableDkBg conttable">
      <tr>
        <td>
             <table width="100%" cellpadding="4" cellspacing="5" border="0">
                <tr>
                    <td width="25%" align="right" valign="top"><strong>Deal Unique Id:</strong> </td>
                    <TD  align="left">{$deal_info.deal_unique_id}</td>
                </tr>
		<tr>
                    <td width="25%" align="right" valign="top"><strong>iId: </strong></td>
                    <TD  align="left"> {$deal_info.iId}</td>
                </tr>
                 <tr>
                    <td width="25%" align="right" valign="top"><strong>Category:</strong> </td>
                    <TD  align="left">{$deal_info.category_name}</td>
                </tr>
		<tr>
                    <td width="25%" align="right" valign="top"><strong>Merchant: </strong></td>
                    <TD  align="left"> {$deal_info.deal_from_seller_name}</td>
                </tr>
                 <tr>
                    <td width="25%" align="right" valign="top"><strong>Merchant Product Id:</strong> </td>
                    <TD  align="left">{$deal_info.sMerchantProductId}</td>
                </tr>
		<tr>
                    <td width="25%" align="right"><strong>Adult: </strong></td>
                    <TD  align="left"> {$deal_info.iAdult}</td>
                </tr>
		<tr>
                    <td width="25%" align="right" valign="top"><strong>HotPick:</strong> </td>
                    <TD  align="left">{$deal_info.bHotPick}</td>
                </tr>
		<tr>
                    <td width="25%" align="right" valign="top"><strong>Upc: </strong></td>
                    <TD  align="left"> {$deal_info.iUpc}</td>
                </tr>
                <tr>
                    <td width="25%" align="right" valign="top"><strong>iEan:</strong> </td>
                    <TD  align="left">{$deal_info.iEan}</td>
                </tr>
		<tr>
                    <td width="25%" align="right" valign="top"><strong>Mpn: </strong></td>
                    <TD  align="left"> {if $deal_info.sMpn}{$deal_info.sModel}{else}------{/if}</td>
                </tr>
                <tr>
                    <td width="25%" align="right" valign="top"><strong>iIsbn:</strong> </td>
                    <TD  align="left">{$deal_info.iIsbn}</td>
                </tr>
		<tr>
                    <td width="25%" align="right" valign="top"><strong>Name: </strong></td>
                    <TD  align="left"> {$deal_info.sName|html_entity_decode}</td>
                </tr>
                <tr>
                    <td width="25%" align="right" valign="top"><strong>Description:</strong> </td>
                    <TD  align="left">{$deal_info.sDescription|html_entity_decode}</td>
                </tr>
		<tr>
                    <td width="25%" align="right" valign="top"><strong>Specification: </strong></td>
                    <TD  align="left"> {$deal_info.sSpecification|html_entity_decode}</td>
                </tr>
                <tr>
                    <td width="25%" align="right" valign="top"><strong>Promotion :</strong> </td>
                    <TD  align="left"> {$deal_info.sPromotion|html_entity_decode}</td>
                </tr>
		<tr>
                    <td width="25%" align="right" valign="top"><strong>Brand: </strong></td>
                    <TD  align="left"> {if $deal_info.sBrand}{$deal_info.sBrand}{else}------{/if}</td>
                </tr>
                <tr>
                    <td width="25%" align="right" valign="top"><strong>Model:</strong> </td>
                    <TD  align="left"> {if $deal_info.sModel}{$deal_info.sModel}{else}------{/if}</td>
                </tr>
		<tr>
                    <td width="25%" align="right" valign="top"><strong>Aw Deep Link: </strong></td>
                    <TD  align="left"> {if $deal_info.sAwDeepLink}{$deal_info.sAwDeepLink}{else}------{/if}</td>
                </tr>
                 <tr>
                    <td width="25%" align="right" valign="top"><strong>Aw Thumb Url:</strong> </td>
                    <TD  align="left"> {if $deal_info.sAwThumbUrl}<img src="{$deal_info.sAwThumbUrl}" alt="sAwThumbUrl">{else}------{/if}</td>
                </tr>
		<tr>
                    <td width="25%" align="right" valign="top"><strong>Aw Image Url: </strong></td>
                    <TD  align="left"> {if $deal_info.sAwImageUrl}<img src="{$deal_info.sAwImageUrl}" alt="sAwImageUrl">{else}------{/if}</td>
                </tr>
                <tr>
                    <td width="25%" align="right" valign="top"><strong>Merchant Thumb Url:</strong> </td>
                    <TD  align="left"> {if $deal_info.sMerchantThumbUrl}<img src="{$deal_info.sMerchantThumbUrl}" alt="sMerchantThumbUrl">{else}------{/if}</td>
                </tr>
		<tr>
                    <td width="25%" align="right" valign="top"><strong>Merchant Image Url: </strong></td>
                    <TD  align="left"> {if $deal_info.sMerchantImageUrl}<img src="{$deal_info.sMerchantImageUrl}" alt="sMerchantImageUrl">{else}------{/if}</td>
                </tr>
                <tr>
                    <td width="25%" align="right" valign="top"><strong>Delivery Time:</strong> </td>
                    <TD  align="left"> {if $deal_info.sDeliveryTime}{$deal_info.sDeliveryTime}{else}------{/if}</td>
                </tr>
		<tr>
                    <td width="25%" align="right"><strong>Price: </strong></td>
                    <TD  align="left"> {if $deal_info.fPrice}{$deal_info.fPrice}{else}------{/if}</td>
                </tr>
                <tr>
                    <td width="25%" align="right"><strong>Currency:</strong> </td>
                    <TD  align="left"> {if $deal_info.deal_currency_type}{$deal_info.deal_currency_type}{else}------{/if}</td>
                </tr>
		<tr>
                    <td width="25%" align="right"><strong>Store Price: </strong></td>
                    <TD  align="left"> {if $deal_info.fStorePrice}{$deal_info.fStorePrice}{else}------{/if}</td>
                </tr>
                <tr>
                    <td width="25%" align="right"><strong>Rrp Price:</strong> </td>
                    <TD  align="left"> {if $deal_info.fRrpPrice}{$deal_info.fRrpPrice}{else}------{/if}</td>
                </tr>
		<tr>
                    <td width="25%" align="right" valign="top"><strong>Delivery Cost: </strong></td>
                    <TD  align="left"> {if $deal_info.fDeliveryCost}{$deal_info.fDeliveryCost}{else}------{/if}</td>
                </tr>
                <tr>
                    <td width="25%" align="right" valign="top"><strong>bWebOffer:</strong> </td>
                    <TD  align="left"> {if $deal_info.bWebOffer}{$deal_info.bWebOffer}{else}------{/if}</td>
                </tr>
		<tr>
                    <td width="25%" align="right" valign="top"><strong>PreOrder: </strong></td>
                    <TD  align="left"> {if $deal_info.bPreOrder}{$deal_info.bPreOrder}{else}------{/if}</td>
                </tr>
                <tr>
                    <td width="25%" align="right" valign="top"><strong>Warranty:</strong> </td>
                    <TD  align="left"> {if $deal_info.sWarranty}{$deal_info.sWarranty}{else}------{/if}</td>
                </tr>
		<tr>
                    <td width="25%" align="right" valign="top"><strong>Commission Group: </strong></td>
                    <TD  align="left"> {if $deal_info.sCommissionGroup}{$deal_info.sCommissionGroup}{else}------{/if}</td>
                </tr>
                <tr>
                    <td width="25%" align="right" valign="top"><strong>Commission Amount: </strong></td>
                    <TD  align="left"> {if $deal_info.fCommissionAmount}{$deal_info.fCommissionAmount}{else}------{/if}</td>
                </tr>
                <tr>
                    <td width="25%" align="right" valign="top"><strong>ValidFrom:</strong> </td>
                    <TD  align="left"> {$deal_info.dValidFrom}</td>
                </tr>
                 <tr>
                    <td width="25%" align="right" valign="top"><strong>ValidTo: </strong></td>
                    <TD  align="left"> {$deal_info.dValidTo}</td>
                </tr>
                <tr>
                    <td width="25%" align="right" valign="top"><strong>Deal Main Type:</strong> </td>
                    <TD  align="left"> {if $deal_info.deal_main_type}{$deal_info.deal_main_type}{else}------{/if}</td>
                </tr>
                 <tr>
                    <td width="25%" align="right" valign="top"><strong>Status: </strong></td>
                    <TD  align="left"> {if $deal_info.status}{$deal_info.status|ucfirst}{else}------{/if}</td>
                </tr>
                <tr>
                    <td width="25%" align="right" valign="top"><strong>Added Date:</strong> </td>
                    <TD  align="left"> {$deal_info.added_date}</td>
                </tr>
        </table>
      </TD></TR>
      </table> 

</div>
{include file=$footer}
