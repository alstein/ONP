<?php
//include_once('includes/SiteSetting.php');
class PhotoGallery extends DBTransact
{
function updateimageByAdmin()
{
	//print_r($_POST);exit;
	if ($_FILES['image']['tmp_name'] == '')
	{
		extract($_POST);
		$fields = array('title' , 'description','price','countryid','stateid','cityid','region','zipcode','phoneno', 'url','address','email','status','added_date');
		$values = array($title,addslashes($description),$price,$countryid,$province,$cityid,$region,$zipcode,$phno,$url,$address,$email,'1',date('Y-m-d H:i:s'));				
		$dbres = $this->cupdt('tbl_listing', $fields , $values ,"id",$id,"");
	}
	else{
	$size = getimagesize($_FILES['image']['tmp_name']);
	$tmp_name = $_FILES['image']['tmp_name'];
	$wt = $size[0];
	//print_r($wt); exit;
	$width_array = array("354","150",$wt);
	$path_array=array("../../../uploads/listing/","../../../uploads/listing/thumbnail/","../../../uploads/listing/");
	$send_upload=resize_multiple_images($_FILES["image"],$width_array,$path_array);		
	if($send_upload)
		{
			extract($_POST);
			$fields = array('title' , 'description','price','countryid','stateid','cityid','region','zipcode','phoneno', 'url','address','email','status','thumbnail','added_date');
			$values = array($title,addslashes($description),$price,$countryid,$province,$cityid,$region,$zipcode,$phno,$url,$address,$email,'1',$send_upload,date('Y-m-d H:i:s'));
		}
	$dbres = $this->cupdt('tbl_listing', $fields , $values ,"id",$id,"");
	}
	return;
}

	function uploadimageByAdmin()
	{
 	//print_r($_POST);exit;
		$size = getimagesize($_FILES['image']['tmp_name']);
		$tmp_name = $_FILES['image']['tmp_name'];
		$wt = $size[0];
		//print_r($wt); exit;
		$width_array = array("354","150",$wt);
		$path_array=array("../../../uploads/listing/","../../../uploads/listing/thumbnail/","../../../uploads/listing/");
		$send_upload=resize_multiple_images($_FILES["image"],$width_array,$path_array);		
		if($send_upload)
			{
				extract($_POST);
				$fields = array('title' , 'description','price','countryid','stateid','cityid','region','zipcode','phoneno', 'url','address','email','status','thumbnail','added_date');
			 	$values = array($title,addslashes($description),$price,$countryid,$stateid,$cityid,$region,$zipcode,$phno,$url,$address,$email,'1',$send_upload,date('Y-m-d H:i:s'));
			}
		$dbres = $this->cgi('tbl_listing', $fields , $values , "");
		return;
	}
}
?>