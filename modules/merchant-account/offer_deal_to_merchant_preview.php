<?php
include_once('../../include.php');

if(!isset($_SESSION['csUserId']))
{
	header("location:".SITEROOT); exit;
}

$deal_cond_rs=$dbObj->cgs("tbl_deal_condition", "*", "merchant_id", $_SESSION['temp_mer_id'], $ob, $ot, "");
$deal_cond_row=@mysql_fetch_assoc($deal_cond_rs);
$smarty->assign("deal_cond_row",$deal_cond_row);

//**************Merchant Details************//
$sf="*";
$cnd="userid=".$_SESSION['temp_mer_id'];
$tbl="tbl_users ";
$select_mechant_det=$dbObj->gj($tbl, $sf, $cnd, "", "", "", "", "");
$res_merchant_det=@mysql_fetch_assoc($select_mechant_det);
$bussines_name=$res_merchant_det['business_name'];
$address=$res_merchant_det['address1'];
$phone_no=$res_merchant_det['contact_detail'];
$smarty->assign("bussines_name",$bussines_name);
$smarty->assign("address",$address);
$smarty->assign("phone_no",$phone_no);
//**************End Of Merchant Details************//


//add to live wire
if($_POST['addto_live_wire']!=""){
	$addlivewire="yes";
}else{
	$addlivewire="no";
}
$smarty->assign("addlivewire",$addlivewire);

//Authorization
$authorisation="Authorization";
$smarty->assign("authorisation",$authorisation);
//Authorization


$smarty->display( TEMPLATEDIR . '/modules/merchant-account/offer_deal_mer_preview.tpl');
//$smarty->display( TEMPLATEDIR . '/modules/merchant-account/offer_deal_to_merchant.tpl');
$dbObj->Close();
?>
