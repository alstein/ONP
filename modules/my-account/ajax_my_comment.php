<?php
include_once('../../include.php');



if(!isset($_SESSION['csUserId']))
{
	header("location:".SITEROOT); exit;
}

if($_GET['userid']!="" )
{
$user=$_GET['userid'];
}
else
{
$user=$_SESSION['csUserId'];
}


	if(isset($_POST['submit_share']))
	{
		
		if($_GET['userid']!="")
		{
			$loc_thinking=trim($_POST['txt_thinking']);
			$timestamp=date("Y-m-d H:i:s");
			$insert_thinking=$dbObj->customqry("insert into tbl_activity(msg,vault_t,vault,timestamp,wall,uid,fid,parent_id,deal_id)values('".$loc_thinking."','status','',Now(),'1','".$_SESSION['csUserId']."','".$_GET['userid']."','".$_GET['parentid']."','".$_GET['dealid']."') ","");
		}
		else
		{
			$loc_thinking=trim($_POST['txt_thinking']);
			$timestamp=date("Y-m-d H:i:s");
			$insert_thinking=$dbObj->customqry("insert into tbl_activity(msg,vault_t,vault,timestamp,wall,uid,fid,parent_id,deal_id)values('".$loc_thinking."','status','',Now(),'1','".$_SESSION['csUserId']."','".$_SESSION['csUserId']."','".$_GET['parentid']."','".$_GET['dealid']."') ","");
		}	
	}

$currentpage=$_SERVER["HTTP_REFERER"];
if(strpos($currentpage,"my_profile") && !strpos($currentpage,"my_profile_home")){
		$smarty->assign("currentpage","no");	
}else{
		$smarty->assign("currentpage","yes");	
}


$smarty->display(TEMPLATEDIR . '/modules/my-account/ajax_my_comment.tpl');
$dbObj->Close();
?>