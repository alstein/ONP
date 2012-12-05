<?php
include_once('../../includes/SiteSetting.php');
include_once("../../includes/paging.php");
include_once('../../includes/class.message.php');
$msobj= new message();
if(!isset($_SESSION['duAdmId']))
exit;

if(isset($_POST['question']))
{

	if($_POST['id']){

		$rs=$dbObj->cupdt("security_question",array("question", "active"),array($_POST['question'], $_POST['status']), "id",$_POST['id'],"");
		$s=$msobj->showmessage(25);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
	}
	else
	{
		$rs=$dbObj->cgi("security_question",array("question", "active"),array($_POST['question'], $_POST['status']),"");
		$s=$msobj->showmessage(24);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
	}
	header("location:".SITEROOT."/admin/mastermanagement/security_question_list.php");
	exit;
}


$rs=$dbObj->cgs("security_question","*","id",$_GET['id'],"","","");
$question = @mysql_fetch_assoc($rs);
$smarty->assign("question",$question);


$smarty->display(TEMPLATEDIR.'/admin/mastermanagement/edit_security_question.tpl');

$dbObj->Close();
?>