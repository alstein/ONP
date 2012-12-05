<?php
include_once('../../includes/SiteSetting.php');
require_once("../../includes/classes/class.myaccount.php");
require_once("../../includes/common.lib.php");
include_once('../../includes/class.message.php');
$msobj= new message();

if(!isset($_SESSION['duAdmId']))
	header("location:".SITEROOT . "/admin/login/index.php");

if(!isset($_POST['userid'])){
	$_SESSION['cities_name'] = array();
	$_SESSION['states_ids'] = array();
}




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
$cnd="u.userid=".$_GET['userid'];
$tbl="tbl_users as u";
//$rs=$dbObj->gj($tbl, $sf, $cnd, "", "", "", "", "");


	$rs = $dbObj->cgs("tbl_users d LEFT JOIN mast_deal_category as c ON d.deal_cat = c.id LEFT JOIN mast_deal_category as s ON d.deal_subcat = s.id ","d.*,c.category as category,s.category as sub_category","d.userid",$_GET['userid'],"","","");


$user=@mysql_fetch_assoc($rs);

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


// echo "<pre>";
// print_r($user);
// exit;

$state_id=$user['state'];

$stateid11 = @explode(",", $user['mulitple_state']);
$cityid11 = @explode(",", $user['multiple_city']);
$ids = array_pop($stateid11);
//$cityid = array_pop($cityid11);
//array_push($stateid11,$ids);
//array_push($cityid11,$cityid);
$deal_cat= $user['deal_cat'];
$deal_cat1= $user['deal_subcat'];
//$deal_cat2= $user['deal_subsubcat'];
//$deal_cat3= $user['deal_subsubsubcat'];
//echo "=========><pre>".print_r($deal_cat2);echo "</pre>";



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
            if($deal_cat1)
            {	$subsubcategory=array();
                $sqlsub="select * from mast_deal_category where parent_id = ".$deal_cat1;
                $resultsub = mysql_query($sqlsub) or die('Error, query failed2');
                while($rowsub = mysql_fetch_array($resultsub))
                {
                    $subsubcategory[] = $rowsub;
                }
            }
             /*if($deal_cat2!="")
            {	$subsubsubcategory=array();
                echo $sqlsubsub="select * from mast_deal_category where parent_id = ".$deal_cat2;
                $resultsubsub = mysql_query($sqlsubsub) or die('Error, query failed3');
                while($rowsubsub = mysql_fetch_array($resultsubsub))
                {
                    $subsubsubcategory[] = $rowsubsub;
                }
            }*/


		$smarty->assign("dealcat",$deal_cat);
		$smarty->assign("state_con",$subcategory);
		$smarty->assign("state_sub",$subsubcategory);
		$smarty->assign("state_subsub",$subsubsubcategory);


$sqlque="SELECT * FROM mast_city mc , mast_country mcou WHERE mc.country_id = mcou.countryid and mcou.status = 'Active' order by mc.city_name";
$cityrow=mysql_query($sqlque)or die(mysql_error());
//$citysql = $dbObj->cgs("mast_city","*","status","Active","","","");
   while($cityres =mysql_fetch_array($cityrow))
   {
      $citylst[]=$cityres;
   }
$smarty->assign("city",$citylst);



#-------------Get Country---------------#
$row_country = array();
$rs1 = $dbObj->customqry("select * from mast_country where countryid = '225' and status='Active'","");
$row1 = @mysql_fetch_assoc($rs1);
if($row1){
$row_country[]=$row1;
}
$cnd= "c.status='Active' and countryid !=225";
$sf="c.*";
$ob="country ASC";
//$rs1=$dbObj->gj("mast_country c",$sf,$cnd, $ob, "", "", $l, "");
$res_country=$dbObj->gj("mast_country c",$sf,$cnd, $ob, "", "", $l, "");


//$res_country = $dbObj->cgs("mast_country","*","status","Active","country","ASC","");
$num_country = @mysql_num_rows($res_country);

while($row_con = @mysql_fetch_assoc($res_country))
{
	$row_country[] = $row_con;
}

/*
$countrysql = $dbObj->cgs("mast_country","*","status","Active","country","","");
while($countryres =mysql_fetch_array($countrysql))
  $country[]=$countryres;*/
$smarty->assign("country",$row_country);
#--------------End Country-------------#

#--------------START Get subscription data--------------#
	$rs_subscription = $dbObj->customqry("select * from tbl_subscription_package where status = 1", "");
	while($row_subscription = @mysql_fetch_assoc($rs_subscription))
	{
		$subscriptionData[] = $row_subscription;
	}

	$smarty->assign("subscriptionData", $subscriptionData);
#--------------END Get subscription data--------------#



#-------------access levels-#
$rs1=$dbObj->cgs("mast_levels","","","","","","0");
while($rows=@mysql_fetch_array($rs1))
{
	$levels[] = $rows;
}
$smarty->assign("levels",$levels);

