{include file=$header1}
{include file=$header2}

<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a>
<a href="{$siteroot}/admin/modules/affiliate-marchant/discount_codes_list.php">&gt; Affiliate Discount Codes List</a>
 &gt;  Affiliate Discount Codes View
</div>
<br/>
<h3>Affiliate Discount Codes Information</h3>
<div class="holdthisTop">
            <span style="float:right;"> <h3><a href="discount_codes_list.php">Back</a></h3></span> 
                    <table width="100%" cellpadding="5" cellspacing="5" class="conttableDkBg conttable">
                        <tr>
                                <td width="25%" align="right" ><strong>Merchant Id: </strong></td>
                                <td  align="left">{$marchantResult.iMerchantId }</td>
                        </tr>
                        <tr>
                                <td width="25%" align="right"><strong>Merchant Name: </strong></td>
                                <td  align="left">{$marchantResult.iMerchantName}</td>
                        </tr>
                        <tr>
                                <td width="25%" align="right" ><strong>Code: </strong></td>
                                <td  align="left">{$marchantResult.sCode } </td>
                        </tr>
                         <tr>
                                <td align="right" valign="top"><strong>Details: </strong></td>
                                <td align="left">{$marchantResult.sDescription|html_entity_decode}</td>
                        </tr>
                        <tr>
                                <td align="right" valign="top"><strong>Details Url: </strong></td>
                                <td align="left">{$marchantResult.sUrl} </td>
                        </tr>
                        <tr>
                            <td align="right"><strong>Start Date:</strong> </td><TD  align="left">{$marchantResult.sStartDate|date_format:$smarty_date_format}</td>
                        </tr>
                        <tr>
                            <td align="right"><strong>End Date:</strong> </td><TD  align="left">{$marchantResult.sEndDate|date_format:$smarty_date_format} {$marchantResult.sEndDate|date_format:"%H:%M:%S"}</td>
                        </tr>
                        <tr>
                            <td align="right"><strong>Added Date:</strong> </td>
                            <TD  align="left">{$marchantResult.added_date|date_format:$smarty_date_format}</td>
                        </tr>
                        <tr>
                            <td align="right"><strong>Image:</strong> </td><TD  align="left">
                            {if $marchantResult.image}
                            <img src="{$siteroot}/uploads/discount_codes_image/{$marchantResult.image}" title="Active" align="middle" style="float:left;" width="50" height="50"  />
                            {else}
                            <img src="{$siteroot}/templates/default/images/no_image.gif" title="Active" align="middle" style="float:left;" width="70" height="70"  />
                            {/if}
                            </td>
                        </tr>
                    
    </table> 
  </div>
{include file=$footer}