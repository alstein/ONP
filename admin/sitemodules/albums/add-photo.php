<?php
include_once('../../../includes/SiteSetting.php');
include_once('../../../includes/common.lib.php');


 include_once('../../../includes/classes/class.profile.php');
 include_once('../../../includes/classes/class.security.php');
include_once('../../../includes/classes/class.general.php');
 include_once('../../../includes/classes/class.feed.php');

// echo"album id is---->".$id=$_GET['aid'];
// echo"<br>photo id is---->".$id=$_GET['eid'];




if(!$_SESSION['duAdmId'])
{
	header("location:".SITEROOT . "/admin/login/home.php");
	exit();
}

ini_set('memory_limit', 8192 * 1024 * 1024);

if(isset($_POST['submit']))
{
	extract($_POST);
	if($_GET['act']=="edit")
	{
		$ext = strtolower(strrchr($_FILES['file']['name'], "."));
		if($ext == ".avi" || $ext == ".asf"  || $ext == ".qt" || $ext == ".3g2"  || $ext == ".3gpp" || $ext == ".gsm"  || $ext == ".mpeg" || $ext == ".m4v" || $ext == ".wmv" || $ext == ".mov" || $ext == ".mpg" || $ext == ".cmp" || $ext == ".divx" || $ext == ".xvid" || $ext == ".264" || $ext == ".rm" || $ext == ".rmvb" || $ext == ".mpe" || $ext == ".flv"  || $ext == ".wmf"  || $ext == ".MPEG" || $ext == ".movie" || $ext == ".mp4" || $ext == ".swf" || $ext == ".3gp" || $ext == ".txt" || $ext == ".doc")
		{
			$_SESSION['msg']="<span class='error'>Please upload the Image file with extension jpg,jpeg,gif,png,tif.</span>";
			header("location:".SITEROOT."/admin/sitemodules/albums/add-photo.php?act=edit&eid=".$_GET['eid']."aid=".$_GET['aid']);
			exit();
		}
		#==============new =============#
		if($_FILES['file']['name'] != "")
		{//echo "eidf".$_GET['eid']; exit;
				$mtmpRoot    = $HTTP_POST_FILES["file"]["tmp_name"];
				$mMainPhoto  = $HTTP_POST_FILES['image']['name'];
				$original['name']     = $_FILES["file"]['name'];
			
				$original['type']     = $_FILES["file"]['type'];
			
				$original['tmp_name'] = $_FILES["file"]['tmp_name'];
			
				$original['error']    = $_FILES["file"]['error'];
			
				$original['size']     = $_FILES["file"]['size'];
				
				$size 		      = $original['size'];
				
				//$size_bytes 		  = 1048576;
				$size_bytes 		  = 2097152; 

				$ftype = $_FILES["file"]['name'];

				 $filetype = strstr($ftype,".");
				
				//if($filetype == '.png' || $filetype == '.jpg' || $filetype == '.gif' || $filetype == '.txt' || $filetype == '.pdf' || $filetype == '.jpeg')
				
				if($filetype == '.png' || $filetype == '.jpg' || $filetype == '.gif' || $filetype == '.jpeg')
				{
				
					if($size > $size_bytes)
					{
						echo $msg="Unable to upload file. Please upload file less than 1 MB.";
						exit();
					}
					elseif($original['name'])
					{
						@chmod("../../../uploads/post_accomplish/thumbnail/",0777);
					
						$imagename = "photo_".rand(1,1000);
			
						$original = newgeneralfileupload($_FILES["file"], "../../../uploads/post_accomplish/thumbnail/", true);

						 $str11 = explode(".",$original);
						 //print_r($str11);
						 $thumb_1 = crop_image("../../../uploads/post_accomplish/thumbnail/".$original, "../../../uploads/post_accomplish/400X400/".$str11['0'],400,400);

					
		//$thumb_1 = crop_image("../../../uploads/post_accomplish/thumbnail/".$original, "../../../uploads/post_accomplish/400X400".$imagename, 400,400);
// 
// 						$bigimage_1 = crop_image("../../../uploads/album/photo/".$original, "../../../uploads/album/photo/bigimage/".$imagename, 400,300);
// 						$thumb_90X90 = crop_image("../../../uploads/album/photo/".$original, "../../../uploads/album/photo/90X90/".$imagename, 90,90);
// 						$img_arr = explode("/",$thumb_1);
// 						$img_ext = count($img_arr) - 1;
// 						$thumbnail = $img_arr[$img_ext];

		
						//$fields = array("photoid","image","added_date");
// 			original			$values = array($_SESSION['duAdmId'],$photo_title,date("Y-m-d H:i:s"));
						//$values = array($_GET['eid'],$photo_title,date("Y-m-d H:i:s"));

						//$dbres = $dbObj->cupdt('tbl_accomplishment_photo', $fields , $values ,"photoid", $_GET['eid'],"");
					}	
				}
		/*}
		else
		{*///echo "eide".$_GET['eid']; exit;


		//echo $original ;
		//exit;

		}



		else
		{

			 $original=$_POST['oldphoto'];
		

		}
		$fields = array("photoid","album_id","image","description","added_date");
		$values = array($_GET['eid'],$_GET['aid'],$original,$_POST['photo_description'],date("Y-m-d H:i:s"));
			$dbres = $dbObj->cupdt('tbl_accomplishment_photo', $fields , $values ,"photoid", $_GET['eid'],"");
		
		$_SESSION['msg']="<span class='success'>Photo Updated Successfully.</span>";
		header("location:".SITEROOT."/admin/sitemodules/albums/view-album.php?id=".$_GET['aid']);
		exit();
   	}
	elseif($_GET['id']!="")
	{
		$ext = strtolower(strrchr($_FILES['file']['name'], "."));
		if($ext == ".avi" || $ext == ".asf"  || $ext == ".qt" || $ext == ".3g2"  || $ext == ".3gpp" || $ext == ".gsm"  || $ext == ".mpeg" || $ext == ".m4v" || $ext == ".wmv" || $ext == ".mov" || $ext == ".mpg" || $ext == ".cmp" || $ext == ".divx" || $ext == ".xvid" || $ext == ".264" || $ext == ".rm" || $ext == ".rmvb" || $ext == ".mpe" || $ext == ".flv"  || $ext == ".wmf"  || $ext == ".MPEG" || $ext == ".movie" || $ext == ".mp4" || $ext == ".swf" || $ext == ".3gp" || $ext == ".txt" || $ext == ".doc")
		{
			$_SESSION['msg']="<span class='error'>Please upload the Image file with extension jpg,jpeg,gif,png,tif.</span>";
			header("location:".SITEROOT."/admin/sitemodules/albums/add-photo.php?id=".$_GET['id']);
			exit();
		}
		if($_FILES['file']['name'] != "")
		{
				$mtmpRoot    = $HTTP_POST_FILES["file_".$f]["tmp_name"];
				$mMainPhoto  = $HTTP_POST_FILES['image']['name'];
					$original['name']     = $_FILES["file"]['name'];
				
					$original['type']     = $_FILES["file"]['type'];
				
					$original['tmp_name'] = $_FILES["file"]['tmp_name'];
				
					$original['error']    = $_FILES["file"]['error'];
				
					$original['size']     = $_FILES["file"]['size'];
				
				$size 		      = $original['size'];
				
				//$size_bytes 		  = 1048576;
				$size_bytes 		  = 2097152; 
				
				$ftype = $_FILES["file"]['name'];
				
				$filetype = strstr($ftype,".");
				
		
				if($filetype == '.png' || $filetype == '.jpg' || $filetype == '.gif' || $filetype == '.jpeg')
				{
				
					if($size > $size_bytes)
					{
						echo $msg="Unable to upload file. Please upload file less than 1 MB.";
						exit();
					}
					elseif($original['name'])
					{
						@chmod("../../../uploads/post_accomplish/thumbnail/",0777);
						
						//@move_uploaded_file($_FILES["file_".$f]['tmp_name'],"../../sexepediaimages/".$original['name']);
						$imagename = "photo_".rand(1,1000);
			
						$original = newgeneralfileupload($_FILES["file"], "../../../uploads/post_accomplish/thumbnail/", true);
						$thumb_1 = crop_image("../../../uploads/post_accomplish/thumbnail/".$original, "../../../uploads/post_accomplish/400X400/".$imagename, 400,400);
						
						
// 						$bigimage_1 = crop_image("../../../uploads/album/photo/".$original, "../../../uploads/album/photo/bigimage/".$imagename, 400,300);
// 						$thumb_90X90 = crop_image("../../../uploads/album/photo/".$original, "../../../uploads/album/photo/90X90/".$imagename, 90,90);
// 						$img_arr = explode("/",$thumb_1);
// 						$img_ext = count($img_arr) - 1;
// 						$thumbnail = $img_arr[$img_ext];

		
						$fields = array("photoid","album_id","image","added_date");
						$values = array($_SESSION['duAdmId'],$_GET['id'],$original,date("Y-m-d H:i:s"));
						//add photos in tbl_accomplishment_photo table.
						$dbres = $dbObj->cgi('tbl_accomplishment_photo', $fields , $values , "");

					}	
				}

		}
		else
		{
			$fields = array("photoid","album_id","image","added_date");
			$values = array($_SESSION['duAdmId'],$_GET['id'],$original,date("Y-m-d H:i:s"));
			$dbres = $dbObj->cgi('tbl_accomplishment_photo', $fields , $values , "");
		}
		/*$dbres = $dbObj->cgi('tbl_albumphotos', $fields , $values , "");*///exit;
		$_SESSION['msg']="<span class='success'>Photo Added Successfully.</span>";
	}
	header("location:".SITEROOT."/admin/sitemodules/albums/view-album.php?id=".$_GET['id']);
	exit();
}		
//echo $id=$_GET['aid'];

