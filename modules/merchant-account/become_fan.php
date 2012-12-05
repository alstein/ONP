<?php
include_once('../../include.php');

if(!isset($_SESSION['csUserId']))
{
	header("location:".SITEROOT); exit;
}
if($_POST['merchant_id']){
	$fl=array("userid","fan_id","status");
	$vl=array($_POST['merchant_id'],$_SESSION['csUserId'],'Active');
	$res=$dbObj->cgi("tbl_fan", $fl, $vl, $prn);
	echo '1';
}
?>