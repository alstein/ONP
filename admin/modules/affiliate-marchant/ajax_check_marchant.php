<?php
include_once('../../../includes/SiteSetting.php');
$result = 'true';

	if(trim($_REQUEST['marchant_id']) != "")
	{
		$cnd = "marchant_id='".trim($_REQUEST['marchant_id'])."' ";
		if(isset($_REQUEST['mid']) && $_REQUEST['mid']!=""){
			$cnd .= " AND id !=".$_REQUEST['mid'];
		}

		$rs = $dbObj->gj("tbl_deal_affiliate_marchant", "marchant_id", $cnd, "", "", "", "", "");
		if($rs != 'n')
		if($row = @mysql_fetch_assoc($rs))
		$result='false';
	}

	if(trim($_REQUEST['marchant_name']) != "")
	{
		$cnd = "marchant_name='".trim($_REQUEST['marchant_name'])."' ";
		if(isset($_REQUEST['mid']) && $_REQUEST['mid']!=""){
			$cnd .= " AND id !=".$_REQUEST['mid'];
		}

		$rs = $dbObj->gj("tbl_deal_affiliate_marchant", "marchant_id", $cnd, "", "", "", "", "");
		if($rs != 'n')
		if($row = @mysql_fetch_assoc($rs))
		$result='false';
	}
	if(trim($_REQUEST['discount_code']) != "")
	{
		$cnd = "sCode='".trim($_REQUEST['discount_code'])."' ";
		if(isset($_REQUEST['id']) && $_REQUEST['id']!=""){
			$cnd .= " AND id !=".$_REQUEST['id'];
		}

		$rs = $dbObj->gj("tbl_affiliate_discount_codes", "sCode", $cnd, "", "", "", "", "");
		if($rs != 'n')
		if($row = @mysql_fetch_assoc($rs))
		$result='false';
	}

echo $result;
?>
