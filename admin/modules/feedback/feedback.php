<?php
//ini_set("session.save_path", "/home/usortd/tmp");
session_start();
include_once('../../../includes/SiteSetting.php');
include_once('../../../includes/paging.php');
include_once('../../../includes/class.message.php');
include_once('../../../includes/classes/class.feedback.php');

if(!$_SESSION['duAdmId'])
	header("location:".SITEROOT . "/admin/login/index.php");

$fObj= new Feedback();
$msobj= new message();

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
		exit;file:///root/.gvfs/htdocs%20on%20192.168.0.59/alpha/admin/globalsettings/message-center/checkemail.php
	}

	extract($_POST);
	 $mesgid = implode(", ", $mesgid);	

	if($action == "delete")
	{
		$id = $dbObj->customqry("delete from tbl_feedback_review where id in (".$mesgid.")","");
		$s=$msobj->showmessage(161);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
	}
	header("location:".$_SERVER['HTTP_REFERER']);
	exit;
}


#----------------Get Feedback----------------#
$feed_info="";
if(isset($_GET['uname']))
    $feed_info = $fObj->getAdminSideFeedback($_GET['uname']);
else
    $feed_info = $fObj->getAdminSideFeedback('');
//echo "<pre>";print_r($feed_info);exit;
$smarty->assign("feed_info", $feed_info['records']);
$smarty->assign("showpaging", $feed_info['showpaging']);
$smarty->assign("pagenation", $feed_info['pgnation']);
#---------------End Get Feedback-------------#

#---------------Get all username-------------#
$user_list = $fObj->getAllUserName();
$smarty->assign("user_list", $user_list);
#---------------Get all username-------------#

#----------et messgae into session-----------#
if(isset($_SESSION['msg'])){
	$smarty->assign("msg",$_SESSION['msg']);
	$_SESSION['msg']=NULL;
}
#---------------End Set messgae--------------#

$smarty->assign("inmenu","sitemodules");

$smarty->display(TEMPLATEDIR . '/admin/modules/feedback/feedback.tpl');

$dbObj->Close();
?>