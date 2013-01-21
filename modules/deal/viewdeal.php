<?php
//session_start();
include_once('../../include.php');
include_once('../../includes/classes/class.deals.php');
include_once('../../include/SiteSetting.php');
//if($_SESSION['csUserId']==""){
//	header("location:".SITEROOT);
//}
if(!empty($_POST['shippingaddress'])){ //cupdtii
    $shippingaddress=$_POST['shippingaddress'];  
    $addressspin=$_POST['add3']."  ".$_POST['pin'];
    $field1shipp=array("shippingaddress_send"=>$shippingaddress,"address1"=>$_POST['add1'],
        "address2"=>$_POST['add2'],"address3"=>$addressspin);
    $userid = $dbObj->cupdtii("tbl_users",$field1shipp,"userid= '{$_SESSION['csUserId']}'","");
    echo "1";
    exit;
 }
//print_r($_GET);

// reducing rewards on each transaction 
if(isset($_POST['reward'])){
    if(($_POST['reward'])%10==0){
        $amountreduced_dollar= $_POST['reward']/10;
    }
    else{
        $amountreduced_dollar=($_POST['reward'])/10;
    } 
    $select3=$dbObj->customqry("SELECT rewardpoints, flag FROM tbl_rewards WHERE userid=".$_SESSION['csUserId']." and flag=4");
    $rsltset3=@mysql_fetch_assoc($select3);
    $rewardscurrent=$rsltset3['rewardpoints'];
    if($rewardscurrent >= $_POST['reward'])
    {
        $rewards=$rewardscurrent- $_POST['reward'];
        $updaterewards=$dbObj->customqry("update tbl_rewards set rewardpoints=".$rewards." where userid=".$_SESSION['csUserId']." and flag=4");
        $rsltset=@mysql_fetch_assoc($updaterewards);
        echo $amountreduced_dollar.",".$rewards; exit;
    }
}

$row_meta=$dbObj->getseodetails(22);
$smarty->assign("row_meta",$row_meta);

$select_deal_no=$dbObj->customqry("select max_deal_no  from tbl_deals where deal_unique_id='".$_GET['deal_id']."'","");
$res_deal_no=@mysql_fetch_array($select_deal_no);
$max_deal_no=$res_deal_no['max_deal_no'];

$select_deal_bought_cnt= $dbObj->customqry("select count(uniqueid) as count  from tbl_deal_payment_unique where deal_id='".$_GET['deal_id']."'","");
$res_deal_bought_cnt=@mysql_fetch_array($select_deal_bought_cnt);
$deal_count=$res_deal_bought_cnt['count'];
$no_of_bought=$max_deal_no-$deal_count;
$smarty->assign("no_of_bought",$no_of_bought);
//print_r($_SESSION);
$config['date'] = '%I:%M %p';

$config['time'] = '%H:%M:%S';

$smarty->assign('config', $config);
/*
$tbl="tbl_deals d,tbl_users u,mast_deal_category mc";
$sf="u.first_name ,u.last_name,u.specility,u.about_us,u.address1,u.business_webURL,u.contact_detail,u.userid,mc.category,u.business_start_date1,u.business_end_date1,u.business_start_date2,u.business_end_date2,d.*";
$cd="d.merchant_id=u.userid and (u.deal_cat=mc.id and mc.active=1) and d.deal_unique_id=".$_GET['deal_id']." and d.status='active'";	
*/

//get the admin 

$adminperres=$dbObj->customqry("select customer_pay from tbl_merchant_pay where id=1","");
$adminperrow=@mysql_fetch_array($adminperres);

//get the admin 

$tbl="tbl_deals d,tbl_users u,mast_deal_category mc";
$sf="u.email,u.first_name ,u.last_name,u.business_name,u.specility,u.about_us,u.address1,u.business_webURL,u.contact_detail,u.userid,mc.category,u.business_start_date1,u.business_end_date1,u.business_start_date2,u.business_end_date2,d.*";
$cd="d.deal_unique_id=".$_GET['deal_id']." and d.merchant_id=u.userid and u.deal_cat=mc.id and d.status='active'";	

$res=$dbObj->gj($tbl, $sf , $cd, $ob, $gb, $ad, $l, "");

$row=@mysql_fetch_assoc($res);
//print_r($row); exit;
$max_deals=$row['max_deal_no'];
$end_date=$row['deal_end_date'];
$shippingstatus=$row['shippingstatus'];
$smarty->assign("shippingstatus",$shippingstatus); 

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

$useridshipp=$_SESSION['csUserId'];
//shippingaddress insertion

//map location

$maplocation=$row['address1'];

if (strpos($maplocation, 'Singapore') !== false || strpos($maplocation, 'singapore') !== false) {

}else{
    $maplocation.= " Singapore";
}

$maplocation = str_replace(" ", "+", $maplocation);
$smarty->assign("maplocation",$maplocation);
$smarty->assign("mapuser",$user);

$region1="Singapore";
$json1 = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=$maplocation&sensor=false&region=$region1");
$json1 = json_decode($json1);

$lat1 = $json1->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
$long1 = $json1->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
$smarty->assign("lat1",$lat1);
$smarty->assign("long1",$long1);
//map location