if($_GET['eid']!=""){
	$dbres = $dbObj->cgs('tbl_accomplishment_photo', "*" ,"photoid",$_GET['eid'], "","", "");
	$row_result = @mysql_fetch_assoc($dbres);}

$smarty->assign("photorec",$row_result);
 	//correct results are fetched with status,no userid is fetched here.	
//     echo"<pre>";
// 	print_r($row_result);
// 	exit;


# fetch Albums created by that user
	$tbl = "tbl_album";
	$sf = "*";
	$cnd = "album_id='".$_GET['aid']."' AND status = 'Active' ";
	$row= $dbObj->gj($tbl, $sf, $cnd , "album_title", "", "ASC", "", "");
	while($rec = @mysql_fetch_assoc($row))
	{
		$other_album[] = $rec;
	}
	$smarty->assign("other_album", $other_album);
//correct results are fetched not with status ,but correct userid.
//  echo"<pre>";
//  print_r($other_album);
//  exit;
//----------------------------------------------------------------------------------


//fetch roleids and their userids
		$tbr="users u LEFT JOIN tbl_accomplishment ac ON u.userid=ac.userid LEFT JOIN tbl_awards taw ON ac.award=taw.award_id";
$sfr="u.role_id,u.first_name,u.userid,ac.award,taw.award_title";
$cndr="u.role_id='3' OR u.role_id='4' OR u.role_id='5'";
$rsr = $dbObj->gj($tbr,$sfr,$cndr,"","","","","");
while($rowr = @mysql_fetch_assoc($rsr))
		{
				$newr[]=$rowr;
				//echo "<pre>userid========".$rowr['award_title'];
		}
