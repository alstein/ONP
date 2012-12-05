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

if($_POST['submit']=="Update")
{
	extract($_POST);
	$f=array("type","value");
	$v=array($parameter,$desc);
	$id=$dbObj->cupdt("sitesetting",$f,$v,"id",$_POST['id'],"");
	
        $s = $msobj->showmessage(157);
	$_SESSION['msg'] = "<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
	
	?><script type="text/javascript">window.setTimeout('parent.location.reload();', 10);</script><?php 
	exit;
}

$rs=$dbObj->cgs("sitesetting","","id",$_GET['id'],"","","");
$row=@mysql_fetch_assoc($rs);
$smarty->assign("row",$row);

$smarty->display( TEMPLATEDIR.'/admin/globalsettings/Edit_Sitemaster.tpl');

?>