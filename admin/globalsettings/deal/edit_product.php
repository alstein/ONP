<?php
include_once('../../../includes/SiteSetting.php');
include_once("../../../includes/common.lib.php");
include_once('../../../includes/class.message.php');

if(!$_SESSION['duAdmId'])
{
    header("location:".SITEROOT . "/admin/login/index.php");
    exit;
}

$res_dealdiscount = $dbObj->cgs("tbl_deal_discount","","deal_id",$_GET['id'],"","","");
$i1=1;
while($fetch_deal_discount = @mysql_fetch_assoc($res_dealdiscount))
{
$deal_discount_city[]=$fetch_deal_discount;
 #-----------------Get State START--------------------#

		$res_state = $dbObj->customqry("select * from mast_state ms,mast_country mcou where ms.country_id = mcou.countryid and mcou.status = 'Active' and ms.active=1  and ms.country_id in(".$fetch_deal_discount['country_id'].") order by ms.state_name ASC","");
		$num_state = @mysql_num_rows($res_state);
// 		$row_state = array();
		while($row_sta = @mysql_fetch_assoc($res_state))
		{
			$row_state[] = $row_sta;
		}
// print_r($row_state);exit;
		$smarty->assign("state_discount",$row_state);

 	
    #-----------------Get State END--------------------#
    #-----------------Get city--------------------#
   
    //$_re1 = $dbObj->cgs("mast_city","",array("status"),array("Active"),"city_name","DESC","");
    $_re1 = $dbObj->customqry("select * from mast_city mc,mast_country mcou where mc.country_id = mcou.countryid and mcou.status = 'Active' and mc.status='Active' and state_id in(".$fetch_deal_discount['state_id'].") order by mc.city_name ASC","");
    $num = @mysql_num_rows($_re1);
//     $_arr = array();
    while($_row2 = @mysql_fetch_assoc($_re1))
    {
            $_arr2[] = $_row2;
    }
    $smarty->assign("city",$_arr2);
    #-----------------Get city--------------------#
}

	
$count_discount=@mysql_num_rows($res_dealdiscount);
$smarty->assign("count_discount",$count_discount);
$smarty->assign("deal_discount_city",$deal_discount_city);
#------------Check For access----------#
if(!(in_array("10", $arr_modules_permit)))
{
      unset($_SESSION['duAdmId']);
      $s=$msobj->showmessage(166);
      $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";

      header("location:".SITEROOT . "/admin/login/index.php");
      exit;
}
#----------End Check For access----------#

#----code for deleting images-------#

function remove_item_by_value($array, $val = '', $preserve_keys = true) {
	if (empty($array) || !is_array($array)) return false;
	if (!in_array($val, $array)) return $array;

	foreach($array as $key => $value) {
		if ($value == $val) unset($array[$key]);
	}

	return ($preserve_keys === true) ? $array : array_values($array);
}

  $deal_img = $dbObj->gj("tbl_deal","*","deal_unique_id = '{$_GET['id']}'","","","","","");
  $deal_row = @mysql_fetch_assoc($deal_img);	

if($_GET['delete']){
	 	$mImage1 = explode(",",$deal_row['small_image']);
		$mImage2= explode(",",$deal_row['medium_image']);
		$mImage3 = explode(",",$deal_row['big_image']);
	
		if(in_array($_GET['delete'],$mImage1)){
			$removeThis = $_GET['delete'];
			$newArray1 = remove_item_by_value($mImage1, $removeThis);
			$newArray2 = remove_item_by_value($mImage2, $removeThis);
			$newArray3 = remove_item_by_value($mImage3, $removeThis);
       
         @unlink("../../../uploads/product/thumb588X288/".$removeThis);
         @unlink("../../../uploads/product/thumb332X290/".$removeThis);
         @unlink("../../../uploads/product/thumb76X64/".$removeThis);
         @unlink("../../../uploads/".$removeThis);  
      

			$newImgArray1 = implode(",", $newArray1);
			$newImgArray2 = implode(",", $newArray2);
			$newImgArray3 = implode(",", $newArray3);

			$f = array("small_image","medium_image","big_image");
			$v = array($newImgArray1,$newImgArray2,$newImgArray3);

			$dbObj->cupdt("tbl_deal", $f, $v,"deal_unique_id",$_GET['id'],"");
			@header("Location:".SITEROOT."/admin/globalsettings/deal/edit_product.php?id=".$_GET['id']);
		}
	}


#--------------end------------------#

#----------ordering---------#

