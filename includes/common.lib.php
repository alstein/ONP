<?php
/**************************************************************************************************************************************
1	Normal File upload		:  generalfileupload($original , $foldername)
2  	Imageuploadwithresizing :  resizingimage($original, $bigimage, $thumbnail, $height, $width)
3	Country name using id	:	getcountryname($countryid, $dbObj, $tbl)
4	Padding to digits		:	PadDigit($digit)
5	Removing padding		:	RemovePad($digit)
6	mailsend using phpmailer:	sendmailer($sender, $sendername, $subject, $mailcontent, $receiver, $receivername)
7	send html email 		:	SendHTMLMail($to,$subject,$mailcontent,$from)
8	normal mail function	:	SendMail($to,$subject,$mailcontent,$from)
9	random password geneart :   randompasword()
10	Calucaltes age of person:	get_age($dob)
11	Encoding IP address		:	encode_ip($dotquad_ip)
12	Decoding IP address		:	decode_ip($dotquad_ip)
13	Binary to ASCII			:	bin2asc($binaryInput, $byteLength=8)
14	ASCII to Binary			:	asc2bin($inputstring, $byteLength=8)
**************************************************************************************************************************************/

/********************************************************************
  General file uploading
******************************************************************/


	function getLATIANDLONG($address){
		$totle = $address;
		
		if($_SERVER['HTTP_HOST'] == "192.168.0.58"){
			//	for local
			$apikey = "ABQIAAAAtXcQkYCBfW9cuqqM52aU0BTB1yehqaEkcV91sklpH2qWTrnldxSya6yfG2iKUiReyQqYb1F-EKrN9g";
		}else{
			//	for server
			$apikey = "ABQIAAAAtXcQkYCBfW9cuqqM52aU0BTgbArCeR4NR2Nuv0H4dteBvNvGTRTPUg2KQ9NAKLnvWYM2to18DtfjSg";
		}

		//header ("content-type: text/xml");

		$address1 = urlencode($totle);
		$url = "http://maps.google.com/maps/geo?q=$address1&output=xml&oe=utf8&sensor=false&key=$apikey";
		$ch = curl_init();
                curl_setopt($ch, CURLOPT_TIMEOUT, 5000);
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$data = curl_exec($ch);
 		preg_match_all('@<coordinates>(.*?)</coordinates>@s', $data, $matches, PREG_PATTERN_ORDER); 
		
		$pass = explode(",",$matches[0][0]);
// 		print_r($pass);
		$lat = $pass[0];
		$long = $pass[1];
		$mix = $long.",".$lat;
		return $mix;

	}
	
function newgeneralfileupload($original,$foldername, $nameflag)
   {

      if($original['name']!== "")
      {
         if($nameflag)
            $newname = date("Ymd_His").str_replace(" ", "_", $original['name']);
         else
            $newname = $original['name'];

         $fullpath = $foldername."/".$newname;
         $cpy = copy($original['tmp_name'], $fullpath);

         if($cpy) return $newname;
         else return 0;
      }

   }
   
   
//NEW resize function for image resize in specific size
function resize_multiple_images_new($file_parameter,$width_array,$path_array,$height_array,$dbi=100)
{
   $image =$file_parameter["name"];
   $uploadedfile = $file_parameter['tmp_name']; 

   if ($image) 
   {
      $filename = stripslashes($file_parameter['name']);    
      $extension = getExtension($filename);
      $extension = strtolower($extension);
   
      //if($extension == 'gif')
      //{
         resize_multiple_images_gif($file_parameter,$width_array,$path_array,$height_array,$dbi=100);
      //}
      //else
      //{
      // resize_multiple_images_other_than_gif($file_parameter, $width_array, $height_array, $newfilename, $path_array);
      //}
   }
}

 define ("MAX_SIZE","400");
 function getExtension($str) {
         $i = strrpos($str,".");
         if (!$i) { return ""; }
         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
 }


