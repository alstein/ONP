<?php
include_once('../../include.php');
include_once('../../includes/SiteSetting.php');
include_once('../../includes/classes/class.profile.php');
include_once('../../includes/classes/class.photos.php');
include('../../includes/paging.php');

if(!$_SESSION['csUserId'])
{
	header("Location:".SITEROOT."/");
}
$smarty->assign("lfmnsellink","photos");

$whose_profile="album";
$smarty->assign("whose_profile",$whose_profile);

// print_r($_GET);
$select_type=$dbObj->customqry("select * from tbl_users where 	username='".$_GET['user']."'","");
$fetch_type=@mysql_fetch_assoc($select_type);
$usertype_id=$fetch_type['usertypeid'];
$smarty->assign("usertype_id",$usertype_id);
if($siteUserId!="")
{
$userid=$siteUserId;
}

else
{
$userid=$_SESSION['csUserId'];
}
$userinfo = $profObj->fetchProfile($userid);
$smarty->assign("profileinfo",$userinfo);
$smarty->assign("user",$userinfo);

$albumid = $_GET['album'];
$smarty->assign("albumid",$_GET['album']);
$photoid=$_GET["imageid"];


//get like dislik cnt
if($photoid!="")
{
//get all rows with dislikes
$cndlikescheck="i.photo_id=".$photoid." AND i.status='likes' and i.userid=u.userid";
$reschcklikes=$dbObj->gj("tbl_imagelikes i,tbl_users u","i.photo_id,i.userid,i.status,u.fullname,u.business_name,u.usertypeid",$cndlikescheck,"i.id","","desc","2","");
$checkrowlikes=@mysql_num_rows($reschcklikes);
if($checkrowlikes >0)
{
$likcnt=$checkrowlikes;
}
else
{
$likcnt=0;
}

while($likrow=@mysql_fetch_assoc($reschcklikes)){
	$usernames[]=$likrow;
	if($likrow['usertypeid']==2)
		$unames.='<a href="'.SITEROOT.'/my-account/'.$likrow['userid'].'/my_profile/" target="_blank">'.$likrow['fullname']."</a>,";
	else
		$unames.='<a href="'.SITEROOT.'/merchant-account/'.$likrow['userid'].'/merchant_profile/" target="_blank">'.$likrow['business_name']."</a>,";
}
$unames=substr_replace($unames ,"",-1);
$smarty->assign("usernames",$usernames);
$smarty->assign("unames",$unames);
$smarty->assign("likcnt",$likcnt);

//echo "<pre>";print_r($usernames);echo "</pre>";exit;

//dislikes


$cnddislikescheck="photo_id=".$photoid." AND status='dislikes'";
$reschckdislikes=$dbObj->gj("tbl_imagelikes","photo_id,userid,status",$cnddislikescheck,"","","","","");
$checkrowdislikes=@mysql_num_rows($reschckdislikes);
if($checkrowdislikes>0)
{
$dislikcnt=$checkrowdislikes;
}
else
{
$dislikcnt=0;
}
$smarty->assign("dislikcnt",$dislikcnt);

//check for particular user
$cndusercheck="photo_id=".$photoid." AND userid=".$_SESSION['csUserId'];
$resuserchck=$dbObj->gj("tbl_imagelikes","photo_id,userid,status",$cndusercheck,"","","","","");
$checkuserrow=@mysql_num_rows($resuserchck);
$resultuserset=@mysql_fetch_assoc($resuserchck);
if($checkuserrow>0)
{

		if($resultuserset['status']=="likes")
		{
		$flaguserlikchk=1;
		}
		else
		{
		$flaguserdislikchk=1;
		}
}
else
{
$flaguserlikchk=0;
$flaguserdislikchk=0;
}

$smarty->assign("flaguserlikchk",$flaguserlikchk);
$smarty->assign("flaguserdislikchk",$flaguserdislikchk);
}

// for getting album photos
//---------------------------------------------------//
if(!isset($_GET['page']))
{
	$page =1;
}
else
{
	$page=$_GET['page'];
	$page = $page;
}

$adsperpage =15;
$StartRow = $adsperpage * ($page-1);

$l =  $StartRow.','.$adsperpage;

