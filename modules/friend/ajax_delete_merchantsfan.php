<?php
include_once('../../include.php');
include_once("../../includes/paging.php");

if(!isset($_SESSION['csUserId']))
{
	header("location:".SITEROOT); exit;
}
$whose_profile="view_friend";
$smarty->assign("whose_profile",$whose_profile);


$id_delete_fan = $dbObj->customqry("delete from tbl_fan where (fan_id =".$_GET['delid']." and userid =".$_GET['ses_id'].") ","");

@header("location:".SITEROOT."/friend/view_all_merchants_fan");

$dbObj->Close();
?>