function resize_multiple_images_gif($file_parameter,$width_array,$path_array,$height_array,$dbi=100)
{
   $image =$file_parameter["name"];
   $uploadedfile = $file_parameter['tmp_name'];

   
   if($image) 
   {
      $filename = stripslashes($file_parameter['name']);    
      $extension = getExtension($filename);
      $extension = strtolower($extension);

      if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) 
      {
         $change='<div class="msgdiv">Unknown Image extension </div> ';
         $errors=1;
         return "error";
      }
      else
      {
         $size=filesize($file_parameter['tmp_name']);

         if ($size > MAX_SIZE*1024)
         {
            $change='<div class="msgdiv">You have exceeded the size limit!</div> ';
            $errors=1;
         }
         if($extension=="jpg" || $extension=="jpeg" )
         {
            $uploadedfile = $file_parameter['tmp_name'];
            $src = imagecreatefromjpeg($uploadedfile);
         }
         else if($extension=="png")
         {
            $uploadedfile = $file_parameter['tmp_name'];
            $src = imagecreatefrompng($uploadedfile);       
         }
         else 
         {
            $src = imagecreatefromgif($uploadedfile);
         }
         echo $scr;
         list($width,$height)=getimagesize($uploadedfile);
         for($i=0;$i<sizeof($width_array);$i++)
         {
            if($height_array){
               $newheight = $height_array;
            }
            else{
               $newheight=($height/$width)*$width_array[$i];
            }
            $newwidth=$width_array[$i];

            $tmp=imagecreatetruecolor($newwidth,$newheight);

            imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
            $filename = $path_array[$i].$file_parameter['name'];
            imagejpeg($tmp,$filename,$dbi);
            
            imagedestroy($tmp);
         }
         imagedestroy($src);
         return($file_parameter['name']);
      }
   }
}



	function generalfileupload($original,$foldername,$nameflag=1){
		if($original['name']!== ""){
			if($nameflag)
				$newname = time().str_replace(" ", "_", $original['name']);
			else
				$newname = time().$original['name'];

			$fullpath = $foldername."/".$newname;

			$cpy = copy($original['tmp_name'],$fullpath);

			if($cpy) return $newname;
			else return 0;
		}
	}

