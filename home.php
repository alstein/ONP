<?php
include_once('include.php');


if($_SESSION['msg'])
{
	$smarty->assign("msg", $_SESSION['msg']);
	$_SESSION['msg'] = NULL;
	unset($_SESSION['msg']);
}

if($_SESSION['csUserId']!=""){
	if($_SESSION['csUserTypeId']=="2")
		header("location:".SITEROOT."/my-account/my_profile_home");
	elseif($_SESSION['csUserTypeId']=="3")
		header("location:".SITEROOT."/merchant-account/merchant_profile_home");
}


if($_POST['pass']!=""){
	$rs=$dbObj->customqry("select * from `beta_password` where password='".$_POST['pass']."'","");
	$num=mysql_num_rows($rs);
	if($num!=0){
		header("location:".SITEROOT."/welcome/1");
	}else{ 
		$_SESSION['msg']="Please enter correct password.";	
		header("location:".SITEROOT);
	}
}

$smarty->display(TEMPLATEDIR . '/home.tpl');
$dbObj->Close();
?>