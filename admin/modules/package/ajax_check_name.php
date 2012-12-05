<?php
include_once('../../../includes/SiteSetting.php');

$result = 'true';

	if(trim($_REQUEST['pacname']) != "")
	{
		$cnd = "lower(pack_name)='".strtolower(trim($_REQUEST['pacname']))."' ";
		if(isset($_REQUEST['packid']) && $_REQUEST['packid']!=""){
			$cnd .= "  AND id !=".$_REQUEST['packid'];
		}

		$rs = $dbObj->gj("tbl_subscription_package", "id", $cnd, "", "", "", "", "");
		if($rs != 'n')
		if($row = @mysql_fetch_assoc($rs))
		$result='false';
	}

echo $result;
?>
