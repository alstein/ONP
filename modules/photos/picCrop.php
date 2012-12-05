<?php
include_once('../../includes/SiteSetting.php');
include_once('../../includes/common.lib.php');
include('../../includes/paging.php');
// include_once('../../includes/classes/class.rating.php');
require_once("../../includes/classes/class.profile.php");

if(empty($_SESSION['csUserId']))
{
	header("location:".SITEROOT."/");
	exit;
}

//Fetch user Info
$userid=$siteUserId;
$userinfo = $profObj->fetchProfile($siteUserId);
$smarty->assign("user",$userinfo);

    $photoid = $_GET['photoid'];


   $crpid = $_GET['id1'];
   $userid=$_SESSION['csUserId'];

   if(isset($_POST['crop_photo']))
   {
      extract($_POST);
      if($_POST['x'])
         {
	            extract($_POST);
	            $jpeg_quality = 100;
	            //echo $target_file = "crop".$original_image;
               $target_file =$original_image;  
	            $src = '../../uploads/album/photo/600X600/'.$original_image;
            
	            $functions = array(
		            'image/png' => 'ImageCreateFromPng',
		            'image/jpeg' => 'ImageCreateFromJpeg',
		            'image/gif'=> 'ImageCreateFromGif'
		            );
   
	   
	   $size = getimagesize($src);
	   if (!$function = $functions[$size['mime']]) 
	   {
		   trigger_error("MIME Type unsupported: {$size['mime']}",E_USER_WARNING);
		   exit;
	   }
	   $image_sizes = array(132=>101,400=>300,180=>158,600=>600);
      $target_file = "crop_".$target_file;
	   foreach($image_sizes as $key=>$val)
	   {
		   $img_r = $function($src);
		   $targ_w=$key;
		   $targ_h=$val;
		   //$targ_w = $targ_h = $img_size;
		   $dst_r = ImageCreateTrueColor($targ_w, $targ_h);

		   imagecopyresampled($dst_r, $img_r, 0, 0, $_POST['x'], $_POST['y'], $targ_w, $targ_h, $_POST['w'], $_POST['h']);
		   $res = imagejpeg($dst_r, "../../uploads/album/photo/".$targ_w."X".$targ_h."/".$target_file, $jpeg_quality);
		   
		   imagedestroy($img_r);
		   imagedestroy($dst_r);
   //      echo $target_file; exit;
	   }
		   $id=$dbObj->cupdt("tbl_albumphotos", array("thumbnail","big_image"),array($target_file,$target_file), "photo_id",$photoid,"");
         $id=$dbObj->cupdt("tbl_albumphotos","tempthumb",$original_image_path,"photo_id",$photoid,"");
		   //$ids=$dbObj->cupdt("tbl_albumphotos", "cropimage", "", "id", $_POST['cropimageid'], "");
		   //$update_profilephoto=$dbObj->cupdt("users","thumbnail",$target_file,"userid",$_SESSION['csUserId'],""); 
		   $_SESSION['msg']="photo changed successfully.";
         unset($placeinfo);
	   }
   }


      if(isset($_POST['Save']))
      {
         header("location:".SITEROOT."/".$_GET['user']."/public/albumphotos/");
         exit;
      }

      if(isset($_POST['Cancel']))
      {
            $pht = $dbObj->cgs("tbl_albumphotos","tempthumb","photo_id",$photoid,"","","");//exit;
            $phtinfo=@mysql_fetch_assoc($pht); //getting cropimage and user id
            
            $id=$dbObj->cupdt("tbl_albumphotos", array("thumbnail","big_image"),array($phtinfo['tempthumb'],$phtinfo['tempthumb']), "photo_id",$photoid,"");
                header("location:".SITEROOT."/".$_GET['user']."/public/albumphotos/");
            exit; 
      }


   if($photoid !="")
   {
      $profileusers = $dbObj->cgs("tbl_albumphotos", array("photo_id","thumbnail"), "photo_id",$photoid, "", "", "");//exit;
      $placeinfo=@mysql_fetch_assoc($profileusers); //getting cropimage and user id
      $smarty->assign("placeinfo", $placeinfo);
      $smarty->assign("photoid",$photoid);
      // $smarty->assign("original_image_path", $original_1);
   }



   $smarty->assign("albcnt",$nums);
   $smarty->assign("tabact","photo");
   $smarty->assign("scttab","photo");
	$smarty->display(TEMPLATEDIR.'/modules/photos/picCrop.tpl');
	$dbObj->Close();
?>  