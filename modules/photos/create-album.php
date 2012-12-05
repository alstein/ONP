<?php
include_once('../../include.php');
include_once('../../includes/SiteSetting.php');
include_once('../../includes/classes/class.profile.php');
include_once('../../includes/common.lib.php');
include_once('../../includes/classes/class.photos.php');
//ini_set('memory_limit',"50MB");


//print_r($_GET);
if(!$_SESSION['csUserId'])
{
	header("Location:".SITEROOT."/");
}

$row_meta=$dbObj->getseodetails(10);
$smarty->assign("row_meta",$row_meta);



$smarty->assign("seotitle",$seoname." - Create Album");

$whose_profile="album";
$smarty->assign("whose_profile",$whose_profile);
$select_name=$dbObj->cgs("tbl_users","*",array(userid),array($_SESSION['csUserId']),"","",""); 
$res_select_name=@mysql_fetch_assoc($select_name);
$username=$res_select_name['first_name'];
$smarty->assign("username",$username);
$smarty->assign("lfmnsellink","photos");
$userid=$_SESSION['csUserId'];
$profileinfo = $profObj->fetchProfile($userid);
$smarty->assign("profileinfo",$profileinfo);
if(isset($_POST["delete"]))
{

      $getphotodetails=$dbObj->cgs("tbl_albumphotos","*",array(user_id,album_id),array($_SESSION['csUserId'],'0'),"","","");  //exit;
      while($fetch_photodetails=@mysql_fetch_assoc($getphotodetails))
      {
         $photo_todel[]=$fetch_photodetails["photo_id"];
         $del_comm=$dbObj->customqry("delete from tbl_albumphotos where photo_id='".$fetch_photodetails['photo_id']."'",""); 

         @unlink('../../uploads/album/photo/'.$fetch_photodetails['thumbnail']);
         @unlink('../../uploads/album/photo/180X158/'.$fetch_photodetails['thumbnail']);
         @unlink('../../uploads/album/photo/400X300/'.$fetch_photodetails['thumbnail']);
         @unlink('../../uploads/album/photo/600X600/'.$fetch_photodetails['thumbnail']);
         @unlink('../../uploads/album/photo/132X101/'.$fetch_photodetails['thumbnail']);
         @unlink('../../uploads/album/photo/bigimage/'.$fetch_photodetails['thumbnail']);
         @unlink('../../uploads/album/photo/90X90/'.$fetch_photodetails['thumbnail']);
//         $photo_unlink[]= $fetch_photodetails["thumbnail"];
      }
    header("location:".SITEROOT."/".$profileinfo['username']."/albumphotos/");
}


 $albid=$_GET['id1'];
