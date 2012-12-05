<?php
include_once('../../include.php');

if(!isset($_SESSION['csUserId']))
{
	header("location:".SITEROOT); exit;
}
$whose_profile="view_friend";
$smarty->assign("whose_profile",$whose_profile);

$row_meta=$dbObj->getseodetails(11);
$smarty->assign("row_meta",$row_meta);


$smarty->display(TEMPLATEDIR . '/modules/friend/view_all_fav_places.tpl');
$dbObj->Close();
?>