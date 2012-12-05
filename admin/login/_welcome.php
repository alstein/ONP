<?php
include_once('../../includes/SiteSetting.php');

if(isset($_SESSION['duAdmId']))
	header("location:". SITEROOT . "/admin/");

#--------Messaging----------------
if(isset($_SESSION['msg'])){
	$smarty->assign("msg", $_SESSION['msg']);
	unset($_SESSION['msg']);
}
#----------END---------------

if(isset($_SERVER['HTTP_REFERER']))
	$smarty->assign("pgbck",$_SERVER['HTTP_REFERER']);

$smarty->display(TEMPLATEDIR . '/admin/login/index.tpl');

$dbObj->Close();
?>