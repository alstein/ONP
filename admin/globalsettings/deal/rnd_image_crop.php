<?php
	include_once('../../../includes/SiteSetting.php');
	include_once("../../../includes/common.lib.php");
	if(!$_SESSION['duAdmId'])
		header("location:".SITEROOT . "/admin/login/index.php");
	$productid = $_GET['productid'];
	$smarty->assign("productid",$productid);
	// set thumbanil parameters
	$thumb_width = "655";	//500					// Width of thumbnail image
	$thumb_height = "355";	//380					// Height of thumbnail image

	//You do not need to alter these functions
	function getHeight($image) 
		{
			$sizes = getimagesize($image);
			$height = $sizes[1];
			return $height;
		}
	//You do not need to alter these functions
	function getWidth($image)
		{
			$sizes = getimagesize($image);
			$width = $sizes[0];
			return $width;
		}

	//You do not need to alter these functions
	function resizeThumbnailImage($thumb_image_name, $image, $width, $height, $start_width, $start_height, $scale)
		{
			$newImageWidth = ceil($width * $scale);
			$newImageHeight = ceil($height * $scale);
			$newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
			$source = imagecreatefromjpeg($image);
			imagecopyresampled($newImage,$source,0,0,$start_width,$start_height,$newImageWidth,$newImageHeight,$width,$height);
			imagejpeg($newImage,$thumb_image_name,90);
			chmod($thumb_image_name, 0777);
			return $thumb_image_name;
		}

	$rs = $dbObj->cgs("tbl_deal","product_image,product_thumbnail","product_id",$productid,"","","");
	$row = @mysql_fetch_assoc($rs);
	//$smarty->assign("image",$row['product_image']); 20100408_183354baner-img.jpg
$smarty->assign("image","leo.jpg"); 
	$upload_path = "../../../uploads/product/";
	$upload_path_thumb = "../../../uploads/product/thumbnail/";
	
	if($_GET['act'] == 'del')
	{
		$res1 = $dbObj->cgs("tbl_deal","product_thumbnail","product_id",$_GET['productid'],"","","");
		$row2 = @mysql_fetch_assoc($res1);
		unlink("../../../uploads/product/thumbnail/".$row2['product_thumbnail']);
		header("location:".SITEROOT."/admin/sitemodules/deal/image_crop.php?productid=".$_GET['productid']);
	}
	
	$large_image_location = $upload_path."leo.jpg";
	if($row['product_thumbnail'])
	{
		$thumb_image = $row['product_thumbnail'];
	}
	else
	{
		$thumb_image = "thumb_".time().".jpg";
	}
	$thumb_image_location = $upload_path_thumb.$thumb_image;

	//Check to see if any images with the same names already exist
// 	echo file_exists($large_image_location);exit;
	if(file_exists($large_image_location))
	{
		
		if(file_exists($thumb_image_location))
		{
			$thumb_photo_exists = "<img src=\"".$upload_path_thumb.$thumb_image."\" alt=\"Thumbnail Image\"/>";
		}
		else
		{
			$thumb_photo_exists = "";
		}
		$large_photo_exists = "<img src=\"".$upload_path."leo.jpg"."\" alt=\"Large Image\"/>";
		
	} 
	else 
	{
		$large_photo_exists = "";
		$thumb_photo_exists = "";
	}
	
	if(strlen($large_photo_exists)>0)
	{
		$current_large_image_width = getWidth($large_image_location);
		$current_large_image_height = getHeight($large_image_location);
	}	

		$smarty->assign("thumb_width",$thumb_width);
		$smarty->assign("thumb_height",$thumb_height);
	
		$smarty->assign("current_large_image_width",$current_large_image_width);
		$smarty->assign("current_large_image_height",$current_large_image_height);
	
		$smarty->assign("large_photo_exists",$large_photo_exists);
		$smarty->assign("thumb_photo_exists",$thumb_photo_exists);
	
	if (isset($_POST["upload_thumbnail"]) && strlen($large_photo_exists)>0) 
	{
		//Get the new coordinates to crop the image.
		$x1 = $_POST["x1"];
		$y1 = $_POST["y1"];
		$x2 = $_POST["x2"];
		$y2 = $_POST["y2"];
		$w = $_POST["w"];
		$h = $_POST["h"];
		//Scale the image to the thumb_width set above
		$scale = $thumb_width/$w;
		$cropped = resizeThumbnailImage($thumb_image_location, $large_image_location,$w,$h,$x1,$y1,$scale);
		$dbObj->cupdt("tbl_deal","product_thumbnail",$thumb_image,"product_id",$_GET['productid'],"");
		//Reload the page again to view the thumbnail
		header("location:".$site.$_SERVER["HTTP_REFERER"]);
		exit();
	}


	$smarty->display(TEMPLATEDIR.'/admin/sitemodules/deal/rnd_image_crop.tpl');
	$dbObj->Close();
?>