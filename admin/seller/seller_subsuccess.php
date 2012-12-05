<?php
include_once('../../includes/SiteSetting.php');

if((!$_SESSION['duAdmId']) || $_SESSION['duUserTypeId'] != 3)
{
	$_SESSION['type'] = 'seller';
	header("location:". SITEROOT . "/signin");
}

#-----------------Site Message------------#
if(isset($_SESSION['msg'])){
	$smarty->assign("msg",$_SESSION['msg']);
	unset($_SESSION['msg']);
}
#--------------------End------------------#

$smarty->display(TEMPLATEDIR . '/admin/seller/seller_subsuccess.tpl');
$dbObj->Close();
?>