$res=$dbObj-> customqry("select a.*,u.username,u.userid from tbl_albumphotos a LEFT JOIN tbl_users u on a.user_id=u.userid where a.album_id=".$albumid." and a.user_id=".$userid." and a.status = 'Active' order by a.photo_id ASC","");	
while($row_p = @mysql_fetch_assoc($res))
{
	$row_arr[]=$row_p;
}
for($k=0;$k<count($row_arr);$k++)
{
	if($row_arr[$k]['photo_id']==$photoid)
		$sliceid = $k;
}
if($sliceid!="")
{
$row_arr_new1 = array_slice($row_arr,$sliceid);
$row_arr_new2 = array_slice($row_arr,0,$sliceid);
$row_arr_final = array_merge($row_arr_new1,$row_arr_new2); 
$smarty->assign("album_photos",$row_arr_final);
}
else
{
$smarty->assign("album_photos",$row_arr);
}
$rs = $dbObj-> customqry("select a.*,u.username,u.userid from tbl_albumphotos a LEFT JOIN tbl_users u on a.user_id=u.userid where a.album_id=".$albumid." and a.user_id=".$userid." and a.status = 'Active' order by a.photo_id ASC","");
	$nums = @mysql_num_rows($rs);
	$show =1;		
	$total_pages = ceil($nums / $adsperpage);
	if($total_pages > 1)
		$smarty->assign("showpgnation", 'yes');
			$showing   = !($getpage)? 1 : $getpage;
			$firstlink = basename($_SERVER['PHP_SELF'])."?albumid=$albumid&userid=$userid&imageid=$photoid&page=";
	
		$baselink  = $firstlink;
		$pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums,'',$startingnumber,$endingnumber);
		
		$smarty->assign("paging", $pgnation);

/*-----------------------------------*/
// album details
$get_albumdetails=$dbObj->cgs("tbl_album","user_id,album_id,album_title,url_title","album_id",$albumid,"","","");
$fetch_albumdetails=@mysql_fetch_assoc($get_albumdetails);
$smarty->assign("album_details",$fetch_albumdetails);
//---------------------------------likes dislikes--------------------------------------------//
 
	if($_POST['act']!=""  && $_POST['imageid']!="")
	{
	//check record
	$cndcheck="photo_id=".$_POST['imageid']." AND userid=".$_SESSION['csUserId'] ;
	$reschck=$dbObj->gj("tbl_imagelikes","photo_id,userid,status",$cndcheck,"","","","","");
	$checkrow=@mysql_num_rows($reschck);
	$resultset=@mysql_fetch_assoc($reschck);
	if($_POST['act']=="likes")
	{

		if($checkrow>0)
		{
			//update
			
			if($resultset['status']=="dislikes")
			{
				$resupdate=$dbObj->cupdt("tbl_imagelikes",array("status"),array($_POST['act']),array("photo_id","userid"),array($_POST['imageid'],$_SESSION['csUserId']),"");
			
			}
		}
		else
		{
		//insert
		$resinsert=$dbObj->cgi("tbl_imagelikes",array("photo_id","userid","status"),array($_POST['imageid'],$_SESSION['csUserId'],$_POST['act']),"");
		}


	}
	else if($_POST['act']=="dislikes")
	{

		if($checkrow>0)
		{
			
			if($resultset['status']=="likes")
			{
			 
			  $resupdate=$dbObj->cupdt("tbl_imagelikes",array("status"),array($_POST['act']),array("photo_id","userid"),array($_POST['imageid'],$_SESSION['csUserId']),"");
			}
			
		}
		else
		{
			//insert
			$resinsert=$dbObj->cgi("tbl_imagelikes",array("photo_id","userid","status"),array($_POST['imageid'],$_SESSION['csUserId'],$_POST['act']),"");
	
		}
	}
	else
	{

	}

}
if($_POST['action']=="delete"  && $_POST['imageid']!="")
{
	
	  $getphotodetails=$dbObj->cgs("tbl_albumphotos","*",array("photo_id"),array($_POST['imageid']),"","","");  //exit;
      $fetch_photodetails=@mysql_fetch_assoc($getphotodetails);
      
         $photo_todel=$fetch_photodetails["photo_id"];
         $del_comm=$dbObj->customqry("delete from tbl_albumphotos where photo_id='".$fetch_photodetails['photo_id']."'","");

         @unlink('../../uploads/album/photo/'.$fetch_photodetails['thumbnail']);
         @unlink('../../uploads/album/photo/180X158/'.$fetch_photodetails['thumbnail']);
         @unlink('../../uploads/album/photo/400X300/'.$fetch_photodetails['thumbnail']);
         @unlink('../../uploads/album/photo/600X600/'.$fetch_photodetails['thumbnail']);
         @unlink('../../uploads/album/photo/132X101/'.$fetch_photodetails['thumbnail']);
         @unlink('../../uploads/album/photo/bigimage/'.$fetch_photodetails['thumbnail']);
         @unlink('../../uploads/album/photo/90X90/'.$fetch_photodetails['thumbnail']);
// 	 header("location:".SITEROOT."/".$profileinfo['username']."//");
}
//-----------------------------------------------------------------------------------------------------//
if(isset($_SESSION['msg']))
{
	$smarty->assign("msg",$_SESSION['msg']);
	unset($_SESSION['msg']);
}

$smarty->assign("photorate",TEMPLATEDIR."/modules/common/photorate.tpl");
$smarty->assign("tabact","photo");
$smarty->assign("pagecnt",$page-1);
$smarty->assign("scttab","photo");
$smarty->assign("showright","yes");
$smarty->display(TEMPLATEDIR .'/modules/photos/ajaximageslider.tpl');
?>