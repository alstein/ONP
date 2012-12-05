<?php
ob_start();
session_start();
date_default_timezone_set('Asia/Singapore');
include_once('includes/SiteSetting.php');
include_once('includes/input.php');
include_once("includes/JSON.php");
include_once("includes/Functions.php");
include_once("includes/function.php");
include_once("includes/common.lib.php");
//include_once ("db_mysql.inc");
include_once("includes/classes/combo.class.php");
include_once("includes/AccessLevel.php");



$input = new input();
$date=date("Y-m-d H:i:s");

$currTime = mktime(date("H",time())+5,date("i",time())+30,date("s",time()),date("m",time()),date("d",time()),date("Y",time()));

//**************************Find Address Of User********************************************//
if($_GET['id1']!="")
{
$user=$_GET['id1'];
}
elseif($_GET['user']!="")
{
$select_userid=$dbObj->customqry("select userid from tbl_users where username='".$_GET['user']."'","");
$res_select_userid=@mysql_fetch_assoc($select_userid);
$user=$res_select_userid['userid'];
}
else
{
$user=$_SESSION['csUserId'];
}


$select_setting=$dbObj->customqry("select address1,fullname,business_name,usertypeid from tbl_users where userid='".$user."'","");
$res_select_setting=@mysql_fetch_assoc($select_setting);
$map_location=$res_select_setting['address1'];

if (strpos($map_location, 'Singapore') !== false || strpos($map_location, 'singapore') !== false) {

}else{
$map_location.= " Singapore";
}
$map_location = str_replace(" ", "+", $map_location);
$smarty->assign("maplocation",$map_location);
$smarty->assign("mapuser",$user);

$region="Singapore";
$json = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=$map_location&sensor=false&region=$region");
$json = json_decode($json);

$lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
$long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
$smarty->assign("lat",$lat);
$smarty->assign("long",$long);


if($res_select_setting['usertypeid']==2){
	$seoname=str_replace("-"," ",(ucfirst($res_select_setting['fullname'])));
}else{
	$seoname=str_replace("-"," ",ucfirst($res_select_setting['business_name']));
}

if($seoname=="")
	$seoname=str_replace("-"," ",$_SESSION['csFullName']);


$smarty->assign("seoname",$seoname);

//**************************End Of Find Address Of User*************************************//
$sf="count(id) as count,verification";
$cnd="(userid='".$_SESSION['csUserId']."' and friendid='".$_GET['id1']."')or (userid='".$_GET['id1']."' and friendid='".$_SESSION['csUserId']."')";
$tbl="tbl_friends ";
$sel_friend=$dbObj->gj($tbl, $sf, $cnd, "", "", "", "", "");
$res_friend=@mysql_fetch_assoc($sel_friend);
$count_friend=$res_friend['count'];
$smarty->assign("count_friend",$count_friend);
$smarty->assign("res_friend",$res_friend);

$sf1="count(id) as count";
$cnd1="(userid='".$_GET['id1']."' and fan_id='".$_SESSION['csUserId']."')";
$tbl1="tbl_fan ";
$sel_fan=$dbObj->gj($tbl1, $sf1, $cnd1, "", "", "", "", "");
$res_fan=@mysql_fetch_assoc($sel_fan);
$count_fan=$res_fan['count'];
$smarty->assign("count_fan",$count_fan);


$t=$dbObj->customqry("select usertypeid from tbl_users where userid=".$_GET['id1'],"");
$r=@mysql_fetch_assoc($t);
$smarty->assign("chkusertype",$r['usertypeid']);

