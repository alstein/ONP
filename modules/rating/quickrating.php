<?php
include_once('../../include.php');
		if($_SESSION['csUserId']=="")
			header("location:".SITEROOT."/login/");
		
$fl=array("type","from_id","user_id","quik_rating","rating_date","status");
$vl=array("other",$_SESSION['csUserId'],$_POST['publicuserid'],$_POST['iter'],date("Y-m-d H:i:s"),"1");
$dbObj->cgi("tbl_rating", $fl, $vl, "");
		
?>