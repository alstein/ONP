<?php
//ini_set("session.save_path", "/home/usortd/tmp");
session_start();
include_once('../../includes/DBTransact.php');
$result = 'true';
if(trim($_REQUEST['username']) != "")
{
	$cnd = "username='".trim($_REQUEST['username'])."'";
	if(isset($_REQUEST['userid'])){
		$cnd .= "  AND userid !=".$_REQUEST['userid'];
	}
	$rs = $dbObj->gj("tbl_users", "username", $cnd, "", "", "", "", "");
   if($rs != 'n')
		if($row = mysql_fetch_assoc($rs))
			$result='false';
}
if(trim($_REQUEST['email']) != "")
{
	$cnd = "email='".trim($_REQUEST['email'])."'";
	
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
