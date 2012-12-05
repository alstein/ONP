<?php
include_once('../../includes/SiteSetting.php');
include_once('../../includes/common.lib.php');
include_once('../../includes/classes/class.profile.php');
include_once('../../includes/classes/class.photos.php');
extract($_POST);
if($_POST['id']!='')
{
	$img=$dbObj->getInfo("temp_gallary","file_name","img_id",$_POST['id']);
	@unlink("uploads/".$img);
	$temp=$dbObj->gdel("temp_gallary","img_id",$_POST['id'],"");
}

session_start();
$_SESSION["file_info"] = array();
$dbObj->not_login();
$result = $profObj->getProfileInfo($_SESSION['csUserId']);
$smarty->assign("result",$result);
$uid="";
$rs = $dbObj->cgs("photoalbum","userid","album_id",$_GET['id1'],"","","");
if($rs!='n')
{
	$row = mysql_fetch_assoc($rs);
	$a[]=$row;
	$uid=$a[0]['userid'];
}
// echo $_GET['id2'];exit;
if($_GET['id1']=='' || $uid!=$_SESSION['csUserId'])
{
	header("Location:".SITEROOT."/photos/create-album/");
	exit;
}

/*
if(isset($_POST['sub'])||isset($_POST['adddet']))
{
   //print_r($_SESSION['temp_upload1']);
	$sf = array("moduleid","itemid","userid","comment","date_added");
	$sv = array("10",$_GET['id1'],$_SESSION['csUserId'],"new Photos",date("Y-m-d H:i:s"));
	$insert= $dbObj->cgi("comments",$sf,$sv,"");
    foreach($_SESSION['temp_upload1'] as $key=>$val)
    {
        $insert_id = addAlbumsPhotos($_GET['id1'],$val,"");
        unlink("temp_uploads/".$val);
	}	
	// print_r($val);exit;
	unset($_SESSION['temp_upload1']);
	if(isset($_POST['adddet']))
	{
		header("Location:".SITEROOT."/photos/1/".$_GET['id1']."/photo-album/");exit;
	}
	else
	{
		header("Location:".SITEROOT."/photos/search-photos/");exit;
	}
}*/
extract($_POST);

if((isset($sub)) OR (isset($adddet)))
{
	$temp_photo_list=$photoObj->get_temp_photo_list();
	if(isset($temp_photo_list))
	{
		$len=count($temp_photo_list);
		for($i=0;$i<$len;$i++)
		{
			$tempphotoid[$i]['img_id']=$temp_photo_list[$i]['img_id'];
		}
	}
	if((isset($sub)) OR (isset($adddet)))
	{
		if(is_array($tempphotoid))
		{
			$cntph= count($tempphotoid);
			for($i=0;$i<$cntph;$i++)
			{
				$sql_temp_img = $dbObj->cgs("temp_gallary" , "img_id,id,file_name", "img_id", $tempphotoid[$i]['img_id'], "", "", "");
				if($sql_temp_img!='n')
				{
					$fetch_temp_img = mysql_fetch_assoc($sql_temp_img);
					
					$original['name'] = $fetch_temp_img['file_name'];
					$original['tmp_name'] = "uploads/".$fetch_temp_img['file_name'];

					$width_array = array("85","116","170","383","576","160","232");
					$height_array = array("85","70","113","255","433","106","142");
					$path_array=array("../../uploads/photos/thumbnail/vsmall/","../../uploads/photos/thumbnail/small/","../../uploads/photos/thumbnail/medium/","../../uploads/photos/thumbnail/large/","../../uploads/photos/thumbnail/vlarge/","../../uploads/photos/thumbnail/medium_new/","../../uploads/photos/thumbnail/large_new/");
					$original_image="../../uploads/photos/original";
					$newfile=resize_multiple_images($original,$width_array,$path_array,$original_image,$height_array);
					$field=array('userid','album_id','photo_path','added_date');
					$val=array($_SESSION['csUserId'],$_GET['id1'],$newfile,date("Y-m-d H:i:s"));
					$insert_photo=$dbObj->cgi("photos",$field,$val,"");
					$insert = mysql_query("insert into comments set moduleid='10', itemid='".$insert_photo."', userid='".$_SESSION['csUserId']."',comment='new photos', date_added='".date("Y-m-d H:i:s")."'");
					$temp_del_photo=$photoObj->del_temp_photo($tempphotoid[$i]['img_id']);
					unset($original);
					unset($newfile);
					unset($width_array);
					unset($path_array);
				}
			}
		}
		unset($tempphotoid);
		if(isset($_POST['adddet']))
		{
			header("Location:".SITEROOT."/photos/1/".$_GET['id1']."/photo-album/");exit;
		}
		else
		{
			header("Location:".SITEROOT."/photos/search-photos/");exit;
		}
		exit;
		//$_SESSION['delmsg']="<div class=error>Photo saved successfully successfully.</span></div>";
		//header("Location:".SITEROOT."/property/".$_GET['id1']."/photo/");exit;
		
		
	}
}

$theUploadFolder = "upload";

//get space used;

$spaceUsed = 0;
if ($dir = @opendir($theUploadFolder)) 
{
	while (($file = readdir($dir)) !== false) 
	{
		if($file != '.' && $file !='..')
		{
			$spaceUsed = $spaceUsed + filesize($theUploadFolder."/".$file);

		}

	}
}

$smarty->assign("spaceUsed",$spaceUsed);

$temp_photo_list=$photoObj->get_temp_photo_list();
$smarty->assign("temp_photo_list",$temp_photo_list);

#--------Messaging----------------
if($_SESSION['msg']){
	$smarty->assign("msg", $_SESSION['msg']);
	unset($_SESSION['msg']);
}

$_SESSION['albumid'] = $_GET['id1'];

$smarty->assign("session_id", session_id());

$smarty->display(TEMPLATEDIR."/modules/photos/upload-photos.tpl");
$dbObj->Close();
?>