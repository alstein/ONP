<?php

$PATH_PREFIX = "../";
include_once('../../include.php');
if($_SESSION['profilename']=="")
{
@header("Location:".SITEROOT);
}

// if($_POST['city']!="" && $_POST['rel_status']!="" && $_POST['grad_collage']!="" && $_POST['under_grad_collage']!="" && $_POST['music']!="" && $_POST['activity']!="")

if($_POST['city']!="" && $_POST['rel_status']!="")
{
	$_SESSION['profilecity']=$_POST['city123'];
	$_SESSION['profilel_relstatus']=$_POST['rel_status'];
	$_SESSION['profile_grad_collage']=$_POST['grad_collage'];
	$_SESSION['profile_under_grad_collage']=$_POST['under_grad_collage'];
	$_SESSION['profile_music']=$_POST['music'];
	$_SESSION['profile_activity']=$_POST['activity'];
	@header("Location:".SITEROOT."/profilestep");
	exit;
}

$smarty->display(TEMPLATEDIR.'/modules/registration/profile_info.tpl');

$dbObj->Close();
?>