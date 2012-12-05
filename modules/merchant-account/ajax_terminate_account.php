<?php
include_once('../../include.php');
include_once('../../includes/SiteSetting.php');
//require_once("../../includes/classes/class.myaccount.php");
require_once("../../includes/common.lib.php");
include_once("../../includes/classes/combo.class.php");
include_once('../../includes/class.message.php');
include_once('../../includes/class.user.php');
$msobj= new message();

if(isset($_SESSION['msg'])){
   $smarty->assign("msg",$_SESSION['msg']);
   unset($_SESSION['msg']);
}



if(!isset($_SESSION['csUserId']) || $_SESSION['csUserTypeId']!='3')
{
	header("location:".SITEROOT); exit;
}
$userid=$_GET['userid'];
$sel_type=$dbObj->customqry("delete from tbl_users where userid ='".$_GET['userid']."'","");
$fan=$userobj->deletefan($userid);
$friend=$userobj->deletefriend($userid);
$cheer=$userobj->deletecheer($userid);
$activity=$userobj->deleteactivity($userid);
$photo=$userobj->deletephoto($userid);
$review=$userobj->deletereview($userid);
$coupons=$userobj->deletecoupons($userid);
$messages=$userobj->deletemessages($userid);
$offerdeal=$userobj->deleteofferdeal($userid);
session_destroy();
print_r($_SESSION);
// header("location:".SITEROOT); exit;
?>
