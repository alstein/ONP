<?php
//ini_set("session.save_path", "/home/usortd/tmp");
session_start();
include_once('../../../includes/SiteSetting.php');
include_once('../../../includes/classes/class.suggestdeal.php');
include_once('../../../includes/paging.php');
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


if(isset($_POST['submit']))
{
	if($_POST['action'] == "" || !isset($_POST['action']))
        {
		$s=$msobj->showmessage(4);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
		header("location:".$_SERVER['HTTP_REFERER']);
		exit;
	}
	if(count($_POST['mesgid']) == 0 || (!isset($_POST['mesgid'])))
        {	
		$s=$msobj->showmessage(5);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
		header("location:".$_SERVER['HTTP_REFERER']);
		exit;
	}

	extract($_POST);
	$mesgid = implode(", ", $mesgid);	
	if($action == "delete")
	{
		$id = $dbObj->customqry("delete from tbl_suggest_deal where id in (".$mesgid.")","");
		$s=$msobj->showmessage(164);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
	}
	header("location:".$_SERVER['HTTP_REFERER']);
	exit;
}

#-------------Get Suggest Deal-------------#
$deal_info = $sObj->getAllSuggestDeal();
$smarty->assign("msg_info", $deal_info['records']);
$smarty->assign("showpaging", $deal_info['showpaging']);
$smarty->assign("pagenation", $deal_info['pgnation']);
#-------------End Suggest Deal-------------#


#----------Set messgae into session-----------#
if(isset($_SESSION['msg'])){
	$smarty->assign("msg",$_SESSION['msg']);
	$_SESSION['msg']=NULL;
}
#---------------End Set messgae--------------#

$smarty->assign("inmenu","sitemodules");
$smarty->display(TEMPLATEDIR . '/admin/globalsettings/deal/suggest-deal.tpl');
$dbObj->Close();
?>