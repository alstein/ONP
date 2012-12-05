<?php
//session_start();
include_once('../../include.php');
include_once('../../includes/classes/class.deals.php');

$tbl="tbl_deals d,tbl_users u,mast_deal_category mc";
$sf="u.first_name ,u.last_name,u.specility,u.about_us,u.address1,u.business_webURL,u.contact_detail,u.userid,mc.category,d.*";
$cd="d.merchant_id=u.userid and (u.deal_cat=mc.id and mc.active=1) and d.deal_unique_id=".$_GET['deal_id']." and d.status='active'";	
$res=$dbObj->gj($tbl, $sf , $cd, $ob, $gb, $ad, $l, $prn);
$row=@mysql_fetch_assoc($res);
$smarty->assign("deal",$row);

//map location

$maplocation=$row['address1'];
$mapLocation = urlencode(str_replace("\r\n", " ", trim($maplocation)));
$smarty->assign("maplocation",$maplocation);
//map location

//payment setting

$result = $dbObj->customqry("select * from tbl_payment_setting","");
$row = @mysql_fetch_assoc($result);

if($row['paymentmode'] == 1)
	$action = 'https://www.paypal.com/cgi-bin/webscr';
else
	$action = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
	
$businessEmailId = $row['paypal_account'];

$smarty->assign("businessEmailId", $businessEmailId);
$smarty->assign("action", $action);

//payment setting

	



$smarty->assign("pgName","deals");
$smarty->display(TEMPLATEDIR . '/modules/deal/buy.tpl');
$dbObj->Close();
?>