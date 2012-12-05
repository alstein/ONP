<?php
include_once('../../include.php');
include_once('../../includes/SiteSetting.php');
include_once('../../includes/classes/class.profile.php');
include_once('../../includes/common.lib.php');
include_once('../../includes/classes/class.comments.php');
include_once('../../includes/classes/class.photos.php');
include('../../includes/paging.php');
$comObj=new Comments();

if(!$_SESSION['csUserId'])
{
	header("Location:".SITEROOT."/");
}
$whose_profile="album";
$smarty->assign("whose_profile",$whose_profile);
if($_GET['id1']!="")
{
$siteUserId=$_GET['id1'];
}
else
{
$siteUserId=$_SESSION['csUserId'];
}
$smarty->assign("siteUserId",$siteUserId);
$smarty->assign("lfmnsellink","photos");
$albumid = $photoObj->fetchAlbumId($_GET['albumid']);
$smarty->assign("albumid",$albumid);

if($_GET["id3"]=="delete")
{
   $del_comm=$dbObj->customqry("delete from tbl_comments where itemid='".$_GET["id2"]."' and moduleid = 13 and userid ='".$_SESSION['csUserId']."'",""); 

	$get_albumdetails=$dbObj->cgs("tbl_albumphotos","user_id,album_id,thumbnail","photo_id",$_GET["id2"],"","","");
	$fetch_albumdetails=@mysql_fetch_assoc($get_albumdetails);

	$del_qry=$dbObj->customqry("delete from tbl_albumphotos where photo_id='".$_GET["id2"]."'","");
	$_SESSION["msg"]="Photo Deleted Successfully!";

	if($fetch_albumdetails['thumbnail']!="")
	{
		@unlink('../../uploads/album/photo/'.$fetch_albumdetails['thumbnail']);
		@unlink('../../uploads/album/photo/90X90/'.$fetch_albumdetails['thumbnail']);
		@unlink('../../uploads/album/photo/132X101/'.$fetch_albumdetails['thumbnail']);
		@unlink('../../uploads/album/photo/180X158/'.$fetch_albumdetails['thumbnail']);
		@unlink('../../uploads/album/photo/400X300/'.$fetch_albumdetails['thumbnail']);
		@unlink('../../uploads/album/photo/600X600/'.$fetch_albumdetails['thumbnail']);
		@unlink('../../uploads/album/photo/bigimage/'.$fetch_albumdetails['thumbnail']);
		@unlink('../../uploads/album/photo/thumbnail/'.$fetch_albumdetails['thumbnail']);
	}
        @header("location:".SITEROOT."/".$profileinfo['username']."/"."/albumphotos/");
// 	header("location:".SITEROOT."/".$userinfo['login_name']."/".$_GET["id2"]."/photos/");
	//header("location:".$_SERVER["HTTP_REFERER"]);
	exit;
}

// for comment delete details
if($_GET["id2"]=="commentdelete")
{
	$del_comment=$dbObj->customqry("delete from tbl_comments where id=".$_GET["id1"]." ","");
	header("location:".$_SERVER["HTTP_REFERER"]);
	exit;
}
// end for comment delete details

if(isset($_SESSION['msg']))
{
	$smarty->assign("msg",$_SESSION['msg']);
	unset($_SESSION['msg']);
}
// $smarty->assign("albcnt1",$nums);
$smarty->assign("tabact","photo");
$smarty->assign("scttab","photo");
$smarty->assign("showright","yes");
$smarty->display(TEMPLATEDIR .'/modules/photos/details.tpl');
?>