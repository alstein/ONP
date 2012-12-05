<?php

include_once('../../include.php');
$tbl="tbl_deals d,tbl_users u,mast_deal_category mc";
$sf="u.first_name ,u.last_name,u.business_name,u.specility,u.about_us,u.address1,u.business_webURL,u.contact_detail,u.userid,mc.category,u.business_start_date1,u.business_end_date1,u.business_start_date2,u.business_end_date2,d.*";
$cd="d.merchant_id=u.userid and d.deal_unique_id=".$_GET['id1']." and d.status='active'";	

$res=$dbObj->gj($tbl, $sf , $cd, $ob, $gb, $ad, $l, $prn);
$row=@mysql_fetch_assoc($res);
$smarty->assign("deal",$row);

$maplocation=$row['address1'];
$mapLocation = urlencode(str_replace("\r\n", " ", trim($maplocation)));
$smarty->assign("maplocation",$maplocation);

$smarty->display(TEMPLATEDIR . '/modules/deal/map.tpl');
$dbObj->Close();
?>