if(isset($_POST['submit_login'])){

      if($_POST['lemail']!="" && $_POST['lpassword']!=""){
       
                $query = "select * from tbl_users where email='".trim($_POST['lemail'])."' and password = '".trim(md5($_POST['lpassword']))."' and isverified ='yes' and status='active' and isDeleted=0 and usertypeid!=1";
       
         $res = @mysql_query($query);
       $num = @mysql_num_rows($res);
         if($num>0){
         
            $usersInfo = mysql_fetch_object($res);
		$usersInfo->usertypeid;
            if($usersInfo->usertypeid == 2 || $usersInfo->usertypeid == 3){
               if($_POST['isremember'] == 1){
                  setcookie("lemail", $_POST['lemail'],time()+3600);
                  setcookie("lpassword", $_POST['lpassword'],time()+3600);
                  setcookie("isremember", 1);
               }else{
                  setcookie("lemail", "");
                  setcookie("lpassword", "");
                  setcookie("isremember", 0);
               }

               $_SESSION['usrLgn']        = "TRUE";
               $_SESSION['csUserId']      =  $usersInfo->userid;
		 if($usersInfo->usertypeid == 2)
		{
               		$_SESSION['csFullName']    =  $usersInfo->fullname;
		}
		else	
		{
			$_SESSION['csFullName']    =  $usersInfo->business_name;
		}
               $_SESSION['csEmail']    	  =  $usersInfo->email;
               $_SESSION['csUserTypeId']  =  $usersInfo->usertypeid;
               $_SESSION['csUserAvtar']   =  ((strlen(trim($usersInfo->pic_image))>0)?$usersInfo->pic_image:"noimage");
   		
		
		
			 $f_array = array("userid"     => $usersInfo->userid,
                           "login_date"      => date("Y-m-d H:i:s"),
                           "ipaddress"       => $_SERVER['REMOTE_ADDR']);
   
			$dbObj->cgii("tbl_login_log",$f_array,"");
		

 		$_SESSION['sign-in-message']="<span>".getFrontErrorMessage(1)."</span>";
		$previous_page=$_SESSION['previous_page'];
		if($_SESSION['previous_page']!="")
		{
			$previoue_page="";
			 $login_error = "The username entered does not belong to any account. Please ensure that it is typed correctly.";
			 $_SESSION['login_error']=$login_error;
			@header("Location:".SITEROOT."/login/");
 			exit;
		}
		else
		{
			
			if($_SESSION['csUserTypeId']==2)
			{
			@header("Location:".SITEROOT."/my-account/my_profile_home");
			exit;
			}
			elseif($_SESSION['csUserTypeId']==3)
			{
				$res=$dbObj->customqry("select * from tbl_deal_condition where merchant_id=".$_SESSION['csUserId'],"");
				$num=@mysql_num_rows($res);
				if($num>0)
					$_SESSION['alertpopup']="no";
				else
					$_SESSION['alertpopup']="yes";

			@header("Location:".SITEROOT."/merchant-account/merchant_profile_home");
			exit;
			}
		}	
            }
        else{
            }
         }
         else{
             $login_error = "The username entered does not belong to any account. Please ensure that it is typed correctly.";
			 $_SESSION['login_error']=$login_error;
			@header("location:".SITEROOT."/login/");
// 		 echo "<script>";
// 		echo "alert(\"Your email and or password is incorrect or till you are not verified. Please try again.\");";
// 		echo "</script>";

            $smarty->assign("login_error",$login_error);
         }
         
      }else{
	
          $login_error = "The username entered does not belong to any account. Please ensure that it is typed correctly.";
		  $_SESSION['login_error']=$login_error;
		  @header("Location:".SITEROOT."/login/");
      }

      $smarty->assign("login_error",$login_error);
   }

//*************************************find that login user is friend of search user or not********************//
$select=$dbObj->customqry("select COUNT(id) as count   from tbl_friends where (userid='".$_SESSION['csUserId']."' and friendid='".$_GET['id1']."') or (userid='".$_GET['id1']."' and friendid='".$_SESSION['csUserId']."')","");
$res=@mysql_fetch_assoc($select);
$loc_count=$res['count'];
$smarty->assign("loc_count",$loc_count);
//*****************************************************END*************************************************//

//******************Start Of find the details of profile left section********************************************//

if($_GET['id1']!="")
{
$user=$_GET['id1'];
}
elseif($_GET['user']!="")
{
$select_username=$dbObj->customqry("select * from tbl_users where username='".$_GET['user']."'","");
$res_select_username=@mysql_fetch_assoc($select_username);
$user=$res_select_username['userid'];
}
else
{
$user=$_SESSION['csUserId'];
}

$select_user_details=$dbObj->customqry("select * from tbl_users where userid='".$user."'","");
$res_select_qry=@mysql_fetch_assoc($select_user_details);
$smarty->assign("user",$res_select_qry);

