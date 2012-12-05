<?php
include("../../include.php");
include_once('../../includes/SiteSetting.php');
include_once('../../includes/common.lib.php');
include_once('../../includes/classes/class.profile.php');
include_once('../../includes/classes/class.photos.php');

if(!$_SESSION['csUserId'])
{
	header("Location:".SITEROOT."/");
}

$row_meta=$dbObj->getseodetails(10);
$smarty->assign("row_meta",$row_meta);


$whose_profile="album";
$smarty->assign("whose_profile",$whose_profile);
$cnd_name="userid=".$_SESSION['csUserId'];
$select_name=$dbObj->gj("tbl_users","*",$cnd_name,"","","","",""); 
$res_select_name=@mysql_fetch_assoc($select_name);
$username=$res_select_name['first_name'];
$smarty->assign("username",$username);
if($siteUserId!="")
{
$userid=$siteUserId;
}
else
{
$userid=$_SESSION['csUserId'];
}


//fetch abl id
	$albumid = $photoObj->fetchAlbumId($_GET['album']);
      	$smarty->assign("albums",$albumid);

//fetch common profile info	
	$userinfo = $profObj->fetchProfile($userid);
	$smarty->assign("user",$userinfo);

//fetch album details
	$fetch_details = $photoObj->fetchAlbumDetails($albumid);
	$smarty->assign("album_details",$fetch_details);

$smarty->assign("lfmnsellink","photos");
$smarty->assign("profileinfo",$userinfo);
//insert images in table photos
$tbl1="tbl_users as u left join mast_city as m ON m.city_id=u.city left join mast_state as s ON s.id=u.state_id";
$sf1="u.*";
$cd1 = "userid=".$userid;
$result1= $dbObj ->gj($tbl1,$sf1,$cd1,$ob,$gb,$ad,$l,"");
$profileinfo1=@mysql_fetch_assoc($result1);

if(isset($_POST["addphotobtn"]))
{
   $photoObj->addPhotos($albumid,$userid,$_FILES); 
   @header("location:".SITEROOT."/".$profileinfo1['username']."/".$_GET["album"]."/photos");
   exit;
}

if(isset($_SESSION['msg']))
{
	$smarty->assign("msg",$_SESSION['msg']);
	unset($_SESSION['msg']);
}
$smarty->assign("tabact","photo");
$smarty->assign("scttab","photo");
$smarty->assign("showright","yes");
$smarty->display(TEMPLATEDIR .'/modules/photos/addphotos.tpl');
?>