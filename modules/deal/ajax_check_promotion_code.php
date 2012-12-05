<?php
	//ini_set("session.save_path", "/home/usortd/tmp");
	session_start();
	include_once('../../includes/DBTransact.php');
	$result = 'false';

	if(trim($_REQUEST['prmoCode']) != "")
	{
		$rs = $dbObj->customqry("select tcmu.coupon_unique_id from tbl_coupon_master_uniqueids tcmu, tbl_coupon_master tcm where tcmu.coupon_id = tcm.coupon_id and tcm.expire_date >= now() and coupon_unique_id='".trim($_REQUEST['prmoCode'])."' and used=0", "");
		if($rs != 'n')
			if($row =@mysql_fetch_assoc($rs))
				$result='true';
	}

	echo $result;
?>