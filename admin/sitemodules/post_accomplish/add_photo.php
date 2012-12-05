<?php 
include_once("../../../includes/paging.php");
include_once('../../../includes/SiteSetting.php');
include_once('../../../includes/common.lib.php');
ini_set('upload_max_filesize', '8M');
if(!$_SESSION['duAdmId'])
{
	header("location:".SITEROOT . "/admin/login/home.php");
	exit();
}

if($_POST['submit']=="Save")
{
/*
for($z=1;$z<6;$z++)
{
	if($_FILES["image$z"]["name"]!="")
	{
		$ext = strtolower(strrchr($_FILES["image$z"]['name'], "."));
		if($ext == ".avi" || $ext == ".asf"  || $ext == ".qt" || $ext == ".3g2"  || $ext == ".3gpp" || $ext == ".gsm"  || $ext == ".mpeg" || $ext == ".m4v" || $ext == ".wmv" || $ext == ".mov" || $ext == ".mpg" || $ext == ".cmp" || $ext == ".divx" || $ext == ".xvid" || $ext == ".264" || $ext == ".rm" || $ext == ".rmvb" || $ext == ".mpe" || $ext == ".flv"  || $ext == ".wmf"  || $ext == ".MPEG" || $ext == ".movie" || $ext == ".mp4" || $ext == ".swf" || $ext == ".3gp" || $ext == ".txt" || $ext == ".doc")
		{
			$_SESSION['msg']="<span class='error'>Please upload the Image file with extension jpg,jpeg,gif,png,tif.</span>";
			header("location:".SITEROOT."/admin/sitemodules/post_accomplish/add_photo.php?id=".$_GET['id']);
			exit();
		}
		#==============new =============#
		if($_FILES["image$z"]["name"] != "")
		{
				$mtmpRoot    = $HTTP_POST_FILES["image$z"]["tmp_name"];
				$mMainPhoto  = $HTTP_POST_FILES["image$z"]['name'];
				$original['name']     = $_FILES["image$z"]['name'];
				$original['type']     = $_FILES["image$z"]['type'];
				$original['tmp_name'] = $_FILES["image$z"]['tmp_name'];
				$original['error']    = $_FILES["image$z"]['error'];
				$original['size']     = $_FILES["image$z"]['size'];
				$size 		      = $original['size'];
				$size_bytes 	      = 2097152; 
				
				$ftype = $_FILES["image$z"]['name'];
				
				$filetype = strstr($ftype,".");
				
				if($filetype == '.png' || $filetype == '.jpg' || $filetype == '.gif' || $filetype == '.jpeg')
				{
				
					if($size > $size_bytes)
					{
						echo $msg="Unable to upload file. Please upload file less than 1 MB.";
						exit();
					}
					elseif($original['name'])
					{
						@chmod("../../../uploads/post_accomplish/",0777);
					
						$imagename = "photo_".rand(1,1000);
			
						$original = newgeneralfileupload($_FILES["image$z"], "../../../uploads/post_accomplish/", true); 
						$thumb_1 = crop_image("../../../uploads/post_accomplish/".$original, "../../../uploads/post_accomplish/145X145/".$imagename, 145,145);
								
						$bigimage_1 = crop_image("../../../uploads/post_accomplish/".$original, "../../../uploads/post_accomplish/400X400/".$imagename, 400,400);
						$thumb_90X90 = crop_image("../../../uploads/post_accomplish/".$original, "../../../uploads/post_accomplish/90X90/".$imagename, 90,90);
						$img_arr = explode("/",$thumb_1);
						$img_ext = count($img_arr) - 1;
						$thumbnail = $img_arr[$img_ext];
						
						$tbl="tbl_accomplishment_photo";
						$sf = array("acc_id","image","status");
						$sv = array($_GET['id'],$thumbnail, 'Active');
					
						$insrt=$dbObj->cgi($tbl,$sf,$sv,"");
					}
				}
		}
	}
}*/
	$_SESSION['msg']="Photos Added Successfully";
	header("location:".SITEROOT."/admin/sitemodules/post_accomplish/edit_photo.php?id=".$_GET['id']);
	exit;
}//end submit

if($_GET['album_id']!="")
{
	$dbres = $dbObj->cgs('tbl_album', "*" ,array("acc_id","album_id"),array($_GET['acc_id'],$_GET['album_id']), "","", "");
	$row_result = @mysql_fetch_assoc($dbres);
}
$smarty->assign("album",$row_result);


$smarty->assign("inmenu","sitemodules");
$smarty->assign("leftadminmenu","post_acc");

$smarty->display(TEMPLATEDIR .'/admin/sitemodules/post_accomplish/add_photo.tpl');
$dbObj->Close();
?>