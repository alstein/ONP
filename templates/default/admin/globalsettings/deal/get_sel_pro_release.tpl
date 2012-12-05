{include file=$header1}

{include file=$header2}



<div class="breadcrumb">

<table width="100%">

<tr><Td width="80%">

<td width="5%">

<a href="{$smarty.session.backsession}">Back</a></td>

</tr>

</table></div>



<div id="maincont1">

   <iframe src="{$siteroot}/PHP-Kit/sel_pro_release.php?VendorTxCode={$smarty.get.VendorTxCode}&dealid={$smarty.get.dealid}" height="700" width="900" align="center"  ></iframe>

</div>



{include file=$footer}
