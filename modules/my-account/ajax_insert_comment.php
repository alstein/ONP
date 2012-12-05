<?php
include_once('../../include.php');
include_once('../../includes/SiteSetting.php');
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

		if($_GET['delid']!="")
		{

			$delete_comment=$dbObj->customqry("delete  from  tbl_activity where msg_id='".$_GET['delid']."' ","");
		}
		else
		{
			if($_GET['userid']!="")
			{
				$loc_thinking=trim($_POST['txt_thinking']);
				$timestamp=date("Y-m-d H:i:s");
				$insert_thinking=$dbObj->customqry("insert into tbl_activity(msg,vault_t,vault,timestamp,wall,uid,fid,parent_id,deal_id)values('".$_GET['thinking']."','status','','".$timestamp."','1','".$_SESSION['csUserId']."','".$_GET['userid']."','".$_GET['parentid']."','".$_GET['dealid']."') ","1");
			}
			else
			{
				$loc_thinking=trim($_POST['txt_thinking']);
				$timestamp=date("Y-m-d H:i:s");
				$insert_thinking=$dbObj->customqry("insert into tbl_activity(msg,vault_t,vault,timestamp,wall,uid,fid,parent_id,deal_id)values('".$loc_thinking."','status','','".$timestamp."','1','".$_SESSION['csUserId']."','".$_SESSION['csUserId']."','".$_GET['parentid']."','".$_GET['dealid']."') ","1");
			}
		}	

 $dbObj->Close();
?>