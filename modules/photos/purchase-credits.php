<?php
include_once('../../includes/SiteSetting.php');
include_once("../../includes/classes/class.profile.php");
include_once('../../includes/paging.php');

if(!$_SESSION['csUserId'])
{
    header("location:".SITEROOT."/");
    exit;
}

$userid=$siteUserId;
$userinfo = $profObj->fetchProfile($userid);
$smarty->assign("user",$userinfo);

// $IsDonated = $profObj->isDonated($_SESSION['csUserId'],$siteUser);
// $smarty->assign("IsDonated",$IsDonated);

// $userinfo = $profObj->fetchProfile($_SESSION['csUserId']);
// $smarty->assign("profile",$userinfo);
// $userid =$_SESSION['csUserId'];

// $siteUserTypeId = $profObj->fetchUserTypeid($siteUser);//exit;
// $smarty->assign("siteUserTypeId",$siteUserTypeId);

$smarty->assign("tabact","photo");
$smarty->assign("scttab","photo");
$smarty->assign("showright","yes");

$smarty->assign("siteroot", SITEROOT);
$smarty->display(TEMPLATEDIR . '/modules/photos/purchase-credits.tpl');
$dbObj->Close();
?>