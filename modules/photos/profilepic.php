<?php
include_once('../../includes/SiteSetting.php');
include_once('../../includes/classes/class.profile.php');
include_once('../../includes/classes/class.photos.php');
include_once('../../includes/common.lib.php');
include('../../includes/paging.php');

if(!$_SESSION['csUserId'])
{
    header("Location:".SITEROOT."/");
}


//delete Album
if($_GET["id2"]=="del")
{
   $photoObj->deleteAlbum($_GET['id1']);
        $_SESSION["msg"]="Album Deleted Successfully!";
   header("location:".$_SERVER["HTTP_REFERER"]);
   exit;
}
//end delete

//Fetch user Info

$userid=$siteUserId;
$userinfo = $profObj->fetchProfile($userid);
$smarty->assign("user",$userinfo);


	$getuserphotos=$dbObj->cgs("tbl_profile_images","*","userid",$userid,"id","DESC","");
	while($fetch_userphotos=@mysql_fetch_assoc($getuserphotos))
{
	$userphotos_arr[]=$fetch_userphotos;
}
	$cnt_userphotos=count($userphotos_arr);
	$smarty->assign("cnt_userphotos",$cnt_userphotos);
	$smarty->assign("userphotos",$userphotos_arr);

	if($_GET["id2"]=="delete")
{
	$getimagedetails=$dbObj->cgs("tbl_profile_images","*","id",$_GET["id1"],"","","");
	$fetch_imagedetails=@mysql_fetch_assoc($getimagedetails);
	
	$getimagedetails_checkavailable=$dbObj->customqry("select id from tbl_profile_images where userid='".$userid."' and id!='".$_GET["id1"]."' ","");
	$fetch_imagedetails_checkavailable=@mysql_fetch_assoc($getimagedetails_checkavailable);

	if($fetch_imagedetails["status"]=="active" || $fetch_imagedetails_checkavailable["id"]=="")
	{
		$update_profilephoto=$dbObj->cupdt("users","thumbnail","","userid",$_SESSION['csUserId'],"");
	}

	$delete_qry=$dbObj->customqry("delete from `tbl_profile_images` where id='".$_GET["id1"]."'","");
	header("location:".SITEROOT."/profile/photo/");
}