//print_r($_POST);
if(isset($_POST["album_name"]))
{
   //if($_POST['album_name']=="")
        // $_POST['album_name'] ='Default';
	if( $_POST['album_name']!='')
	{
		$retvar = $photoObj->createAlbum($albid,$_FILES,$_POST);
		if($retvar)
		{
			unset($_POST);
		}
	}
	
	$_SESSION['msg'] = $retvar[0];
	if($retvar[1]!="")
	{
      $photos=$dbObj->cgs("tbl_albumphotos","*",array("album_id","user_id"),array("0",$_SESSION['csUserId']),"photo_id","","");
		$p=0;
      while($fetch_pht=@mysql_fetch_array($photos))
      {
         $alb_photos[$p]=$fetch_pht; 
         $update_details=$dbObj->cupdt("tbl_albumphotos","album_id",$retvar[1],"photo_id",$fetch_pht['photo_id'],"");
	if($p==0)
	{

		$album_url=	$dbObj->customqry("select * from tbl_album where album_id='".$retvar[1]."'","");
		$res_album_url=@mysql_fetch_assoc($album_url);

		$sel_user_name=$dbObj->customqry("select * from tbl_users where userid='".$_SESSION['csUserId']."'","");
		$res_user_name=@mysql_fetch_assoc($sel_user_name);
		$msg='<a   href="'.SITEROOT.'/'.$res_user_name['username'].'/'.$res_album_url['url_title'].'/photos" target="_blank">'.'<span style="color:#044EA2;" >'.$res_user_name['fullname']."</span>"." Created an album  ".'<span style="color:#044EA2;">'.$res_album_url['album_title']."</span>".'</a>';
		$sel_photo=$dbObj->customqry("select thumbnail from tbl_albumphotos where photo_id='".$fetch_pht['photo_id']."'","");
		$res_photo=@mysql_fetch_assoc($sel_photo);
		$date=Date("Y:m:d H:i:s");
	$insert_activity=$dbObj->customqry("insert into tbl_activity(msg,vault_t,vault,timestamp,wall,uid,fid)values('".$msg."','album','".$res_photo['thumbnail']."','".$date."','1','".$_SESSION['csUserId']."','".$_SESSION['csUserId']."')","");
	}
         $p++;
      }
		
	
	

		//add to wall
		$cndgetphoto="t.album_id=".$retvar[1];


		$tbl_check="tbl_albumphotos as tp LEFT JOIN tbl_album as t ON tp.album_id=t.album_id"; 

		$sfcheck="tp.thumbnail,t.album_id,t.url_title,t.album_title";


		$resgetphotos=$dbObj->gj($tbl_check,$sfcheck,$cndgetphoto,"","","","","");
		$linegetphoto=@mysql_num_rows($resgetphotos);$x=0;
		while($rowgetphoto=@mysql_fetch_assoc($resgetphotos))
		{	
			$getphoto[$x]=$rowgetphoto;	
			$x++;
		}
		
		//flat this array
		for($j=0;$j<$linegetphoto;$j++)
		{
		$arrphoto[$j]=$getphoto[$j]['thumbnail'];
		}
		if(is_array($arrphoto))
		{
		$getstrphoto="|".implode($arrphoto,"|"); 
		}

		$contentimg=$getphoto[0]['url_title'];

		$currdate=Date('Y:m:d H:i:s', strtotime("+1 days"));
// 		$resinsert=$dbObj->cgi("messages",array("msg","vault_t","vault","timestamp","uid","fid","albumcheck"),array($contentimg,"img",$getstrphoto,$currdate,$_SESSION["csUserId"],$_SESSION["csUserId"],1),"");
		
		header("location:".SITEROOT."/".$profileinfo['username']."/albumphotos/");
		exit;
	//	$photoObj->addPhotos($retvar[1],$_SESSION['csUserId'],$_FILES); 
	}
// 	elseif($albid!="")
// 	{
// 	//	$photoObj->addPhotos($albid,$_SESSION['csUserId'],$_FILES); 
// 
// 		//add userid for photos
// 		$photos=$dbObj->cgs("tbl_albumphotos","*",array("album_id","user_id"),array($albumid,"0"),"photo_id","","");
// 		while($fetch_pht=@myselect * from tbl_users where userid='21'sql_fetch_array($photos))
// 		{
// 			$alb_photos[$p]=$fetch_pht;
// 			$update_details=$dbObj->cupdt("tbl_albumphotos","album_id",$albid,"photo_id",$fetch_pht['photo_id'],"");
// 			$p++;
// 		}
// 	}
//		header("location:".SITEROOT."/".$profileinfo['username']."/albumphotos/");
//		exit;


	
}

if($_GET["id2"]=="edit")
{
	$getalbumdetails=$dbObj->cgs("tbl_album","*",array("user_id","album_id"),array($_SESSION['csUserId'],$_GET['id1']),"","","");
	$fetch_albumdetails=@mysql_fetch_assoc($getalbumdetails);
	$smarty->assign("albumdetails",$fetch_albumdetails);
	
// 	echo "<pre>";
// 	print_r($fetch_albumdetails);exit;
}

if(isset($_SESSION['msg']))
{
	$smarty->assign("msg",$_SESSION['msg']);
	unset($_SESSION['msg']);
}
$smarty->assign("tabact","photo");
$smarty->assign("scttab","photo");
$smarty->assign("showright","yes");
$smarty->display(TEMPLATEDIR .'/modules/photos/create_album.tpl');
?>