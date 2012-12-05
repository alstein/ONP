<?php
include_once('../../../includes/SiteSetting.php');
include_once('../../../includes/classes/class.mymessage.php');

if(!$_SESSION['duAdmId'])
	header("location:".SITEROOT . "/admin/login/index.php");

$umsgObj= new Mymessage();

#----------------Get User Messages----------------#
if($_GET['id'])
{
  $user_msg_info = $umsgObj->getAdminMessageById($_GET['id']);
  $smarty->assign("user_msg_info", $user_msg_info);
}
#---------------End User Messages-------------#

$smarty->assign("inmenu","sitemodules");
$smarty->display(TEMPLATEDIR . '/admin/modules/user-message/view-user-message.tpl');

$dbObj->Close();
?>