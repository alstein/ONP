<?php
include_once('../../include.php');

if(isset($_SESSION['login_log_id']))
{
////////Update tbl_login_log table details Start////////////

	$InsertedIdLog = $dbObj->customqry("update tbl_login_log set logout_date = '".date("Y-m-d H:i:s")."' where id = ".$_SESSION['login_log_id'],"");

//////////Update tbl_login_log table details End/////////////
}

session_destroy();

header("location:".SITEROOT);
exit;

?>