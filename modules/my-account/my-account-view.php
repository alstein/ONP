<?php
include_once('../../include_after_twitterlogin.php');
//include_once('../../include.php');
include_once('../../includes/classes/class.frontregister.php');

//Get meta tags of the page as per id
$call_meta=$dbObj->meta_SEO(17);
$smarty->assign("row_meta",$call_meta);

unset($_SESSION['oauth_request_token']);
unset($_SESSION['oauth_request_token_secret']);
unset($_SESSION['oauth_state']);
unset($_SESSION['oauth_access_token']);
unset($_SESSION['oauth_access_token_secret']);
unset($_SESSION['name']);
unset($_SESSION['screen_name']);
unset($_SESSION['twitter_id']);
unset($_SESSION['location']);
unset($_SESSION['password']);
unset($_SESSION['emailverfiye']);

if(!isset($_SESSION['csUserId']))
{
	header("location:".SITEROOT."/"); exit;
}

///////////////Fetching User Records START/////////////////////

$objregister = new frontregister();
$userData = $objregister->getUserDetails($_SESSION['csUserId']);
$totalStar = ((strlen($userData['p_credit_card_no']) > 0) ? (strlen($userData['p_credit_card_no']) - 4) : 0);
$totalStarDisp = "";
for($s=0; $s < $totalStar; $s++)
{
	$totalStarDisp .= "*";
}
$userData['p_credit_card_no'] = $totalStarDisp.substr($userData['p_credit_card_no'],-4,4);
/*echo "<pre>";
print_r($userData);
exit;*/
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

$smarty->display(TEMPLATEDIR . '/modules/my-account/my-account-view.tpl');
$dbObj->Close();
?>