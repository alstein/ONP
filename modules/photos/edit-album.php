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

if($_POST['album_name']!="" && $_POST["postbtn"]=="")
{
	$retvar = $photoObj->createAlbum($albid,$_FILES,$_POST);
	//add userid for photos
	$photos=$dbObj->cgs("tbl_albumphotos","*",array("album_id","user_id"),array("0",$_SESSION['csUserId']),"photo_id","","");
	while($fetch_pht=@mysql_fetch_array($photos))
	{
		$alb_photos[$p]=$fetch_pht;
		$update_details=$dbObj->cupdt("tbl_albumphotos","album_id",$retvar[1],"photo_id",$fetch_pht['photo_id'],"");
		$p++;
	}

	header("location:".SITEROOT."/".$profileinfo['username']."/albumphotos/");
	exit;
}

 $albid=$_GET['id1'];
if(isset($_POST["postbtn"]))
{
	$retvar = $photoObj->createAlbum($albid,$_FILES,$_POST);
	$_SESSION['msg'] = $retvar[0];
	if($retvar[1]!="")
	{
		$photoObj->addPhotos($retvar[1],$_SESSION['csUserId'],$_FILES); 
	}
	elseif($albid!="")
	{
		$photoObj->addPhotos($albid,$_SESSION['csUserId'],$_FILES); 
		//add userid for photos
		$photos=$dbObj->cgs("tbl_albumphotos","*",array("album_id","user_id"),array($albumid,"0"),"photo_id","","");
		while($fetch_pht=@mysql_fetch_array($photos))
		{
			$alb_photos[$p]=$fetch_pht;
			$update_details=$dbObj->cupdt("tbl_albumphotos","album_id",$albid,"photo_id",$fetch_pht['photo_id'],"");
			$p++;
		}
	}
		header("location:".SITEROOT."/".$profileinfo['username']."/albumphotos/");
		exit;	
}

if($_GET["id2"]=="edit")
{
	$getalbumdetails=$dbObj->cgs("tbl_album","*",array("user_id","album_id"),array($_SESSION['csUserId'],$_GET['id1']),"","","");
	$fetch_albumdetails=@mysql_fetch_assoc($getalbumdetails);
	$smarty->assign("albumdetails",$fetch_albumdetails);
}

if(isset($_SESSION['msg']))
{
	$smarty->assign("msg",$_SESSION['msg']);
	unset($_SESSION['msg']);
}
$smarty->assign("tabact","photo");
$smarty->assign("scttab","photo");
$smarty->assign("showright","yes");
$smarty->display(TEMPLATEDIR .'/modules/photos/edit-album.tpl');
?>