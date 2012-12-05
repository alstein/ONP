<?php
include_once('../../include.php');

include_once('../../includes/SiteSetting.php');
require_once("../../includes/classes/class.myaccount.php");
require_once("../../includes/common.lib.php");
include_once("../../includes/classes/combo.class.php");
include_once('../../includes/class.message.php');
include_once("../../includes/paging.php");
$msobj= new message();

if(!$_SESSION['duAdmId'])
	header("location:". SITEROOT . "/admin/login/index.php");




$date=date("Y-m-d H:i:s");
$smarty->assign("date",$date);
/*-----------------------Pagination Part1--------------------*/
$page=$_GET['page'];

if(!isset($_GET['page']))
    $page =1;
else
    $page = $page;

$newsperpage =20;
$StartRow = $newsperpage * ($page-1);
$l =  $StartRow.','.$newsperpage;



if(isset($_GET['searchuser'])!="")
{

	$search=$dbObj->sanitize($_GET['searchuser']);
	if($search!="")
			$cnd1_a = " AND (d.deal_title  LIKE '%{$search}%' OR d.original_price LIKE '%{$search}%'  OR d.redeem_from LIKE '%{$search}%'  OR d.redeem_to LIKE '%{$search}%' OR d.offer_price LIKE '%{$search}%' OR d.status LIKE '%{$search}%')";
}

	//$res = $dbObj->gj($tbl,$sf,$cnd,"deal_unique_id","","DESC",$l, "");
	$res = $dbObj->customqry("select d.*,u.fullname from tbl_deals d left join tbl_users u on d.merchant_id=u.userid where   d.merchant_id='".$_GET['userid']."'".$cnd1_a." group by d.deal_unique_id   LIMIT  ".$l, "");

	$res_all = $dbObj->customqry("select d.*,u.fullname from tbl_deals d left join tbl_users u on d.merchant_id=u.userid where   d.merchant_id='".$_GET['userid']."'".$cnd1_a." group by d.deal_unique_id", "");

//die();
   $i=0;
   while($row = @mysql_fetch_assoc($res))
   {
      $offer_deal[] = $row;
	$sel=$dbObj->customqry("select count(*) as count from tbl_deal_payment_unique where deal_id='".$row['deal_unique_id']."'","");	
	$row_deal = @mysql_fetch_assoc($sel);
	
	$offer_deal[$i]['count']=$row_deal['count'];
	$i++;
   }

//echo "<pre>"; print_r($offer_deal);
   $smarty->assign("offer_deal",$offer_deal);

// /*-----------------------Pagination Part2--------------------*/
//$rs = $dbObj->gj($tbl,$sf,$cnd,"deal_unique_id","","DESC","", "");

 $nums =@mysql_num_rows($res_all);
 $smarty -> assign("recordsFound",$nums);
$show = 10;
$total_pages = ceil($nums / $newsperpage);
if($total_pages > 1)
    $smarty -> assign("showpgnation","yes");

$showing   = !isset($_GET["page"]) ? 1 : $page;

if($_GET['searchuser'])
      $firstlink = "view_merchant_offered_deal.php?userid=".$_GET['userid']."&searchuser=".$_GET['searchuser'];
   else
      $firstlink = "view_merchant_offered_deal.php?userid=".$_GET['userid'];
   $seperator = '&page=';
   $baselink = $firstlink;

$pagenation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);
$smarty -> assign("pagenation",$pagenation);
/*-----------------------End Part2--------------------*/
$userid=$_GET['userid'];
$smarty->assign("userid",$userid);
$res_firstname = $dbObj->gj("tbl_users","business_name","userid=".$userid,"","","","","");
$row_firstname = @mysql_fetch_assoc($res_firstname);
$firstname = $row_firstname['business_name'];
$smarty->assign("firstname",$firstname);

  if($_SESSION['msg'])
   {
   $smarty->assign("msg", $_SESSION['msg']);
   $_SESSION['msg'] = NULL;
   unset($_SESSION['msg']);
   }


   #----------Success message=--------------#
$smarty->assign("inmenu","sitemodules");
$smarty->display(TEMPLATEDIR . '/admin/user/view_merchant_offered_deal.tpl');

$dbObj->Close();

?>
