<?php
//session_start();
include_once('../../include.php');
include_once('../../includes/classes/class.deals.php');
include('../../includes/paging.php');

if($_SESSION['csUserId']=="" || $_SESSION['csUserTypeId']!=2){
	header("location:".SITEROOT);
}

#------------Pagination Part-1--------------------------------

if(!isset($_GET['page']))
		{
			$getpage='';
			$page =1;
		}
		else
		{
			$getpage = $_GET['page'];
			$page = $getpage;
		}

			$adsperpage = 10;
		$StartRow = $adsperpage * ($page-1);
		$l =  $StartRow.','.$adsperpage;
#-------------------------------------------------------------------------------#



$config['date'] = '%I:%M %p';
$config['time'] = '%H:%M:%S';
$smarty->assign('config', $config);

$tbl="tbl_offer_deal d,tbl_users u";
$sf="d.offer_deal_id,d.redeem_from,d.redeemtype,d.offerdate,d.redeem_to,d.status,d.bid_validity,d.discount,d.amount_spend,d.accepted_to_paid,d.product_name,u.business_name,d.amt_to_pin,d.offer_deal_id";
$cnd="d.user_id=u.userid and d.user_id=".$_SESSION['csUserId'];
$rs=$dbObj->gj($tbl, $sf, $cnd, "offer_deal_id", $gb, "desc", "", "");
$rs_all=$dbObj->gj($tbl, $sf, $cnd, "offer_deal_id", $gb, "desc", "", "");
$i=0;
while($row=@mysql_fetch_array($rs)){
	$deals[]=$row;

	$tbl1="tbl_users u,tbl_offer_deal d";
	$sf1="u.business_name";
	$cnd1="d.merchant_id=u.userid and d.offer_deal_id=".$row['offer_deal_id'];
	$rs1=$dbObj->gj($tbl1, $sf1, $cnd1, "", "", "", "", "");
	$row1=@mysql_fetch_assoc($rs1);
	$deals[$i]['business_name']=$row1['business_name'];

	$days = (strtotime($row['bid_validity']) - strtotime(date("Y-m-d"))) / (60 * 60 * 24);
	if($days<=0)
		$deals[$i]['days']="no";
	else
		$deals[$i]['days']="yes";

$i++;
}
//echo "<pre>";print_r($deals);echo "</pre>";
$smarty->assign("deals",$deals);


/*----------Pagination Part-2-------------------------------------------------------*/

		$nums = @mysql_num_rows($rs_all);
		$show = 3;
		$total_pages = ceil($nums / $adsperpage);
		if($total_pages > 0)
		$groupArray['showpaging']='yes';
		$showing   = !($getpage)? 1 : $getpage;
		$seperator = '&page=';
		$baselink  = $firstlink;

		$pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);
		$groupArray['paging']=$pgnation;
		$smarty->assign("pagination",$pgnation);
		$smarty->assign("count_record",$nums);
		$smarty->assign("total_page",$total_pages);

#----------------------delete photo-----------------------------------#



$smarty->display(TEMPLATEDIR . '/modules/deal/ajax_deal_offered_consumer.tpl');
$dbObj->Close();
?>