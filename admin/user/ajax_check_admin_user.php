<?php
//ini_set("session.save_path", "/home/usortd/tmp");
session_start();
include_once('../../includes/DBTransact.php');
$result = 'true';
if(trim($_REQUEST['username']) != "")
{
	$cnd = "username='".trim($_REQUEST['username'])."' and fb_user_id = 0 and twitter_uid = 0 and usertypeid=1 and isDeleted = 0";
	if(isset($_REQUEST['userid'])){
		$cnd .= "  AND userid !=".$_REQUEST['userid'];
	}
	$rs = $dbObj->gj("tbl_users", "email", $cnd, "", "", "", "", "");
   if($rs != 'n')
		if($row = mysql_fetch_assoc($rs))
			$result='false';
}
if(trim($_REQUEST['email']) != "")
{
	$cnd = "email='".trim($_REQUEST['email'])."' and fb_user_id = 0 and twitter_uid = 0 and usertypeid=1 and isDeleted = 0";
	
		if(isset($_REQUEST['userid']))
		{
			$cnd .= "  AND userid !=".$_REQUEST['userid'];
		}
		$rs = $dbObj->gj("tbl_users", "email", $cnd, "", "", "", "", "");
		if($rs != 'n')
			if($row = mysql_fetch_assoc($rs))
				$result='false';
	}

echo $result;
?>
