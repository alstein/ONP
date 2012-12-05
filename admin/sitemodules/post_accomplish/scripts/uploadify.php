<?php
include_once('../../../../includes/SiteSetting.php');
include_once('../../../../includes/common.lib.php');
session_start();
extract($_POST);

set_time_limit(500000);
$insert_id = array();
if (!empty($_FILES)) 
{
	function get_file_extension($file_name)
	{
		return substr(strrchr($file_name, '.'),1);
	}	

	$file_name = time().$_FILES['Filedata']['name'];
	$fileExtention = get_file_extension($file_name);
	$fileArray = array("jpeg", "jpg", "png", "gif","JPEG","JPG","PNG","GIF");

	$ourFileName = "testFile.txt";
	$ourFileHandle = fopen($ourFileName, 'a') or die("can't open file");

	if(in_array($fileExtention, $fileArray))
	{
		@move_uploaded_file($_FILES['Filedata']['tmp_name'],"../../../../uploads/post_accomplish/".$file_name);
		$original['name'] = $file_name;
		$original['tmp_name'] = "../../../../uploads/post_accomplish/".$file_name;
	
		$size = getimagesize($original['tmp_name']);
		$tmp_name = $_FILES['Filedata']['tmp_name'];
		$imagesize=$size[0]*$size[1];
	
		include_once("../../../../includes/upload.inc.php");
		$yukle = new upload;

		// Upload file Using Upload INC file
		$yukle->set_max_size(1018463000);

		//      $userimagename=time();
		$yukle->set_directory("../../../../uploads/post_accomplish");
		$tname = $yukle->set_tmp_name($_FILES['Filedata']['tmp_name']);
		$tsize =  $yukle->set_file_size($_FILES['Filedata']['size']);
		$ttype = $yukle->set_file_type($_FILES['Filedata']['type']);
		$yukle->set_file_name($file_name);
	
		$yukle->set_thumbnail_name("/600X600/".$file_name);
		$yukle->create_thumbnail();
		$yukle->set_thumbnail_size(600, 600);

		$yukle->set_thumbnail_name("/400X400/".$file_name);
		$yukle->create_thumbnail();
		$yukle->set_thumbnail_size(400, 400);
	
		$yukle->set_thumbnail_name("/145X145/".$file_name);
		$yukle->create_thumbnail();
		$yukle->set_thumbnail_size(145, 145);
	
		$yukle->set_thumbnail_name("/90X90/".$file_name);
		$yukle->create_thumbnail();
		$yukle->set_thumbnail_size(90, 90);
	
		$yukle->set_thumbnail_name("/52X52/".$file_name);
		$yukle->create_thumbnail();
		$yukle->set_thumbnail_size(52, 52);

		// create thumbnail
		//$original_1 = newgeneralfileupload($_FILES['photo'], "../../../../uploads/post_accomplish", true);
		$path = "../../../../uploads/post_accomplish/thumbnail/";
		$width_array  = array(145);
		$height = 145;
		$path_array = array($path);
		resize_multiple_images_new($original, $width_array, $path_array, $height);
		//crop_image_userdifine($file_name, $path,145,145);

		$path = "../../../../uploads/post_accomplish/413X270/";
		$width_array  = array(413);
		$height = 270;
		$path_array = array($path);
		resize_multiple_images_new($original, $width_array, $path_array, $height);



// 		if($album_url=="")
// 			$album_url = "ZingPhotos";
		
		//write upload details in the file
		$res = $dbObj->gj("tbl_album", "album_id", "url_title = '".$album_url."'", "", "", "", "", "");
		$row = @mysql_fetch_assoc($res);

		if($row['album_id'] != "")
			$album_id = $row['album_id'];
		else 
			$album_id = '1';

		$updtid = $dbObj->cupdt("tbl_album", "edited_date" , date("Y-m-d H:i:s"), "album_id", $album_id, "");
		$sf_arr=array("album_id", "image","added_by","added_date","recent");
		$sv_arr=array($album_id, $file_name, $userid, date("Y-m-d H:i:s"),"1");
	
		$insert_id[]=$dbObj->cgi("tbl_accomplishment_photo_temp",$sf_arr,$sv_arr,"");

		@unlink('../../../../uploads/post_accomplish/'.$file_name);
		$_SESSION['msg']="<span class='success'> Photos Added successfully </span>";
		$_SESSION['insert_id'] = $insert_id;
		$msg = "<span class='success'> Photos Added successfully </span>";

		$stringData = "album_url: ".$_REQUEST['album_url']." user: ".$userid." album id = --".$row['album_id']." finally we reach the ED of the page...\n\n";
		fwrite($ourFileHandle, $stringData);
		fclose($ourFileHandle);

		echo "1";
	}
	else
	{
		echo 'Invalid file type.';
	}
	//return $insert_id;
}
?>