<?php
include_once("../../../includes/common.lib.php");
include_once('../../../includes/SiteSetting.php');

if(!$_SESSION['duAdmId'])
{
        header("location:".SITEROOT . "/admin/login/home.php");
		  exit();
}

extract($_POST);
extract($_GET);
// print_r($_POST);
/*fetch banner content*/
if(isset($_POST['submit']))
{
	extract($_POST);
	if($_GET['id']!="")
	{
		$r=$_GET['id'];
		$thumbnail = "album_".date("YmdHis");
		if($_FILES['photo']['name']!="")
		{
			$ext = strtolower(strrchr($_FILES['photo']['name'], "."));
			if($ext == ".avi" || $ext == ".asf"  || $ext == ".qt" || $ext == ".3g2"  || $ext == ".3gpp" || $ext == ".gsm"  || $ext == ".mpeg" || $ext == ".m4v" || $ext == ".wmv" || $ext == ".mov" || $ext == ".mpg" || $ext == ".cmp" || $ext == ".divx" || $ext == ".xvid" || $ext == ".264" || $ext == ".rm" || $ext == ".rmvb" || $ext == ".mpe" || $ext == ".flv"  || $ext == ".wmf"  || $ext == ".MPEG" || $ext == ".movie" || $ext == ".mp4" || $ext == ".swf" || $ext == ".3gp" || $ext == ".txt" || $ext == ".doc")
			{
				$_SESSION['msg']="<span class='error'>Please upload the Image file with extension jpg,jpeg,gif,png,tif.</span>";
				header("location:".SITEROOT."/admin/sitemodules/albums/add-album.php?act=edit&id=".$_GET['id']);
				exit();
			}

			$original = newgeneralfileupload($_FILES['photo'], "../../../uploads/album/", true);
			$thumb_1 = crop_image("../../../uploads/album/".$original, "../../../uploads/album/thumbnail/".$thumbnail, 145,250);
			$img_arr = explode("/",$thumb_1);
// 			$img_arr = explode("/",$original);
			$img_ext = count($img_arr) - 1;
			$thumbnail = $img_arr[$img_ext];
			$set_field = array("album_title", "location", "album_description","privacy","thumbnail ","added_date");
			$set_values = array($album_title,$location,$album_description,$privacy,$thumbnail,date("Y-m-d H:i:s"));
			$dbres = $dbObj->cupdt('tbl_album', $set_field , $set_values, 'album_id' , $_GET['id'] , "");//exit;
			$_SESSION['msg']="<span class='successMsg'>Album Updated Successfully.</span>";
		}
		else
		{
			$set_field = array("album_title", "admin_album_title","location", "album_description","privacy");
			$set_values = array($album_title, $admin_album_title, $location,$album_description,$privacy);
			$dbres = $dbObj->cupdt('tbl_album', $set_field , $set_values, 'album_id' , $_GET['id'] , "");//exit;
			$_SESSION['msg']="<span class='successMsg'>Album Updated Successfully.</span>";
		}
		header("location:".SITEROOT."/admin/sitemodules/albums/album.php");exit();
	}
	else
	{		
		$thumbnail = "photo_".date("YmdHis");
		if($_FILES['photo']['name']!="")
		{
			$ext = strtolower(strrchr($_FILES['photo']['name'], "."));
			if($ext == ".avi" || $ext == ".asf"  || $ext == ".qt" || $ext == ".3g2"  || $ext == ".3gpp" || $ext == ".gsm"  || $ext == ".mpeg" || $ext == ".m4v" || $ext == ".wmv" || $ext == ".mov" || $ext == ".mpg" || $ext == ".cmp" || $ext == ".divx" || $ext == ".xvid" || $ext == ".264" || $ext == ".rm" || $ext == ".rmvb" || $ext == ".mpe" || $ext == ".flv"  || $ext == ".wmf"  || $ext == ".MPEG" || $ext == ".movie" || $ext == ".mp4" || $ext == ".swf" || $ext == ".3gp" || $ext == ".txt" || $ext == ".doc")
			{
				$_SESSION['msg']="<span class='error'>Please upload the Image file with extension jpg,jpeg,gif,png,tif.</span>";
				header("location:".SITEROOT."/admin/sitemodules/albums/add-album.php");
				exit();
			}

			$original = newgeneralfileupload($_FILES['photo'], "../../../uploads/album/", true);
			$thumb_1 = crop_image("../../../uploads/album/".$original, "../../../uploads/album/thumbnail/".$thumbnail, 145,250);
			$img_arr = explode("/",$thumb_1);
			$img_ext = count($img_arr) - 1;
			$thumbnail = $img_arr[$img_ext];
		}
		$url_title = $dbObj->url_title($album_title,"tbl_album");
		$fields = array("user_id","album_title", "admin_album_title","location", "album_description", "thumbnail", "privacy","added_date", "url_title");
		$values = array($_SESSION['duAdmId'],$album_title, $admin_album_title, $location,$album_description, $thumbnail, $privacy,date("Y-m-d H:i:s"), $url_title);
		$idres = $dbObj->cgi('tbl_album', $fields , $values , "");//exit;
		$_SESSION['msg']="<span class='successMsg'>Album Added Successfully.</span>";
      }
	header("location:".SITEROOT."/admin/sitemodules/albums/album.php");
	exit();
}

if($_GET['id']!="")
{
	$dbres = $dbObj->cgs('tbl_album', "*" ,"album_id",$_GET['id'], "","", "");
	$row_result = @mysql_fetch_assoc($dbres);
}

$smarty->assign("category",$row_result);

if($_SESSION['msg'])
{
	$smarty->assign("msg",$_SESSION['msg']);	
	$_SESSION['msg']=NULL;
	unset($_SESSION['msg']);
}

$smarty->assign("inmenu","sitemodules");
$smarty->assign("leftadminmenu","albums");
$smarty->display(TEMPLATEDIR . '/admin/sitemodules/albums/add-album.tpl');

$dbObj->Close();
?>