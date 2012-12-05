<?php
include_once('../../../includes/SiteSetting.php');
include_once('../../../includes/common.lib.php');
extract($_GET);
extract($_REQUEST);

//	$id1 = $_REQUEST['id1'];
if (!empty($_FILES)) 
{
	function get_file_extension($file_name)
	{
		return substr(strrchr($file_name, '.'),1);
	}	

	$file_name = time().$_FILES['Filedata']['name'];
	$fileExtention = get_file_extension($file_name);
	$fileArray = array("jpeg", "jpg", "png", "gif","JPEG","JPG","PNG","GIF");

	if(in_array($fileExtention, $fileArray))
	{												
			move_uploaded_file($_FILES['Filedata']['tmp_name'],"../uploads/".$file_name);

			$original['name'] = $file_name;	
			$original['tmp_name'] = "../uploads/".$file_name;

			$path = "../../../uploads/album/photo/180X158/";
			$width_array  = array(180);
			$height = 158;
			$path_array = array($path);
			resize_multiple_images_new($original, $width_array, $path_array, $height);

			$path = "../../../uploads/album/photo/thumbnail/";
			$width_array  = array(145);
			$height = 145;
			$path_array = array($path);
			resize_multiple_images_new($original, $width_array, $path_array, $height); // image crop

			$path = "../../../uploads/album/photo/bigimage/";
			$width_array  = array(400);
			$height = 250;
			$path_array = array($path);
			resize_multiple_images_new($original, $width_array, $path_array, $height); // image crop

			$path = "../../../uploads/album/photo/132X101/";
			$width_array  = array(132);
			$height = 101;
			$path_array = array($path);
			resize_multiple_images_new($original, $width_array, $path_array, $height); // image crop
		
			$path = "../../../uploads/album/photo/400X300/";
			$width_array  = array(300);
			$height = 400;
			$path_array = array($path);
			resize_multiple_images_new($original, $width_array, $path_array, $height); // image crop

			$path = "../../../uploads/album/photo/600X600/";
			$width_array  = array(600);
			$height = 387;
			$path_array = array($path);
			resize_multiple_images_new($original, $width_array, $path_array, $height); // image crop

			$sf_arr=array("thumbnail","added_date");
			$sv_arr=array($file_name,date("Y-m-d H:i:s"));
			$update_details=$dbObj->cupdt("tbl_albumphotos",$sf_arr,$sv_arr,"album_id",$id,"");	

			echo "1";	
	}
	else
	{
		echo 'Invalid file type.';
	}
 }
?>