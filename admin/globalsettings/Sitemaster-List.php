<?php
include_once("../../includes/common.lib.php");
include_once('../../includes/SiteSetting.php');
include_once('../../includes/class.message.php');

if(!$_SESSION['duAdmId'])
{
    header("location:".SITEROOT . "/admin/login/index.php");
    exit;
}

#------------Check For access----------#
if(!(in_array("19", $arr_modules_permit)))
{
      unset($_SESSION['duAdmId']);
      $s=$msobj->showmessage(166);
      $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";

      header("location:".SITEROOT . "/admin/login/index.php");
      exit;
}
#----------End Check For access----------#

#-------------Get sietsettings values--------------#	
$res = $dbObj->customqry("select * from sitesetting where id  in(3,5,6,7,19,21,26,27,36)", "");
while($row = @mysql_fetch_assoc($res))
{
 	$sitemaster[] = $row;
}

$smarty->assign("site",$sitemaster);

#-------------Get sietsettings values--------------#	
// $smarty->assign("inmenu","sitemgmt");

if(isset($_SESSION['msg']))
{
	$smarty->assign("msg", $_SESSION['msg']);
	unset($_SESSION['msg']);
}

$smarty->display(TEMPLATEDIR . '/admin/globalsettings/Sitemaster_List.tpl');

$dbObj->Close();
?>