<?php
include_once('../../include.php');

if($_GET['ID']==1){
	$smarty->assign("message","You can't offer a deal to this merchant as the merchant hasnt yet activated the facility");
}elseif($_GET['ID']==2){
		$smarty->assign("message","Deal created successfully");
}elseif($_GET['ID']==3){
		$smarty->assign("message","Please Add conditions in Incoming Deal Condtions. Without that customers would not be able to send you deals");
}

$smarty->display( TEMPLATEDIR . '/modules/merchant-account/show_message.tpl');
$dbObj->Close();
?>
