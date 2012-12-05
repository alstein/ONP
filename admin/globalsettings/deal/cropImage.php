<?php
include_once('../../../includes/SiteSetting.php');

// $original_image="20100423_14594920091224111129cartoon.png";
// $_SESSION['img_path']  = $original_image;

// CROP IMAGE
if($_POST['crop_photo'])
{

ini_set('memory_limit', '40M');

	//print_r($_POST);exit;
	if($_POST['x'])
	{
		extract($_POST);
		$jpeg_quality = 90;
		$target_file = "crop_".date("YmdHis").".jpg";
		$src = '../../../uploads/'.$_SESSION['img_path'];
		
		$functions = array('image/png' => 'ImageCreateFromPng','image/jpeg' => 'ImageCreateFromJpeg', 'image/gif'=> 'ImageCreateFromGif');
		
		 $size = getimagesize($src);

		// Check if mime type is listed above
		if (!$function = $functions[$size['mime']]) 
		{
			trigger_error("MIME Type unsupported: {$size['mime']}",E_USER_WARNING);
			exit;
		}
			$img_r = $function($src);
			$targ_w =609; // 655;
			$targ_h = 353; //355;
			$dst_r = ImageCreateTrueColor($targ_w, $targ_h);
		
			imagecopyresampled($dst_r, $img_r, 0, 0, $_POST['x'], $_POST['y'], $targ_w, $targ_h, $_POST['w'], $_POST['h']);
		
			imagejpeg($dst_r, "../../../uploads/product/thumbnail/".$target_file, $jpeg_quality);
			imagedestroy($img_r);
			imagedestroy($dst_r);
		$dbObj->cupdt("tbl_product_image", 'thumbnail', $target_file, "image_id", $_SESSION['image_id'], 0); 

		$_SESSION[msg]="<span color='red'>Image croped and data saved successfully.</span>";
		      header("location:".SITEROOT."/admin/sitemodules/deal/view_product_images.php?id=".$_SESSION[product_id]."&image_id=".$_SESSION[image_id]."&act=view");
		      exit;
	}
}

// $smarty->assign("inmenu","sitemodules");


$smarty->display(TEMPLATEDIR . '/admin/sitemodules/deal/cropImage.tpl');

$dbObj->Close();
?>