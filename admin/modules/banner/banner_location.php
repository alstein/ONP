<?php
	//ini_set("session.save_path", "/home/usortd/tmp");
	session_start();
	include_once("../../../include.php");

	$result = 'true';

	if(trim($_REQUEST['location_name']) != ""){
		$cnd = "location_name='".trim($_REQUEST['location_name'])."' and banner_id=".$_SESSION['current_banner_id'];
		$rs = $dbObj->gj("mast_banners", "location_name", $cnd, "", "", "", "", "");
	if($rs != 'n'){
			if($row =@mysql_fetch_assoc($rs))
			$result='false';
		}

	}

	echo $result;
?>