// 	function uploadandresize($original, $bigImgPath, $thumbPath, $height, $width)
// 	{
// 		if($original['name']!== "")
// 		{
// 			$image_type = $original["type"];
// 			if($image_type=="image/pjpeg" || $image_type=="image/jpeg" || $image_type=="image/gif" || $image_type=="image/png" || $img_type="image/x-png")
// 			{
// 				include_once("resize.php");
// 				$DEST_FILE= $bigImgPath . "/" . date("YmdHis") . str_replace(" ", "_", $original['name']);
// 				$THUMB_FILE= $thumbPath . "/" . date("YmdHis") . str_replace(" ", "_", $original['name']);
// 				copy($original['tmp_name'],  $DEST_FILE);
// 				$thumb=new thumbnail($DEST_FILE);			// generate image_file, set filename to resize
// 				$thumb->size_width($width);				// set width for thumbnail, or
// 				$thumb->size_height($height);				// set height for thumbnail, or
// 				if($width > $height)
// 					$thumb->size_auto($width);					// set the biggest width or height for thumbnail
// 				else
// 					$thumb->size_auto($height);
// 
// 				$thumb->jpeg_quality(75);				// [OPTIONAL] set quality for jpeg only (0 - 100) (worst - best), default = 75
// 				$thumb->jpeg_quality(75);
// 				$thumb->save($THUMB_FILE);
// 				$photos = array('thumbnail'=>basename($THUMB_FILE), 'bigphoto'=>basename($DEST_FILE));
// 				return $photos;
// 			}
// 		}
// 	}


   function uploadandresize($original)
   {
      if($original['name']!== "")
      {
         $image_type = $original["type"];
         if($image_type=="image/pjpeg" || $image_type=="image/jpeg" || $image_type=="image/gif" || $image_type=="image/png" || $img_type="image/x-png")
         {
             include_once("upload.inc.php");
            $userimagename=time();
            $imagename=str_replace(" ", "_", $original['name']);
            // Defining Class
            $yukle = new upload;
            
            // Set Max Size
            $yukle->set_max_size(4000000);
            
            // Set Directory
            $yukle->set_directory("../../uploads/product");
            
            // Do not change
            // Set Temp Name for upload, $_FILES['file']['tmp_name'] is automaticly get the temp name
            $yukle->set_tmp_name($original['tmp_name']);
            
            // Do not change
            // Set file size, $_FILES['file']['size'] is automaticly get the size
            $yukle->set_file_size($original['size']);
            
            // Do not change
            // Set File Type, $_FILES['file']['type'] is automaticly get the type
            $yukle->set_file_type($original['type']);
            
            // Set File Name, $_FILES['file']['name'] is automaticly get the file name.. you can change
            $yukle->set_file_name($userimagename.$imagename);
            
            // Start Copy Process
            $yukle->start_copy();
            
            // If uploaded file is image, you can resize the image width and height
            // Support gif, jpg, png
            $yukle->resize(0,0);
            $image=$yukle->set_thumbnail_name($userimagename);
            // 332 X 290
            $yukle->set_thumbnail_name("../../uploads/product/thumb332X290/".$userimagename);
            $yukle->create_thumbnail();
            $yukle->set_thumbnail_size(332, 290);
            
              // 76 X 64
            $yukle->set_thumbnail_name("../../uploads/product/thumb76X64/".$userimagename);
            $yukle->create_thumbnail();
            $yukle->set_thumbnail_size(76, 64);
            
              // 588  X 288
            $yukle->set_thumbnail_name("../../uploads/product/thumb588X288/".$userimagename);
            $yukle->create_thumbnail();
            $yukle->set_thumbnail_size(588, 288);
           
            return $image;
         }
      }
   }
   
   
   
    function uploadandresize1($original,$i)
   {
      if($original['name'][$i]!== "")
      {
         $image_type = $original["type"][$i];
         if($image_type=="image/pjpeg" || $image_type=="image/jpeg" || $image_type=="image/gif" || $image_type=="image/png" || $img_type="image/x-png")
         {
             include_once("upload.inc.php");
            $userimagename=time()."_".$original['name'][$i];
            $imagename=str_replace(" ", "_", $original['name'][$i]);
            // Defining Class
            $yukle = new upload;
            
            // Set Max Size
            $yukle->set_max_size(4000000);
            
            // Set Directory
            $yukle->set_directory("../../uploads/product");
            
            // Do not change
            // Set Temp Name for upload, $_FILES['file']['tmp_name'] is automaticly get the temp name
            $yukle->set_tmp_name($original['tmp_name'][$i]);
            
            // Do not change
            // Set file size, $_FILES['file']['size'] is automaticly get the size
            $yukle->set_file_size($original['size'][$i]);
            
            // Do not change
            // Set File Type, $_FILES['file']['type'] is automaticly get the type
            $yukle->set_file_type($original['type'][$i]);
            
            // Set File Name, $_FILES['file']['name'] is automaticly get the file name.. you can change
            $yukle->set_file_name($userimagename.$imagename);
            
            // Start Copy Process
            $yukle->start_copy();
            
            // If uploaded file is image, you can resize the image width and height
            // Support gif, jpg, png
            $yukle->resize(0,0);
            $image=$yukle->set_thumbnail_name1($userimagename);
            // 332 X 290
            $yukle->set_thumbnail_name1("thumb332X290/".$userimagename);
            $yukle->create_thumbnail();
            $yukle->set_thumbnail_size(332, 290);
            
              // 76 X 64
            $yukle->set_thumbnail_name1("thumb76X64/".$userimagename);
            $yukle->create_thumbnail();
            $yukle->set_thumbnail_size(76, 64);
            
              // 588  X 288
            $yukle->set_thumbnail_name1("thumb588X288/".$userimagename);
            $yukle->create_thumbnail();
            $yukle->set_thumbnail_size(588, 288);
           
            return $image;
         }
      }
   }
    function uploadandresizedeal($original,$i)
   {
      if($original['name'][$i]!== "")
      {
         $image_type = $original["type"][$i];
         if($image_type=="image/pjpeg" || $image_type=="image/jpeg" || $image_type=="image/gif" || $image_type=="image/png" || $img_type="image/x-png")
         {
             include_once("upload.inc.php");
             $userimagename=time()."_".$original['name'][$i];
            $imagename=str_replace(" ", "_", $original['name'][$i]);
            // Defining Class
            $yukle = new upload;
            
            // Set Max Size
            $yukle->set_max_size(4000000);
            
            // Set Directory
            $yukle->set_directory("../../../uploads/product");
            
            // Do not change
            // Set Temp Name for upload, $_FILES['file']['tmp_name'] is automaticly get the temp name
            $yukle->set_tmp_name($original['tmp_name'][$i]);
            
            // Do not change
            // Set file size, $_FILES['file']['size'] is automaticly get the size
            $yukle->set_file_size($original['size'][$i]);
            
            // Do not change
            // Set File Type, $_FILES['file']['type'] is automaticly get the type
            $yukle->set_file_type($original['type'][$i]);
            
            // Set File Name, $_FILES['file']['name'] is automaticly get the file name.. you can change
            $yukle->set_file_name($userimagename.$imagename);
            
            // Start Copy Process
            $yukle->start_copy();
            
            // If uploaded file is image, you can resize the image width and height
            // Support gif, jpg, png
            $yukle->resize(0,0);
            $image=$yukle->set_thumbnail_name1($userimagename);

              // 76 X 64
            $yukle->set_thumbnail_name1("thumb76X64/".$userimagename);
            $yukle->create_thumbnail();
            $yukle->set_thumbnail_size(76, 64);

            // 332 X 290
            $yukle->set_thumbnail_name1("thumb332X290/".$userimagename);
            $yukle->create_thumbnail();
            $yukle->set_thumbnail_size(332, 290);
 
              // 588  X 288
            $yukle->set_thumbnail_name1("thumb588X288/".$userimagename);
            $yukle->create_thumbnail();
            $yukle->set_thumbnail_size(588, 288);
           
            return $image;
         }
      }
   }

    function uploadandresizeEditDeal($original,$i,$oldimage)
    {
      $image="";
      if($original['name'][$i]!== "")
      {
         $image_type = $original["type"][$i];
         if($image_type=="image/pjpeg" || $image_type=="image/jpeg" || $image_type=="image/gif" || $image_type=="image/png" || $img_type="image/x-png")
         {
             include_once("upload.inc.php");
             $userimagename=time()."_".$original['name'][$i];
            $imagename=str_replace(" ", "_", $original['name'][$i]);
            // Defining Class
            $yukle = new upload;
            
            // Set Max Size
            $yukle->set_max_size(4000000);
            
            // Set Directory
            $yukle->set_directory("../../../uploads/product");
            
            // Do not change
            // Set Temp Name for upload, $_FILES['file']['tmp_name'] is automaticly get the temp name
            $yukle->set_tmp_name($original['tmp_name'][$i]);
            
            // Do not change
            // Set file size, $_FILES['file']['size'] is automaticly get the size
            $yukle->set_file_size($original['size'][$i]);
            
            // Do not change
            // Set File Type, $_FILES['file']['type'] is automaticly get the type
            $yukle->set_file_type($original['type'][$i]);
            
            // Set File Name, $_FILES['file']['name'] is automaticly get the file name.. you can change
            $yukle->set_file_name($userimagename.$imagename);
            
            // Start Copy Process
            $yukle->start_copy();
            
            // If uploaded file is image, you can resize the image width and height
            // Support gif, jpg, png
            $yukle->resize(0,0);
            $image=$yukle->set_thumbnail_name1($userimagename);

              // 76 X 64
            $yukle->set_thumbnail_name1("thumb76X64/".$userimagename);
            $yukle->create_thumbnail();
            $yukle->set_thumbnail_size(76, 64);

            // 120 X140
            $yukle->set_thumbnail_name1("thumb332X290/".$userimagename);
            $yukle->create_thumbnail();
            $yukle->set_thumbnail_size(332, 290);
 
              // 588  X 288
            $yukle->set_thumbnail_name1("thumb588X288/".$userimagename);
            $yukle->create_thumbnail();
            $yukle->set_thumbnail_size(588, 288);

         }
      }
      else if($oldimage != '')
      {
          $image.=$oldimage;
      }
      return $image;
    }

