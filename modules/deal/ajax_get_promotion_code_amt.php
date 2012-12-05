<?php
	//ini_set("session.save_path", "/home/usortd/tmp");
	session_start();
	include_once('../../includes/DBTransact.php');
	$result = '0';

	if(trim($_REQUEST['prmoCode']) != "")
	{
		if($_REQUEST['curType'] == 'pound')
			$sField = "tcm.credit_amount_pound";
		elseif($_REQUEST['curType'] == 'euro')
			$sField = "tcm.credit_amount_euro";
		else
			$sField = "tcm.credit_amount_dollar";

		$rs = $dbObj->customqry("select ".$sField." 'amt' from tbl_coupon_master_uniqueids tcmu, tbl_coupon_master tcm where tcmu.coupon_id = tcm.coupon_id and tcm.expire_date >= now() and coupon_unique_id='".trim($_REQUEST['prmoCode'])."' and used=0", "");
		if($rs != 'n')
			if($row =@mysql_fetch_assoc($rs))
				$result= $row['amt'];
	}

	echo $result;
?>