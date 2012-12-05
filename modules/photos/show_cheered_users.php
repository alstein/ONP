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


/*-----------------------Pagination Part1--------------------*/
if(!isset($_GET['page']))
   $page =1;
else
   $page = $_GET['page'];
   $adsperpage =20;
   $StartRow = $adsperpage * ($page-1);
   $l= $StartRow.','.$adsperpage;

/*-----------------------End Part1--------------------*/


//get like dislik cnt
if($_GET['imageid']!="")
{

	$rs1=$dbObj->customqry("select p.thumbnail as photo,a.album_title from tbl_albumphotos p,tbl_album a where p.album_id=a.album_id and p.photo_id=".$_GET['imageid'],"");
	$arow=mysql_fetch_assoc($rs1);
	$smarty->assign("arow",$arow);


//get all rows with dislikes
	$cndlikescheck="i.photo_id=".$_GET['imageid']." AND i.status='likes' and i.userid=u.userid";
	$reschcklikes=$dbObj->gj("tbl_imagelikes i,tbl_users u","i.photo_id,i.userid,i.status,u.fullname,u.business_name,u.usertypeid,u.photo",$cndlikescheck,"i.id","","desc",$l,"");

	$res_all=$dbObj->gj("tbl_imagelikes i,tbl_users u","i.photo_id,i.userid,i.status,u.fullname,u.business_name,u.usertypeid,u.photo",$cndlikescheck,"i.id","","desc","","");
	$checkrowlikes=@mysql_num_rows($reschcklikes);

	if($checkrowlikes >0){
		$likcnt=$checkrowlikes;
	}else{
		$likcnt=0;
	}

	while($likrow=@mysql_fetch_assoc($reschcklikes)){
		$usernames[]=$likrow;
	}


/*----------Pagination Part-2--------------*/

    $nums = @mysql_num_rows($res_all);

    $show = 5;

    $total_pages = ceil($nums / $adsperpage);



if($total_pages > 1){

   $showing   = !isset($_GET["page"]) ? 1 : $page;


   $firstlink = SITEROOT."/show_cheered_users/".$_GET['imageid']."/";

   $seperator = 'page/';

   $baselink  = $firstlink;

   $pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);

   $smarty -> assign("pgnation",$pgnation);

}

#-----------------------------------#




//echo "<pre>";print_r($usernames);echo "</pre>";
$smarty->assign("friend1",$usernames);
$smarty->assign("likcnt",$likcnt);
}


$smarty->display(TEMPLATEDIR .'/modules/photos/show_cheered_users.tpl');
?>
