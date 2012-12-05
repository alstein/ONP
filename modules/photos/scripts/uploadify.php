<?php
include_once('../../../includes/SiteSetting.php');
include_once('../../../includes/common.lib.php');

extract($_GET);
extract($_POST);
extract($_REQUEST);

set_time_limit(500000);


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

  
            move_uploaded_file($_FILES['Filedata']['tmp_name'],"../../../uploads/album/photo/".$file_name);
            $original['name'] = $file_name;
            $original['tmp_name'] = "../../../uploads/album/photo/".$file_name;

            $size = getimagesize($original['tmp_name']);
            $tmp_name = $_FILES['Filedata']['tmp_name'];
            $imagesize=$size[0]*$size[1];

            //upload photo as album cover
            if($_SESSION['newupload']=="")
            {
                     // for resize details
                     $path = "../../../uploads/album/thumbnail/";
                     $width_array  = array(132);
                     $height = 101;
                     $path_array = array($path);
                     resize_multiple_images_new($original, $width_array, $path_array, $height); // image crop

                     // for resize details
                     $path = "../../../uploads/album/180X158/";
                     $width_array  = array(180);
                     $height = 158;
                     $path_array = array($path);
                     resize_multiple_images_new($original, $width_array, $path_array, $height); // image crop

                     $_SESSION['newupload'] = "1";
              }



/*-----    Resize photo with good Quality function     ----*/

require("../../../includes/classes/upload.inc.php");
      	



         // Defining Class
         $yukle = new upload;





         // Upload file Using Upload INC file
         $yukle->set_max_size(1018463000);
   //      $userimagename=time();
         $yukle->set_directory("../../../uploads/album/photo");
         $tname = $yukle->set_tmp_name($_FILES['Filedata']['tmp_name']);
         $tsize =  $yukle->set_file_size($_FILES['Filedata']['size']);
         $ttype = $yukle->set_file_type($_FILES['Filedata']['type']);
         $yukle->set_file_name($file_name);
      
         $yukle->set_thumbnail_name("/600X600/".$file_name);   
         $yukle->create_thumbnail();
         $yukle->set_thumbnail_size(720, 470);

         //write upload details in the file
        // $stringData = "name: ".$file_name." size: ".$imagesize." type: ".$fileExtention." ".$_SESSION['newupload']." ".$_SESSION['newupload']."\n\n";



         $yukle->set_thumbnail_name("/180X158/".$file_name);
         $yukle->create_thumbnail();
         $yukle->set_thumbnail_size(180, 158);

         $yukle->set_thumbnail_name("/thumbnail/".$file_name);
         $yukle->create_thumbnail();
         $yukle->set_thumbnail_size(145, 145);

         $yukle->set_thumbnail_name("/bigimage/".$userimagename.$file_name);
         $yukle->create_thumbnail();
         $yukle->set_thumbnail_size(400, 250);

         $yukle->set_thumbnail_name("/132X101/".$userimagename.$file_name);
         $yukle->create_thumbnail();
         $yukle->set_thumbnail_size(132, 101);

         $yukle->set_thumbnail_name("/400X300/".$userimagename.$file_name);
         $yukle->create_thumbnail();
         $yukle->set_thumbnail_size(300, 400);



	$sf_arr=array("user_id","album_id","thumbnail","big_image","added_date");
	$sv_arr=array($id,$album,$file_name,$file_name,date("Y-m-d H:i:s"));
	$insert_details=$dbObj->cgi("tbl_albumphotos",$sf_arr,$sv_arr,"");	

//$a=implode(",",$sf_arr);
//$b=implode(",",$sv_arr);


         $_SESSION['newupload']= $_SESSION['newupload']+1; 
         @unlink('../../../uploads/album/photo/'.$file_name);
         echo "1";
	}
	else
	{
		echo 'Invalid file type.';
	}
}
?>
