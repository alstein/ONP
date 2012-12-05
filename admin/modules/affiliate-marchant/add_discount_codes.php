<?php
include_once('../../../includes/SiteSetting.php');
include_once("../../../includes/paging.php");
include_once("../../../includes/common.lib.php");
include_once('../../../includes/class.message.php');
$msobj= new message();
if(!isset($_SESSION['duAdmId']))
{
    header("location:".SITEROOT . "/admin/login/index.php");
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
	$rev_min = array_reverse($min);
	$smarty->assign("rev_min",$rev_min);
	$smarty->assign("min",$min);
        $smarty->assign("delivery_mins",$min);

        $days = range(2,30);
	$smarty->assign("days",$days);
	$hours = range(0,23);
	$smarty->assign("hours",$hours);


#---------------Get Deal name and Title start----------------#
$date = date("Y-m-d H:i:s");
$cnd = "status = '1'";


$rs = $dbObj->gj("tbl_deal_affiliate_marchant", "id,marchant_id,marchant_name", $cnd, "", "", "", "", "");
		while($deal = @mysql_fetch_assoc($rs))
		{
		  $dealreturn[]=$deal;
		}
		
		$smarty->assign("marchant_info", $dealreturn);
// 		echo "<pre>";
// 		print_r($dealreturn);
// 		exit;
#---------------Get Deal name and Title End----------------#


   // Generate a random character string
//    function randUniqueCoupId($length = 10, $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ123456789')
//    {
//       // Length of character list
//       $chars_length = (strlen($chars) - 1);
//    
//       // Start our string
//       $string = $chars{rand(0, $chars_length)};
//       
//       // Generate random string
//       for ($i = 1; $i < $length; $i = strlen($string))
//       {
//          // Grab a random character from our list
//          $r = $chars{rand(0, $chars_length)};
//          
//          // Make sure the same two characters don't appear next to each other
//          if ($r != $string{$i - 1}) $string .=  $r;
//       }
//       
//       // Return the string
//       //## return $string;
//       //Before direct return to coupon unqiue value need to check if it's already exist into DB.
//       //Chk generated coupon unique coupon code is not allready exist
//       $query = "select * from tbl_affiliate_discount_codes where sCode = '".strtoupper($string)."'";
//       $rs = mysql_query($query);
//       $num = @mysql_num_rows($rs);
//       if($num < 1)
//       {
//          return strtoupper($string);
//       }else
//       {
//          randUniqueCoupId();
//       }
// } 
//              $uniquecouponid = randUniqueCoupId();
             $image= $_POST['image'];
             
	if(strlen(trim($_POST['submit'])) > 0){
	
                $image = generalfileupload($_FILES['image'],"../../../uploads/discount_codes_image","");
		$f_array = array("iMerchantId" => trim($_POST['iMerchantId']),
		                      "iMerchantName" => trim($_POST['iMerchantName']),
		                      "sCode" =>trim($_POST['discount_code']),
		                      "sDescription" => trim($_POST['discution']),
					"sUrl" =>trim($_POST['url']),
					"sStartDate" => $_POST['start_date'],
					"sEndDate" => $_POST['end_date']." ".$_POST['end_hour'].":".$_POST['end_min'].":00",
					"image" => $image,
					"added_date" => $date,
					"status" => "1"					
					);

            $dbObj->cgii("tbl_affiliate_discount_codes",$f_array,"");

//          if($insertedCoupId > 0)
//          {
//             for($l = 0;$l < $_POST['no_of_coupons'];$l++)
//             {
//                //$uniquecouponid = rand(1, 9999999999);
//                $uniquecouponid = randUniqueCoupId();
//                $ins_array = array(
//                               "coupon_id"=>$insertedCoupId,
//                               "coupon_unique_id"=>$uniquecouponid,
//                               "used"=>0
//                            );
//                $dbObj->cgii("tbl_coupon_master_uniqueids",$ins_array,"");
//             }
//          }
			$_SESSION['msg']="<span class='success'>Disscount code added successfully.</span>";
		        header("location:".SITEROOT."/admin/modules/affiliate-marchant/discount_codes_list.php");
		        exit;
	}
	
	 //------update  followus-------------
	 //echo $_POST["id"];
 		if($_POST["id"])
		{   
                    $id=$_GET['mid'];
                    if ($_FILES["image"]["error"]== 4)
                    {
                    
                       $f_array = array("iMerchantId" => trim($_POST['iMerchantId']),
		                      "iMerchantName" => trim($_POST['iMerchantName']),
		                      "sCode" => trim($_POST['discount_code']),
		                      "sDescription" => trim($_POST['discution']),
					"sUrl" =>trim($_POST['url']),
					"sStartDate" => $_POST['start_date'],
					"sEndDate" => $_POST['end_date']." ".$_POST['end_hour'].":".$_POST['end_min'].":00",
					//"image" => $image,
					//"added_date" => $_POST['expire_date'],
					"status" => "1"					
					);
                        $dbObj->cupdtii("tbl_affiliate_discount_codes",$f_array,"id=".$id,"");
                        $_SESSION['msg']="<span class='success'>Discount codes updated successfully</span>";
                        header("location:". SITEROOT ."/admin/modules/affiliate-marchant/discount_codes_list.php");
                        exit;
                    }else
                    {
                        $image = generalfileupload($_FILES['image'],"../../../uploads/discount_codes_image","");
                       $f_array = array("iMerchantId" => trim($_POST['iMerchantId']),
		                      "iMerchantName" => trim($_POST['iMerchantName']),
		                     "sCode" => trim($_POST['discount_code']),
		                      "sDescription" => trim($_POST['discution']),
					"sUrl" =>trim($_POST['url']),
					"sStartDate" => $_POST['start_date'],
					"sEndDate" => $_POST['end_date']." ".$_POST['end_hour'].":".$_POST['end_min'].":00",
					"image" => $image,
					//"added_date" => $_POST['expire_date'],
					"status" => "1"					
					);
                        $dbObj->cupdtii("tbl_affiliate_discount_codes",$f_array,"id=".$id,"");
                        $_SESSION['msg']="<span class='success'>Discount codes updated successfully</span>";
                        header("location:". SITEROOT . "/admin/modules/affiliate-marchant/discount_codes_list.php");
                        exit;
                    }
		}
    //----Get the updated id here and display record to add_followus.tpl file-----
		if($_GET['mid'])
		{
		$id=$_GET['mid'];
		$sql="select * from tbl_affiliate_discount_codes where id='$id'";
		$discount_row=mysql_query($sql)or die(mysql_error());
		$results = array();
		$r=mysql_fetch_array($discount_row);
		$e_date = explode(" ",$r['sEndDate']);
                $end_date = $e_date[0];
                $e_arr = explode(":",$e_date[1]);
                $e_hr = $e_arr[0];
                 $e_min = $e_arr[1];
		$smarty->assign('id', $r['id']);
		$smarty->assign('iMerchantId', $r['iMerchantId']);
		$smarty->assign('iMerchantName', $r['iMerchantName']);
		$smarty->assign('code', $r['sCode']);
		$smarty->assign('disscution', $r['sDescription']);
		$smarty->assign('url', $r['sUrl']);
		$smarty->assign('start_date', $r['sStartDate']);
		$smarty->assign('end_date', $r['sEndDate']);
		$smarty->assign('image', $r['image']);
		$smarty->assign('status', $status);
		$smarty->assign("e_hr",$e_hr);
                $smarty->assign("e_min",$e_min);
      		}
	
$smarty->display(TEMPLATEDIR . '/admin/modules/affiliate-marchant/add_discount_codes.tpl');
$dbObj->Close();
?>