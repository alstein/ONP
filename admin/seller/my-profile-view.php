<?php
include_once('../../includes/SiteSetting.php');
include_once('../../includes/classes/class.frontregister.php');

if((!$_SESSION['duAdmId']) || $_SESSION['duUserTypeId'] != 3)
{
	$_SESSION['type'] = 'seller';
	header("location:". SITEROOT . "/signin");
}

/////////////////////////////////////////////
//START
//this file is added for checking the subscription is expired or subscribed of seller
include_once(ABSPATH.'/admin/seller/check_seller_subscription.php');
//this file is added for checking the subscription is expired or subscribed of seller
//END
/////////////////////////////////////////////

///////////////Fetching User Records START/////////////////////

$objregister = new frontregister();
$userData = $objregister->getUserDetails($_SESSION['duAdmId']);
$totalStar = ((strlen($userData['p_credit_card_no']) > 0) ? (strlen($userData['p_credit_card_no']) - 4) : 0);
$totalStarDisp = "";
for($s=0; $s < $totalStar; $s++)
{
	$totalStarDisp .= "*";
}
$userData['p_credit_card_no'] = $totalStarDisp.substr($userData['p_credit_card_no'],-4,4);
$smarty->assign("userData", $userData);

$res_delivery_chr = $dbObj->customqry("SELECT * FROM sitesetting WHERE id IN(52,53,54,55,56)","");
while($row_delivery_chr = @mysql_fetch_assoc($res_delivery_chr))
	$data_delivery_chr[] = $row_delivery_chr;

$smarty->assign("data_delivery_chr", $data_delivery_chr);

$res_delivery_service_chr = $dbObj->customqry("SELECT * FROM tbl_delivery_service_charges WHERE set_for = 'user' AND user_id = ".$_SESSION['duAdmId'],"");
while($row_delivery_service_chr = @mysql_fetch_assoc($res_delivery_service_chr))
	$data_delivery_service_chr[] = $row_delivery_service_chr;

$smarty->assign("data_delivery_service_chr", $data_delivery_service_chr);
/////////////Fetching User Records END///////////////////////

/////////////Fetching City Records END///////////////////////

$rs = $dbObj->gj("mast_country","*", "status='active'", "", "", "", "", "");
if($rs != 'n')
{
	while($row = @mysql_fetch_assoc($rs))
		$country[]=$row;
}

$smarty->assign("country", $country);

/////////////Fetching City Records END///////////////////////


$smarty->assign("inmenu","myaccount");
$smarty->display(TEMPLATEDIR . '/admin/seller/my-profile-view.tpl');

$dbObj->Close();
?>