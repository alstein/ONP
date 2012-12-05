<?php
//ini_set("session.save_path", "/home/usortd/tmp");
session_start();
include_once('../../includes/DBTransact.php');
$result = 'true';

if(trim($_REQUEST['category']) != "")
{
	$cnd = "category='".trim($_REQUEST['category'])."'and parent_id='0'";
	if($_REQUEST['caatid']!=''){
		$cnd .= " AND id !=".$_REQUEST['caatid'];
	}
	$rs = $dbObj->gj("mast_deal_category", "category", $cnd, "", "", "", "", "");
   if($rs != 'n')
		if($row = mysql_fetch_assoc($rs))
			$result='false';
}
echo $result;
?>
