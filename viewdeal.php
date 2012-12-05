<?php
//session_start();
include_once('../../include.php');
include_once('../../includes/classes/class.deals.php');
if($_SESSION['csUserId']==""){
	header("location:".SITEROOT);
}
print_r($_SESSION);
$config['date'] = '%I:%M %p';

$config['time'] = '%H:%M:%S';

$smarty->assign('config', $config);

$tbl="tbl_deals d,tbl_users u,mast_deal_category mc";
$sf="u.first_name ,u.last_name,u.specility,u.about_us,u.address1,u.business_webURL,u.contact_detail,u.userid,mc.category,u.business_start_date1,u.business_end_date1,u.business_start_date2,u.business_end_date2,d.*";
$cd="d.merchant_id=u.userid and (u.deal_cat=mc.id and mc.active=1) and d.deal_unique_id=".$_GET['deal_id']." and d.status='active'";	
$res=$dbObj->gj($tbl, $sf , $cd, $ob, $gb, $ad, $l, $prn);
$row=@mysql_fetch_assoc($res);
$smarty->assign("deal",$row);

//merchant suncategory
$subcat_tbl="tbl_users u,mast_deal_category mc";
$subcat_sf="mc.category";
$subcat_cd="u.deal_subcat=mc.id and mc.active=1 and u.userid=".$row['userid'];	
$subcat_res=$dbObj->gj($subcat_tbl, $subcat_sf , $subcat_cd, $ob1, $gb1, $ad1, $l1, $prn);
$subcat_row=@mysql_fetch_assoc($subcat_res);
$smarty->assign("deal_subcat",$subcat_row);
//merchant suncategory


$review_res=$dbObj->customqry("select r.*,u.first_name,u.last_name,u.photo from tbl_rating r left join tbl_users u on r.user_id =u.userid  where r.merchant_id ='".$row['merchant_id']."'  order by rating_id  DESC","");
$i=0;

while($review_row=mysql_fetch_assoc($review_res)){
	$review[]=$review_row;
	$review[$i]['empty_stars']=5-$review_row['average_rating'];
	$i++;
}
$smarty->assign("review",$review);


//avg rating

$select_rating1=$dbObj->customqry("select *,count(rating_id)  as count,sum(average_rating) as sum_rating from tbl_rating where merchant_id ='".$row['userid']."'","");
$res_rating1=@mysql_fetch_assoc($select_rating1);
$count1=$res_rating1['count'];
$sum_rating1=$res_rating1['sum_rating'];
$average_rating1=@($sum_rating1/$count1);
$smarty->assign("average_rating1",$average_rating1);

//avg rating

//map location

$maplocation=$row['address1'];
$mapLocation = urlencode(str_replace("\r\n", " ", trim($maplocation)));
$smarty->assign("maplocation",$maplocation);
//map location

$date=$row['deal_end_date'];
$edate=explode(" ",$row['deal_end_date']);
$edate1=explode("-",$edate['0']);
$smarty->assign("day",$edate1['2']);
$smarty->assign("month",$edate1['1']);
$smarty->assign("year",$edate1['0']);


//payment setting



$result = $dbObj->customqry("select * from tbl_payment_setting","");

$row1 = @mysql_fetch_assoc($result);



if($row1['paymentmode'] == 1)

	$action = 'https://www.paypal.com/cgi-bin/webscr';

else
	$action = 'https://www.sandbox.paypal.com/cgi-bin/webscr';

	
$businessEmailId = $row1['paypal_account'];


$smarty->assign("businessEmailId", $businessEmailId);

$smarty->assign("action", $action);



//payment setting


//chk how many deals are remaining_deals out of tiotal number of deals<br>

$deal_max_count_res=$dbObj->customqry("select count(deal_quantity) as remaining_deals from tbl_deal_payment where deal_id=".$_GET['deal_id'],"1");
$deal_max_count_row=@mysql_fetch_assoc($deal_max_count_res);
$remaining_deals=$row['max_deal_no']-$deal_max_count_row['remaining_deals'];
$smarty->assign("remaining_deals",$remaining_deals);

//chk how many deals are remaining_deals out  of tiotal number of deals


//chk deal end date
$todays_date=strtotime(date("Y-m-d H:i:s"));
$deal_end_date=strtotime($row['deal_end_date']);
if($todays_date>$deal_end_date){
	 $deal_status='complete';
}else{
	 $deal_status='running';
}

$smarty->assign("deal_status",$deal_status);
//chk deal end date


//business hour 
$business_start_date1=$row['business_start_date1'];
$bse=explode(":",$business_start_date1);
$business_start_hours=$smarty->assign("business_start_hours",$bse['0']);
$business_start_minute=$smarty->assign("business_start_minute",$bse['1']);

$business_end_date1=$row['business_end_date1'];
$bed=explode(":",$business_end_date1);
$business_end_hours=$smarty->assign("business_end_hours",$bed['0']);
$business_end_minute=$smarty->assign("business_end_minute",$bed['1']);


$business_start_date2=$row['business_start_date2'];
$bse1=explode(":",$business_start_date2);
$business_start_hours1=$smarty->assign("business_start_hours1",$bse1['0']);
$business_start_minute1=$smarty->assign("business_start_minute1",$bse1['1']);

$business_end_date2=$row['business_end_date2'];
$bed1=explode(":",$business_end_date2);
$business_end_hours1=$smarty->assign("business_end_hours1",$bed1['0']);
$business_end_minute1=$smarty->assign("business_end_minute1",$bed1['1']);



//business hour 

$smarty->assign("pgName","deals");
$smarty->display(TEMPLATEDIR . '/modules/deal/viewdeal.tpl');
$dbObj->Close();
?>