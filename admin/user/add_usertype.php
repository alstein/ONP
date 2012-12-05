<?php
include_once('../../includes/SiteSetting.php');
require_once("../../includes/classes/class.myaccount.php");
require_once("../../includes/common.lib.php");

if(!isset($_SESSION['duAdmId']))
	header("location:".SITEROOT . "/admin/login/index.php");

if(isset($_POST['submit']))
{
	if($_GET['typeid'])
	{
		$rs = $dbObj->cupdt('mast_usertype',"usertype",$_POST['usertype'],'typeid',$_POST['typeid'],'');
		$_SESSION['msg']="<span class='success'>User type has been updated successfully.</span>";
	}
	else
	{
		$rs = $dbObj->cgi('mast_usertype','usertype',$_POST['usertype'],'');
		$_SESSION['msg']="<span class='success'>User type has been added Successfully.</span>";
	}
	?><script type="text/javascript">window.setTimeout('parent.location.reload();', 10);</script><?
	exit;
}


#----Getting User Types-------------------------------
$rs=$dbObj->cgs("mast_usertype","","typeid",$_GET['typeid'],"","","");
while($row=@mysql_fetch_array($rs))
	$usertype=$row;
$smarty->assign("usertype",$usertype);
#---------END--------------------------------------

if(isset($_SESSION['msg']))
{
	$smarty->assign("msg",$_SESSION['msg']);
	unset($_SESSION['msg']);
}

$smarty->assign("inmenu", "user");
$smarty->display( TEMPLATEDIR . '/admin/user/add_usertype.tpl');
$dbObj->Close();
?>