//		$rowr = @mysql_fetch_assoc($rsr);
		$smarty->assign("newr",$newr);
		//echo"<pre>";
		//print_r($newr);
		//exit;
//------------------------------------------------------------
//fetch award id from 
		
//------------------------------------------------------------		
// fetch Friends
 		$friends = $profObj->getfriends($_GET['aid']);
 	if($ch_userid != "")
 		foreach($ch_userid as $k=>$v)
 	{
 		$ch_friends = $profObj->getfriends($v);
 		if($ch_friends != "")
 			$friends = @array_merge($friends, $ch_friends);
 	}
 	$smarty->assign("friends", $friends);

//nothing in friends.
// 	echo"<pre>";
// 	print_r($friends);
// 	exit;

$friends = $profObj->getfriends($profile['userid']);
$smarty->assign("friends", $friends);


//print_r($friends);
if($friends != "")
{
	foreach($friends as $k=>$v)
	{
		$friend_arr[] = $friends[$k]['userid'];
	}
	//print_r($friend_arr);
	$friends_str = implode(",",$friend_arr);
}
// 		echo"<pre>";
// 		print_r($friends_str);
// 	exit;
//------------------------------------------------------------------------------------

//fetch user id from tbl_album

		$tbl123="tbl_accomplishment_photo r LEFT JOIN tbl_album u ON u.album_id = r.album_id";
        $sf123="r.album_id,u.user_id";
		$cnd123="u.album_id=".$_GET['aid']."";
		$rs123=$dbObj->gj($tbl123,$sf123,$cnd123,"","","","","");

		while($rec = @mysql_fetch_assoc($rs123))
{
	$cat[] = $rec;
}
	$smarty->assign("cat",$cat);

		
