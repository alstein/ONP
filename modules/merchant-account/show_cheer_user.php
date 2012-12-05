<?php
include_once('../../include.php');
include_once("../../includes/paging.php");

if(!isset($_SESSION['csUserId']))
{
	header("location:".SITEROOT); exit;
}
$whose_profile="view_friend";
$smarty->assign("whose_profile",$whose_profile);

// print_r($_GET);exit;
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

if ($_GET['dealid']!="")
{
$sel_cheer=$dbObj->customqry("select c.*,u.* from tbl_cheers c left join tbl_users u on c.userid=u.userid  where c.deal_id='".$_GET['dealid']."' group by cheer_id","");
}
else
{
$sel_cheer=$dbObj->customqry("select c.*,u.* from tbl_cheers c left join tbl_users u on c.userid=u.userid  where c.activity_id='".$_GET['activityid']."' group by cheer_id","");
}

$i=0;
while($res_select_friend1=@mysql_fetch_assoc($sel_cheer))
{
	$friend1[]=$res_select_friend1;

	$sel_usertype=$dbObj->customqry("select * from tbl_users where userid='".$res_select_friend1['userid']."'","");
	$fetch_user=mysql_fetch_assoc($sel_usertype);
	if($fetch_user['usertypeid']==2)
	{
	$user_type="user";
	}
	else
	{
	$user_type="merchant";	
	}
	$friend1[$i]['usertype']=$user_type;
$i++;	
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






$smarty->display(TEMPLATEDIR . '/modules/merchant-account/show_cheer_user.tpl');
$dbObj->Close();
?>