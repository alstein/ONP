<?php
include_once('../../../includes/SiteSetting.php');
include_once('../../../includes/classes/class.mymessage.php');
include_once('../../../includes/class.message.php');

if(!$_SESSION['duAdmId'])
{
    header("location:".SITEROOT . "/admin/login/index.php");
    exit;
}

#------------Check For access----------#
if(!(in_array("34", $arr_modules_permit)) )
{
      unset($_SESSION['duAdmId']);
      $s=$msobj->showmessage(166);
      $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";

      header("location:".SITEROOT . "/admin/login/index.php");
      exit;
}
#----------End Check For access----------#

$umsgObj= new Mymessage();

#----------------Get User Messages----------------#
if($_GET['id'])
{
  $user_msg_info = $umsgObj->getAdminMessageById($_GET['id']);
  $smarty->assign("user_msg_info", $user_msg_info);
}
#---------------End User Messages-------------#

$smarty->assign("inmenu","sitemodules");
$smarty->display(TEMPLATEDIR . '/admin/modules/member-message/view-member-message.tpl');

$dbObj->Close();
?>