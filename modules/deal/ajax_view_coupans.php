<?php
//session_start();
include_once('../../include.php');
include_once('../../includes/classes/class.deals.php');

$config['date'] = '%I:%M %p';
$config['time'] = '%H:%M:%S';
$smarty->assign('config', $config);
//and  du.user_id=".$_SESSION['csUserId']
//$rs=$dbObj->customqry("select du.uniqueid,p.*,du.coupon_id,du.uniqueid from tbl_deal_payment  as p left join tbl_deal_payment_unique as du ON p.pay_id=du.pay_id and du.user_id=".$_SESSION['csUserId'],"1"

$rs=$dbObj->customqry("select dp.uniqueid,dp.coupon_id,d.deal_title from tbl_deal_payment_unique dp,tbl_deals d where dp.deal_id=d.deal_unique_id and dp.deal_id=".$_POST['deal_id']." and dp.user_id=".$_SESSION['csUserId'],"");
$i=0;
while($voucher=@mysql_fetch_assoc($rs))
		{
			$view_voucher[$i]=$voucher;
			$i++;
		}
$smarty->assign("view_voucher",$view_voucher);

$smarty->assign("deals",$deals);

$smarty->display(TEMPLATEDIR . '/modules/deal/ajax_view_coupans.tpl');
$dbObj->Close();
?>