$select_user_friend=$dbObj->customqry("select f.*,u.photo as photo1,u1.photo as photo2,u.first_name,u.fullname as full_name1,u.usertypeid,u.last_name,u1.first_name as first_name1,u1.last_name as last_name1,u.facebook_userid,u1.facebook_userid as 	facebook_userid1 from tbl_friends f left join tbl_users u on f.userid=u.userid  left join tbl_users u1 on f.friendid=u1.userid where (f.userid='".$user."' or f.friendid='".$user."') and f.verification='yes' and u.status='active' and u1.status='active' and f.status='Active' group by f.userid,f.friendid ","");

while($res_select_friend=@mysql_fetch_assoc($select_user_friend))
{
	$friend[]=$res_select_friend;
}
$friend_count=count($friend);
$smarty->assign("friend",$friend);
$smarty->assign("friend_count",$friend_count);

//******************End Of find the details of profile left section********************************************//

//**********************************Show that user is fan of which merchants**********************************//
$select_user_fan=$dbObj->customqry("select f.*,u.photo as photo1,u.first_name,u.last_name,u.fullname,u.business_name,u.facebook_userid,u.usertypeid from tbl_fan f left join tbl_users u on f.userid=u.userid  where f.status='Active' and f.fan_id='".$user."'   ","");
$i=0;
while($res_select_fan=@mysql_fetch_assoc($select_user_fan))
{
	
	$fan[]=$res_select_fan;
	if($i==0)
	{
	$fan_arr=$fan[0]['userid'];
	}
	$fan_arr=$fan_arr.",".$fan[$i]['userid'];
$i++;
}
//  print_r($fan_arr);
$fan_count=count($fan);
$smarty->assign("fan",$fan);
$smarty->assign("fan_count",$fan_count);
//**********************************End Of Show that user is fan of which merchants*************************//

//**********************************Show that Merchant's  fan **********************************//
if($_GET['id1']!="")
{
$user=$_GET['id1'];
}
else
{
$user=$_SESSION['csUserId'];
}
$select_merchant_fan=$dbObj->customqry("select f.*,u.photo as photo1,u.first_name,u.last_name , u.facebook_userid from tbl_fan f left join tbl_users u on f.fan_id=u.userid  where f.userid='".$user."' and f.status='Active' and u.status='active'","");

while($res_merchants_fan=@mysql_fetch_assoc($select_merchant_fan))
{
	$merchants_fan[]=$res_merchants_fan;
}
$merchants_fan_count=count($merchants_fan);
$smarty->assign("merchants_fan",$merchants_fan);
$smarty->assign("merchants_fan_count",$merchants_fan_count);
//**********************************End Of Show that Merchant's fan *************************//

//**************************************Show the merchant rating**********************************************//
if($_GET['id1']!="")
{
$merchant_id=$_GET['id1'];
}
else
{
$merchant_id=$_SESSION['csUserId'];
}
$select_rating=$dbObj->customqry("select *,count(rating_id)  as count,sum(average_rating) as sum_rating from tbl_rating where merchant_id ='".$merchant_id."'","");
$res_rating=@mysql_fetch_assoc($select_rating);
$count=$res_rating['count'];
$sum_rating=$res_rating['sum_rating'];
$average_rating=@($sum_rating/$count);
$smarty->assign("average_rating",$average_rating);
//***************************************End Of Show Merchant Rating******************************************//


//****************************************View All Searches Form Header**************************************//

if(isset($_POST['txt_search']))
{
$arr=explode(" ",$_POST['txt_search']);
if(count($arr)>0)
{
$serch=$arr[0]."-".$arr[1];
}
else
{
$serch=$_POST['txt_search'];
}
@header("Location:".SITEROOT."/friend/".$_SESSION['csUserId']."/".$serch."/view_all_search");
}


//****************************************End Of View All Searches Form Header**************************************//

//*************************************Select username for photo album************************************************//

