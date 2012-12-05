<?php
include_once('../../includes/SiteSetting.php');
include_once('../../includes/ajax_topposters.php');
include_once('../../includes/classes/class.profile.php');

if(!$_SESSION['csUserId'])
{
	header("Location:".SITEROOT."/");
}
//Fetch user Info

$userid=$_GET['userid'];
$userinfo = $profObj->fetchProfile($_SESSION['csUserId']);
$smarty->assign("user",$userinfo);

	$smarty->display(TEMPLATEDIR .'/modules/photos/zoomimage.tpl');	
	$dbObj->Close();
?>
