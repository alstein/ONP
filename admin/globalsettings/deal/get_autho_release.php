<?php
include_once('../../../includes/SiteSetting.php');
include_once('../../../includes/class.message.php');

if(!$_SESSION['duAdmId'])
{
    header("location:".SITEROOT . "/admin/login/index.php");
    exit;
}

#------------Check For access----------#
if(!(in_array("8", $arr_modules_permit)))
{
      unset($_SESSION['duAdmId']);
      $s=$msobj->showmessage(166);
      $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";

      header("location:".SITEROOT . "/admin/login/index.php");
      exit;
}
#----------End Check For access----------#

$autho_rs = $dbObj->gj("tbl_deal_autho","*","deal_id= '".$_GET['id']."'","","","","","");
$autho = @mysql_fetch_assoc($autho_rs);
$smarty->assign("autho",$autho);
	
    $smarty->display(TEMPLATEDIR . '/admin/globalsettings/deal/get_autho_release.tpl');


$dbObj->Close();
?>