/*******************************************************************
new resizing function
/*******************************************************************/

    function resizingimagenew($original, $bigimage, $thumbnail, $height, $width)
	{
		if($original['name']!== "")
		{ //start of loop
			$target_path = $bigimage.'/';
			$basename=time().basename($original['name']);
			//$basename="big".time();
			$target_path = $target_path.$basename;

			$SMALL_IMAGE_PATH= $thumbnail;
			$SMALL_IMAGE_NEW_WIDTH= $height;
			$SMALL_IMAGE_NEW_HEIGHT= $width;

			$image_name = $original["name"];
			$image_type = $original["type"];
			$image_temp = $original["tmp_name"];

	 		$uniquepriceid =md5(uniqid(rand()));

			if($image_type=="image/pjpeg" || $image_type=="image/jpeg" || $image_type=="image/gif")
      	 	{
			   $v_value=uniqid(date(s));
			   if($image_type=="image/pjpeg" || $image_type== "image/gif" || $image_type=="image/jpeg")
			   {


					 $SMALL_IMAGE_NEW_WIDTH= $width;
					 $SMALL_IMAGE_NEW_HEIGHT= $height;

				   if($image_type=="image/jpeg" || $image_type=="image/pjpeg")
				   {
						$smallimage_name="thumb".$v_value.".jpg";
						$smallimage_path =$SMALL_IMAGE_PATH."/".$smallimage_name;
						$im = ImageCreateFromJPEG($image_temp);
						if(!$im)
						$Error = 6;
					}
					if($image_type=="image/gif")
					{
						 $smallimage_name="thumb".$v_value.".gif";
						 $smallimage_path =$SMALL_IMAGE_PATH."/".$smallimage_name;
						 $im = ImageCreateFromGIF($image_temp);
					}

					 $OldWidth  = ImageSX($im);
					 $OldHeight = ImageSY($im);
					 $small_image = imagecreatetruecolor ($SMALL_IMAGE_NEW_WIDTH, $SMALL_IMAGE_NEW_HEIGHT );
				ImageCopyResized($small_image,$im,0,0,0,0,$SMALL_IMAGE_NEW_WIDTH, $SMALL_IMAGE_NEW_HEIGHT, $OldWidth,$OldHeight);
					 ImageJpeg($small_image,$smallimage_path,180);

					 //$bigimagename=time();

						if($image_type=="image/jpeg" || $image_type=="image/pjpeg")
						{
							$bigimagename = "big".$v_value.".jpg";
						}
						else if($image_type=="image/gif")
						{
							$bigimagename = "big".$v_value.".gif";
						}

					 $bigimagepath = $bigimage."/".$bigimagename;
					 $LARGE_IMAGE_NEW_WIDTH = $OldWidth;
					 $LARGE_IMAGE_NEW_HEIGHT = $OldHeight;

					 $big_image = imagecreatetruecolor ($LARGE_IMAGE_NEW_WIDTH, $LARGE_IMAGE_NEW_HEIGHT );
					 ImageCopyResized($big_image,$im,0,0,0,0, $LARGE_IMAGE_NEW_WIDTH, $LARGE_IMAGE_NEW_HEIGHT , $OldWidth,$OldHeight);
					 ImageJpeg($big_image,$bigimagepath,180);


					 @copy($big_image, $bigimagepath);
					//echo $smallimage_name;
					 if($bigimagename && $smallimage_name)
					  {
					 	$imagenames = array($bigimagename, $smallimage_name);
						return $imagenames;
					 }

				}
			}
		}
	}
	
	function isValidEmail($email){
		return eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email);
	}


	function uniqueId($length){
		//set the random id length 
		$random_id_length = $length; 
		//generate a random id encrypt it and store it in $rnd_id 
		$rnd_id = crypt(uniqid(rand(),1)); 
		//to remove any slashes that might have come 
		$rnd_id = strip_tags(stripslashes($rnd_id)); 
		//Removing any . or / and reversing the string 
		$rnd_id = str_replace(".","",$rnd_id); 
		$rnd_id = strrev(str_replace("/","",$rnd_id)); 
		//finally I take the first 10 characters from the $rnd_id 
		$rnd_id = substr($rnd_id,0,$random_id_length); 
		return $rnd_id;
	}
