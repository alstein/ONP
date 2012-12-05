<?php
include_once('../../include.php');


if($_POST['act']=="act"){
	$rs=$dbObj->customqry("select menu_price_file from tbl_users where userid=".$_SESSION['csUserId'],"");
	$row=@mysql_fetch_assoc($rs);
	if($row['menu_price_file']!=""){
		unlink("../../uploads/menu_price_list/".$row['menu_price_file']);
		$rs1=$dbObj->customqry("update tbl_users set menu_price_file='' where userid=".$_SESSION['csUserId'],"");
	}
}
$smarty->display( TEMPLATEDIR . '/modules/merchant-account/account_setting.tpl');
$dbObj->Close();
?>
