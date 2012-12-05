<?php
	include_once("../../../include.php");

	$dbObj = new DBTransact();
	$dbObj->Connect();

if(!isset($_SESSION['duAdmId']))
	header("location:".SITEROOT . "/admin/login/index.php");

if(isset($_SESSION['msg'])){
	$smarty->assign("msg", $_SESSION['msg']);
	unset($_SESSION['msg']);
}
	
	
	$smarty->display(TEMPLATEDIR.'/admin/mastermanagement/newsletter/nl_success.tpl');


?>