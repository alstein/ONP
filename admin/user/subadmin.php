<?php

include_once("../../includes/paging.php");
include_once('../../includes/SiteSetting.php');

if(!$_SESSION['duAdmId'])
	header("location:".SITEROOT . "/admin/login/index.php");

$sf="u.*";
$cnd="u.status = 'Active' AND u.usertypeid = '2' and userid<>'".$_SESSION['duAdmId']."'" ;

$tbl="tbl_users u";

$rs=$dbObj->gj($tbl, $sf, $cnd, $ob, "", "", $l, "");

while($row=@mysql_fetch_assoc($rs))
{
	$users[]=$row;
}
$smarty->assign("users", $users);

if($_POST['action'])
{
	extract($_POST);
	$userid = implode(", ", $userid);
	
	if($action == "banned")
	{
		$id = $dbObj->customqry("update tbl_users set usertypeid = 6 where userid in (".$userid.")","");
		$_SESSION['msg']="<span class='success'>User(s) Banned Successfully</span>";
	}
	elseif($action == "delete")
	{
		$id = $dbObj->customqry("delete from tbl_users where userid in (".$userid.")","");
		$_SESSION['msg']="<span class='success'>User(s) Record Deleted Successfully</span>";
	}
	header("location:".$_SERVER['HTTP_REFERER']);
	exit;
}

#-------------------#
if($_SESSION['msg'])
{
	$smarty->assign("msg",$_SESSION['msg']);
	$_SESSION['msg']=NULL;
}
#------------------#

$smarty->assign("inmenu", "user");
$smarty->display(TEMPLATEDIR . '/admin/user/subadmin.tpl');

$dbObj->Close(); 
?>