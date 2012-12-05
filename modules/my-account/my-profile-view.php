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

///////////////Fetching User Records START/////////////////////

$objregister = new frontregister();
$userData = $objregister->getUserDetails($_SESSION['csUserId']);

$smarty->assign("userData", $userData);

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

$smarty->display(TEMPLATEDIR . '/modules/my-account/my-profile-view.tpl');
$dbObj->Close();
?>