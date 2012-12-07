<?php
$PATH_PREFIX = "../";
include_once('include.php');
include_once('includes/classes/class.deals.php');
include_once('includes/SiteSetting.php');

if(!empty($_GET['deal_id'])){
	$tbl="tbl_deals d,tbl_users u,mast_deal_category mc";
	$sf="u.email,u.first_name ,u.last_name,u.business_name,u.specility,u.about_us,u.address1,u.business_webURL,u.contact_detail,u.userid,mc.category,u.business_start_date1,u.business_end_date1,u.business_start_date2,u.business_end_date2,d.*";
	$cd="d.deal_unique_id=".$_GET['deal_id']." and d.merchant_id=u.userid and u.deal_cat=mc.id and d.status='active'";	
	$res=$dbObj->gj($tbl, $sf , $cd, $ob, $gb, $ad, $l, "");
	$row=@mysql_fetch_assoc($res);
	
	$smarty->assign("username",$_SESSION['csFullName']);
	$smarty->assign("discount",$row['discount_in_per']);
	$smarty->assign("deal_title",$row['deal_title']);
$smarty->assign("business_name",$row['business_name']);
}
$smarty->display(TEMPLATEDIR.'/success.tpl');

$dbObj->Close();
?>