/********************************************************************
   Created by : Archana Mapari
   Date       : 22/11/2008
   Runtime resizing of image
********************************************************************/
    function resizingimage_bysize($original, $bigimage, $thumbnail, $height, $width)
	{
		if($original['name']!== "")
		{ //start of loop
			$target_path = $bigimage.'/';
			$basename=time().basename($original['name']);
			$target_path = $target_path.$basename;

			$SMALL_IMAGE_PATH= $thumbnail;
			$SMALL_IMAGE_NEW_WIDTH= $width;
			$SMALL_IMAGE_NEW_HEIGHT= $height;

			$image_name = $original["name"];
			$image_type = $original["type"];
			 $image_temp = $original["tmp_name"];

	 		$uniquepriceid =md5(uniqid(rand()));
      	 	if($image_type=="image/pjpeg" || $image_type=="image/jpeg" || $image_type=="image/gif")
      	 	{
			   $v_value=uniqid(date(s));
			   if($image_type=="image/pjpeg" || $image_type== "image/gif" || $image_type=="image/jpeg")
			   {
				   $mysock = getimagesize($image_temp);
					$target=100;

					 $SMALL_IMAGE_NEW_WIDTH= $width;
					 $SMALL_IMAGE_NEW_HEIGHT= $height;

				   if($image_type=="image/jpeg" || $image_type=="image/pjpeg")
				   {
						$smallimage_name="thumb".$v_value.".jpg";
						$smallimage_path =$SMALL_IMAGE_PATH."/".$smallimage_name;
						$im = ImageCreateFromJPEG($image_temp);
						if(!$im)
						$Error = 6;
					}

					if($image_type=="image/gif")
					{
						 $smallimage_path =$SMALL_IMAGE_PATH."/".$smallimage_name;
						 $im = ImageCreateFromGIF($image_temp);
					}

					 $OldWidth  = ImageSX($im);
					 $OldHeight = ImageSY($im);
					 $small_image = imagecreatetruecolor ($SMALL_IMAGE_NEW_WIDTH, $SMALL_IMAGE_NEW_HEIGHT );
					 ImageCopyResized($small_image,$im,0,0,0,0,$SMALL_IMAGE_NEW_WIDTH, $SMALL_IMAGE_NEW_HEIGHT, $OldWidth,$OldHeight);
					 ImageJpeg($small_image,$smallimage_path,100);

						if($image_type=="image/jpeg" || $image_type=="image/pjpeg")
						{
							$bigimagename = "big".$v_value.".jpg";
						}
						else if($image_type=="image/gif")
						{
							$bigimagename = "big".$v_value.".gif";
						}

					 $bigimagepath = $bigimage."/".$bigimagename;
					 $LARGE_IMAGE_NEW_WIDTH = $OldWidth;
					 $LARGE_IMAGE_NEW_HEIGHT = $OldHeight;

					 $big_image = imagecreatetruecolor ($LARGE_IMAGE_NEW_WIDTH, $LARGE_IMAGE_NEW_HEIGHT );
					 ImageCopyResized($big_image,$im,0,0,0,0, $LARGE_IMAGE_NEW_WIDTH, $LARGE_IMAGE_NEW_HEIGHT , $OldWidth,$OldHeight);
					 ImageJpeg($big_image,$bigimagepath,100);

					 @copy($big_image, $bigimagepath);

					 if($bigimagename && $smallimage_name)
					  {
					 	$imagenames = array($bigimagename, $smallimage_name);
						return $imagenames;
					 }

				}
			}
		}
	}