if($_GET['user']!="")
{
$select_username=$dbObj->customqry("select * from tbl_users where username='".$_GET['user']."'","");
$res_select_username=@mysql_fetch_assoc($select_username);
}
elseif($_GET['id1']!="")
{
$select_username=$dbObj->customqry("select * from tbl_users where userid='".$_GET['id1']."'","");
$res_select_username=@mysql_fetch_assoc($select_username);
}
else
{
$select_username=$dbObj->customqry("select * from tbl_users where userid='".$_SESSION['csUserId']."'","");
$res_select_username=@mysql_fetch_assoc($select_username);
}
$smarty->assign("username",$res_select_username);
//********************************End Of Select username for photo album***********************************************//
//**************************Statrt of Check Merchant deal request is Approve or not********************************************//
$select_deal_eligibility=$dbObj->customqry("select * from tbl_merchant_deal_request where 	merchant_id='".$_SESSION['csUserId']."'","");
$res_deal_eligibility=@mysql_fetch_assoc($select_deal_eligibility);
$smarty->assign("deal_eligibility",$res_deal_eligibility);
$count_deal_eligibility=mysql_num_rows($select_deal_eligibility);
$smarty->assign("count_deal_eligibility",$count_deal_eligibility);
//**************************End Of Check Merchant deal request is Approve or not********************************************//
if($_SESSION['popup']!="")
{
	$smarty->assign("popup",$_SESSION['popup']);
	$_SESSION['popup']="";
	unset($_SESSION['popup']);
}
//--------------------Friend Request---------------------------//

//$_SESSION['csUserId'];

$friend_request=$dbObj->customqry("select * from tbl_friends where friendid='".$_SESSION['csUserId']."' AND verification='pending'","");
$numfrendsq = @mysql_num_rows($friend_request);
$smarty->assign("numfrendsq",$numfrendsq);

//-------------------------------------------------------------//
//*****************************************Show Avg Rating in my category.*****************************************************//
if($_GET['id1']!="")
{
$user=$_GET['id1'];
}
else
{
$user=$_SESSION['csUserId'];
}
$select=$dbObj->customqry("select deal_cat from tbl_users where userid='".$user."' AND usertypeid=3","");
$res_select=mysql_fetch_assoc($select);
$deal_cat=$res_select['deal_cat'];

$sel_user=$dbObj->customqry("select userid from tbl_users where deal_cat=".$deal_cat." AND usertypeid=3","");
$i=0;
while($fetch_sel_user=@mysql_fetch_assoc($sel_user))
{
	$user_cat[]=$fetch_sel_user;

	$user_cat_arr[]=$user_cat[$i]['userid'];
$i++;
}
$user_cat_array=@implode(",",$user_cat_arr);
$sel_rating=$dbObj->customqry("select sum(average_rating) as sum_rating ,count(rating_id) as count from tbl_rating where merchant_id in(".$user_cat_array.")","");
$fetch_rating=@mysql_fetch_assoc($sel_rating);
$sum_rating=$fetch_rating['sum_rating'];
$count=$fetch_rating['count'];
$avg_rating=@($sum_rating/$count);
$smarty->assign("avg_rating",$avg_rating);
//***************************************End Of Avg Rating in my category.******************************************************//

//*******************************************Show Avg Deal Discount inmy category************************************************************//

$sel_discount=$dbObj->customqry("select sum(discount_in_per) as sum_discount ,count(deal_unique_id) as count_discount from tbl_deals where merchant_id in(".$user_cat_array.")","");
$fetch_discount=@mysql_fetch_assoc($sel_discount);
$sum_discount=$fetch_discount['sum_discount'];
$count_discount=$fetch_discount['count_discount'];
$avg_discount=@($sum_discount/$count_discount);
$smarty->assign("avg_discount",$avg_discount);

//*******************************************End Of Show Avg Deal Discount inmy category*************************************************//

//merchant condition
//$mer_cond_res=$dbObj->customqry("select merchant_id from tbl_deal_condition where merchant_id=".$_GET['id1']."","");

$mer_cond_res=$dbObj->customqry("select dc.merchant_id from tbl_deal_condition dc,tbl_merchant_deal_request dr where dc.merchant_id=dr.merchant_id and  dc.merchant_id=".$_GET['id1']." and dr.status='yes'","");
if(@mysql_num_rows($mer_cond_res)>0){
	$allow="yes";
}else{
	$allow="no";
}
$smarty->assign("allow",$allow);

