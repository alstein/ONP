<?php
//session_start();
include_once('../../include.php');
include_once('../../includes/classes/class.deals.php');
include('../../includes/paging.php');

if($_SESSION['csUserId']=="" || $_SESSION['csUserTypeId']!=2){
	header("location:".SITEROOT);
}


$config['date'] = '%I:%M %p';
$config['time'] = '%H:%M:%S';
$smarty->assign('config', $config);


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



$tbl="tbl_deal_payment p,tbl_deals d,tbl_users u";
$sf="d.deal_title,d.deal_unique_id,d.redeem_to,p.buy_date,d.original_price,d.discount_in_per,d.deal_unique_id,d.offer_price,d.deal_unique_id";
$cnd="p.user_id=u.userid and p.deal_id=d.deal_unique_id and p.user_id=".$_SESSION['csUserId'];
$rs=$dbObj->gj($tbl, $sf, $cnd, "pay_id", $gb, "desc", "", "");
$rs_all=$dbObj->gj($tbl, $sf, $cnd, "pay_id", $gb, "desc", "", "");
$i=0;
while($row=@mysql_fetch_array($rs)){
	$deals[]=$row;

	$tbl1="tbl_users u,tbl_deals d";
	$sf1="u.business_name";
	$cnd1="d.merchant_id=u.userid and d.deal_unique_id=".$row['deal_unique_id'];
	$rs1=$dbObj->gj($tbl1, $sf1, $cnd1, "", "", "", "", "");
	$row1=@mysql_fetch_assoc($rs1);
	$deals[$i]['merchant_name']=$row1['business_name'];
$i++;
}

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


$smarty->display(TEMPLATEDIR . '/modules/deal/ajax_deal_bought_consumer.tpl');
$dbObj->Close();
?>