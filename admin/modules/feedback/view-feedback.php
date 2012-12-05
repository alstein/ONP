<?php
include_once('../../../includes/SiteSetting.php');
include_once('../../../includes/classes/class.feedback.php');

if(!$_SESSION['duAdmId'])
	header("location:".SITEROOT . "/admin/login/index.php");

$fObj= new Feedback();

#----------------Get User Messages----------------#
if($_GET['id'])
{
  $f_info = $fObj->getFeedbackById($_GET['id']);
  $smarty->assign("f_info", $f_info);
}
#---------------End User Messages-------------#

$smarty->assign("inmenu","sitemodules");
$smarty->display(TEMPLATEDIR . '/admin/modules/feedback/view-feedback.tpl');

$dbObj->Close();
?>