<?php
	//ini_set("session.save_path", "/home/usortd/tmp");
	session_start();
	include_once('../../includes/DBTransact.php');
	$result = 'true';

// if(trim($_REQUEST['fname']) != "")
// {
// 	$cnd = "username='".trim($_REQUEST['fname'])."'";
// 	if(isset($_REQUEST['userid']) && $_REQUEST['userid']!= null){
// 		$cnd .= "  AND userid !=".$_REQUEST['userid'];
// 	}
// 	$rs = $dbObj->gj("tbl_users", "email", $cnd, "", "", "", "", "");
//    if($rs != 'n')
// 		if($row =@mysql_fetch_assoc($rs))
// 			$result='false';
// }
if(trim($_REQUEST['email']) != "")
{
	//$cnd = "email='".trim($_REQUEST['email'])."' and isDeleted=0 and (usertypeid = 2 or usertypeid = 3) and fb_user_id = 0 and twitter_uid = 0";
	$cnd = "email='".trim($_REQUEST['email'])."' and isDeleted=0 and usertypeid = 2 and fb_user_id = 0 and twitter_uid = 0";
	if(isset($_REQUEST['userid']) && $_REQUEST['userid']!= null ){
		$cnd .= "  AND userid !=".$_REQUEST['userid'];
	}
	$rs = $dbObj->gj("tbl_users", "email", $cnd, "", "", "", "", "");
	if($rs != 'n')
		if($row =@mysql_fetch_assoc($rs))
			$result='false';
}
echo $result;

?>
