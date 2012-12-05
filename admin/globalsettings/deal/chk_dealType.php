<?php
	include_once('../../../includes/SiteSetting.php');
	
	$siteroot = SITEROOT;

	$rs = $dbObj->customqry("select * from tbl_dealtype where typeid = ".$_GET['dealtypeid'],"");
	$data = array();
	if($row = @mysql_fetch_assoc($rs))
	{
		$data = $row;
	}
	if($data['price_option'] == 'groupbuy')
	{
		echo 'groupbuy';
	}else
	{
		echo 'normal';
	}
?>