<?php
include_once('../../include.php');
include_once('../../includes/SiteSetting.php');
//require_once("../../includes/classes/class.myaccount.php");
require_once("../../includes/common.lib.php");
include_once('../../includes/class.message.php');

$msobj= new message();

if(!isset($_SESSION['csUserId']) && $_SESSION['csUserTypeId']!='2')
{
	header("location:".SITEROOT);exit;
}

$row_meta=$dbObj->getseodetails(12);
$smarty->assign("row_meta",$row_meta);

#-------------access levels-#
$rs1=$dbObj->cgs("mast_levels","","","","","","0");
while($rows=@mysql_fetch_array($rs1))
{
	$levels[] = $rows;
}
$smarty->assign("levels",$levels);

#------end----------------#


#--------------Get Time--------------------#
	$i = 0;
	$hr = array();	
	for($hh = 0; $hh <=23; $hh++) 
	{
		if($hh<10)
			$hh = "0$hh"; 
		else
			$hh = $hh;
		$hr[$i] = $hh;
		$i++;
	}
	$rev_hr = array_reverse($hr);
	$smarty->assign("rev_hr",$rev_hr);
	$smarty->assign("hr",$hr);
        $smarty->assign("delivery_hrs",$hr);

	$i = 0;
	$min = array();	
	for($mm = 0; $mm <=59; $mm++) 
	{
		if($mm<10)
			$mm = "0$mm"; 
		else
			$mm = $mm;
		$min[$i] = $mm;
		$i++;
	}
	$min=array("00","15","30","45");
	$rev_min = array_reverse($min);
	$smarty->assign("rev_min",$rev_min);
	$smarty->assign("min",$min);
        $smarty->assign("delivery_mins",$min);

        $days = range(2,30);
	$smarty->assign("days",$days);
	$hours = range(0,23);
	$smarty->assign("hours",$hours);

#---------------End Time-------------------#

#----------------get Main category----------------------------#
	$sql="select * from mast_deal_category where parent_id=0 order by category";
        $result = mysql_query($sql) or die('Error, query failed');
        $i = 0;
        while($row = mysql_fetch_array($result))
        {
                $tmp = array('id'=>$row['id'],
                 'category'=>$row['category']);
                $results[$i++] = $tmp;
        }
	$smarty->assign("category",$results);
#----------------get Main category----------------------------#



#------Getting User Info--------------
$sf="u.*";
$cnd="u.userid=".$_SESSION['csUserId'];
$tbl="tbl_users as u";

	$rs = $dbObj->cgs("tbl_users d LEFT JOIN mast_deal_category as c ON d.deal_cat = c.id LEFT JOIN mast_deal_category as s ON d.deal_subcat = s.id ","d.*,c.category as category,s.category as sub_category","d.userid",$_SESSION['csUserId'],"","","");

	$user=@mysql_fetch_assoc($rs);
	
	$deal_cat= $user['deal_cat'];
	if($deal_cat)
	{
		$subcategory=array();
		$sql="select * from mast_deal_category where parent_id = ".$deal_cat;
		$result = mysql_query($sql) or die('Error, query failed1');
		while($row = mysql_fetch_array($result))
		{
			$subcategory[] = $row;
		}
	}
	$smarty->assign("state_con",$subcategory);
	
	$smarty->assign("user",$user);
#------Getting User Info--------------


            $s_arr = explode(":",$user['business_start_date1']);
            $s_hr = $s_arr[0];
            $s_min = $s_arr[1];

            $e_arr = explode(":",$user['business_end_date1']);
            $e_hr = $e_arr[0];
            $e_min = $e_arr[1];

			$smarty->assign("s_hr",$s_hr);
			$smarty->assign("s_min",$s_min);
			
			$smarty->assign("e_hr",$e_hr);
			$smarty->assign("e_min",$e_min);

			$smarty->assign("start_date",$start_date);
			$smarty->assign("end_date",$end_date);


            $s_arr1 = explode(":",$user['business_start_date2']);
            $s_hr1 = $s_arr1[0];
            $s_min1 = $s_arr1[1];

            $e_arr1 = explode(":",$user['business_end_date2']);
            $e_hr1 = $e_arr1[0];
            $e_min1 = $e_arr1[1];


			$smarty->assign("s_hr1",$s_hr1);
			$smarty->assign("s_min1",$s_min1);
			
			$smarty->assign("e_hr1",$e_hr1);
			$smarty->assign("e_min1",$e_min1);

			$smarty->assign("start_date1",$start_date1);
			$smarty->assign("end_date1",$end_date1);


