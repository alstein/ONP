<?php
//include_once('../../../includes/SiteSetting.php');
include_once('../../../includes/DBTransact.php');
include_once('../../../includes/common.lib.php');

$result = 'false';
if($_REQUEST['userid'] != '' && $_REQUEST['photo'] != '')
{
	$userid = $_GET['userid'];
	$thumbnail = $_GET['photo'];

	$cpy = copy("../../../uploads/album/photo/thumbnail/".$thumbnail, "../../../uploads/post_accomplish/145X145/".$thumbnail);
	$cpy = copy("../../../uploads/album/photo/90X90/".$thumbnail, "../../../uploads/post_accomplish/90X90/".$thumbnail);

	$dbres = $dbObj->cupdt('tbl_accomplishment', array("thumbnail") , array($thumbnail), 'userid' , $userid, "");
	$result = 'true';
}
$dbObj->Close();
echo $result;
?>