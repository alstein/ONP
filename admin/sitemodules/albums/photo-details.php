<?php
include_once('../../../includes/SiteSetting.php');
include_once('../../../includes/common.lib.php');
include('../../../includes/paging.php');
// include_once('../../../includes/class.message.php');
// 
// $msobj= new message();
// $smarty->assign("msobj",$msobj);
if(!$_SESSION['duAdmId'])
{
        header("location:".SITEROOT . "/admin/login/_welcome.php");
		  exit();
}

extract($_POST);
extract($_GET);
if(isset($_POST['savebtn']))
{

	for($pd=1;$pd<=$_POST["count_photos"];$pd++)
	{
		$update_qry=$dbObj->cupdt("tbl_albumphotos","photo_title",$_POST["caption$pd"],"photo_id",$_POST["hiddenphotoid$pd"],"");	
	}

	$set_as_cover=$dbObj->cupdt("tbl_albumphotos","is_cover","yes","photo_id",$_POST["photo"],"");
	$p=$_POST['photo'];
	$aid=$_GET['id'];
	$dntset_as_cover=$dbObj->customqry("update tbl_albumphotos set is_cover='no' where photo_id!=$p and album_id=$aid","");//exit;
	
	$getphotodetails=$dbObj->cgs("tbl_albumphotos","*","photo_id",$_POST["photo"],"","","");
	$fetch_photodetails=@mysql_fetch_assoc($getphotodetails);

	$image_name=$fetch_photodetails["thumbnail"];
	$update_albumdetails=$dbObj->cupdt("tbl_album","thumbnail",$image_name,"album_id",$_GET["id"],"");
	
	header("location:".SITEROOT."/admin/sitemodules/albums/album.php");
	exit();
}
$smarty->assign("fetch_photodetails",$fetch_photodetails);
// photos in album details

$getalbum_images=$dbObj->cgs("tbl_albumphotos","*","album_id",$_GET["id"],"","","");//exit;
while($fetch_details=@mysql_fetch_assoc($getalbum_images))
{
	$album_photos[]=$fetch_details;
}
// test($album_photos);
$count_photos=@mysql_num_rows($getalbum_images);
$smarty->assign("count_photos",$count_photos);
$smarty->assign("album_photos",$album_photos);

// end for photos in album details 


$getalbumdetails=$dbObj->cgs("tbl_album","*","album_id",$_GET["id"],"","","");
$fetch_albumdetails=@mysql_fetch_assoc($getalbumdetails);
$smarty->assign("albumdetails",$fetch_albumdetails);

if($_SESSION['msg'])
{
	$smarty->assign("msg",$_SESSION['msg']);
	$_SESSION['msg']=NULL;
	unset($_SESSION['msg']);
}

$smarty->assign("selecttab",'photo');
$smarty->assign("leftadminmenu","albums");
$smarty->display(TEMPLATEDIR .'/admin/sitemodules/albums/photo-details.tpl');
$dbObj->Close();

?>