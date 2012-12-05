<?php
ob_start();
//ini_set("session.save_path", "/home/usortd/tmp");
session_start();
include_once("../../../includes/SiteConfig.php");
include_once("../../../includes/libs/Smarty.class.php");
if(!$_SESSION['duAdmId'])
	header("location:".SITEROOT . "/admin/login/index.php");
$smarty = new Smarty;
$smarty->compile_check = true;

include_once('../../../includes/DBTransact.php');
include_once('../../../includes/SiteSetting.php');
include_once("../../../includes/paging.php");
include_once("../../../includes/Functions.php");

//include_once("../../../includes/classes/class.rns_common_function.php");
//$smarty = new Smarty;
//$smarty->compile_check = true;

$dbObj = new DBTransact();
$dbObj->Connect();
$fnObj    = new functions();
//$Rns_Obj =  new RNS_Common_Functions();


if(isset($_SESSION['msg_suc']))
{
	$smarty->assign("suc_msg",$_SESSION['msg_suc']);
	unset($_SESSION['msg_suc']);
}

//Code starts for calendar
/* don't useable now */

$sql_date = "$year-$month-$today";
/*  calculate todays'date or selected date */

// exit;
if($_GET['act'] == 'next')
{
	if($month == '13')
	{
 		$year=$year+1;
		$month=1;
	}
	else
	{
		$year=$year;
		$month=$month;
	}
//	if($month == '12'
	$sql_date = "$year-$month-$today";
}
elseif($_GET['act']== 'prev')
{
	if($month == '0')
	{
		$year=$year-1;
		$month=1;
	}
	else
	{
		$year=$year;
		$month=$month;
	}
	$sql_date = "$year-$month-$today";
}
elseif($sql_date=="--")
{
	  $sql_date =date("Y-m-d H:i:s");
}


// country
	$res1 = $dbObj->cgs("mast_country","",array("status"),array("active"),"country asc","","");
	$array = array();
	while($row1 = @mysql_fetch_assoc($res1))
	{
		$array[] = $row1;
	}
	$smarty->assign("country",$array);

// 	$get = $dbObj->cgs("mast_city","city_name,city_id",array("countryid"),array(14),"","","");
// 	while($getCity = @mysql_fetch_assoc($get))
// 	{
// 		$array_city[] = $getCity;
// 	}
// 	$smarty->assign("city_arr",$array_city);

	//if($_GET['country'])
	//{
		$res2 = $dbObj->cgs("mast_city","city_name,city_id",array('active_city'),array("1"),"","","");
		while($row2 = @mysql_fetch_assoc($res2))	
		{
			$arr_city[] = $row2;
		}
		$smarty->assign("city_arr",$arr_city);
	//}
	extract($_GET);
	$city = ($_GET['city']?$_GET['city']:$array_city[0]['city_name']);
	$city_rep = str_replace(" ","-",$city);
	$smarty->assign("city_rep",$city_rep);
	$getCountry = ($_GET['country']?$_GET['country']:14);
	$smarty->assign("getCountry",$getCountry);
// echo $month;
// echo $year;
	/**** current date , month and  year    ****/
	$current_date = explode("-", date("Y-m-d"));	
	$smarty->assign("current_year", $current_date[0]);
	$smarty->assign("current_month", $current_date[1]);
	$smarty->assign("current_day", $current_date[2]);
	
	$cur_month = date("n",time());
	$cur_year =date("Y",time());
	$cur_today =date("j", time());
/* Some required varibals related to  selected date of event */
	 $month = (isset($month)) ? $month : date("n",time());
	 $year = (isset($year)) ? $year : date("Y",time());
	 $today = (isset($today))? $today : date("j", time());
	$daylong = date("l",mktime(1,1,1,$month,$today,$year));
	$monthlong = date("F",mktime(1,1,1,$month,$today,$year));
	$month_year = date ("F Y", mktime(0,0,0,$month,$today,$year));
	$dayone = date("w",mktime(1,1,1,$month,1,$year));
	$numdays = date("t",mktime(1,1,1,$month,1,$year));
	$alldays = array('SUN','MON','TUE','WED','THU','FRI','SAT');
	
	
	$smarty->assign("month_year",$month_year);

