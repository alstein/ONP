<?php
include_once('../../includes/SiteSetting.php');
$result = 'true';

	if(trim($_REQUEST['cname']) != "")
	{
		$cnd = "city_name='".trim($_REQUEST['cname'])."'";
		if(isset($_REQUEST['cityid']) && $_REQUEST['cityid']!=""){
			$cnd .= "  AND city_id !=".$_REQUEST['cityid'];
		}
		if(isset($_REQUEST['stateid']) && $_REQUEST['stateid']!=""){
			$cnd .= "  AND state_id =".$_REQUEST['stateid'];
		}
			$rs = $dbObj->gj("mast_city", "city_name", $cnd, "", "", "", "", "");
			if($rs != 'n')
			if($row =@mysql_fetch_assoc($rs))
			$result='false';
	}

echo $result;
?>
