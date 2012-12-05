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



/*-----------------------Pagination Part1--------------------*/
$page=$_GET['page'];

if(!isset($_GET['page']))
    $page =1;
else
    $page = $page;

$newsperpage =20;
$StartRow = $newsperpage * ($page-1);
$l =  $StartRow.','.$newsperpage;
/*-----------------------End Part1--------------------*/



//For search Content

if(isset($_GET['searchuser']))
{
	$search=$_GET['searchuser'];
	if($_GET['searchuser']=='Accepted')
	{
		$search='yes';
	}
	if($_GET['searchuser']=='Rejected')
	{
		$search='rejected';
	}
	if($_GET['searchuser']=='Pending')
	{
		$search="no";
	}
	$search=$dbObj->sanitize($search);
	$cnd_a = " AND (d.product_name  LIKE '%{$search}%' OR d.offerdate LIKE '%{$search}%'  OR d.amount_spend LIKE '%{$search}%'  OR d.discount LIKE '%{$search}%' OR d.outflow LIKE '%{$search}%' OR d.bid_validity LIKE '%{$search}%' OR d.bid_validity LIKE '%{$search}%' OR d.status LIKE '%{$search}%')";
}
	//$res = $dbObj->gj($tbl,$sf,$cnd,"deal_unique_id","","DESC",$l, "");
	$res = $dbObj->customqry("select d.*,u.fullname from tbl_offer_deal d left join tbl_users u on d.user_id=u.userid where   d.merchant_id='".$_GET['userid']."'".$cnd_a."group by d.offer_deal_id order by d.offer_deal_id  desc LIMIT  ".$l, "");

$res_all_a = $dbObj->customqry("select d.*,u.fullname from tbl_offer_deal d left join tbl_users u on d.user_id=u.userid where   d.merchant_id='".$_GET['userid']."'".$cnd_a."group by d.offer_deal_id order by d.offer_deal_id desc", "");

//die();
   $i=0;
   while($row = @mysql_fetch_assoc($res))
   {
      $offer_deal[] = $row;
		
   }


//echo "<pre>"; print_r($offer_deal);echo "</pre>";
   $smarty->assign("offer_deal",$offer_deal);

// /*-----------------------Pagination Part2--------------------*/
//$rs = $dbObj->gj($tbl,$sf,$cnd,"deal_unique_id","","DESC","", "");

 $nums =@mysql_num_rows($res_all_a);
 $smarty -> assign("recordsFound",$nums);
$show = 10;
$total_pages = ceil($nums / $newsperpage);
if($total_pages > 1)
    $smarty -> assign("showpgnation","yes");

$showing   = !isset($_GET["page"]) ? 1 : $page;
// $firstlink = basename($_SERVER['PHP_SELF']) . "?prod_deal_id=".$_GET['prod_deal_id'];
// $seperator = '&page=';
// $baselink  = $firstlink; 
if(isset($_GET['searchuser']))
      $firstlink = "view_merchant_incoming_deal.php?userid=".$_GET['userid']."&searchuser=".$_GET['searchuser'];
   else
      $firstlink = "view_merchant_incoming_deal.php?userid=".$_GET['userid'];
   $seperator = '&page=';
   $baselink = $firstlink;
$pagenation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);
$smarty -> assign("pagenation",$pagenation);
/*-----------------------End Part2--------------------*/

$userid=$_GET['userid'];
$smarty->assign("userid",$userid);

$res_firstname = $dbObj->gj("tbl_users","first_name","userid=".$userid,"","","","","");
$row_firstname = @mysql_fetch_assoc($res_firstname);
$firstname = $row_firstname['first_name'];
$smarty->assign("firstname",$firstname);

  if($_SESSION['msg'])
   {
   $smarty->assign("msg", $_SESSION['msg']);
   $_SESSION['msg'] = NULL;
   unset($_SESSION['msg']);
   }


   #----------Success message=--------------#
$smarty->assign("inmenu","sitemodules");
$smarty->display(TEMPLATEDIR . '/admin/user/view_merchant_incoming_deal.tpl');

$dbObj->Close();

?>