if($_GET['mode']){
		
		$mImage1 = explode(",",$deal_row['small_image']);
		$mImage2= explode(",",$deal_row['medium_image']);
		$mImage3 = explode(",",$deal_row['big_image']);

		function swap ($ary,$element1,$element2)
		{
		$temp= array();
		$temp=$ary[$element1];
		$ary[$element1]=$ary[$element2];
		$ary[$element2]=$temp;
		return $ary;
		}

		$mImage11= swap($mImage1,0,$_GET['order']);
		$mImage22= swap($mImage2,0,$_GET['order']);
		$mImage33= swap($mImage3,0,$_GET['order']);
		
			

		//echo "<pre>";print_r($myArray);
		$newImgArray1 = implode(",", $mImage11);
		$newImgArray2 = implode(",", $mImage22);
		$newImgArray3 = implode(",", $mImage33);

		$f = array("small_image","medium_image","big_image");
		$v = array($newImgArray1,$newImgArray2,$newImgArray3);

		$dbObj->cupdt("tbl_deal", $f, $v,"deal_unique_id",$_GET['id'],"");

		@header("Location:".SITEROOT."/admin/globalsettings/deal/edit_product.php?id=".$_GET['id']);
		
	}


#------end-----------#

$row3="";

if(isset($_POST['box']))
{
    ?><script language="javascript"> self.parent.tb_remove();</script><?php exit;
}