//padding to one length numerics
  function PadDigit($digit)
  {
    if($digit<=9)
      $digit = "0".$digit;
    return $digit;
  }
/********************************************************************
    Remove Pad Ex 01 becomes 1
********************************************************************/

  function RemovePad($digit)
  {
    if($digit[0]=='0')
      $ret = $digit[1];
    else
      $ret = $digit;
    return $ret;
  }


 /********************************************************************
   Mail sending using PHP mailer function
 ********************************************************************/
//  function sendmailer($sender, $sendername, $subject, $mailcontent, $receiver, $receivername, $attachment="")
//  {
//  	include_once("class.sendmail.php");
//  	$mail = new sendmail();
//  	$flag = $mail->send_comman_mail_attachment($receiver, $subject, $mailcontent, $sendername, $sender, $attachment);
// 
// 	return $flag;
//  }
 /******************************************************************************************
	 Random password generator
 *****************************************************************************************/
function randompassword()
{
	 $password = "";
	  $possible = "0123456789bcdfghjkmnpqrstvwxyz";
	  $i = 0;

	while ($i < 8)
	{
	   $char = substr($possible, mt_rand(0, strlen($possible)-1), 1);

	   if (!strstr($password, $char))
	   {
		$password .= $char;
		$i++;
		}
	}
	return $password;
 }
 /******************************************************************************************
//calculate the age of the persons
******************************************************************************************/
function get_age($dob)
{
    $ageparts = explode("-",$dob);
    $today = date('Y-m-d');
    $todayparts = explode("-",$today);
    $age=  $todayparts[0]-$ageparts[0];
    $month=$todayparts[1]-$ageparts[1];
    $day=  $todayparts[2]-$ageparts[2];
    return floor($age+($month/12)+($day/365));
}
/******************************************************************************************
	Encodes the IP Address
******************************************************************************************/
function encode_ip($dotquad_ip)
{
	$ip_sep = explode('.', $dotquad_ip);
	return sprintf('%02x%02x%02x%02x', $ip_sep[0], $ip_sep[1], $ip_sep[2], $ip_sep[3]);
}
/******************************************************************************************
	Encodes the IP Address
******************************************************************************************/
function decode_ip($int_ip)
{
	$hexipbang = explode('.', chunk_split($int_ip, 2, '.'));
	return hexdec($hexipbang[0]). '.' . hexdec($hexipbang[1]) . '.' . hexdec($hexipbang[2]) . '.' . hexdec($hexipbang[3]);
}
/******************************************************************************************
// convert an input string into it's binary equivalent.
******************************************************************************************/
function asc2bin($inputString, $byteLength=8)
{
	$binaryOutput = '';
	$strSize = strlen($inputString);

	for($x=0; $x<$strSize; $x++)
	{
		$charBin = decbin(ord($inputString{$x}));
		$charBin = str_pad($charBin, $byteLength, '0', STR_PAD_LEFT);
		$binaryOutput .= $charBin;
	}

	return $binaryOutput;
}

