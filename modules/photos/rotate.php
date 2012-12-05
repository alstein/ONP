<?php
 function rotatephoto($photoid,$rotatedegree)
        {
        $degree=0;
        $photo_path=$this->getInfo("photos","photo_path","photo_id",$photoid);
//         echo $photo_path;exit;
        if($rotatedegree=='nclk')
        {
        	$degree=270;
        }
        else if($rotatedegree=='ncountclk')
        {
                $degree=90;
        }
        else if($rotatedegree=='halfclk')
        {
       		 $degree=180;
        }
        
        $photo1="../../uploads/photos/thumbnail/large/".$photo_path;
        $this->getimageforrotate($degree,$photo1);
        $photo2="../../uploads/photos/thumbnail/vlarge/".$photo_path;
        $this->getimageforrotate($degree,$photo2);
        $photo3="../../uploads/photos/thumbnail/vsmall/".$photo_path;
        $this->getimageforrotate($degree,$photo3);
        $photo4="../../uploads/photos/thumbnail/small/".$photo_path;
        $this->getimageforrotate($degree,$photo4);
        $photo5="../../uploads/photos/thumbnail/medium/".$photo_path;
        $this->getimageforrotate($degree,$photo5);
        $photo6="../../uploads/photos/thumbnail/medium_new/".$photo_path;
        $this->getimageforrotate($degree,$photo6);
         $photo7="../../uploads/photos/thumbnail/large_new/".$photo_path;
        $this->getimageforrotate($degree,$photo7);        
}

function getimageforrotate($degree,$photo)
{
$imageinfo=getimagesize($photo);
  switch($imageinfo['mime'])
  {
   //create the image according to the content type
   case "image/jpg":
   case "image/jpeg":
   case "image/pjpeg": //for IE
        $src_img=imagecreatefromjpeg($photo);
                break;
    case "image/gif":
        $src_img = imagecreatefromgif($photo);
                break;
    case "image/png":
        case "image/x-png": //for IE
        $src_img = imagecreatefrompng($photo);
                break;
        
        }
//         print_r($src_img);exit;
        $rotate = imagerotate($src_img, $degree, 0);
                switch($imageinfo['mime'])
  {
   //create the image according to the content type
   case "image/jpg":
   case "image/jpeg":
   case "image/pjpeg": //for IE
        imagejpeg($rotate,$photo);
                break;
    case "image/gif":
        imagegif($rotate,$photo);
                break;
    case "image/png":
        case "image/x-png": //for IE
       imagepng($rotate,$photo);
                break;
        
        }
}
?>