//merchant condition
// print_r($_SESSION['sign-out-message']);exit;
//**************************Check setting********************************************//
if($_GET['id1']!="")
{
	$select_setting=$dbObj->customqry("select * from tbl_users where userid='".$_GET['id1']."'","");
	$res_select_setting=@mysql_fetch_assoc($select_setting);
	$smarty->assign("privacy_setting",$res_select_setting);
	
}
//**************************End Of Check Setting*************************************//
if($_SESSION['sign-out-message']!="")
{
/*  	print_r($_SESSION['sign-out-message']);exit;*/
        $smarty->assign("outMsg",$_SESSION['sign-out-message']);
        $_SESSION['sign-out-message']="";
        unset($_SESSION['sign-out-message']);
}


//fan
$sfr="count(id) as count";
$cndr="(userid='".$_GET['id1']."' and fan_id='".$_SESSION['csUserId']."')";
$tblr="tbl_fan";
$sel_fanr=$dbObj->gj($tblr, $sfr, $cndr, "", "", "", "", "");
$rowr=@mysql_fetch_array($sel_fanr);
$smarty->assign("num_fan",$rowr['count']);
//fan


//taking merchant name on merchnt profilr
$fan_mer=$dbObj->customqry("select u.fullname from tbl_users  u  where u.userid='".$_GET['id1']."'","");
$fan_rrow=mysql_fetch_array($fan_mer);
$smarty->assign("fan_rrow",$fan_rrow);








//show deals as usual and right now deals counter from last login
$qry=$dbObj->customqry("select logout_date from tbl_login_log where userid=".$_SESSION['csUserId']." order by id desc limit 1,2","");
$getlrow=@mysql_fetch_assoc($qry);
$last_logout=$getlrow['logout_date'];
$last_logout1=explode(" ",$last_logout);


if($_GET['userid']!="" ){
	$user123=$_GET['userid'];
}
else{
	$user123=$_SESSION['csUserId'];
}

$select_merchant_fan123=$dbObj->customqry("select userid from tbl_fan where fan_id='".$user123."'","");
$i=0;
while($fetch_merchant_fan123=@mysql_fetch_assoc($select_merchant_fan123))
{
	$merchant_fan123[]=$fetch_merchant_fan123;
	$merchant_fan_arr123[]=$merchant_fan123[$i]['userid'];
	$i++;
}
//print_r($merchant_fan_arr123);
//echo "--->".count($merchant_fan_arr123);

$select_cat_preferance123=$dbObj->customqry("select * from tbl_users where userid='".$user123."'","");
$res_cat_preferance123=@mysql_fetch_assoc($select_cat_preferance123);
$category_preferance123=$res_cat_preferance123['category_preferance'];


$sel_other_merchant123=$dbObj->customqry("select * from tbl_users where deal_cat in(".$category_preferance123.") and  usertypeid='3'","");
$i=0;
while($res_other_merchant123=@mysql_fetch_assoc($sel_other_merchant123))
{

	$merchant_other123[]=$res_other_merchant123;
	$merchant_other_arr123[]=$merchant_other123[$i]['userid'];
	$i++;
}



if(count($merchant_fan_arr123)>0)
{
	
	$merge_result123 = @array_merge($merchant_fan_arr123,$merchant_other_arr123);
	
	$unique_array123 = @array_unique($merge_result123);
	
	$cnt_implode123=@implode(",",$unique_array123);

}
else{
	
	$unique_array123 = @array_unique($merchant_other_arr123);

	$implode_array123=@implode(",",$unique_array123);
}

//echo "=====>".$cnt_implode123=count($implode_array123);
if($cnt_implode123 > 0)
{
	$cnd123="d.merchant_id in(".$cnt_implode123.") and d.deal_category='deal_as_usual' and d.posted_date>='".$last_logout1['0']."'";
	$select_merchant123 = $dbObj->gj("tbl_deals d left join tbl_users u on d.merchant_id=u.userid left join mast_city m on u.city=m.city_id left join mast_deal_category c on u.deal_cat=c.id ","count(d.deal_unique_id) as tot_cnt123", $cnd123, "d.deal_unique_id", "", "desc", "", "");//main
	
	$row_merchant123=mysql_fetch_assoc($select_merchant123);
	$daucnt=$row_merchant123['tot_cnt123'];
	
	$smarty->assign("daucnt",$daucnt);

	$cnd456="d.merchant_id in(".$cnt_implode123.") and d.deal_category='right_now_deal' and d.posted_date>='".$last_logout1['0']."'";
	$select_merchant456 = $dbObj->gj("tbl_deals d left join tbl_users u on d.merchant_id=u.userid left join mast_city m on u.city=m.city_id left join mast_deal_category c on u.deal_cat=c.id ","count(d.deal_unique_id) as tot_cnt456", $cnd456, "d.deal_unique_id", "", "desc", "", "");//main
	$row_merchant456=mysql_fetch_assoc($select_merchant456);
	$rndcnt=$row_merchant456['tot_cnt456'];
	$smarty->assign("rndcnt",$rndcnt);
}


