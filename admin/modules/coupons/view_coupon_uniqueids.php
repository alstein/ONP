<?php
include_once("../../../include.php");
include_once('../../../includes/SiteSetting.php');
include_once("../../../includes/paging.php");
include_once('../../../includes/class.message.php');


if(!$_SESSION['duAdmId']){	header("location:".SITEROOT . "/admin/login/_welcome.php");	}

 $coupon_id = ($_GET['coupon_id']?$_GET['coupon_id']:0);

 $query = "select * from tbl_coupon_master where coupon_id = '".$coupon_id."'";
$rs = mysql_query($query);
	while($row = @mysql_fetch_assoc($rs))
	{
		$coupondet = $row;
	}

$smarty->assign("coupondet",$coupondet);

// SQl suery for the list starts

#------------Pagination Part-1------------#

if(!isset($_GET['page']))
	$page =1;
else
	$page = $_GET['page'];
	$adsperpage =20;
	$StartRow = $adsperpage * ($page-1);
	$l= $StartRow.','.$adsperpage;
/*-----------------------------------*/


 $rs_coupUnq_query = "select * from tbl_coupon_master_uniqueids where coupon_id = '".$coupon_id."' order by uniqueid limit $l";
 $rs = mysql_query($rs_coupUnq_query);

while($row = @mysql_fetch_assoc($rs))
{
   $uniquecoupondet[] = $row;
}

$smarty->assign("uniquecoupondet", $uniquecoupondet);

/*----------Pagination Part-2--------------*/

	$rs=$dbObj->gj("tbl_coupon_master_uniqueids","*","coupon_id = ".$coupon_id,"", "", "", "", "");
	$nums = @mysql_num_rows($rs);
	$show = 20;
	$total_pages = ceil($nums / $adsperpage);

if($total_pages > 1){
        $smarty->assign("showpgnation","yes");
	$showing   = !isset($_GET["page"]) ? 1 : $page;
	$firstlink = "view_coupon_uniqueids.php?coupon_id=".$_GET['coupon_id'];

	$seperator = '&page=';
	$baselink  = $firstlink;
	$pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);
	$smarty -> assign("pgnation",$pgnation);
}

#-----------------------------------#

// query for Listing informations Ends

$smarty->assign("inmenu","sitemodules");

   #----------Success message=--------------#
   if($_SESSION['msg']){
      $smarty->assign("msg", $_SESSION['msg']);
      $_SESSION['msg'] = NULL;
      unset($_SESSION['msg']);
   }
   #--------------End-----------------------#

$smarty->display(TEMPLATEDIR . '/admin/modules/coupons/view_coupon_uniqueids.tpl');

$dbObj->Close();
?>