<?php
include_once('../../include.php');
include_once("../../includes/paging.php");

if(!isset($_SESSION['csUserId']))
{
	header("location:".SITEROOT); exit;
}
$whose_profile="view_friend";
$smarty->assign("whose_profile",$whose_profile);

$row_meta=$dbObj->getseodetails(11);
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
}
else
{
$user=$_SESSION['csUserId'];
}
$select_merchant_fan1=$dbObj->customqry("select f.*,u.photo as photo1,u.first_name,u.last_name,u.facebook_userid from tbl_fan f left join tbl_users u on f.fan_id=u.userid  where f.userid='".$user."' and f.status='Active' and u.status='active' limit $l","");

$res_all=$dbObj->customqry("select f.*,u.photo as photo1,u.first_name,u.last_name,u.facebook_userid from tbl_fan f left join tbl_users u on f.fan_id=u.userid  where f.userid='".$user."' and f.status='Active' and u.status='active' ","");

while($res_merchants_fan1=@mysql_fetch_assoc($select_merchant_fan1))
{
	$merchants_fan1[]=$res_merchants_fan1;
}
$smarty->assign("merchants_fan1",$merchants_fan1);


/*----------Pagination Part-2--------------*/

    $nums = @mysql_num_rows($res_all);

    $show = 5;

    $total_pages = ceil($nums / $adsperpage);



if($total_pages > 1){

   $showing   = !isset($_GET["page"]) ? 1 : $page;


if($_GET['id1']!="")
      $firstlink = SITEROOT."/friend/".$_GET['id1']."/view_all_merchants_fan/";
else
	  $firstlink = SITEROOT."/friend/view_all_merchants_fan/";

   $seperator = 'page/';

   $baselink  = $firstlink;

   $pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);

   $smarty -> assign("pgnation",$pgnation);

}

#-----------------------------------#



$smarty->display(TEMPLATEDIR . '/modules/friend/view_all_merchants_fan.tpl');
$dbObj->Close();
?>