if(isset($_POST["photobtn"]))
{
	ini_set("memory_limit",'100M');
	if($_FILES['image']['name']!="")
	{
		$image = newgeneralfileupload($_FILES['image'], "../../uploads/user_photo/original/", true);
		$image = newgeneralfileupload($_FILES['image'], "../../uploads/user_photo/", true);
		$original['name'] = $image;
		$original['tmp_name'] = "../../uploads/user_photo/".$image;

		/*-----    Resize photo with good Quality function     ----*/
				include_once("../../includes/classes/upload.inc.php");
         // Defining Class
				 $yukle = new upload;
         
         // Upload file Using Upload INC file
				 $yukle->set_max_size(1018463000);
   //      $userimagename=time();
   $yukle->set_directory("../../uploads/user_photo");
   $tname = $yukle->set_tmp_name($_FILES['image']['tmp_name']);
   $tsize =  $yukle->set_file_size($_FILES['image']['size']);
   $ttype = $yukle->set_file_type($_FILES['image']['type']);
   $yukle->set_file_name($image);

   $yukle->set_thumbnail_name("/55X55/".$image);
   $yukle->create_thumbnail();
   $yukle->set_thumbnail_size(55,55);

   $yukle->set_thumbnail_name("/90X93/".$image);
   $yukle->create_thumbnail();
   $yukle->set_thumbnail_size(90,93);

   $yukle->set_thumbnail_name("/189X148/".$image);
   $yukle->create_thumbnail();
   $yukle->set_thumbnail_size(189,148);

   $yukle->set_thumbnail_name("/28X29/".$image);
   $yukle->create_thumbnail();
   $yukle->set_thumbnail_size(28, 29);

   $yukle->set_thumbnail_name("/30X31/".$image);
   $yukle->create_thumbnail();
   $yukle->set_thumbnail_size(30, 31);

   $yukle->set_thumbnail_name("/155X157/".$image);
   $yukle->create_thumbnail();
   $yukle->set_thumbnail_size(155, 157);

   $yukle->set_thumbnail_name("/thumbnail/".$image);
   $yukle->create_thumbnail();
   $yukle->set_thumbnail_size(212,212);
/*

		// for resize details
		$path = "../../uploads/user_photo/55X55/";
		$width_array  = array(55);
		$height = 55;
		$path_array = array($path);
		resize_multiple_images_new($original, $width_array, $path_array, $height);

		$path = "../../uploads/user_photo/90X93/";
		$width_array  = array(90);
		$height = 93;
		$path_array = array($path);
		resize_multiple_images_new($original, $width_array, $path_array, $height); // image crop


		$path = "../../uploads/user_photo/189X148/";
		$width_array  = array(189);
		$height = 148;
		$path_array = array($path);
		resize_multiple_images_new($original, $width_array, $path_array, $height); // image crop

		$path = "../../uploads/user_photo/28X29/";
		$width_array  = array(28);
		$height = 29;
		$path_array = array($path);
		resize_multiple_images_new($original, $width_array, $path_array, $height); // image crop


		$path = "../../uploads/user_photo/30X31/";
		$width_array  = array(30);
		$height = 31;
		$path_array = array($path);
		resize_multiple_images_new($original, $width_array, $path_array, $height); // image crop

		$path = "../../uploads/user_photo/155X157/";
		$width_array  = array(155);
		$height = 157;
		$path_array = array($path);
		resize_multiple_images_new($original, $width_array, $path_array, $height); // image crop

		$path = "../../uploads/user_photo/thumbnail/";
		$width_array  = array(212);
		$height = 212;
		$path_array = array($path);
		resize_multiple_images_new($original, $width_array, $path_array, $height); // image crop
 */
	}
	$sv_arr=array("userid","thumb_image","cropimage","status","date_added");
	$sf_arr=array($_SESSION["csUserId"],$image,$image,"active",date("Y-m-d H:i:s"));
	$insert_details=$dbObj->cgi("tbl_profile_images",$sv_arr,$sf_arr,"");

	$comment =  " has changed his profile picture ";
	$f=array("moduleid","itemid","userid","comment","date_added");
	$v=array('12',$userid,$_SESSION['csUserId'],$comment,date("Y-m-d h:i:s"));
	$id=$dbObj->cgi("tbl_comments",$f,$v,"");

	$update_profilephoto=$dbObj->cupdt("users","thumbnail",$image,"userid",$_SESSION['csUserId'],"");
	$dbObj->customqry("update `tbl_profile_images` set status='inactive' where userid='".$_SESSION["csUserId"]."' and id!='".$insert_details."'","");
	header("location:".SITEROOT."/profile/$insert_details/crop/");
	//header("location:".$_SERVER["HTTP_REFERER"]);
	exit;
}


if(isset($_POST["savechangebtn"]))
{
	$getimagedetails=$dbObj->cgs("tbl_profile_images","*","id",$_POST["setdefault"],"","","");

	$fetch_imagedetails=@mysql_fetch_assoc($getimagedetails);
	$update_profilephoto=$dbObj->cupdt("users","thumbnail",$fetch_imagedetails["thumb_image"],"userid",$_SESSION['csUserId'],"");

	$update_profilephoto=$dbObj->cupdt("tbl_profile_images","status","active","id",$_POST["setdefault"],"");
	$dbObj->customqry("update `tbl_profile_images` set status='inactive' where userid='".$_SESSION["csUserId"]."' and id!='".$_POST["setdefault"]."'","");

	header("location:".SITEROOT."/".$_SESSION['csUserName']."/profilephotos/");
}



//Fetch profile Info
		$cnd = "userid =".$userid;
$userid = $dbObj->gj("tbl_profile","userid",$cnd,"","","","","");//exit;
if(is_resource($userid))
{
	$userinfo = $profObj->fetchProfile($_SESSION['csUserId']);
	if($userinfo['language']!="")
	{
		$reslang = explode(",",$userinfo['language']);
		$smarty->assign("reslang",$reslang['mast_value']);
	}

	if($userinfo['birth_date'])
	{
		$birthdate = explode("-",$userinfo['birth_date']);
		$year = date("Y");
		$userinfo['age'] = $year - $birthdate[0] - 1;
	}
}
$smarty->assign("user",$userinfo);


if(isset($_SESSION['msg']))
{
	$smarty->assign("msg",$_SESSION['msg']);
	unset($_SESSION['msg']);
}

$smarty->assign("albcnt",$resarr[1]['nums']);
$smarty->assign("tabact","photo");
$smarty->assign("scttab","photo");
$smarty->assign("showright","yes");
$smarty->assign("profact","active");
$smarty->display(TEMPLATEDIR .'/modules/photos/profilepic.tpl');
?>