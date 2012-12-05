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

$smarty->assign("seotitle",$seoname." - Album Photos");

$row_meta=$dbObj->getseodetails(8);
$smarty->assign("row_meta",$row_meta);


$whose_profile="album";
$smarty->assign("whose_profile",$whose_profile);

if($siteUserId!="")
{
$userid=$siteUserId;
}

else
{
$userid=$_SESSION['csUserId'];
}

if($_GET["userid"]!='')
    $userid = $profObj->fetchUserid($_GET["userid"]);

// if($_GET['id1']!="")
// {
//  $siteUserId=$_GET['id1'];
// 
// }
// elseif($_GET['userid']!="")
// {
// $select_username=$dbObj->customqry("select * from tbl_users where username='".$siteUserId."'","");
// $res_select_username=@mysql_fetch_assoc($select_username);
// $siteUserId=$res_select_username['userid'];
// }
// elseif($_GET['user']!="")
// {
// $siteUserId=$_GET['user'];
// $select_username=$dbObj->customqry("select * from tbl_users where username='".$_GET['user']."'","");
// $res_select_username=@mysql_fetch_assoc($select_username);
// $siteUserId=$res_select_username['userid'];
// }
// else
// {
// $siteUserId=$_SESSION['csUserId'];
// }
// if($_GET['user']!="")
// {
// $siteUserId=$_GET['user'];


$select_username=$dbObj->customqry("select * from tbl_users where username='".$_GET['user']."'","");
$res_select_username=@mysql_fetch_assoc($select_username);
$UserId=$res_select_username['userid'];
$smarty->assign("UserId",$UserId);

$userinfo = $profObj->fetchProfile($userid);
$smarty->assign("profileinfo",$userinfo);
$smarty->assign("user",$userinfo);
//}
// print_r($_GET);exit;
$albumid = $photoObj->fetchAlbumId($_GET['album']);
$smarty->assign("albumid",$albumid);
//for getting album description
$res_album_description = $dbObj->gj("tbl_album","album_description","album_id=".$albumid,"","","","","");
$row_album_description=@mysql_fetch_assoc($res_album_description);
$smarty->assign("album_description",$row_album_description);
// for getting album photos
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
// echo "paging :".$l;

$getalbumphotos=$dbObj->cgs("tbl_albumphotos ap left join tbl_album a on ap.album_id=a.album_id 	","ap.*,a.album_title",array("ap.album_id","ap.status"),array($albumid,"Active"),"photo_id","ASC limit $l","");
$prObj=new Profile();
$p=0;
while($fetch_albumdetails=@mysql_fetch_assoc($getalbumphotos))
{
	$album_photos[$p]=$fetch_albumdetails;

   //calculate rating for indivisual photo
//     $rs = $dbObj->cgs("tbl_rating", "sum(average_rating)/count(average_rating), count(average_rating)", array("moduleid", "itemid"), array('1',$fetch_albumdetails['photo_id']), "", "", "");
//      $row=@mysql_fetch_array($rs);
// 
//      $rating = number_format($row[0],'1','.','');
//      $album_photos[$p]['rating'] = $rating;
//      $album_photos[$p]['ratecnt'] =$row[1];
//      $rateval = @explode(".",$rating);

//      $starRate = $profObj->calculateRating($rating);
//      $album_photos[$p]['ratingstar'] = $starRate['ratingstar'];
//       echo "<pre>";
//       print_r($album_photos[$p]['ratingstar']);
     $p++;
}
$smarty->assign("album_photos",$album_photos);

// echo "<pre>";
// print_r($album_photos);
// exit;

// end for getting album photos

// ablbum details
$get_albumdetails=$dbObj->cgs("tbl_album","user_id,album_id,album_title,url_title","album_id",$albumid,"","","");
$fetch_albumdetails=@mysql_fetch_assoc($get_albumdetails);
$smarty->assign("album_details",$fetch_albumdetails);

// album details end

/*----------Pagination Part-2--------------*/
$rs=$dbObj->cgs("tbl_albumphotos","*",array("album_id","status"),array($albumid,"Active"),"photo_id","ASC","");
$nums = @mysql_num_rows($rs);
$show = 5;
$total_pages = ceil($nums / $adsperpage);

if($total_pages > 1)
{
	//$showing   = !isset($_GET["id1"]) ? 1 : $id1;
	$showing   = $page;
	$firstlink = SITEROOT."/".$userinfo['username']."/".$fetch_albumdetails['url_title']."/photos/";
	$seperator = '?page=';
	$baselink  = $firstlink;
	 $pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);
	//print_r($pgnation);
	$smarty -> assign("pgnation",$pgnation);
}
//echo $pgnation;
/*-----------------------------------*/

//add userid for photos
$photos=$dbObj->cgs("tbl_albumphotos","*",array("album_id","user_id"),array($albumid,"0"),"photo_id","","");
while($fetch_pht=@mysql_fetch_array($photos))
{
	$alb_photos[$p]=$fetch_pht;
	$update_details=$dbObj->cupdt("tbl_albumphotos","user_id",$_SESSION['csUserId'],"photo_id",$fetch_pht['photo_id'],"");
	$p++;
}

$smarty -> assign("moduleid",1);


//      $qrypid = $dbObj->cgs("tbl_albumphotos", "photo_id", array("album_id"), array($albumid), "", "", "");
//       $i=0;
//      while($fetchids=@mysql_fetch_array($qrypid))
//      {
//          $phtids[$i] = $fetchids['photo_id'];
//          $i++;
//       }
//       $arrpid = @implode(",",$phtids);      
// 
//          $tbl  = 'tbl_rating';
//          $sf   = 'sum(rating)/count(rating), count(rating)';
//          $cd   = "itemid in (".$arrpid.") and moduleid='1'";
//          $ob   = '';
//          $ad   = '';
//          $prn  = '';
//          $result  = $dbObj -> gj($tbl, $sf , $cd, $ob, $gb, $ad, $l, $prn);
//          $row=@mysql_fetch_array($result);
// 
//          $rating = number_format($row[0],'1','.','');
//          $albumrate['rating'] = $rating;
//          $albumrate['ratecnt'] =$row[1];
//          $rateval = @explode(".",$rating);
// 
//          $starRate = $profObj->calculateRating($rating);
//          $albumrate['ratingstar'] = $starRate['ratingstar'];

          //print_r($albumrate);

         $albumrate = $profObj->calPhotoAlbumRating($albumid,"1",$userid);
         $smarty -> assign("albumrate",$albumrate);

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
$smarty->display(TEMPLATEDIR .'/modules/photos/photos.tpl');
?>
