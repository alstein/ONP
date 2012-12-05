<?
include_once('../../includes/SiteSetting.php');

if(!isset($_SESSION['duAdmId']))
	header("location:".SITEROOT . "/admin/login/index.php");

$smarty->assign("inmenu", "user");
$smarty->display(TEMPLATEDIR . '/admin/user/charts.tpl');

$dbObj->Close();
?>