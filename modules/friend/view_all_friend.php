<?php
include_once('../../include.php');
include_once("../../includes/paging.php");

if(!isset($_SESSION['csUserId']))
{
	header("location:".SITEROOT); exit;
}
$whose_profile="view_friend";
$smarty->assign("whose_profile",$whose_profile);

$row_meta=$dbObj->getseodetails(16);
$smarty->assign("row_meta",$row_meta);


/*-----------------------Pagination Part1--------------------*/
if(!isset($_GET['page']))
   $page =1;
else
   $page = $_GET['page'];
   $adsperpage =20;
   $StartRow = $adsperpage * ($page-1);
   $l= $StartRow.','.$adsperpage;

/*-----------------------End Part1--------------------*/



if($_GET['id1']!="")
{
$user=$_GET['id1'];
}else
{
$user=$_SESSION['csUserId'];
}

$select_user_details=$dbObj->customqry("select * from tbl_users where userid='".$user."'","");
$res_select_qry=@mysql_fetch_assoc($select_user_details);
$smarty->assign("user",$res_select_qry);

$select_user_friend1=$dbObj->customqry("select f.*,u.photo as photo1,u1.photo as photo2,u.first_name,u.last_name,u1.first_name as first_name1,u1.last_name as last_name1 ,u.facebook_userid,u1.facebook_userid as 	facebook_userid1 from tbl_friends f left join tbl_users u on f.userid=u.userid  left join tbl_users u1 on f.friendid=u1.userid where (f.userid='".$user."' or f.friendid='".$user."') and f.verification='yes'  and u.status='active' and u1.status='active' and f.status='Active'  group by f.userid,f.friendid limit $l","");

$res_all=$dbObj->customqry("select f.*,u.photo as photo1,u1.photo as photo2,u.first_name,u.last_name,u1.first_name as first_name1,u1.last_name as last_name1,u.facebook_userid,u1.facebook_userid as 	facebook_userid1 from tbl_friends f left join tbl_users u on f.userid=u.userid  left join tbl_users u1 on f.friendid=u1.userid where (f.userid='".$user."' or f.friendid='".$user."') and f.verification='yes' and u.status='active' and u1.status='active' and f.status='Active'  group by f.userid,f.friendid ","");


while($res_select_friend1=@mysql_fetch_assoc($select_user_friend1))
{
	$friend1[]=$res_select_friend1;
}
$smarty->assign("friend1",$friend1);






/*----------Pagination Part-2--------------*/

    $nums = @mysql_num_rows($res_all);

    $show = 5;

    $total_pages = ceil($nums / $adsperpage);



if($total_pages > 1){

   $showing   = !isset($_GET["page"]) ? 1 : $page;


if($_GET['id1']!="")
      $firstlink = SITEROOT."/friend/".$_GET['id1']."/view_all_friend/";
else
	  $firstlink = SITEROOT."/friend/view_all_friend/";

   $seperator = 'page/';

   $baselink  = $firstlink;

   $pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);

   $smarty -> assign("pgnation",$pgnation);

}

#-----------------------------------#






$smarty->display(TEMPLATEDIR . '/modules/friend/view_all_friend.tpl');
$dbObj->Close();
?>