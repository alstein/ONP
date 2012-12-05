<?php
include_once('../../include.php');
include_once('../../includes/SiteSetting.php');
include('../../includes/paging.php');

if(!isset($_SESSION['csUserId']))
{
	header("location:".SITEROOT); exit;
}


/*-----------------------Pagination Part1--------------------*/
if(!isset($_GET['page']))
   $page =1;
else
   $page = $_GET['page'];
   $adsperpage =1;
   $StartRow = $adsperpage * ($page-1);
   $l= $StartRow.','.$adsperpage;

/*-----------------------End Part1--------------------*/



$config['date'] = '%I:%M %p';
$config['time'] = '%H:%M:%S';
$smarty->assign('config', $config);

$tbl="tbl_offer_deal d left join tbl_users u on d.merchant_id=u.userid left join tbl_users u1 on d.user_id=u1.userid";
$sf="u.business_name,d.offerdate,d.status,d.offer_deal_id,u1.fullname";
$cnd="d.status!='no' and d.user_id=".$_SESSION['csUserId'];
$rs=$dbObj->gj($tbl, $sf, $cnd, "offer_deal_id", $gb, "desc", $l, "");
$rs_all=$dbObj->gj($tbl, $sf, $cnd, "offer_deal_id", $gb, "desc", "", "");

while($row=@mysql_fetch_array($rs)){
	$deals[]=$row;
}

$smarty->assign("deals",$deals);


/*----------Pagination Part-2--------------*/

    $nums = @mysql_num_rows($rs_all);

    $show = 5;

    $total_pages = ceil($nums / $adsperpage);



if($total_pages > 1){

   $showing   = !isset($_GET["page"]) ? 1 : $page;

   $firstlink = SITEROOT."/deal/deal-notifications/";

   $seperator = 'page/';

   $baselink  = $firstlink;

   $pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);

   $smarty -> assign("pgnation",$pgnation);

}

#-----------------------------------#

$smarty->display( TEMPLATEDIR . '/modules/deal/deal-notifications.tpl');
$dbObj->Close();
unset($_SESSION['str']);
?>

