<?php
include_once('../../include.php');
include_once("../../includes/paging.php");

if(!isset($_SESSION['csUserId']))
{
	header("location:".SITEROOT); exit;
}
$whose_profile="view_friend";
$smarty->assign("whose_profile",$whose_profile);


$id_delete_friends = $dbObj->customqry("delete from tbl_friends where (userid =".$_GET['delid']." and friendid =".$_GET['ses_id'].") or (userid =".$_GET['ses_id']." and friendid =".$_GET['delid'].")","");

@header("location:".SITEROOT."/friend/view_all_friend");

$dbObj->Close();
?>