<?php
include_once('../../include.php');

if(!isset($_SESSION['csUserId']))
{
	header("location:".SITEROOT); exit;
}

$row_meta=$dbObj->getseodetails(2);
$smarty->assign("row_meta",$row_meta);

if($_SESSION['msg']!=""){
	$msg=$_SESSION['msg'];
	unset($_SESSION['msg']);
	$smarty->assign("msg",$msg);
}

if($_SESSION['view_success_message']!=""){
	$view_success_message=$_SESSION['view_success_message'];
	unset($_SESSION['view_success_message']);
	$smarty->assign("view_success_message",$view_success_message);
}

if($_SESSION['alertpopup']!=""){
    $smarty->assign("alertpopup",$_SESSION['alertpopup']);
    $_SESSION['alertpopup']="no";
}


// if(isset($_POST['share']))
// {
// 
// 	if($_GET['id1']!="")
// 	{
// 		$loc_thinking=trim($_POST['txt_thinking']);
// 		$timestamp=date("Y-m-d H:i:s");
// 		$insert_thinking=$dbObj->customqry("insert into tbl_activity(msg,vault_t,vault,timestamp,wall,uid,fid,parent_id)values('".$loc_thinking."','status','','".$timestamp."','1','".$_SESSION['csUserId']."','".$_GET['id1']."','0') ","");
// 	}
// 	else
// 	{
// 		$loc_thinking=trim($_POST['txt_thinking']);
// 		$timestamp=date("Y-m-d H:i:s");
// 		$insert_thinking=$dbObj->customqry("insert into tbl_activity(msg,vault_t,vault,timestamp,wall,uid,fid,parent_id)values('".$loc_thinking."','status','','".$timestamp."','1','".$_SESSION['csUserId']."','".$_SESSION['csUserId']."','0') ","");
// 	}
// 	@header("location:".SITEROOT."/merchant-account/merchant_profile_home");	
// }



$smarty->display(TEMPLATEDIR . '/modules/merchant-account/merchant_profile_home.tpl');
$dbObj->Close();
?>