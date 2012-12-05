<?php
include_once('../../includes/SiteSetting.php');
$result = 'true';

	if(trim($_REQUEST['states']) != "")
	{
		//$cnd = "lower(state_name)='".strtolower(trim($_REQUEST['states']))."' and country_id='".trim($_REQUEST['countryid'])."'";
		$cnd = "lower(state_name)='".strtolower(trim($_REQUEST['states']))."' ";
		if(isset($_REQUEST['countryid']) && $_REQUEST['countryid']!=""){
			$cnd .= "  AND 	country_id =".$_REQUEST['countryid'];
		}
                if(isset($_REQUEST['stateid']) && $_REQUEST['stateid']!=""){
			$cnd .= "  AND 	id !=".$_REQUEST['stateid'];
		}

		$rs = $dbObj->gj("mast_state", "state_name", $cnd, "", "", "", "", "");
		if($rs != 'n')
		if($row = @mysql_fetch_assoc($rs))
		$result='false';
	}

echo $result;
?>
