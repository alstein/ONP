<?php
include_once('../../include.php');
include_once('../../includes/SiteSetting.php');
include_once('../../includes/classes/class.profile.php');
include_once('../../includes/classes/class.photos.php');
include_once('../../includes/common.lib.php');
include('../../includes/paging.php');

if(!$_SESSION['csUserId'])
{
    header("Location:".SITEROOT."/");
}


$row_meta=$dbObj->getseodetails(7);
$smarty->assign("row_meta",$row_meta);

$smarty->assign("seotitle",$seoname." - Album");

$whose_profile="album";
$smarty->assign("whose_profile",$whose_profile);
$smarty->assign("lfmnsellink","photos");
//delete Album
if($_GET["id2"]=="del")
{
   $photoObj->deleteAlbum($_GET['id1']);
        $_SESSION["msg"]="Album Deleted Successfully!";
   header("location:".$_SERVER["HTTP_REFERER"]);
   exit;
}
//end delete
$selusername=$dbObj->customqry("select * from tbl_users where userid='".$_SESSION['csUserId']."'","");
$resusername=@mysql_fetch_assoc($selusername);
$ses_username=$resusername['username'];

//Fetch user Info

if($siteUserId!="")
{
$userid=$siteUserId;
}
elseif($_GET['id1']!="")
{
$userid=$_GET['id1'];
}
elseif($_GET['user']!="")
{
$select_username=$dbObj->customqry("select * from tbl_users where username='".$_GET['user']."'","");
$res_select_username=@mysql_fetch_assoc($select_username);
$userid=$res_select_username['userid'];
}
else
{
$userid=$_SESSION['csUserId'];
}
$profileinfo = $profObj->fetchProfile($userid);
$smarty->assign("profileinfo",$profileinfo);
$smarty->assign("siteUserId",$siteUserId);
// if($_GET['privacy'] == "private")
// {
//    if($_SESSION['csUserTypeId'] == '2' && $userinfo['user_type']=='3')
//    {
//          if($CheckStatus != 'active' && $IsDonated != 'yes' || $CheckStatus != 'active' && $IsDonated != 'no')
//          {
//                header("Location:".SITEROOT."/".$userinfo['login_name']."/donation-request/");
//                exit;  
//         }
//    }
// }


//display user albums
    $resarr = $photoObj->displayUserAlbums2($userid,$_GET['page'],$_GET['privacy']);
// echo "<pre>"; print_r($resarr[1]['pgnation']);
//  $pgnation=$resarr[1]['pgnation'];
   // $smarty->assign("pgnation",$resarr[1]['pgnation']);
    $smarty->assign("photodetails",$resarr[0]); //exit;

//     $privacyRating= $profObj->calPrivacyRating($_GET['privacy'],"1",$siteUserId);
//     $smarty->assign("privacyRating",$privacyRating);


if(isset($_SESSION['msg']))
{
	$smarty->assign("msg",$_SESSION['msg']);
	unset($_SESSION['msg']);
}
$smarty->assign("ses_username",$ses_username);
$smarty->assign("count",$count);
$smarty->assign("albcnt",$resarr[1]['nums']);
$smarty->assign("tabact","photo");
$smarty->assign("scttab","photo");
$smarty->assign("showright","yes");
$smarty->display(TEMPLATEDIR .'/modules/photos/album.tpl');
?>