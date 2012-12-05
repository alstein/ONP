<?php
include_once('../../include.php');
include_once('../../includes/classes/class.frontregister.php');

//Get meta tags of the page as per id
$call_meta=$dbObj->meta_SEO(17);
$smarty->assign("row_meta",$call_meta);

if(!isset($_SESSION['csUserId']))
{
	header("location:".SITEROOT."/"); exit;
}

///////////////Updating records Start///////////////////////////

if(strlen(trim($_POST['submit'])) > 0)
{
	$objregister = new frontregister();

	if($objregister->updateUsersMyProfile($_POST,$_SESSION['csUserId']) == "error")
	{
		header("location:".SITEROOT."/my-profile-update"); exit;
	}
}

///////////////Updating records End///////////////////////////

///////////////Fetching User Records START/////////////////////

$objregister = new frontregister();
$userData = $objregister->getUserDetails($_SESSION['csUserId']);

$smarty->assign("pref_cities_arr",explode(",",$userData['preferences_city']));

$smarty->assign("userData", $userData);

/////////////Fetching User Records END///////////////////////


/////////////Fetching City Records START///////////////////////

$rs = $dbObj->gj("mast_city","*", "status='Active'", "city_name", "", "", "", "");
if($rs != 'n')
{
	while($row = @mysql_fetch_assoc($rs))
		$city[]=$row;
}
$smarty->assign("city", $city);

/////////////Fetching City Records END///////////////////////



/////////////Fetching DealType Records START///////////////////////

$rs = $dbObj->gj("tbl_dealtype","*", "1", "dealtype", "", "", "", "");
if($rs != 'n')
{
	while($row = @mysql_fetch_assoc($rs))
		$dealTypes[]=$row;
}
$smarty->assign("dealTypes", $dealTypes);

/////////////Fetching DealType Records END///////////////////////



/////////////Fetching Deal Category Records START///////////////////////

$rs = $dbObj->gj("mast_deal_category","*", "active=1 and parent_id = 0", "category", "", "", "", "");
if($rs != 'n')
{
	while($row = @mysql_fetch_assoc($rs))
		$categories[]=$row;
}
$smarty->assign("categories", $categories);

/////////////Fetching Deal Category Records END///////////////////////




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

$smarty->display(TEMPLATEDIR . '/modules/my-account/my-profile-update.tpl');
$dbObj->Close();
?>