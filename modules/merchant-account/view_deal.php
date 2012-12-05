<?php
include_once('../../include.php');

if(!isset($_SESSION['csUserId']))
{
	header("location:".SITEROOT); exit;
}
if($seoname==""){
		$seoname=$_SESSION['csFullName'];
}

$row_meta=$dbObj->getseodetails(4);
$smarty->assign("row_meta",$row_meta);

//**************Merchant Details************//
$sf="u.fullname,u.business_name,u.address1,u.contact_detail,d.*";
$cnd="d.merchant_id=u.userid and offer_deal_id=".$_GET['id1'];
$tbl="tbl_offer_deal d,tbl_users u";
$select_mechant_det=$dbObj->gj($tbl, $sf, $cnd, "", "", "", "", "");
$res_merchant_det=@mysql_fetch_assoc($select_mechant_det);
$smarty->assign("res_merchant_det",$res_merchant_det);


//**************customer Details************//
$sf1="u.fullname,u.business_name,u.address1,u.contact_detail,d.*";
$cnd1="d.user_id=u.userid and offer_deal_id=".$_GET['id1'];
$tbl1="tbl_offer_deal d,tbl_users u";
$select_cust_det=$dbObj->gj($tbl1, $sf1, $cnd1, "", "", "", "", "");
$res_cust_det=@mysql_fetch_assoc($select_cust_det);
$smarty->assign("res_cust_det",$res_cust_det);


//get th merchant condition

$deal_cond_rs=$dbObj->cgs("tbl_deal_condition", "*", "merchant_id", $res_merchant_det['merchant_id'], $ob, $ot, "");
$deal_cond_row=@mysql_fetch_assoc($deal_cond_rs);
$smarty->assign("deal_cond_row",$deal_cond_row);

//get th merchant condition



$smarty->display( TEMPLATEDIR . '/modules/merchant-account/view_deal.tpl');
//$smarty->display( TEMPLATEDIR . '/modules/merchant-account/offer_deal_to_merchant.tpl');
$dbObj->Close();
?>
