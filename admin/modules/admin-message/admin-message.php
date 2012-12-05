<?php
//ini_set("session.save_path", "/home/usortd/tmp");
session_start();
include_once('../../../includes/SiteSetting.php');
include_once('../../../includes/classes/class.mymessage.php');
include_once('../../../includes/paging.php');
include_once('../../../includes/class.message.php');

if(!$_SESSION['duAdmId'])
{
    header("location:".SITEROOT . "/admin/login/index.php");
    exit;
}

#------------Check For access----------#
if(!(in_array("35", $arr_modules_permit)) )
{
      unset($_SESSION['duAdmId']);
      $s=$msobj->showmessage(166);
      $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";

      header("location:".SITEROOT . "/admin/login/index.php");
      exit;
}
#----------End Check For access----------#

$umsgObj= new Mymessage();

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
		$id = $dbObj->customqry("delete from tbl_message where id in (".$mesgid.")","");
		$s=$msobj->showmessage(123);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
	}
	header("location:".$_SERVER['HTTP_REFERER']);
	exit;
}

#----------------Get Admin Messages----------------#
if($_GET['mtype'] == 'Sent')
    $msg_info = $umsgObj->getAdminMessages($_SESSION['duAdmId'],'Sent');
else
    $msg_info = $umsgObj->getAdminMessages($_SESSION['duAdmId'],'Inbox');

$smarty->assign("msg_info", $msg_info['records']);
$smarty->assign("showpaging", $msg_info['showpaging']);
$smarty->assign("pagenation", $msg_info['paging']);
#---------------End Get AdminMessages-------------#

#---------------Get all username-------------#
$user_list = $umsgObj->getAllUserName();
$smarty->assign("user_list", $user_list);
#---------------Get all username-------------#

#----------Set messgae into session-----------#
if(isset($_SESSION['msg'])){
	$smarty->assign("msg",$_SESSION['msg']);
	$_SESSION['msg']=NULL;
}
#---------------End Set messgae--------------#

$smarty->assign("inmenu","sitemodules");
$smarty->display(TEMPLATEDIR . '/admin/modules/admin-message/user-message.tpl');
$dbObj->Close();
?>