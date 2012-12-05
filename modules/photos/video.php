<?php
include_once('../../includes/SiteSetting.php');
include_once('../../includes/classes/class.video.php');
include('../../includes/paging.php');
include_once('../../includes/classes/class.profile.php');
if(!$_SESSION['csUserId'])
{
	header("Location:".SITEROOT."/");
}

//Get User profile
$userid=$siteUserId;
$userinfo = $profObj->fetchProfile($userid);
$smarty->assign("user",$userinfo);

//Fetch album id 
$albid=$videoObj->fetchVideoAblId($_GET['id1']);
$smarty->assign("albid",$albid);

//delete Album
if($_GET["id2"]=="del")
{
    $videoObj->deleteAlbum($_GET['id1']);
    $_SESSION["msg"]="Album Deleted Successfully!";
    header("location:".$_SERVER["HTTP_REFERER"]);
    exit;
}

$resarr = $videoObj->getVideos($albid,$_GET['page'],$userid);
$smarty -> assign("pgnation",$resarr[0]);
$smarty->assign("video",$resarr[1]);
$smarty->assign("videoCount",$resarr[2]);


if(isset($_SESSION['msg']))
{
    $smarty->assign("msg",$_SESSION['msg']);
    unset($_SESSION['msg']);
}

$smarty->assign("showright","yes");
$smarty->assign("tabact","video");
$smarty->assign("scttab","video");
$smarty->display(TEMPLATEDIR .'/modules/video/video.tpl');
?>