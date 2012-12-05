<?php
include_once('../../../includes/SiteSetting.php');

if($_GET['userid'] != '' && $_GET['photo'] != '')
{
	$userid = $_GET['userid'];
	$thumbnail = $_GET['photo'];

	@unlink('../../../uploads/post_accomplish/145X145/'.$thumbnail);
	@unlink('../../../uploads/post_accomplish/90X90/'.$thumbnail);

	$dbres = $dbObj->cupdt('tbl_accomplishment', array("thumbnail") , array(""), 'userid' , $userid, "");

}
$dbObj->Close();
?>