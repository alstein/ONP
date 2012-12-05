<?php
include_once('../../includes/SiteSetting.php');
$result = 'true';

	if(trim($_REQUEST['country']) != "")
	{
		$cnd = "lower(country)='".strtolower(trim($_REQUEST['country']))."' ";
		if(isset($_REQUEST['countryid']) && $_REQUEST['countryid']!=""){
			$cnd .= "  AND countryid !=".$_REQUEST['countryid'];
		}
		$rs = $dbObj->gj("mast_country", "country", $cnd, "", "", "", "", "");
	if($rs != 'n')
			if($row =@mysql_fetch_assoc($rs))
				$result='false';
	}

echo $result;
?>
