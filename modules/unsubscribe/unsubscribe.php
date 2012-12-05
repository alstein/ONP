<?php
	include_once("../../include.php");

	$emailid = ($_GET['emailid']?$_GET['emailid']:'');
	$cityid = ($_GET['cityid']?$_GET['cityid']:'');

	if($emailid){
		$query = "select * from tbl_newsletter where nemail ='".base64_decode(base64_decode($emailid))."' and city='".$cityid."'";
		
		$res = @mysql_query($query);
		$num = @mysql_num_rows($res);
		if($num>0){
			$query = "delete from tbl_newsletter where nemail='".base64_decode(base64_decode($emailid))."' and city='".$cityid."'";
			$res = mysql_query($query);
		}
	}

	$smarty->display(TEMPLATEDIR . '/modules/unsubscribe/unsubscribe.tpl');
	$dbObj->Close();
?>