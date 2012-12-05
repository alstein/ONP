<?php
include_once('../../include.php');
if( $_SESSION['csUserTypeId']=='3' || !isset($_SESSION['csUserId']) )
{
	header("location:".SITEROOT); exit;
}

$smarty->assign("seotitle",$seoname." Account Setting");

$selct_setting=$dbObj->customqry("select photo_setting,live_wire_setting,deal_setting from tbl_users where userid='".$_SESSION['csUserId']."'","");
$res_setting=@mysql_fetch_assoc($selct_setting);
$smarty->assign("setting",$res_setting);
if(isset($_POST['Submit'])!="")
{
extract($_POST);
$update_setting=$dbObj->customqry("update tbl_users set photo_setting='".$photos."',live_wire_setting='".$live_wires."',deal_setting='".$deal."'  where userid='".$_SESSION['csUserId']."'","1");
@header("Location:".SITEROOT."/merchant-account/account_setting");
}

$smarty->display( TEMPLATEDIR . '/modules/merchant-account/account_setting.tpl');
$dbObj->Close();
?>
