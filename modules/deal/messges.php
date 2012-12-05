<?php
//session_start();
include_once('../../include.php');
include_once('../../includes/classes/class.deals.php');

if($_SESSION['csUserId']=="" && $_SESSION['csUserTypeId']==2){
	header("location:".SITEROOT);
}

$smarty->assign("pgName","deals");
$smarty->display(TEMPLATEDIR . '/modules/deal/deal-history-consumer.tpl');
$dbObj->Close();
?>