/******************************************************************************************
// convert an binary to ascii string
******************************************************************************************/
function bin2asc($binaryInput, $byteLength=8)
{
	if (strlen($binaryInput) % $byteLength)
	{
		return false;
	}

	// why run strlen() so many times in a loop? Use of constants = speed increase.
	$strSize = strlen($binaryInput);
	$origStr = '';

	// jump between bytes.
	for($x=0; $x<$strSize; $x += $byteLength)
	{
		// extract character's binary code
		$charBinary = substr($binaryInput, $x, $byteLength);
		$origStr .= chr(bindec($charBinary)); // conversion to ASCII.
	}
	return $origStr;
}

function limit_text( $text, $limit )
{
  // figure out the total length of the string
  if( strlen($text)>$limit )
  {
    # cut the text
    $text = substr( $text,0,$limit );
    # lose any incomplete word at the end
    $text = substr( $text,0,-(strlen(strrchr($text,' '))) );
  }

  // return the processed string
  return $text;
}

// convert date to One single format
function convertDate($date)
{
  $ex_date =  explode("-", $date);
  $converted_date = @date("F j, Y", @mktime(0,0,0,$ex_date[1], $ex_date[2], $ex_date[0]));

  return $converted_date;
}


function crop_image($src, $target, $expected_length=100)
{
//echo $src;
//exit;
$quality = 90;
$size = getimagesize($src);
$selected_length = 100;

if($size[0] < $size[1])
				  {
				  $selected_length = $size[0];
				  $x = 1;
				  $y = (($size[1]-$size[0])/2)-1;
				  }
				  else
				  {
				  $selected_length = $size[1];
				  $x = (($size[0]-$size[1])/2)-1;
				  $y = 1;
				  }
				  
				  $create_images = array(
				  'image/png'    => 'imagecreatefrompng',
	'image/jpeg'   => 'imagecreatefromjpeg',
	'image/gif'    => 'imagecreatefromgif'
	);
	
	$save_images = array(
	'image/png'    => 'imagepng',
	'image/jpeg'   => 'imagejpeg',
	'image/gif'    => 'imagegif'
	);
	
	$extensions = array(
	'image/png'    => '.png',
	'image/jpeg'   => '.jpg',
	'image/gif'    => '.gif'
	);
	
	
	
	// Get image creation function
	if (!$create_image = $create_images[$size['mime']]) {
	trigger_error("MIME Type unsupported: {$size['mime']}",E_USER_WARNING);
	exit;
	}
	
	// get image saving function
	if (!$save_image = $save_images[$size['mime']]) {
	trigger_error("MIME Type unsupported: {$size['mime']}",E_USER_WARNING);
	exit;
	}
	
	//get Image extensions
	if (!$extension = $extensions[$size['mime']]) {
	trigger_error("MIME Type unsupported: {$size['mime']}",E_USER_WARNING);
	exit;
	}
	
	if($extension==".png")
	$quality = 9;
	
	$img_r = $create_image($src);
	$dst_r = ImageCreateTrueColor($expected_length, $expected_length);
	
	imagecopyresampled($dst_r, $img_r, 0, 0, $x, $y, $expected_length, $expected_length, $selected_length,
	$selected_length);
	
	$target .= $extension;
	
	$save_image($dst_r, $target, $quality);
	imagedestroy($img_r);
	imagedestroy($dst_r);
	
      return $target;
   }

// get cityfrom IP address
 
    function getCityFromIP($address)
    {
	
        //$url = "http://ipinfodb.com/ip_query.php?ip=".$address."&timezone=false";
	$url = "http://api.ipinfodb.com/v2/ip_query.php?key=f7d171cd36f09e25c7f69c4e18274022a7e60ea7d5b8042b453988970005c3b6&ip=".$address."&timezone=false";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_TIMEOUT, 5000);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // header("content-type:xml");
        $data = curl_exec($ch);
        $arr = @simplexml_load_string($data);
        $array = get_object_vars($arr);
        return $array['City'];
    }
	
?>
