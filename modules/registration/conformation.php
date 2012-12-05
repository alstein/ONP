<?php
include_once('../../include.php');

//Get meta tags of the page as per id
$call_meta=$dbObj->meta_SEO(35);
$smarty->assign("row_meta",$call_meta);

/*if(!isset($_GET['id']))
{
	header("location:".SITEROOT);
	exit;
}else
{
	//$rs = $dbObj->customqry("update tbl_users set verification = 1 where userid = ".$_GET['id'], "");
	$rs = $dbObj->customqry("update tbl_users set isverified = 'yes' where userid = ".$_GET['id'], "");
}*/
// print_r($_GET);
if($_GET['code'])
{
	$rs=$dbObj->cgs("tbl_users", "userid,activationcode,isverified", array("activationcode","userid"), array($_GET['code'],$_GET['id']), "", "", "");
	$user=@mysql_fetch_assoc($rs);
	if($user['userid'])
	{
		if($user['isverified'] != "yes")
		{
			$rs=$dbObj->cupdt("tbl_users", array("isverified", "verified_date"), array("yes", date("Y-m-d H:i:s")), "userid", $user['userid'], "");
			$_SESSION['msg_succ'] = "Email verified successfully";
		}else
		{
			$_SESSION['msg']= "Account is already verified";
		}
	}
	else
	{
		$_SESSION['msg']= "Invalid key";
	}
}
else
{
	$_SESSION['msg'] = "Please follow the link in your email to verify your registration.";
}

if(isset($_SESSION['msg']))
{
	$smarty->assign("msg", $_SESSION['msg']);
	unset($_SESSION['msg']);
}

if(isset($_SESSION['msg_succ']))
{
	$smarty->assign("msg_succ", $_SESSION['msg_succ']);
	unset($_SESSION['msg_succ']);
}


$smarty->display(TEMPLATEDIR . '/modules/registration/conformation.tpl');
$dbObj->Close();
?>