#--------------------Edit Deal----------------------#
if(isset($_POST['Submit']))
{
        /*$cat_rs = $dbObj->gj("mast_deal_category","id","category = '".$_POST['category']."'","","","","","");
        if($cat_rs == "n")
        {
            $field = array("userid"=>$_SESSION['csUserId'],"category"=>$_POST['category'],"date"=>date('Y-m-d'),"parent_id"=>0,"category_type"=>$_POST['deal_type'],"active"=>1);
            $cat_id = $dbObj->cgii("mast_deal_category",$field,"");
        }
        else
        {
            $cat = mysql_fetch_assoc($cat_rs);
            $cat_id = $cat['id'];
        }
    
        $subcat_rs = $dbObj->gj("mast_deal_category","id","category = '".$_POST['subcategory']."'","","","","","");
        if($cat_rs == "n")
        {
            $field = array("userid"=>$_SESSION['csUserId'],"category"=>$_POST['subcategory'],"date"=>date('Y-m-d'),"parent_id"=>$cat_id,"category_type"=>$_POST['deal_type'],"active"=>1);
            $subcat_id = $dbObj->cgii("mast_deal_category",$field,"");
        }
        else
        {
            $subcat = mysql_fetch_assoc($subcat_rs);
            $subcat_id = $subcat['id'];
        }*/
        
         ////////////////////////Qr Code image Code Here start/////////////////
    if($_FILES['qr_code_image'])
    {
                        $original_1 = newgeneralfileupload($_FILES['qr_code_image'], "../../../uploads/qr_code/real/", true); 
                        //original image move to main folder
                        $original['name'] = $original_1;
                        $original['tmp_name'] = "../../../uploads/qr_code/real/".$original_1;
                        //otherpage for homepage listing
                        $path = "../../../uploads/qr_code/64X64/";
                        $width_array  = array(205);
                        $height = 233;
                        $path_array = array($path);
                        resize_multiple_images_new($original, $width_array, $path_array, $height);// image crop for showing 
                        $path1 = "../../../uploads/qr_code/51X50/";
                        $width_array1  = array(184);
                        $height1 = 91;
                        $path_array1 = array($path1);
                        resize_multiple_images_new($original, $width_array1, $path_array1, $height1);// image crop for showing 
    }else{
   $original_1= $_POST['qr_code_image'];
    
    }
    
    ////////////////////////Qr Code image Code Here end//////////////////

        
        
	$str     = $_POST['title1'];
		$order   = array("(",")",":","$","#","@","%","^","*","[","]","&","{","}","|","/","_","+","!","~","`","?","<",".",",",">","'");
		$replace = '';
		$url_title = str_replace($order, $replace, $str);
		$title2=str_replace(" ","-",$url_title);
		
		
		 $tit= array();
	
     		$is_title = $dbObj->gj("tbl_deal","url_title","deal_unique_id != '{$_GET['id']}' and url_title like '".$title2."%'","","","","","");

     		while($title_row = @mysql_fetch_assoc($is_title))
     		{
         		$tit[] =$title_row;
			if($title_row['url_title']==$title2)
          		{
          			$title2.="-";
          		}
     		}



//featured
if($_POST['3']== "")
{
	$featured=0;
}
else
{
	$featured=1;
}

//news letter subscription
if($_POST['10']== "")
{
	$news_subscribe=0;
}
else
{
	$news_subscribe=1;
}

if($_POST['4']!= "" || $_POST['5']!= "")
{
	$page_featured='yes';
}
else
{
	$page_featured='no';
}

if($_POST['is_national'] == "on")
{
	$is_national = "yes";
}else
{
	$is_national = "no";
}

$howitwork = $_POST['howitwork'];

if($_POST['only_fans']!="" && $_POST['all_who_choose_category']!="")
{
$send_deal_to=$_POST['only_fans'].",".$_POST['all_who_choose_category'];
}
elseif($_POST['only_fans']!="")
{
$send_deal_to=$_POST['only_fans'];
}
else
{
$send_deal_to=$_POST['all_who_choose_category'];
}


// 	echo "price=".$groupBuyPrice = $_POST['price'];
// 	echo "<br>quantity=".$savePer = trim($_POST['quantity']);
// 	echo "<br>min_buyer=".$_POST['min_buyer'];
// 	echo "<br>max_buyer=".$_POST['max_buyer']; exit;

	$field_array = array(
		
		"deal_city"=>"", //$_POST['dealcity'],
		"title"=>$_POST['title1'],
		"subtitle"=>$_POST['subtitle'],
		"slogan"=>$_POST['slogan'],
		"url_title"=>$title2,
		"description"=>$_POST['description'],
		"termsandconditions"=>$_POST['terms'],
		"highlight"=>$_POST['highlight'],
		"fineprint"=>$_POST['fineprint'],
		"payment_method"=>$_POST['payment_type'],
		"vedio_link"=>trim($_POST['videolink']),
		"groupbuy_price"=>$_POST['price'],
		"whybuy"=>$_POST['whybuy'],
		"orignal_price"=>$_POST['originalprice'],
		"quantity"=>$_POST['quantity'],
		"min_buyer"=>$_POST['min_buyer'],
		"max_buyer"=>$_POST['max_buyer'],
		"start_date"=>$_POST['dob1']." ".$_POST['start_hour'].":".$_POST['start_min'].":00",
		"end_date"=>$_POST['dob2']." ".$_POST['end_hour'].":".$_POST['end_min'].":00",
		"comments"=>$_POST['comments'],
		
		"sub_delivery_cost"=>$_POST['sub_delivery_cost'],
		"seller_support_email"=>$_POST['seller_support_email'],
		"trackURL"=>$_POST['trackURL'],
		"delivered_tracking_url_code"=>$_POST['delivered_tracking_url_code'],
		"refund_policy"=>$_POST['refund_policy'],
		"otherproductURL"=>$_POST['otherproductURL'],
		
		"addressandlocation"=>$_POST['addressandlocation'],
		"show_deal_tag"=>$_POST['show_deal_tag'],
		"deal_tag"=>$_POST['deal_tag'],
		"featured"=>$featured,
		"featured_page"=>$page_featured,
		"news_subscribe"=>$news_subscribe,
		"deal_ending"=>$_POST['endingsoon'],
		"validfrom"=>$_POST['validfrom'],
		"validto"=>$_POST['validto'],
		"howitwork"=>$howitwork,
		"deal_main_type"=>$_POST['dealmaintype'],
		"deal_currency"=>$_POST['deal_currency'],
		"seller_account_no"=>$_POST['seller_account_no'],
		"deal_from_seller_name"=>$_POST['deal_from_seller_name'],
		"deal_from_seller_name_other"=>$_POST['deal_from_seller_name_other'],
		"seller_zipcode"=>$_POST['zipcode'],
		"voucher_text"=>$_POST['free_voucher_text'],
		"senddealto"=>$send_deal_to,
		"redeemfrom"=>$_POST['redeemfrom'],
		"redeemto"=>$_POST['redeemto'],
	);

        // print_r($field_array); echo "</pre>"; exit;

        if($_POST['option_selected'] != "")
        {
            $field_array = array_merge($field_array,array("final_value"=>$_POST['final_value']));
            $field_array = array_merge($field_array,array("listing_value"=>$_POST['listing']));
            $field_array = array_merge($field_array,array("option_selected"=>$_POST['option_selected']));
	}

        if($_POST['website'] != "")
        {
            $field_array = array_merge($field_array,array("option_website"=>$_POST['website']));
        }
        if($_POST['shop_addr'] != "")
        {
            $field_array = array_merge($field_array,array("shop_location"=>$_POST['shop_addr']));
        }

        #--------------Set deal images---------------#
	extract($_FILES);
        //echo "<pre>"; print_r($_FILES); echo "</pre>";

	#---code for image upload start---#	
	if($_SESSION['selectedimage'] !='')
	{
// 		if($deal_row['small_image'] !='')
// 		{
// 
// 			  $small_picture = $deal_row['small_image'].",".$_SESSION['selectedimage'];
//             		  $medium_picture =$deal_row['medium_image'].",".$_SESSION['selectedimage'];
//             		  $big_picture = $deal_row['big_image'].",".$_SESSION['selectedimage'];
// 			
// 		}
// 		else
// 		{
			  $small_picture =$_SESSION['selectedimage'];
            		  $medium_picture =$_SESSION['selectedimage'];
            		  $big_picture =$_SESSION['selectedimage'];	
// 		}
	}
	else		
	{
	
			  $small_picture = $deal_row['small_image'];
            		  $medium_picture= $deal_row['medium_image'];
            		  $big_picture =$deal_row['big_image'];	
	}
	
	    $field_array = array_merge($field_array,array("small_image"=>$small_picture));
            $field_array = array_merge($field_array,array("medium_image"=>$medium_picture));
            $field_array = array_merge($field_array,array("big_image"=>$big_picture));

	#---code for image upload end ---#


/*
        if($_SESSION['selectedimage'])
        {
            $small_picture = $_SESSION['selectedimage']; 
            $medium_picture = $_SESSION['selectedimage']; 
            $big_picture = $_SESSION['selectedimage'];
    
            $field_array = array_merge($field_array,array("small_image"=>$small_picture));
            $field_array = array_merge($field_array,array("medium_image"=>$medium_picture));
            $field_array = array_merge($field_array,array("big_image"=>$big_picture));
        }*/
        //echo "<pre>"; print_r($field_array); echo "</pre>"; exit;
        
	$dbObj->cupdtii('tbl_deal',$field_array,"deal_unique_id = '{$_GET['id']}'","");



$loc_country=$_POST['dealcountry'];
$loc_state=$_POST['dealstate'];
$loc_city=$_POST['dealcity'];
$loc_discount=$_POST['deal_discount'];
$country_array=array("country" => $loc_country, "state" => $loc_state, "city" => $loc_city , "discount"=>$loc_discount);
// print_r($country_array);
// echo "<br><br>";
// print_r($loc_country);
$count=count($loc_country);
$sel_discount=$dbObj->customqry("select * from tbl_deal_discount where deal_id=".$_GET['id'],"");
while($rs_discount=@mysql_fetch_assoc($sel_discount))
{
$discount_id[]=$rs_discount;
}

for($cc=0;$cc<$count;$cc++)
{
// echo "<br>country=".$loc_country[$cc];
// echo "<br>state=".$loc_state[$cc];
// echo "<br>city=". $loc_city[$cc];
// echo "<br>discount=".$loc_discount[$cc];
$deal_discount_array = array(
			     "country_id"  => $loc_country[$cc],
			     "state_id"    => $loc_state[$cc],
			     "city_id"       => $loc_city[$cc],
			     "discount"    => $loc_discount[$cc]
			    );
	$cnd="deal_id='".$_GET['id']."' and id='".$discount_id[$cc]['id']."'";
$dbObj->cupdtii('tbl_deal_discount',$deal_discount_array,$cnd,"");
}





	if($_GET['id'] > 0)
	{
		//Insert newly selected citites for products
		//delete all existing city id's of selected product before insert new at update time.
		@mysql_query("delete from tbl_deal_city where deal_id = ".$_GET['id']);
		if(count($_POST['dealcity'])>0)
		{
			for($c=0; $c < count($_POST['dealcity']); $c++)
			{
				$prod_cities_array = array(
									"deal_id"    => $_GET['id'],
									"city_id"    => $_POST['dealcity'][$c]
									);
				$dbObj->cgii("tbl_deal_city",$prod_cities_array,"");
			}
		}

		//Insert newly selected States for products
		//delete all existing States id's of selected product before insert new at update time.
		@mysql_query("delete from tbl_deal_state where deal_id = ".$_GET['id']);
		if(count($_POST['dealstate'])>0)
		{
			for($c=0; $c < count($_POST['dealstate']); $c++)
			{
				$deal_states_array = array(
									"deal_id"		=> $_GET['id'],
									"state_id"	=> $_POST['dealstate'][$c]
									);
				$dbObj->cgii("tbl_deal_state",$deal_states_array,"");
			}
		}

		//Insert newly selected Counties for products
		//delete all existing Counties id's of selected product before insert new at update time.
		@mysql_query("delete from tbl_deal_country where deal_id = ".$_GET['id']);
		if(count($_POST['dealcountry'])>0)
		{
			for($c=0; $c < count($_POST['dealcountry']); $c++)
			{
				$deal_countries_array = array(
									"deal_id"		=> $_GET['id'],
									"country_id"	=> $_POST['dealcountry'][$c]
									);
				$dbObj->cgii("tbl_deal_country",$deal_countries_array,"");
			}
		}
	}

	//////////START Inserting Records in tbl_delivery_service_charges////////////
	$res_delivery_service_chr = $dbObj->customqry("SELECT * FROM tbl_delivery_service_charges WHERE set_for = 'deal' AND user_id = ".$_GET['id'],"");

	$opt1 = 1;$opt2 = 1;$opt3 = 1;$opt4 = 1;$opt5 = 1;
	while($row_delivery_service_chr = @mysql_fetch_assoc($res_delivery_service_chr))
	{
		$j = 1;
		while($j<=5)
		{
			if($row_delivery_service_chr['delivery_service_option'] == "opt".$j)
			{
				if($j == 1)$opt1 = 0;if($j == 2)$opt2 = 0;if($j == 3)$opt3 = 0;if($j == 4)$opt4 = 0;if($j == 5)$opt5 = 0;
				$field_del_ser_chr = array(
									"delivery_service_option"=>$_POST['delivery_service_option_'.$j],
									"delivery_charges_pound"=>$_POST['delivery_charges_pound_'.$j],
									"delivery_charges_euro"=>$_POST['delivery_charges_euro_'.$j],
									"delivery_charges_dollar"=>$_POST['delivery_charges_dollar_'.$j],
									"delivery_service_option"=>"opt".$j,
									"is_selected"=>($_POST['delivery_service_option_chk_'.$j] == 'on'?'yes':'no')
									);

				$dbObj->cupdtii("tbl_delivery_service_charges",$field_del_ser_chr,"id=".$row_delivery_service_chr['id'],"");
			}
			$j++;

		} //End Inner While
	} //End Outer While

	if($opt1)
	{
		$field_del_ser_chr = array(
							"user_id"=>$_GET['id'],
							"delivery_service_option"=>$_POST['delivery_service_option_1'],
							"delivery_charges_pound"=>$_POST['delivery_charges_pound_1'],
							"delivery_charges_euro"=>$_POST['delivery_charges_euro_1'],
							"delivery_charges_dollar"=>$_POST['delivery_charges_dollar_1'],
							"delivery_service_option"=>"opt1",
							"is_selected"=>($_POST['delivery_service_option_chk_1'] == 'on'?'yes':'no'),
							"set_for"=>'deal'
							);

		$dbObj->cgii("tbl_delivery_service_charges",$field_del_ser_chr,"");
	}
	if($opt2)
	{
		$field_del_ser_chr = array(
							"user_id"=>$_GET['id'],
							"delivery_service_option"=>$_POST['delivery_service_option_2'],
							"delivery_charges_pound"=>$_POST['delivery_charges_pound_2'],
							"delivery_charges_euro"=>$_POST['delivery_charges_euro_2'],
							"delivery_charges_dollar"=>$_POST['delivery_charges_dollar_2'],
							"delivery_service_option"=>"opt2",
							"is_selected"=>($_POST['delivery_service_option_chk_2'] == 'on'?'yes':'no'),
							"set_for"=>'deal'
							);

		$dbObj->cgii("tbl_delivery_service_charges",$field_del_ser_chr,"");
	}
	if($opt3)
	{
		$field_del_ser_chr = array(
							"user_id"=>$_GET['id'],
							"delivery_service_option"=>$_POST['delivery_service_option_3'],
							"delivery_charges_pound"=>$_POST['delivery_charges_pound_3'],
							"delivery_charges_euro"=>$_POST['delivery_charges_euro_3'],
							"delivery_charges_dollar"=>$_POST['delivery_charges_dollar_3'],
							"delivery_service_option"=>"opt3",
							"is_selected"=>($_POST['delivery_service_option_chk_3'] == 'on'?'yes':'no'),
							"set_for"=>'deal'
							);

		$dbObj->cgii("tbl_delivery_service_charges",$field_del_ser_chr,"");
	}
	if($opt4)
	{
		$field_del_ser_chr = array(
							"user_id"=>$_GET['id'],
							"delivery_service_option"=>$_POST['delivery_service_option_4'],
							"delivery_charges_pound"=>$_POST['delivery_charges_pound_4'],
							"delivery_charges_euro"=>$_POST['delivery_charges_euro_4'],
							"delivery_charges_dollar"=>$_POST['delivery_charges_dollar_4'],
							"delivery_service_option"=>"opt4",
							"is_selected"=>($_POST['delivery_service_option_chk_4'] == 'on'?'yes':'no'),
							"set_for"=>'deal'
							);

		$dbObj->cgii("tbl_delivery_service_charges",$field_del_ser_chr,"");
	}
	if($opt5)
	{
		$field_del_ser_chr = array(
							"user_id"=>$_GET['id'],
							"delivery_service_option"=>$_POST['delivery_service_option_5'],
							"delivery_charges_pound"=>$_POST['delivery_charges_pound_5'],
							"delivery_charges_euro"=>$_POST['delivery_charges_euro_5'],
							"delivery_charges_dollar"=>$_POST['delivery_charges_dollar_5'],
							"delivery_service_option"=>"opt5",
							"is_selected"=>($_POST['delivery_service_option_chk_5'] == 'on'?'yes':'no'),
							"set_for"=>'deal'
							);

		$dbObj->cgii("tbl_delivery_service_charges",$field_del_ser_chr,"");
	}
	///////////END Inserting Records in tbl_delivery_service_charges/////////////

	$s=$msobj->showmessage(150);
	$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
        
	if(isset($_GET['back']) && $_GET['back'] == 'up')
	{
		@header("Location:".SITEROOT."/admin/globalsettings/deal/upcoming_deal.php");
	}elseif(isset($_GET['back']) && $_GET['back'] == 'ex')
	{
		@header("Location:".SITEROOT."/admin/globalsettings/deal/expired_deal.php");
	}elseif(isset($_GET['back']) && $_GET['back'] == 'pend')
	{
		@header("Location:".SITEROOT."/admin/globalsettings/deal/pending-deal.php");
	}else
	{
		@header("Location:".SITEROOT."/admin/globalsettings/deal/manage_deal.php");
	}
	exit;
}
#------------------End update deal----------#
$_SESSION['selectedimage']="";

