<?php
include_once('../../includes/SiteSetting.php');
include_once('../../includes/class.message.php');
include_once('../../includes/classes/class.frontregister.php');

$msobj = new message();

if((!$_SESSION['duAdmId']) || $_SESSION['duUserTypeId'] != 3)
{
	$_SESSION['type'] = 'seller';
	header("location:". SITEROOT . "/signin");
}

$objregister = new frontregister();

/////////////////////////////////////////////
//START
//this file is added for checking the subscription is expired or subscribed of seller
include_once(ABSPATH.'/admin/seller/check_seller_subscription.php');
//this file is added for checking the subscription is expired or subscribed of seller
//END
/////////////////////////////////////////////

///////////////Fetching User Records START/////////////////////

$userData = $objregister->getUserDetails($_SESSION['duAdmId']);

$smarty->assign("userData", $userData);

/////////////Fetching User Records END///////////////////////

///////////////Updating records Start///////////////////////////

if(strlen(trim($_POST['first_name'])) > 0)
{
	if($objregister->updateSeller($_POST,$_SESSION['duAdmId']) == "error")
	{
		header("location:".SITEROOT."/admin/seller/my-profile-update.php"); exit;
	}
}

///////////////Updating records End///////////////////////////

/////////////Fetching Country Records START///////////////////////


$rs = $dbObj->gj("mast_country","*", "status='active' and countryid=225", "country", "", "", "", "");
if($rs != 'n')
{
	while($row = @mysql_fetch_assoc($rs))
		$country[]=$row;
}

$rs = $dbObj->gj("mast_country","*", "status='active' and countryid<>225", "country", "", "", "", "");
if($rs != 'n')
{
	while($row = @mysql_fetch_assoc($rs))
		$country[]=$row;
}

$smarty->assign("country", $country);

/////////////Fetching Country Records END///////////////////////

/////////////Fetching State Records START///////////////////////

$rs = $dbObj->customqry("select ms.* from mast_state ms LEFT JOIN mast_country mc ON ms.country_id=mc.countryid where mc.status='Active' AND active='1' order by state_name","");

if($rs != 'n')
{
	$state = array();
	while($row = @mysql_fetch_assoc($rs))
		$state[]=$row;
}

$smarty->assign("state", $state);

/////////////Fetching State Records END///////////////////////

if(isset($_SESSION['msg']))
{
	$smarty->assign("msg", $_SESSION['msg']);
	unset($_SESSION['msg']);
}

if(isset($_SESSION['msg_succ']))
{
	$smarty->assign("msg_succ", $_SESSION['msg_succ']);
	unset($_SESSION['msg_succ']);
}

$smarty->assign("inmenu","user");
$smarty->display(TEMPLATEDIR . '/admin/seller/my-profile-update.tpl');
$dbObj->Close();
?>