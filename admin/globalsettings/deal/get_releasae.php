<?php
include_once('../../../includes/SiteSetting.php');

if(!$_SESSION['duAdmId'])
	header("location:".SITEROOT . "/admin/login/index.php");
	
	$smarty->display(TEMPLATEDIR . '/admin/globalsettings/deal/get_release.tpl');


$dbObj->Close();
?>