//show deals as usual and right now deals counter from last login




//for friends

if($_GET['userid']!="" ){
	$ses_user123=$_GET['userid'];
}else{
	$ses_user123=$_SESSION['csUserId'];
}

$select_user_friend789=$dbObj->customqry("select f.*,u.photo as photo1,u1.photo as photo2 from tbl_friends f left join tbl_users u on f.userid=u.userid  left join tbl_users u1 on f.friendid=u1.userid where f.userid='".$ses_user123."' or f.friendid='".$ses_user123."' group by f.userid,f.friendid ","");
$i=0;
while($res_select_friend789=@mysql_fetch_assoc($select_user_friend789))
{
		if($res_select_friend789['userid']==$ses_user123){
			$friend789[$i]['userid']=$res_select_friend789['friendid'];
		}elseif($res_select_friend789['friendid']==$ses_user123){
			$friend789[$i]['userid']=$res_select_friend789['userid'];
		}

		if($friend789[$i]!=0){
			$arr_friend123[]=$friend789[$i]['userid'];
		}
$i++;
}

//print_r($arr_friend123);
	$select_merchant_fan789=$dbObj->customqry("select userid from tbl_fan where fan_id='".$ses_user123."'","");
	$i=0;
	while($fetch_merchant_fan789=@mysql_fetch_assoc($select_merchant_fan789)){

		$merchant_fan789[]=$fetch_merchant_fan789;
		$merchant_fan_arr789[]=$merchant_fan789[$i]['userid'];
		$i++;
	}

