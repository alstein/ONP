<?php
include_once('../../include.php');
include_once('../../includes/SiteSetting.php');
if(!isset($_SESSION['csUserId']))
{
	header("location:".SITEROOT); exit;
}
$_GET['status'];
$_GET['msg_id'];
if($_GET['status']=='inbox')
{
	$select_message=$dbObj->cgs(" inbox i left join messages m on m.MID=i.MID left join tbl_users u on i.FROM_ID=u.userid", "u.first_name,u.last_name,i.*,m.*","m.MID" , $_GET['msg_id'], "", "", "");
	$res_messages=mysql_fetch_assoc($select_message);
	
}
if($_GET['status']=='outbox')
{
	$select_message=$dbObj->cgs(" inbox i left join messages m on m.MID=i.MID left join tbl_users u on i.TO_ID=u.userid", "u.first_name,u.last_name,i.*,m.*","m.MID" , $_GET['msg_id'], "", "", "");
	$res_messages=mysql_fetch_assoc($select_message);
	
}
$smarty->assign("messages",$res_messages);
$smarty->display( TEMPLATEDIR . '/modules/messages/view_message.tpl');
$dbObj->Close();
?>
