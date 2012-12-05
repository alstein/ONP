<?php
include_once('../../include.php');


if(!isset($_SESSION['csUserId']) || $_SESSION['csUserTypeId']!=2)
{
	header("location:".SITEROOT); exit;
}
$selct_setting=$dbObj->customqry("select photo_setting,profile_feed_setting,merchant_setting from tbl_users where userid='".$_SESSION['csUserId']."'","");
$res_setting=@mysql_fetch_assoc($selct_setting);
$smarty->assign("setting",$res_setting);

$row_meta=$dbObj->getseodetails(26);
$smarty->assign("row_meta",$row_meta);


if(isset($_POST['Submit'])!="")
{
extract($_POST);
$update_setting=$dbObj->customqry("update tbl_users set photo_setting='".$photos."' ,profile_feed_setting='".$profile_feeds."' ,merchant_setting='".$merchant_setting."'   where userid='".$_SESSION['csUserId']."'","");
  @header("Location:".SITEROOT."/my-account/account_setting");
}

$smarty->display( TEMPLATEDIR . '/modules/my-account/account_setting.tpl');
$dbObj->Close();
?>
