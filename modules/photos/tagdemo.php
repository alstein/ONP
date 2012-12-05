<?php 
include_once('../../include.php');

$userid=$_SESSION['csUserId'];



if($_SESSION['msg'])
{
	$smarty->assign("msg",$_SESSION['msg']);
	unset($_SESSION['msg']);
}

$smarty->display(TEMPLATEDIR .'/modules/photos/tagdemo.tpl');

?>