// 	 $merchants=@implode(",",$merchant_fan_arr);

	$user789=$arr_friend789;
	$select_cat_preferance789=$dbObj->customqry("select * from tbl_users where userid='".$ses_user123."'","");
	$res_cat_preferance123=@mysql_fetch_assoc($select_cat_preferance789);
	$category_preferance789=$res_cat_preferance123['category_preferance'];
	$sel_other_merchant789=$dbObj->customqry("select * from tbl_users where deal_cat in(".$category_preferance789.") and  usertypeid='3'","");

	$i=0;

	while($res_other_merchant789=@mysql_fetch_assoc($sel_other_merchant789)){
		$merchant_other789[]=$res_other_merchant789;
		$merchant_other_arr789[]=$merchant_other789[$i]['userid'];
		$i++;
	}

	

	if(count($merchant_fan_arr789)>0){
		$merge_result789 = @array_merge($merchant_fan_arr789,$merchant_other_arr789);
		$unique_array789 = @array_unique($merge_result789);
		$implode_array789=@implode(",",$unique_array789);
	}
	else{
		$unique_array789 = @array_unique($merchant_other_arr789);
		$implode_array789=@implode(",",$unique_array789);
	}

	$arr2=@implode(",",array_unique($arr_friend789));

	if(count($implode_array789)==0 && count($arr2)>0){
		$arrr=$arr2;
	}elseif(count($implode_array789)>0 && count($arr2)==0){
		$arrr=$implode_array789;
	}elseif(count($implode_array789)>0 && count($arr2)>0){
		$arrr=$implode_array789.",".$arr2;
	}

			$count789=count($arrr);
			$user789=$arrr[$j];

			$select_user_profile123=$dbObj->customqry("select u.*,c.country,s.state_name from tbl_users  u left join mast_country c on u.countryid=c.countryid left join mast_state s on u.state_id=s.id  where u.userid in(".$arrr.") ","");

			$res_select_profile123=@mysql_fetch_assoc($select_user_profile123);

			//$smarty->assign("user_profile",$res_select_profile123);


			if(count($implode_array789)>0 || count($arr2)>0){
				//working query 

			$select_activity789=$dbObj->customqry("select count(a.msg_id) as fdcnt  from tbl_activity a left join tbl_users u on a.uid=u.userid left join tbl_users u1 on a.fid=u1.userid  where ((a.uid in($arrr) and a.fid='".$_SESSION['csUserId']."') or (a.uid='".$_SESSION['csUserId']."' and  a.fid in($arrr)) or (a.uid in($arrr) and a.fid in($arrr)) or (a.uid ='".$_SESSION['csUserId']."' and a.fid='".$_SESSION['csUserId']."') or (a.vault_t='buy_deal' and (a.uid ='".$_SESSION['csUserId']."' or a.fid='".$_SESSION['csUserId']."'))) and a.parent_id='0' and a.timestamp >='".$last_logout1['0']."' order by msg_id DESC ","");
			$row_act=@mysql_fetch_assoc($select_activity789);
			$fdcnt=$row_act['fdcnt'];
			$smarty->assign("fdcnt",$fdcnt);

//for //12.Anna Friends tab shows David Johnn changing profile pic -- team: we discussed so many times that merchants feed doesnt come in friends tab --- it goes to My Fav Local Biz tab

//written elow query

 			//$select_activity=$dbObj->customqry("select count(a.msg_id) as fdcnt  from tbl_activity a left join tbl_users u on a.uid=u.userid left join tbl_users u1 on a.fid=u1.userid  where ((a.uid in($arr) and a.fid='".$_GET['userid']."') or (a.uid='".$_GET['userid']."' and  a.fid in($arr)) or (a.uid ='".$_GET['userid']."' and a.fid='".$_GET['userid']."') or (a.vault_t='buy_deal' and (a.uid ='".$_GET['userid']."' or a.fid='".$_GET['userid']."'))) and a.parent_id='0' and a.timestamp >'".$last_logout."' order by msg_id DESC","");

//working query 

			}else{

			$select_activity789=$dbObj->customqry("select count(a.msg_id) as fdcnt  from tbl_activity a left join tbl_users u on a.uid=u.userid left join tbl_users u1 on a.fid=u1.userid where (a.uid='".$_SESSION['csUserId']."' and a.fid='".$_SESSION['csUserId']."') or  a.uid='".$_SESSION['csUserId']."' or a.fid='".$_SESSION['csUserId']."' and a.parent_id='0' and a.timestamp >='".$last_logout1['0']."' order by msg_id DESC","");
			$row_act=@mysql_fetch_assoc($select_activity789);
			$fdcnt=$row_act['fdcnt'];
			$smarty->assign("fdcnt",$fdcnt);

			}

			

//for friends


//FAVERITE LOCAL BUSINESS


	$select_merchant_fan123=$dbObj->customqry("select userid from tbl_fan where fan_id='".$ses_user123."'","");
	$i=0;
	while($fetch_merchant_fan123=@mysql_fetch_assoc($select_merchant_fan123)){
		$merchant_fan123[]=$fetch_merchant_fan123;
		$merchant_fan_arr123[]=$merchant_fan123[$i]['userid'];
		$i++;
	}
			 $merchants123=@implode(",",$merchant_fan_arr123);

			$select_activity321=$dbObj->customqry("select count(a.msg_id)  as fbcnt from tbl_activity a left join tbl_users u on a.uid=u.userid  where ((a.uid in ($merchants123)) and (a.fid in (".$merchants123."))) and  a.parent_id='0' and  a.timestamp >='".$last_logout1['0']."' order by a.msg_id DESC","");
			$row_fav=@mysql_fetch_assoc($select_activity321);
			$fbcnt=$row_fav['fbcnt'];
			$smarty->assign("fbcnt",$fbcnt);

//FEVORITE LOCAL BUSINESS


if(!isset($_SESSION['friend']))
	$_SESSION['friend']=0;
if(!isset($_SESSION['dealsasusual']))
	$_SESSION['dealsasusual']=0;
if(!isset($_SESSION['rightnowdeal']))
	$_SESSION['rightnowdeal']=0;
if(!isset($_SESSION['favlocalbusiness']))
	$_SESSION['favlocalbusiness']=0;


//counter

?>