if($_GET['id'])
{

	$res1 = $dbObj->cgs("tbl_deal d LEFT JOIN mast_deal_category as c ON d.deal_cat = c.id LEFT JOIN mast_deal_category as s ON d.deal_subcat = s.id ","d.*,c.category as category,s.category as sub_category","deal_unique_id",$_GET['id'],"","","");
	
	if($res1 != 'n')
	{
	
            $row3 = @mysql_fetch_assoc($res1);
            $s_date = explode(" ",$row3['start_date']);
            $start_date = $s_date[0];
            $s_arr = explode(":",$s_date[1]);
            $s_hr = $s_arr[0];
            $s_min = $s_arr[1];
            $e_date = explode(" ",$row3['end_date']);
            $end_date = $e_date[0];
            $e_arr = explode(":",$e_date[1]);
            $e_hr = $e_arr[0];
            $e_min = $e_arr[1];

            $from_date = explode(" ",$row3['validfrom']);
            $end_validfrom = $from_date[0];


            $to_date = explode(" ",$row3['validto']);
            $end_dateto = $to_date[0];


	    $redeemfrom  = explode(" ",$row3['redeemfrom']);
        $redeemfrom = $redeemfrom[0];

            $redeemto = explode(" ",$row3['redeemto']);
            $redeemto = $redeemto[0];

            $deal_main_type=$row3['deal_main_type'];

            $deal_city= $row3['deal_city'];
            $deal_cat= $row3['deal_cat'];
            $deal_cat1= $row3['deal_subcat'];
            $deal_cat2= $row3['deal_subsubcat'];
            $deal_cat3= $row3['deal_subsubsubcat'];
	    $send_to= explode(",",$row3['senddealto']);
	$send_to_fan=$send_to[0];
	$send_to_other=$send_to[1];
            /*     get city     */
            /*$sql="select * from mast_city where city_id = ".$deal_city;        
            $result = mysql_query($sql) or die('Error, query failed');
            while($row = mysql_fetch_array($result))
            {
                $mast_city[] = $row;
            }*/
            /*    get deal type   */
              $dealsql="select * from tbl_dealtype";
             $dealresult = mysql_query($dealsql) or die('Error, query failed');
             $i = 0;
		while($dealrow = mysql_fetch_array($dealresult))
		{
			$tmp = array('typeid'=>$dealrow['typeid'],
			'dealtype'=>$dealrow['dealtype']);
			$dealresults[$i++] = $tmp;
			if($dealrow['price_option'] == 'groupbuy')
			{
				$dealprice_option=$dealprice_option.",".$dealrow['typeid'];
			}
		}
		$dealprice_option = substr($dealprice_option,1);
		
		
		/////////Get category name by using parent id START/////////////
            if($deal_cat)
            {
                $sql="select * from mast_deal_category where parent_id = ".$deal_cat;
                $result = mysql_query($sql) or die('Error, query failed');
                while($row = mysql_fetch_array($result))
                {
                    $subcategory[] = $row;
                }
            }
            if($deal_cat1)
            {
                $sqlsub="select * from mast_deal_category where parent_id = ".$deal_cat1;
                $resultsub = mysql_query($sqlsub) or die('Error, query failed');
                while($rowsub = mysql_fetch_array($resultsub))
                {
                    $subsubcategory[] = $rowsub;
                }
            }
             if($deal_cat2)
            {
                $sqlsubsub="select * from mast_deal_category where parent_id = ".$deal_cat2;
                $resultsubsub = mysql_query($sqlsubsub) or die('Error, query failed');
                while($rowsubsub = mysql_fetch_array($resultsubsub))
                {
                    $subsubsubcategory[] = $rowsubsub;
                }
            }
            /////////Get category name by using parent id START/////////////
            

		$smarty->assign("deal",$dealresults);
		$smarty->assign("dealprice_option",$dealprice_option);
		$smarty->assign("dealprice_option_array",explode(",",$dealprice_option));
		//$smarty->assign("city",$mast_city);
		$smarty->assign("dealcat",$deal_cat);
		$smarty->assign("state_con",$subcategory);
		$smarty->assign("state_sub",$subsubcategory);
		$smarty->assign("state_subsub",$subsubsubcategory);
		$smarty->assign("fromdates",$end_validfrom);
		$smarty->assign("todates",$end_dateto);
		$smarty->assign("send_to_fan",$send_to_fan);
		$smarty->assign("send_to_other",$send_to_other);

		$smarty->assign("start_date",$start_date);
		$smarty->assign("end_date",$end_date);
		$smarty->assign("s_hr",$s_hr);
		$smarty->assign("s_min",$s_min);
		$smarty->assign("e_hr",$e_hr);
		$smarty->assign("e_min",$e_min);
		$smarty->assign("redeemfrom",$redeemfrom);
		$smarty->assign("redeemto",$redeemto);
		
		include_once '../../../ckeditor/ckeditor.php' ;
		require_once '../../../ckfinder/ckfinder.php' ;
		$initialValue = '<p>Just click the <b>Image</b> or <b>Link</b> button, and then <b>&quot;Browse Server&quot;</b>.</p>' ;
		$ckeditor = new CKEditor( ) ;
		$ckeditor->basePath	= '../../../ckeditor/' ;
		CKFinder::SetupCKEditor($ckeditor, '../../' ) ;
		$config['toolbar'] = array(
		array( 'Source', '-', 'Bold', 'Italic', 'Underline', 'Strike' ),
		array( 'NumberedList','BulletedList','-','Image','Format','FontSize','TextColor','BGColor'));

// 		$initialValue = stripslashes(html_entity_decode($row3['title']));
// 		$editorcontentTitle= $ckeditor->editor("title1", $initialValue, $config);
// 		$smarty->assign("oFCKeditorTitle", $editorcontentTitle);
		
// 		$initialValue = stripslashes(html_entity_decode($row3['slogan']));
// 		$editorcontentSlogan= $ckeditor->editor("slogan", $initialValue, $config);
// 		$smarty->assign("oFCKeditorSlogan", $editorcontentSlogan);


		$initialValue = stripslashes(html_entity_decode($row3['description']));
		$editorcontent= $ckeditor->editor("description", $initialValue, $config);
		//print_r($editorcontent);
		$smarty->assign("oFCKeditor", $editorcontent);

		$initialValue = stripslashes(html_entity_decode($row3['whybuy']));
		$editorcontentSubtitle= $ckeditor->editor("whybuy", $initialValue, $config);
		$smarty->assign("oFCKeditorwhybuy", $editorcontentSubtitle);


		$initialValue = stripslashes(html_entity_decode($row3['termsandconditions']));
		$editorcontent1= $ckeditor->editor("terms", $initialValue, $config);
		$smarty->assign("oFCKeditor1", $editorcontent1);

		$initialValue1 = '<p>Just click the <b>Image</b> or <b>Link</b> button, and then <b>&quot;Browse Server&quot;</b>.</p>' ;
		$initialValue2 = stripslashes(html_entity_decode($row3['fineprint']));
		$editorcontent2= $ckeditor->editor("fineprint", $initialValue2, $config);
		//print_r($editorcontent);
		$smarty->assign("oFCKeditor2", $editorcontent2);

		$initialValue = stripslashes(html_entity_decode($row3['refund_policy']));
		$editorcontentRefundPolicy= $ckeditor->editor("refund_policy", $initialValue, $config);
		$smarty->assign("oFCKeditorRefundPolicy", $editorcontentRefundPolicy);

		$initialValue = stripslashes(html_entity_decode($row3['howitwork']));
		$editorcontentHowItWork= $ckeditor->editor("howitwork", $initialValue, $config);
		$smarty->assign("oFCKeditorHowItWork", $editorcontentHowItWork);


            if( $row3['small_image'])
                $s_img = explode(",",$row3['small_image']);
            $smarty->assign("deal_img",$s_img);
            $smarty->assign("deal_img_cnt",count($s_img));

            $smarty->assign("deal_info",$row3);

            
            #----------Get seller type option-----------------#
           
            $sto=$dbObj->customqry("select * from tbl_sellertype_option where sell_id != 11","");
            
            while($row1=@mysql_fetch_array($sto))
            {
                $selleroption1[]=$row1;
            }
            //echo "<pre>"; print_r($selleroption1); echo "</pre>";
            $smarty->assign("selleroption",$selleroption1);
           
            #----------Get seller type option-----------------#

            //-------------------get payment getway type----------------------------//
            $payment_rs = $dbObj->gj("tbl_billing_info","*","user_id='".$row3['seller_id']."'","","","","","");
            
            while($row = @mysql_fetch_assoc($payment_rs))
            {
                $payment[] = $row;
            }
            $smarty->assign("payment",$payment);

             //make selected option array
            $opt = explode(",",$row3['option_selected']);
            $smarty->assign("opt",$opt);

            //make selected payment option
            $pay = explode(",",$row3['payment_method']);
            $smarty->assign("pay",$pay);
            //-------------------end get payment getway type----------------------------//
	}

	$days = range(2,30);
	$smarty->assign("days",$days);
	$hours = range(0,23);
	$smarty->assign("hours",$hours);


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

#---------------End Time-------------------#

    #--------------Get seller type--------------#
    $rs1=mysql_query("select * from tbl_seller_type where Active=1");
    while($row1=@mysql_fetch_array($rs1))
    {
    $seller1[]=$row1;
    }
    $smarty->assign("seller1",$seller1);
    #--------------Get seller type--------------#

#-----------------------------------------------------------------------------#
#-----------------------------------------------------------------------------#

    #-----------------Get Country START--------------------#
$row_country = array();
$rs1 = $dbObj->customqry("select * from mast_country where countryid = '225' and status='Active'","");
$row1 = @mysql_fetch_assoc($rs1);
if($row1){
$row_country[]=$row1;}
$cnd= "c.status='Active' and countryid !=225";
$sf="c.*";
$ob="country ASC";
//$rs1=$dbObj->gj("mast_country c",$sf,$cnd, $ob, "", "", $l, "");
$res_country=$dbObj->gj("mast_country c",$sf,$cnd, $ob, "", "", $l, "");
    
	//$res_country = $dbObj->cgs("mast_country","*","status","Active","country","ASC","");
	$num_country = @mysql_num_rows($res_country);
	//$row_country = array();
	while($row_con = @mysql_fetch_assoc($res_country))
	{
		$row_country[] = $row_con;
	}
	$smarty->assign("country",$row_country);
	
    #-----------------Get Country END--------------------#


	///////////////////////////////////////////
// 	//Get multiple Countries as per product id
// 	$res_dealcountries = $dbObj->cgs("tbl_deal_discount","","deal_id",$_GET['id'],"","","1");
// 	$deal_countries_num_rows = @mysql_num_rows($res_dealcountries);
// 	$deal_countries = "";
// // 	$c_arr=1;
// 	while($row_dealcountries=@mysql_fetch_array($res_dealcountries))
// 	{
// 		$deal_countries .= $row_dealcountries['country_id'];
// // 		if($deal_countries_num_rows != $c_arr )
// // 		{
// // 			$deal_countries .= ",";
// // 		}
// // 		$c_arr++;
// 	} 
// 	
// 	$smarty->assign("deal_countries_arr",$deal_countries);
	
	

#-----------------------------------------------------------------------------#
#-----------------------------------------------------------------------------#

   

	///////////////////////////////////////////
	//Get multiple Countries as per product id
	$res_dealstates = $dbObj->cgs("tbl_deal_state","","deal_id",$_GET['id'],"","","");
	$deal_states_num_rows = @mysql_num_rows($res_dealstates);
	$deal_states = "";
	$c_arr=1;
	while($row_dealstates=@mysql_fetch_array($res_dealstates))
	{
		$deal_states .= $row_dealstates['state_id'];
		if($deal_states_num_rows != $c_arr )
		{
			$deal_states .= ",";
		}
		$c_arr++;
	} 
	$smarty->assign("deal_states_arr",explode(",",$deal_states));

#-----------------------------------------------------------------------------#
#-----------------------------------------------------------------------------#



   ///////////////////////////////////////////
   //Get multiple cities as per product id
   $res_dealcities = $dbObj->cgs("tbl_deal_city","","deal_id",$_GET['id'],"","","");
   $deal_cities_num_rows = @mysql_num_rows($res_dealcities);
   $deal_cities = "";
   $c_arr=1;
   while($row_dealcities=@mysql_fetch_array($res_dealcities))
   {
      $deal_cities .= $row_dealcities['city_id'];
      if($deal_cities_num_rows != $c_arr )
      {
         $deal_cities .= ",";
      }
      $c_arr++;
   } 
   $smarty->assign("deal_cities_arr",explode(",",$deal_cities));

#-----------------------------------------------------------------------------#
#-----------------------------------------------------------------------------#

    #---------get category--------------------#
    /*$selectCategory = $dbObj->gj("mast_deal_category as c", "c.*" , "1", "", "", "",  "", "");
    while($row=@mysql_fetch_array($selectCategory))
    {
        $dealcategory[]=$row;
    }
    $smarty->assign("dealcategory",$dealcategory);*/
    #---------get mai category--------------------#
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
    
    #---------get seller type --------------------#
    if($row3['seller_id']==1)
	{
	$seltype_rs = $dbObj->gj("tbl_deal", "company_type", "deal_unique_id = '".$_GET['id']."'", "", "", "",  "", "");
	}
	else
	{
	 $seltype_rs = $dbObj->gj("tbl_users", "company_type", "userid = '".$row3['seller_id']."'", "", "", "",  "", "");
	}
    $seltype=@mysql_fetch_array($seltype_rs);
    
    $smarty->assign("seller_type",$seltype['company_type']);
    #---------get seller type --------------------#

}