$date=$row['deal_end_date'];
$edate=explode(" ",$row['deal_end_date']);
$edate1=explode("-",$edate['0']);
$smarty->assign("day",$edate1['2']);
$smarty->assign("month",$edate1['1']);
$smarty->assign("year",$edate1['0']);
$smarty->assign("yousave",$row['original_price']-$row['offer_price']);
$smarty->assign("currenttime", time());

//payment setting

$admin_comm=($row['offer_price']*$adminperrow['customer_pay'])/100;
$admin_comm=round($admin_comm,2);
$smarty->assign("admin_comm_amt",$admin_comm);
$smarty->assign("deal",$row);
$merchant_pay=$row['offer_price']-$admin_comm;
$smarty->assign("merchant_pay",$merchant_pay);
//merchant suncategory
/*$subcat_tbl="tbl_users u,mast_deal_category mc";
$subcat_sf="mc.category";
$subcat_cd="u.deal_subcat=mc.id and mc.active=1 and u.userid=".$row['userid'];	
$subcat_res=$dbObj->gj($subcat_tbl, $subcat_sf , $subcat_cd, $ob1, $gb1, $ad1, $l1, $prn);
$subcat_row=@mysql_fetch_assoc($subcat_res);
$smarty->assign("deal_subcat",$subcat_row);*/
//merchant suncategory

$mer_id=$row['merchant_id'];
$review_res=$dbObj->customqry("select r.*,u.first_name,u.last_name,u.photo,r.user_id from tbl_rating r left join tbl_users u on r.user_id =u.userid  where r.merchant_id ='".$row['merchant_id']."'  order by rating_id  DESC","");
$i=0;

while($review_row=@mysql_fetch_assoc($review_res))
{
    $review[]=$review_row;
    $review[$i]['empty_stars']=5-$review_row['average_rating'];

    $com=$dbObj->customqry("select a.*,u.userid,u.business_name,u.usertypeid,u.first_name,u.last_name,u.photo from tbl_activity a left join tbl_users u on a.uid=u.userid where a.review_id=".$review_row['rating_id'],"");
    $sub_num=@mysql_num_rows($com);
    $review[$i]['subcumcnt']=$sub_num;	
    while($row=@mysql_fetch_assoc($com))
    {
        $review[$i]['sub'][]=$row;
    }
    $i++;
}
$smarty->assign("review",$review);
//echo "<pre>";print_r($review);echo "</pre>";

// displaying reward points 
$select3=$dbObj->customqry("SELECT rewardpoints FROM tbl_rewards WHERE userid=".$_SESSION['csUserId']." and flag=4","");
$sumrewards=@mysql_fetch_assoc($select3);

$select31=$dbObj->customqry("SELECT rewardpoints FROM tbl_rewards WHERE userid=".$_SESSION['csUserId']." and flag=5","");
$sumrewards1=@mysql_fetch_assoc($select31);

if($sumrewards['rewardpoints']=="" && $sumrewards1['rewardpoints']==""){
    $sumreward_points= 0; 
}
else
{
    $sumreward_points=$sumrewards['rewardpoints']+$sumrewards1['rewardpoints'];
}

$smarty->assign("rewards",$sumreward_points);

//avg rating

$select_rating1=$dbObj->customqry("select *,count(rating_id)  as count,sum(average_rating) as sum_rating from tbl_rating where merchant_id ='".$mer_id."'","");
$res_rating1=@mysql_fetch_assoc($select_rating1);
$count1=$res_rating1['count'];
$sum_rating1=$res_rating1['sum_rating'];
$average_rating1=@($sum_rating1/$count1);
$smarty->assign("average_rating1",$average_rating1);

//avg rating

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

$todays_date=strtotime(date("Y-m-d H:i:s"));
$deal_end_date=strtotime($end_date);

$date1 = date("Y-m-d");
$date2 =$end_date;

$diff = abs(strtotime($date2) - strtotime($date1));

$years = floor($diff / (365*60*60*24));
$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
$hours = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24)/ (60*60));
$minuts = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60);

$todays_date = date("Y-m-d H:i:s");
$smarty->assign("todays_date",$todays_date);
$date_to_pass =date("Y-m-d H:i:s",$deal_end_date);
$smarty->assign("date_to_pass",$date_to_pass);

$smarty->assign("days",$days);
$smarty->assign("hours",$hours);
$smarty->assign("minuts",$minuts);

$deal_max_count_res=$dbObj->customqry("select sum(deal_quantity) as remaining_deals from tbl_deal_payment where deal_id=".$_GET['deal_id'],"");
$deal_max_count_row=@mysql_fetch_assoc($deal_max_count_res);

$todays_date=strtotime(date("Y-m-d H:i:s"));
$remaining_deals=$max_deals-$deal_max_count_row['remaining_deals'];
$smarty->assign("remaining_deals",$remaining_deals);

if($remaining_deals<=0)
{
    $deal_status='SOLD';
}
elseif($remaining_deals!=0 && $todays_date>$deal_end_date)
{
    $deal_status='Expired';
}
else
{
    $deal_status='running';
}

//chk how many deals are remaining_deals out  of tiotal number of deals

//chk deal end date

// if($todays_date>$deal_end_date){
// 	 $deal_status='complete';
// }else{
// 	 $deal_status='running';
// }

$smarty->assign("deal_status",$deal_status);
//chk deal end date

$smarty->assign("pgName","deals");
$smarty->display(TEMPLATEDIR . '/modules/deal/viewdeal.tpl');
$dbObj->Close();

?>