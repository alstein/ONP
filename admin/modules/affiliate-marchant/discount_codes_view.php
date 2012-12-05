<?php
include_once('../../../includes/SiteSetting.php');


if(!isset($_SESSION['duAdmId']))
{
   header("location:".SITEROOT . "/admin/login/index.php");
   exit;
}
$mid_id=$_GET['mid'];
$rs_marchant = $dbObj->gj("tbl_affiliate_discount_codes", "*" , "id=".$_GET['mid'], "", "", "", "", "");

if($rs_marchant != 'n')
{	
    $row=@mysql_fetch_assoc($rs_marchant);
    //Get Merchant Name using iMerchantId
    /*$query_MerchDet = "select * from tbl_deal_affiliate_marchant where marchant_id='".$row['iMerchantId']."'";
    $res_MerchDet = @mysql_query($query_MerchDet);
    $row_MerchDet = @mysql_fetch_assoc($res_MerchDet);
    $numRows_MerchDet = @mysql_num_rows($res_MerchDet);
    $smarty->assign("marchantName",$row_MerchDet['marchant_name']);*/
		
}
	$smarty->assign("marchantResult",$row);
	
$smarty->display(TEMPLATEDIR . '/admin/modules/affiliate-marchant/discount_codes_view.tpl');

$dbObj->Close();
?>