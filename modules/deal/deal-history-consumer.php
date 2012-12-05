<?php
//session_start();
include_once('../../include.php');
include_once('../../includes/classes/class.deals.php');

if($_SESSION['csUserId']=="" || $_SESSION['csUserTypeId']!=2){
	header("location:".SITEROOT);
}

$row_meta=$dbObj->getseodetails(3);
$smarty->assign("row_meta",$row_meta);


$smarty->assign("pgName","deals");
$smarty->display(TEMPLATEDIR . '/modules/deal/deal-history-consumer.tpl');
$dbObj->Close();
?>