<?php
//require_once("../includes/classes/class.imagick.php");
@header('Content-type: image/jpeg');
$image = new Imagick('../uploads/demo_upload/20121111_154249138orig6icon_vallarta_balcony.jpg');
$image->thumbnailImage(100, 0);
//echo $image;
$filename=$image->getFilename();
$image->writeImage('../uploads/user/thumbnail/somefile.jpg');
//$im = new Imagick($image);
//$im->writeImages("../uploads/user/thumbnail/".$image, true);
exit;
?>