#------end----------------#
// 	print_r($_POST);exit;
if(isset($_POST['email'])){

	$zipCode=$_POST['zipcode'];
	$city=$_POST['city'];

	if($_POST['zipcode'] != ""){
		$p=explode(" ",$_POST['zipcode']);
		if(strlen($p[0])>4){
			$zip=$p[0][0].$p[0][1].$p[0][2].$p[0][3];
			$rs=$dbObj->cgs("zipData", "*", "zipcode", $zip, "", "", "");
			$row=@mysql_fetch_assoc($rs);
			$city=$row['city'];
			if(!$city){
				$zip=$p[0][0].$p[0][1].$p[0][2];
				$rs=$dbObj->cgs("zipData", "*", "zipcode", $zip, "", "", "");
				$row=@mysql_fetch_assoc($rs);
				$city=$row['city'];
			}
		}else{
			$rs=$dbObj->cgs("zipData", "*", "zipcode",$p[0], "", "", "");
			$row=@mysql_fetch_assoc($rs);
			$city=$row['city'];
		}
	}
	if($_POST['zipcode'] == ""){
		$foundCity =$_POST['city'];
		$rs=$dbObj->cgs("zipData", "*", "city", $foundCity, "zipcode ASC", "", "");
		$row=@mysql_fetch_assoc($rs);
		$zip=$row['zipcode'];
	}

        extract($_POST);


	if(! $chk_outlet)
		$address2 = "";

        $fullname = $first_name." ".$last_name;
        //$username = $first_name."_".$last_name;
		if($_SESSION['selectedimage']){
			$small_picture = $_SESSION['selectedimage']; 
			$medium_picture = $_SESSION['selectedimage']; 
			$big_picture = $_SESSION['selectedimage'];	
		}else{
			$small_picture = $user['small_picture']; 
			$medium_picture = $user['medium_picture']; 
			$big_picture = $user['big_picture']; 
		}

    if($_FILES['price_menu_list']['name']!="")
    {
                       $original_1 = newgeneralfileupload($_FILES['price_menu_list'], "../../uploads/menu_price_list/", true); 
    }else{
						$original_1	=$user['menu_price_file'];
	}
 if($_FILES['upload_photo']['name']!="")
    {
             $original_2 = newgeneralfileupload($_FILES['upload_photo'], "../../uploads/user/", true); 
    }
else
{
$original_2=$user['photo'];
}

		$starthour=$_POST['start_hour'].":".$_POST['start_min'].":00";
		$endhour=$_POST['end_hour'].":".$_POST['end_min'].":00";
		$starthour1=$_POST['start_hour1'].":".$_POST['start_min1'].":00";
		$endhour1=$_POST['end_hour1'].":".$_POST['end_min1'].":00";



	if($password!=""){
	  $fl=array("first_name","last_name","business_name","fullname","username","password",'email','usertypeid',"signup_date","title","address1","address2","address3","address4","address5","city",'state_id','countryid', 'postalcode',"business_webURL","contact_detail",'subscription_pack_id',"company_type","limited_comp","vat_reg","activiti",'status',"subscribe_status",'added_by','about_us','deal_cat','deal_subcat','deal_subsubcat','deal_subsubsubcat','	specility','business_start_date1','business_end_date1','business_start_date2','business_end_date2','menu_price_file','photo','contact_person');

	$vl = array($first_name,$last_name,$business_name,$fullname,$username,md5($password),$email,3,date("Y-m-d H:i:s"),$title,$address1,$address2,$address3,$address4,$address5,$cityid,$state,$countryid,$zipCode,$business_webURL,$contact_detail,$subscription,$company_type,$limited_comp,$vat_reg,$activity,"Active","Expired",$_SESSION['duAdmId'],$about_us,$maincategory,$subcategory,$subsubcategory,$subsubsubcategory,$specility,$starthour,$endhour,$starthour1,$endhour1,$original_1,$original_2,$contact_person);
	}else{
	  $fl=array("first_name","last_name","business_name","fullname","username",'email','usertypeid',"signup_date","title","address1","address2","address3","address4","address5","city",'state_id','countryid', 'postalcode',"business_webURL","contact_detail",'subscription_pack_id',"company_type","limited_comp","vat_reg","activiti",'status',"subscribe_status",'added_by','about_us','deal_cat','deal_subcat','deal_subsubcat','deal_subsubsubcat','	specility','business_start_date1','business_end_date1','business_start_date2','business_end_date2','menu_price_file','photo','contact_person');
	$vl = array($first_name,$last_name,$business_name,$fullname,$username,$email,3,date("Y-m-d H:i:s"),$title,$address1,$address2,$address3,$address4,$address5,$cityid,$state,$countryid,$zipCode,$business_webURL,$contact_detail,$subscription,$company_type,$limited_comp,$vat_reg,$activity,"Active","Expired",$_SESSION['duAdmId'],$about_us,$maincategory,$subcategory,$subsubcategory,$subsubsubcategory,$specility,$starthour,$endhour,$starthour1,$endhour1,$original_1,$original_2,$contact_person);
	}

	$rs = $dbObj->cupdt('tbl_users',$fl,$vl,'userid',$_GET['userid'],'');
	$s=$msobj->showmessage(3);
	$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
	@header("Location:".SITEROOT."/admin/user/seller_list.php");


}


$smarty->assign("user",$user);

// if(isset($_SESSION['msg'])){
//    $smarty->assign("msg",$_SESSION['msg']);
//    unset($_SESSION['msg']);
// }

$rs1=mysql_query("select seller_type_id,seller_type_name from tbl_seller_type where Active=1");
while($row1=@mysql_fetch_assoc($rs1)){
   $seller1[]=$row1;
}

$smarty->assign("seller1",$seller1);

$smarty->assign("inmenu", "user");
$smarty->display( TEMPLATEDIR . '/admin/user/seller_information.tpl');
$dbObj->Close();
?>