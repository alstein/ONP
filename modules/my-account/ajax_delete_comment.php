<?php
include_once('../../include.php');

if(!isset($_SESSION['csUserId']))
{
	header("location:".SITEROOT); exit;
}
		

// 		if($_GET['delid']!="")
// 		{

			$delete_comment=$dbObj->customqry("delete  from  tbl_activity where msg_id='".$_GET['delid']."' ","1");
// 		}


// $smarty->display(TEMPLATEDIR . '/modules/my-account/ajax_my_comment.tpl');
 $dbObj->Close();
?>