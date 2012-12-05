<?php
include_once('../../includes/SiteSetting.php');
if(!$_SESSION['csUserId'])
{
	header("Location:".SITEROOT."/login");
}
if($_SESSION['msg'])
{
	   $smarty->assign("msg",$_SESSION['msg']);
	   $_SESSION['msg']=NULL;
	   unset($_SESSION['msg']);
}		
$smarty->display(TEMPLATEDIR.'/modules/photos/classicdemo.tpl');

?>