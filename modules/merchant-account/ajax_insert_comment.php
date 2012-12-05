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
$date=date("Y-m-d H:i:s");

		if($_GET['delid']!="")
		{

			$delete_comment=$dbObj->customqry("delete  from  tbl_activity where msg_id='".$_GET['delid']."' ","");
		}
		else
		{

			if($_GET['userid']!="")
			{
				$loc_thinking=trim($_POST['txt_thinking']);
				
			//	$insert_thinking=$dbObj->customqry("insert into tbl_activity(msg,vault_t,vault,timestamp,wall,uid,fid,parent_id,deal_id,review_id)values('".$_GET['thinking']."','status','',Now(),'1','".$_SESSION['csUserId']."','".$_GET['userid']."','".$_GET['parentid']."','".$_GET['dealid']."','".$_GET['review_id']."') ","");

				$insert_thinking=$dbObj->customqry("insert into tbl_activity(msg,vault_t,vault,timestamp,wall,parent_id,deal_id,review_id,uid)values('".$_GET['thinking']."','status','','".$date."','1','".$_GET['parentid']."','".$_GET['dealid']."','".$_GET['review_id']."','".$_SESSION['csUserId']."') ","");
	

			}
			else
			{
				$loc_thinking=trim($_POST['txt_thinking']);
				$timestamp=now();
				$insert_thinking=$dbObj->customqry("insert into tbl_activity(msg,vault_t,vault,timestamp,wall,uid,fid,parent_id,deal_id,review_id)values('".$loc_thinking."','status','','".$date."','1','".$_SESSION['csUserId']."','".$_SESSION['csUserId']."','".$_GET['parentid']."','".$_GET['dealid']."','".$_GET['review_id']."') ","1");
			}
		}	
// 	}

// $smarty->display(TEMPLATEDIR . '/modules/my-account/ajax_my_comment.tpl');
 $dbObj->Close();
?>