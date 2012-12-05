<?php
	include_once("../../include.php");
	$date=date("Y-m-d H:i:s");
	$ip_address=$_SERVER['REMOTE_ADDR'];
	$sel=$dbObj->customqry("select * from tbl_login_log where ipaddress='".$ip_address."' and userid ='".$_SESSION['csUserId']."' order by id DESC","");
	$res=@mysql_fetch_assoc($sel);
	$id=$res['id'];
	
	
	$update=$dbObj->customqry("update tbl_login_log set logout_date='".$date."' where  id='".$id."' ","");
	session_destroy();
	//echo $_SESSION['city_name'];exit;
	header("location:".SITEROOT);
?>