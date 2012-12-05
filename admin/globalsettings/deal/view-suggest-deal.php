<?php
//ini_set("session.save_path", "/home/usortd/tmp");
session_start();
include_once('../../../includes/SiteSetting.php');
include_once('../../../includes/classes/class.suggestdeal.php');
include_once('../../../includes/class.message.php');

if(!$_SESSION['duAdmId'])
{
    header("location:".SITEROOT . "/admin/login/index.php");
    exit;
}

#------------Check For access----------#
if(!(in_array("41", $arr_modules_permit)))
{
      unset($_SESSION['duAdmId']);
      $s=$msobj->showmessage(166);
      $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";

      header("location:".SITEROOT . "/admin/login/index.php");
      exit;
}
#----------End Check For access----------#

$sObj = new Suggestdeal();

#----------------Get Suggest Deal Messages----------------#
if($_GET['id'])
{
    #----------------Get Messages----------------#
    $msg_info = $sObj->getSuggestDealById($_GET['id']);
    $smarty->assign("user_msg_info", $msg_info);
    #---------------End Get Messages-------------#
}
#---------------End Suggest Deal Messages-------------#


$smarty->assign("inmenu","sitemodules");
$smarty->display(TEMPLATEDIR . '/admin/globalsettings/deal/view-suggest-deal.tpl');

$dbObj->Close();
?>