//-------------------------------------------------------
				$tbl11="tbl_friends f LEFT JOIN tbl_album a ON f.userid=a.user_id";
				$sf111="f.userid,f.friendid";
				$cnd11="f.userid=a.user_id";
				$rs11=$dbObj->gj($tbl11,$sf111,$cnd11,"","","","","");
				while($rcc = @mysql_fetch_assoc($rs11))
{
$rr[]=$rcc;

}
//cat1 has all frnd ids----------------------------
$smarty->assign("cat1",$rr);

		//echo "<pre>";
		//print_r($rr);
//----------------------------------------------------
		$tbl1="tbl_friends f LEFT JOIN users u ON f.userid=u.userid";
				$sf11="f.userid,f.friendid,u.first_name,u.last_name";
				$cnd1="f.userid=u.userid";
				$rs1=$dbObj->gj($tbl1,$sf11,$cnd1,"","","","","");
				while($rcc1 = @mysql_fetch_assoc($rs1))
{
	$rr1[]=$rcc1;

}
//cat11 has all frnd ids wid frndnames----------------------------
		$smarty->assign("cat11",$rr1);

// 		echo "<pre>";
// 		print_r($rr1);



		
		//exit;
// 		$tbl = "tbl_album as a, tbl_accomplishment_photo as u";
// $sf = "a.user_id,u.*";
// $cnd = "user_id=".$_GET['eid'];
// $rs = $dbObj->gj($tbl, $sf , $cnd, "", "", "", $l, "");
// 
// $cat = @mysql_fetch_assoc($rs);
// //echo "<pre>";print_r($cat);exit;	
// $smarty->assign("cat", $cat);
// 		
// 
// echo"<pre>";
// print_r($cat);
// exit;
//----------------------------------------------------------------------------------

# fetch Childs Accomplishment
	if($profile['role_id'] == 4)
{
	$ch_userid = $profObj->getChildUserId($_GET['aid']);
	$feed = $feedObj->stud_friend_feed($_GET['aid'], @implode(",", $ch_userid));
}
	elseif($profile['role_id'] == 5)
{
	$student_arr = $schoolObj->getStudentofTeacher($teacher['schoolid'], $teacher['gradeid'], $teacher['classid']);
	$ch_userid = $student_arr[0];
	$feed = $feedObj->stud_friend_feed($_GET['aid'], @implode(",", $ch_userid));
}
	elseif($profile['role_id'] == 3)
{
	$feed = $feedObj->stud_friend_feed($_GET['aid'], $profile['userid']);
}
	$smarty->assign("feed", $feed);

//nothing in feed
// 	echo"<pre>";
// 	print_r($feed);
// 	exit;



if($_SESSION['msg'])
{
	$smarty->assign("msg",$_SESSION['msg']);	
	$_SESSION['msg']=NULL;
	unset($_SESSION['msg']);
}

$smarty->assign("inmenu","sitemodules");
$smarty->assign("leftadminmenu","albums");
$smarty->display(TEMPLATEDIR . '/admin/sitemodules/albums/add-photo.tpl');

$dbObj->Close();
?>