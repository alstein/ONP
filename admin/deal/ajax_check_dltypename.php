<?php
include_once('../../includes/SiteSetting.php');
$result = 'true';

	if(trim($_REQUEST['dealtype']) != "")
	{
		$cnd = "lower(dealtype)='".strtolower(trim($_REQUEST['dealtype']))."' ";
		if(isset($_REQUEST['dltype_id']) && $_REQUEST['dltype_id']!=""){
			$cnd .= "  AND typeid !=".$_REQUEST['dltype_id'];
		}

		$rs = $dbObj->gj("tbl_dealtype", "dealtype", $cnd, "", "", "", "", "");
		if($rs != 'n')
		if($row = @mysql_fetch_assoc($rs))
		$result='false';
	}

echo $result;
?>
