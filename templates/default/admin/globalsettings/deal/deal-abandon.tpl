{include file=$header1}
{strip}
<script type="text/javascript" src="{$siteroot}/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/add_deal.js"></script>
<script language="javascript" type="text/javascript" src="{$siteroot}/js/calendarDateInput.js"> </script>

{/strip}


{include file=$header2}

<div class="breadcrumb">
	<h3 class="fl width20" style="color:black;">Abandoned Deal Message</h3><br/>
	<span class="fr"><a href="abandoneddeal.php"><strong>Back</strong></a></span>
</div>
<div class="holdthisTop">
{if $msg}<div align="center">{$msg}<br/></div>{/if}
    <form action="" method="post" name='frm' id="frm" enctype="multipart/form-data">
    <input type="hidden" name="sellerid" id="sellerid" value="{$product.seller_id}">
    <input type="hidden" name="option_selected" id="option_selected" value="{$product.option_selected}">
    <input type="hidden" name="payment_type" id="payment_type" value="{$product.payment_method}">
    <table width="70%" align="center" cellpadding="5" cellspacing="5">
        <col width="30%">
        <col width="70%">
       <tr><td align="right" valign="top">Deal Name:</td><td>{$dealname}</td></tr>
         <tr>
            <td align="right" valign="top"> Group Buy IT Comment: </td>
            <td><textarea rows="6"  cols="60" name="gbi_comment" id="gbi_comment">{$gbi_comment|html_entity_decode}</textarea></td>
        </tr>
        
        <tr>
            <td align="right" > <input type="submit" name="submit" id="submit" value="Send"> </td>
            <td></td>
        </tr>
    </table>
    </form>
 

{include file=$footer}
