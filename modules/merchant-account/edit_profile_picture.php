<?php
include_once('../../include.php');
include_once('../../includes/SiteSetting.php');
require_once("../../includes/common.lib.php");

if(!isset($_SESSION['csUserId']))
{
	header("location:".SITEROOT); exit;
}
$smarty->assign("seotitle",$seoname." - Edit Profile Picture");
$sf="u.*";
$cnd="u.userid=".$_SESSION['csUserId'];
$tbl="tbl_users as u";

$rs=$dbObj->gj($tbl, $sf, $cnd, "", "", "", "", "");
$user=@mysql_fetch_assoc($rs);
$smarty->assign("user",$user);


if($_FILES['photo']['name']!="")
{

  if($_FILES['photo'])
    {

              $original_1 = newgeneralfileupload($_FILES["photo"], "../../uploads/user", true); 

	      $image = new Imagick('../../uploads/user/'.$original_1);
	      list($width, $height, $type, $attr) = getimagesize('../../uploads/user/'.$original_1);
	      if($width>$height)
		      $image->thumbnailImage(190, 0);
	      else	
		      $image->thumbnailImage(0,190);

	      $image->writeImage('../../uploads/user/thumbnail/'.$original_1);

	      if($width>$height)
		      $image->thumbnailImage(50, 0);

	      else	
		      $image->thumbnailImage(0, 50);

	      $image->writeImage('../../uploads/user/50X50/'.$original_1);

		$original_2 = newgeneralfileupload($_FILES["photo"], "../../uploads/album/180X158/", true); 
		        $original['name'] = $original_2;
                        $original['tmp_name'] = "../../uploads/album/180X158/".$original_2;


                        $path = "../../uploads/album/180X158/";
                        $width_array  = array(180);
                        $height = 158;
                        $path_array = array($path);
                        resize_multiple_images_new($original, $width_array, $path_array, $height);

	       $original_12 = newgeneralfileupload($_FILES["photo"], "../../uploads/album/photo/180X158/", true); 

			 $original['name'] = $original_12;
			$original['tmp_name'] = "../../uploads/album/photo/180X158/".$original_12;


			$path = "../../uploads/album/photo/180X158/";
			$width_array  = array(180);
			$height = 158;
			$path_array = array($path);
			resize_multiple_images_new($original, $width_array, $path_array, $height);
			
		 $original_13 = newgeneralfileupload($_FILES["photo"], "../../uploads/album/photo/400X300/", true); 
			 $original['name'] = $original_13;
			$original['tmp_name'] = "../../uploads/album/photo/400X300/".$original_13;


			$path = "../../uploads/album/photo/400X300/";
			$width_array  = array(400);
			$height = 300;
			$path_array = array($path);
			resize_multiple_images_new($original, $width_array, $path_array, $height);
			
		 $original_14 = newgeneralfileupload($_FILES["photo"], "../../uploads/album/photo/600X600/", true); 
			 $original['name'] = $original_14;
			$original['tmp_name'] = "../../uploads/album/photo/600X600/".$original_14;


			$path = "../../uploads/album/photo/600X600/";
			$width_array  = array(600);
			$height = 600;
			$path_array = array($path);
			resize_multiple_images_new($original, $width_array, $path_array, $height);
		 $original_15 = newgeneralfileupload($_FILES["photo"], "../../uploads/album/photo/132X101/", true); 
			$original['name'] = $original_15;
			$original['tmp_name'] = "../../uploads/album/photo/132X101/".$original_15;
		
		
			$path = "../../uploads/album/photo/132X101/";
			$width_array  = array(132);
			$height = 101;
			$path_array = array($path);
			resize_multiple_images_new($original, $width_array, $path_array, $height);
		 $original_16 = newgeneralfileupload($_FILES["photo"], "../../uploads/album/photo/bigimage/", true); 
    }
	$url_title=profile-pictures."-".$_SESSION["csUserId"];
	$select_album=$dbObj->customqry(" select * from tbl_album where user_id='".$_SESSION["csUserId"]."' and url_title='".$url_title."'","");
	$res_album=@mysql_fetch_assoc($select_album);
	$num_album=@mysql_num_rows($select_album);
	
	if($num_album ==0)
	{
	$url_title=profile-pictures."-".$_SESSION["csUserId"];
	$sf_arr=array("user_id","album_title","album_description",'thumbnail','privacy ','url_title',"added_date");
	$sv_arr=array($_SESSION["csUserId"],'profile pictures','profile pictures',$original_1,'Public',$url_title,date("Y-m-d H:i:s"));
	$insert_details=$dbObj->cgi("tbl_album",$sf_arr,$sv_arr,"1");
	$album_id=@mysql_insert_id();
	}
	else
	{
	$album_id=$res_album['album_id'];
	}
	$sf_arr=array("user_id","album_id","thumbnail","big_image","added_date");
	$sv_arr=array($_SESSION["csUserId"],$album_id,$original_1,$original_1,date("Y-m-d H:i:s"));
	$insert_details=$dbObj->cgi("tbl_albumphotos",$sf_arr,$sv_arr,"");

		$fl = array("photo");
		$vl = array($original_1);
		$rs = $dbObj->cupdt('tbl_users',$fl,$vl,'userid',$_SESSION['csUserId'],'');
		$update_flag=1;
		$msg_activity="$fullname has changed his profile picture";
		$timestamp=date("Y-m-d H:i:s");
		$insert_activity=$dbObj->customqry("insert into tbl_activity(msg,vault_t,vault,timestamp,wall,uid,fid)values('".$msg_activity."','img','".$original_1."','".$timestamp."','1','".$_SESSION['csUserId']."','".$_SESSION['csUserId']."') ","");
		
		@header("location:".SITEROOT."/merchant-account/merchant_profile_home");
		
}

$smarty->display( TEMPLATEDIR . '/modules/merchant-account/edit_profile_picture.tpl');
$dbObj->Close();
?>