// 	print_r($_POST);exit;
if(isset($_POST['email'])){

        extract($_POST);

	if(! $chk_outlet)
		$address2 = "";

		if($_FILES['price_menu_list']['name']!="")
		{
						$original_1 = newgeneralfileupload($_FILES['price_menu_list'], "../../uploads/menu_price_list/", true); 
		}else{
							$original_1	=$user['menu_price_file'];
		}

		$starthour=$_POST['start_hour'].":".$_POST['start_min'].":00";
		$endhour=$_POST['end_hour'].":".$_POST['end_min'].":00";
		$starthour1=$_POST['start_hour1'].":".$_POST['start_min1'].":00";
		$endhour1=$_POST['end_hour1'].":".$_POST['end_min1'].":00";
// 		$b=str_replace(" ","_",$business_name);
// 		$username = $b_.rand();


	if($password!=""){
	 	 $fl=array("email","password","business_name","contact_person","address1","address2","address3","address4","address5","countryid","city", 'contact_detail',"business_webURL","about_us",'deal_cat',"deal_subcat","specility",'business_start_date1','business_end_date1','business_start_date2','business_end_date2',"menu_price_file","concat_address");

		$vl=array($email,md5($password),$business_name,$contact_person,$address1,$address2,$address3,$address4,$address5,"1","1",$contact_detail,$business_webURL,$about_us,$maincategory,$subcategory,$specility,$starthour,$endhour,$starthour1,$endhour1,$original_1,$concat_address);
		//$fl = array("photo");
		//$vl = array($original_1);
		$rs = $dbObj->cupdt('tbl_users',$fl,$vl,'userid',$_SESSION['csUserId'],'');
		$update_flag=1;
		if($gender=='Male')
		{
		$msg_activity="$fullname updated his profile picture.";
		}
		else
		{
		$msg_activity="$fullname updated her profile picture.";
		}
		$timestamp=date("Y-m-d H:i:s");
		$insert_activity=$dbObj->customqry("insert into tbl_activity(msg,vault_t,vault,timestamp,wall,uid,fid)values('".$msg_activity."','img','".$original_1."','".$timestamp."','1','".$_SESSION['csUserId']."','".$_SESSION['csUserId']."') ","");
		$_SESSION['csFullName']=$business_name;

	}else{
	 	 $fl=array("email","business_name","contact_person","address1","address2","address3","address4","address5","countryid","city", 'contact_detail',"business_webURL","about_us",'deal_cat',"deal_subcat","specility",'business_start_date1','business_end_date1','business_start_date2','business_end_date2',"menu_price_file","concat_address");

		$vl=array($email,$business_name,$contact_person,$address1,$address2,$address3,$address4,$address5,"1","1",$contact_detail,$business_webURL,$about_us,$maincategory,$subcategory,$specility,$starthour,$endhour,$starthour1,$endhour1,$original_1,$concat_address);
	//	$fl = array("photo");
//		$vl = array($original_1);
		$rs = $dbObj->cupdt('tbl_users',$fl,$vl,'userid',$_SESSION['csUserId'],'');
		$update_flag=1;
		if($gender=='Male')
		{
		$msg_activity="$fullname updated his profile picture.";
		}
		else
		{
		$msg_activity="$fullname updated her profile picture.";
		}
		$timestamp=date("Y-m-d H:i:s");
		$insert_activity=$dbObj->customqry("insert into tbl_activity(msg,vault_t,vault,timestamp,wall,uid,fid)values('".$msg_activity."','img','".$original_1."','".$timestamp."','1','".$_SESSION['csUserId']."','".$_SESSION['csUserId']."') ","");
		$_SESSION['csFullName']=$business_name;
	}

	$rs = $dbObj->cupdt('tbl_users',$fl,$vl,'userid',$_SESSION['csUserId'],'');
	$s=$msobj->showmessage(3);
	$_SESSION['msg']="Merchant profile has been updated successfully";

	@header("Location:".SITEROOT."/merchant-account/edit_merchant_profile/");
 	exit;


}



if(isset($_SESSION['msg'])){
   $smarty->assign("msg",$_SESSION['msg']);
   unset($_SESSION['msg']);
}


$smarty->assign("seller1",$seller1);
$smarty->display( TEMPLATEDIR . '/modules/merchant-account/edit_merchant_profile.tpl');
$dbObj->Close();
?>