#-----------------Get Seller Users--------------------#
$res_sellerDet = $dbObj->cgs("tbl_users","userid, fullname, first_name, last_name, email",array("isDeleted","usertypeid"),array(0,3),"first_name","ASC","");
$num_seller = @mysql_num_rows($res_sellerDet);
$row_sellerDet = array();
while($row = @mysql_fetch_assoc($res_sellerDet))
{
	$row_sellerDet[] = $row;
}

$smarty->assign("sellerList",$row_sellerDet);
#-----------------Get Seller Users END--------------------#

#-----------------START to fetching delivery charges label--------------------#
$res_delivery_chr = $dbObj->customqry("SELECT * FROM sitesetting WHERE id IN(52,53,54,55,56)","");
while($row_delivery_chr = @mysql_fetch_assoc($res_delivery_chr))
	$data_delivery_chr[] = $row_delivery_chr;

$smarty->assign("data_delivery_chr", $data_delivery_chr);

$res_delivery_service_chr = $dbObj->customqry("SELECT * FROM tbl_delivery_service_charges WHERE set_for = 'deal' AND user_id = ".$_GET['id'],"");
while($row_delivery_service_chr = @mysql_fetch_assoc($res_delivery_service_chr))
	$data_delivery_service_chr[] = $row_delivery_service_chr;

$smarty->assign("data_delivery_service_chr", $data_delivery_service_chr);
#-----------------END to fetching delivery charges label--------------------#

#------------Display Message----------------#
if($_SESSION['msg'])
{
	$smarty->assign("msg", $_SESSION['msg']);
	$_SESSION['msg']=NULL;
	unset($_SESSION['msg']);
}
#--------------------------------------------#

$smarty->display(TEMPLATEDIR . '/admin/globalsettings/deal/edit_product.tpl');
$dbObj->Close();
?>
