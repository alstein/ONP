<?php
include_once('../../includes/SiteSetting.php');
include_once('../../includes/classes/class.profile.php');
include_once('../../includes/common.lib.php');
include_once('../../includes/classes/class.photos.php');
if(!$_SESSION['csUserId'])
{
	header("Location:".SITEROOT."/");
}
$smarty->assign("lfmnsellink","photos");
$userid=$_SESSION['csUserId'];
$profileinfo = $profObj->fetchProfile($userid);
$smarty->assign("profileinfo",$profileinfo);

extract($_POST);
if($_POST["postbtn"])
{
    if($_GET['id1']!= "")
    {
        $fl = array("photo_id","album_id","photo_title","photo_desc","privacy");
        $vl = array($_GET['id2'],$_GET['id1'],$phototitle,$description,$privacy);
        $update_details=$dbObj->cupdt("tbl_albumphotos",$fl,$vl,"photo_id",$_GET['id2'],"");
        $_SESSION["msg"]="Photo Edited Successfully!";
        header("location:".SITEROOT."/".$profileinfo['username']."/".$_POST['privacy']."/albumphotos/");
	exit;
    }
    else
    {
        $fl = array("user_id","album_id","photo_title","photo_desc","privacy");
        $vl = array($userid,$_GET['id1'],$album_name,$description,$privacy);
        $update_details=$dbObj->cgi("tbl_albumphotos",$fl,$vl,"");
        $_SESSION["msg"]="Photo Added Successfully!";
        header("location:".SITEROOT."/".$profileinfo['username']."/".$_POST['privacy']."/albumphotos/");
	exit;
    }
}

if($_GET["id2"] !="")
{
	$getphotodetails=$dbObj->cgs("tbl_albumphotos","*",array("user_id","photo_id","album_id"),array($_SESSION['csUserId'],$_GET['id2'],$_GET['id1']),"","","");
	$fetch_photodetails=@mysql_fetch_assoc($getphotodetails);
	$smarty->assign("photodetails",$fetch_photodetails);

}

if(isset($_SESSION['msg']))
{
	$smarty->assign("msg",$_SESSION['msg']);
	unset($_SESSION['msg']);
}
$smarty->assign("tabact","photo");
$smarty->assign("scttab","photo");
$smarty->assign("showright","yes");
$smarty->display(TEMPLATEDIR .'/modules/photos/edit-photo.tpl');
?>