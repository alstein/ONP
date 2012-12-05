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

echo "<pre>";
echo "Hiiriiriirirjndsfkkd";
print_r($_POST);
exit;
        if($_POST["addDonatetion"])
        {
               echo "Hiasdasdasdasdasdasdasdsdaadsds";
               exit;
               $deduct = $profObj->deductBalance($_SESSION['csUserId'],$siteUserId,'0.99');
        }

fgjdfjgdgfjgfjdj

// $IsDonated = $profObj->isDonated($_SESSION['csUserId'],$siteUser);
// $smarty->assign("IsDonated",$IsDonated);

// $userinfo = $profObj->fetchProfile($_SESSION['csUserId']);
// $smarty->assign("profile",$userinfo);
// $userid =$_SESSION['csUserId'];

// $siteUserTypeId = $profObj->fetchUserTypeid($siteUser);//exit;
// $smarty->assign("siteUserTypeId",$siteUserTypeId);

// $_GET['id1'] = 'private';
// print_r($_GET);
// exit;
$smarty->assign("donPage","private");
$smarty->assign("tabact","photo");
$smarty->assign("scttab","photo");
$smarty->assign("showright","yes");
$smarty->assign("siteroot", SITEROOT);
$smarty->display(TEMPLATEDIR . '/modules/photos/donation-request.tpl');
$dbObj->Close();
?>