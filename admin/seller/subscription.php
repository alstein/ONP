<?php
include_once('../../includes/SiteSetting.php');

if((!$_SESSION['duAdmId']) || $_SESSION['duUserTypeId'] != 3)
{
	$_SESSION['type'] = 'seller';
	header("location:". SITEROOT . "/signin");
}

///////////////Fetching User Records START/////////////////////

include_once('../../includes/classes/class.frontregister.php');
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

//get current subscription package details
$rs_subsUsr = $dbObj->customqry("select * from tbl_user_subscription_details where userid = '".$userData['userid']."' ORDER BY subs_id DESC LIMIT 1", "");
if(mysql_num_rows($rs_subsUsr) > 0)
{
	$row_subsUsrDet = @mysql_fetch_assoc($rs_subsUsr);
	$smarty->assign("userSubsPackage", $row_subsUsrDet['subs_pack_id']);
}

/////////////Fetching User Records END///////////////////////

/////////////
if(isset($_POST['task']) && strlen(trim($_POST['task'])) > 0 && $_POST['task'] == "seller_subsc")
{
	$objregister->updateSelleSubscription($_POST);
}
////////////

/////////////Fetching City Records END///////////////////////

$rs = $dbObj->gj("mast_country","*", "status='active'", "", "", "", "", "");
if($rs != 'n')
{
	while($row = @mysql_fetch_assoc($rs))
		$country[]=$row;
}

$smarty->assign("country", $country);

/////////////Fetching City Records END///////////////////////

#--------------START Get subscription data--------------#
	$rs_subscription = $dbObj->customqry("select * from tbl_subscription_package where status = 1", "");
	while($row_subscription = @mysql_fetch_assoc($rs_subscription))
	{
		$subscriptionData[] = $row_subscription;
	}

	$smarty->assign("subscriptionData", $subscriptionData);
#--------------END Get subscription data--------------#

#-----------------Site Message------------#
if(isset($_SESSION['msg'])){
	$smarty->assign("msg",$_SESSION['msg']);
	unset($_SESSION['msg']);
}
#--------------------End------------------#

$smarty->display(TEMPLATEDIR . '/admin/seller/subscription.tpl');
$dbObj->Close();
?>