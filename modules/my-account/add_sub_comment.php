<?php
include_once('../../include.php');

if(!isset($_SESSION['csUserId']))
{
	header("location:".SITEROOT); exit;
}

if($_POST['rating_id']!="" && $_POST['user_id']!=""){

$insert_thinking=$dbObj->customqry("insert into tbl_activity(msg,vault_t,timestamp,wall,uid,review_id)values('".$_POST['comment']."','status',Now(),'1','".$_SESSION['csUserId']."','".$_POST['rating_id']."')","");
	
	echo "1";
}


$smarty->display(TEMPLATEDIR . '/modules/my-account/my_review.tpl');
$dbObj->Close();
?>