/* limits for year drop down */
	$start_year=$year-3;
	$smarty->assign("start_year",$start_year);
	$end_year=$year+9;
	$smarty->assign("end_year",$end_year);


	$next_month = $month+1;
	if($next_month == 13)
	{
		$next_month = 1;
		$next_year = $year +1;// + 1;
		$smarty->assign("next_year",$next_year);
	}
	
	$last_month = $month-1;
	if($last_month == 0)
	{
		$last_month = 12;
		$last_year = $year-1;// - 1;
    		$smarty->assign("last_year",$last_year);
	}
	if ($today > $numdays) { $today--; }
	$sql_currentday = "$year-$monthd-$zzd";
	$sql_currentday2=date("Y-m-d");
	$create_emptys = 7 - (($dayone + $numdays) % 7);	


    $smarty->assign("cur_today",$cur_today);
    $smarty->assign("cur_month",$cur_month);
    $smarty->assign("cur_year",$cur_year);

    $smarty->assign("today",$today); 
    $smarty->assign("month",$month);
    $smarty->assign("year",$year);
    $smarty->assign("next_month",$next_month);
    $smarty->assign("last_month",$last_month);
    
    //echo "numdays  --- >".$numdays;
    $smarty->assign("numdays",$numdays);
    

    $smarty->assign("daylong",$daylong);
    $smarty->assign("alldays",$alldays);
    $smarty->assign("dayone",$dayone);
    //echo $sql_date;
    $smarty->assign("sql_date",$sql_date);
    $smarty->assign("displaydate",date("F",mktime(1,1,1,$month,1,$year)));
    $smarty->assign("sql_currentday2",$sql_currentday2);
    $smarty->assign("create_emptys", $create_emptys );

/****************Code to display appointments**********************/
 for($d=0;$d<$numdays;$d++)
 {
	if($d<9)
	{	
	$dt1=$d+1;
	$dt="0".$dt1;
	}
	else
	{
		$dt=$d+1;
	}
// echo "<pre>";
 $_appnt_dt = $year."-".$month."-".$dt;
 $_appnt_dt1 = $year."-".$month."-".$dt;
 //$_appnt_dt1=$year."-".$month."-".$dt." 23:59:59";
 $appnt_dt=$year."-".$month."-".$dt." 00:00:01";
 $appnt_dt1=$year."-".$month."-".$dt." 23:59:59";
// echo  "       ".$datear=date("Y-m-d");
	
	if($_appnt_dt >= date("Y-m-d"))
	{
		$consumer_date_status[$d] = "yes";
	}
	else
	{
		$consumer_date_status[$d] = "no";
	}
	$condapp = "(('$appnt_dt' >= p.deal_start_date or '$appnt_dt1' >= p.deal_start_date) AND (p.deal_end_date >= '$appnt_dt' or p.deal_end_date >= '$appnt_dt1')) and p.product_city = '$city'";
         
	$sp_nm = $dbObj->gj("tbl_deal as p","",$condapp,"","deal_type DESC","","","");
        $num_appoint = @mysql_num_rows($sp_nm);
	if($num_appoint>0)
	{
		$j=0;
		$del = "";
		$sum = "";
		$fin = "";
		$deals = array();
		while($arr = @mysql_fetch_assoc($sp_nm))
		{
			if($arr['product_id'])
			{
				
// 				$fin .= $del.$sum.$arr['product_id'];
// 				$sum = ",";
				$deals[] = $arr;
			}
		}
	}
	
	/************Code for other events**********/
	$condevent = "(('$appnt_dt' >= p.deal_start_date or '$appnt_dt1' >= p.deal_start_date) AND (p.deal_end_date >= '$appnt_dt' or p.deal_end_date >= '$appnt_dt1'))  and p.product_city = '$city'";
	
 	$sp_nm1 = $dbObj->gj("tbl_deal as p","",$condevent,"","","","",""); 

       // echo $num_appoint1 = @mysql_num_rows($sp_nm1);
 	$num_otherapevt[] = $num_appoint1;
	if($num_appoint || $num_appoint1)
 	 {
	   $consumer_status[$d] = "busy";	
	/************Events**************/
 	$condevent = "(('$appnt_dt' >= p.deal_start_date or '$appnt_dt1' >= p.deal_start_date) AND (p.deal_end_date >= '$appnt_dt' or p.deal_end_date >= '$appnt_dt1')) and p.product_city = '$city'";
 	$sp_nmeve = $dbObj->gj("tbl_deal as p","",$condevent,"","","","",""); 
        $connum_event[$d]['num'] = @mysql_num_rows($sp_nmeve);	
	$connum_event[$d]['final_deals'] = $deals;
	$arr = @mysql_fetch_assoc($sp_nmeve);
	$connum_event[$d]['deal'] = $arr['product_id'];
	 
 	/***********Tasks*************/
 	
         }else
	 {
 	   $consumer_status[$d] = "free";
	
 	 }
 }
/*echo "<pre>";
print_R($connum_event);exit;*/
$smarty->assign("consumer_date_status",$consumer_date_status);
$smarty->assign("consumer_status",$consumer_status);
$smarty->assign("deals", $connum_event);


//$ads = $Rns_Obj->Show_Ads("" , $ex1 , $ex2 , $ex3 , $ex4 ,$ex5);

//$smarty->assign("ads_num", $ads[0]);
//$smarty->assign("ads", $ads[1]);
/*****************************************
End Show ads on the right side
*****************************************/

//$smarty->debugging = true;

$smarty->display(TEMPLATEDIR.'/admin/globalsettings/deal/calendarview_month2.tpl');

?>
