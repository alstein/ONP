<?php
include_once('../../../includes/SiteSetting.php');
include_once("../../../includes/common.lib.php");
include_once('../../../includes/class.message.php');
include_once('../../../includes/function.php');

if((!$_SESSION['duAdmId']) || $_SESSION['duUserTypeId'] != 3)
{
	$_SESSION['type'] = 'seller';
	header("location:". SITEROOT . "/signin");
}

/////////////////////////////////////////////
//START 
//this file is added for checking the subscription is expired or subscribed of seller
include_once(ABSPATH.'/admin/seller/check_seller_subscription.php');
//this file is added for checking the subscription is expired or subscribed of seller
//END
/////////////////////////////////////////////

$msobj= new message();



$_SESSION['deal_type'] = "service";

include_once '../../../ckeditor/ckeditor.php' ;
require_once '../../../ckfinder/ckfinder.php' ;

$ckeditor = new CKEditor('description') ;
$ckeditor->basePath	= '../../../ckeditor/' ;
CKFinder::SetupCKEditor($ckeditor, '../../../' ) ;
//$config['toolbar'] = array(
//array( 'Source', '-', 'Bold', 'Italic', 'Underline', 'Strike' ),
//array( 'NumberedList','BulletedList','-','Image','Format','FontSize','TextColor','BGColor'));

/*
$initialValue = '';
$editorcontentTitle= $ckeditor->editor("title1", $initialValue, $config);
$smarty->assign("oFCKeditorTitle", $editorcontentTitle);

$initialValue = '';
$editorcontentSubtitle= $ckeditor->editor("subtitle", $initialValue, $config);
$smarty->assign("oFCKeditorSubtitle", $editorcontentSubtitle);

$initialValue = '';
$editorcontentSlogan= $ckeditor->editor("slogan", $initialValue, $config);
$smarty->assign("oFCKeditorSlogan", $editorcontentSlogan);
*/

$initialValue = '';
$editorcontent= $ckeditor->editor("description", $initialValue, $config);
//print_r($editorcontent);
$smarty->assign("oFCKeditor", $editorcontent);

$initialValue = '';
$editorcontent1= $ckeditor->editor("highlight", $initialValue, $config);
//print_r($editorcontent);
$smarty->assign("oFCKeditor1", $editorcontent1);

$initialValue = '';
$editorcontent2= $ckeditor->editor("fineprint", $initialValue, $config);
//print_r($editorcontent);
$smarty->assign("oFCKeditor2", $editorcontent2);

$initialValue = '';
$editorcontentHowItWork= $ckeditor->editor("howitwork", $initialValue, $config);
$smarty->assign("oFCKeditorHowItWork", $editorcontentHowItWork);

//get data from tabl_users of seller like delivery_charges, refund_policy, seller_support_email, tracking_url_code, delivered_tracking_url_code
$sellerData = getDataFromTable('tbl_users',"userid, delivery_charges_pound, delivery_charges_euro, delivery_charges_dollar, refund_policy, seller_support_email, tracking_url_code, delivered_tracking_url_code","userid = '".$_SESSION['duAdmId']."'");

$initialValue = stripslashes(html_entity_decode($sellerData['refund_policy']));
$editorcontentRefundPolicy= $ckeditor->editor("refund_policy", $initialValue, $config);
$smarty->assign("oFCKeditorRefundPolicy", $editorcontentRefundPolicy);

$smarty->assign("seller_delivery_charges_pound", $sellerData['delivery_charges_pound']);
$smarty->assign("seller_delivery_charges_euro", $sellerData['delivery_charges_euro']);
$smarty->assign("seller_delivery_charges_dollar", $sellerData['delivery_charges_dollar']);
$smarty->assign("seller_seller_support_email", $sellerData['seller_support_email']);
$smarty->assign("seller_tracking_url_code", $sellerData['tracking_url_code']);
$smarty->assign("seller_delivered_tracking_url_code", $sellerData['delivered_tracking_url_code']);


if(!$_SESSION['duAdmId'])
{
    header("location:".SITEROOT . "/admin/login/index.php");
    exit;
}

if(isset($_POST['box']))
{
    ?><script language="javascript"> self.parent.tb_remove();</script><?php exit;
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

#---------------End Time-------------------#

#----------- -Add Deal-------------------#
if(isset($_POST['Submit']))
{
//START checking seller deal adding access//

	$res_seller_deals = $dbObj->customqry("
	select
		 * 
	from 
		tbl_deal as d, 
		tbl_user_subscription_details as subdet, 
		tbl_users as u 
	where 
		d.admin_userid = ".$_SESSION['duAdmId']." and 
		d.added_date > subdet.subscription_date and 
		d.added_date < subdet.expiration_date and 
		u.last_subs_id = subdet.subs_id and 
		u.userid = ".$_SESSION['duAdmId']."
	","");

	
//END checking seller deal adding access//


// 	if($_FILES['dealimage']['name'][0])
// 	{
//             $size = sizeof($_FILES['dealimage']['name']);
// 
//             $photo_names = array();
//             for($i=0;$i<$size;$i++)
//             {
// 	       $photo_names[] = uploadandresizedeal($_FILES['dealimage'],$i);
//             }
//             $small_picture = implode(",",$photo_names); 
//
//             //$photo_namemedium=uploadandresize($_FILES['photo'], '../../uploads/product', '../../uploads/product/thumb122X145/', 120,140);
//             $medium_picture = implode(",",$photo_names);
//
//             // $photo_namebig=uploadandresize($_FILES['photo'], '../../uploads/product', '../../uploads/product/thumb577X385/', 385,577);
//             $big_picture = implode(",",$photo_names);
// 	}
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
        if($subcat_rs  == "n")
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
    }
    
    ////////////////////////Qr Code image Code Here end//////////////////
    

        $small_picture = $_SESSION['selectedimage']; 
        $medium_picture = $_SESSION['selectedimage']; 
        $big_picture = $_SESSION['selectedimage'];

//         $deal_type = "product";
//         if($_POST['sellertype'] == "8")
//         {
//             $deal_type = "service";
//         }
        $str     = $_POST['title1'];
        $order   = array("(",")",":","$","#","@","%","^","*","[","]","&","{","}","|","/","_","+","!","~","`","?","<",".",",",">","'");
        $replace = '';
        $url_title = str_replace($order, $replace, $str);
        $title2=str_replace(" ","-",$url_title);


	 $tit= array();
	
     		$is_title = $dbObj->gj("tbl_deal","url_title","url_title like '".$title2."%'","","","","","");
		
		while($title_row = @mysql_fetch_assoc($is_title))
		{
			$tit[] =$title_row;
			if($title_row['url_title']==$title2)
			{
			$title2.="-";
			}
		}

         //-----------------------get user city for deal-----------------------------------//
//         if($_POST['zipcode'] != "")
//         {
//             $p=explode(" ",$_POST['zipcode']);
//             if(strlen($p[0])>4)
//             {
//                 $zip=$p[0][0].$p[0][1].$p[0][2].$p[0][3];
//                 $rs=$dbObj->cgs("zipData", "*", "zipcode", $zip, "", "", "");
//                 $row=@mysql_fetch_assoc($rs);
//                 $city=$row['city'];
//                 if(!$city)
//                 {
//                     $zip=$p[0][0].$p[0][1].$p[0][2];
//                     $rs=$dbObj->cgs("zipData", "*", "zipcode", $zip, "", "", "");
//                     $row=@mysql_fetch_assoc($rs);
//                     $city=$row['city'];	 
//                 }
//             }
//             else
//             {
//                 $rs=$dbObj->cgs("zipData", "*", "zipcode",$p[0], "", "", "1");
//                 $row=@mysql_fetch_assoc($rs);
//                 $city=$row['city'];
//             }
//             //echo "city : ".$city;exit;
//         }
    
        //-----------------------end get user city for deal-----------------------------------//
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

$howitwork=' <strong> How It Works </strong>

<br/><br>
<i>1. Print the voucher or save it <br/> on your mobile</i><br/><br/>
<i>2. Present the voucher to the merchant<br />
when you are ready.
</i><br/><br/>
<i>3. Enjoy your deal</i>
<br/><br/>
<i> Have fun the Group Buy It Team !</i>';

$howitwork = $_POST['howitwork'];

// if($_POST['dealmaintype'] == '3')
if(in_array($_POST['dealmaintype'], explode(",",$_POST['price_option'])))
{
	if(isset($_POST['chk_1']))
		$_POST['chk_1'] = 'true';
	else
		$_POST['chk_1'] = 'false';

	if(isset($_POST['chk_2']))
		$_POST['chk_2'] = 'true';
	else
		$_POST['chk_2'] = 'false';

	if(isset($_POST['chk_3']))
		$_POST['chk_3'] = 'true';
	else
		$_POST['chk_3'] = 'false';

	if(isset($_POST['chk_4']))
		$_POST['chk_4'] = 'true';
	else
		$_POST['chk_4'] = 'false';

	if(isset($_POST['chk_5']))
		$_POST['chk_5'] = 'true';
	else
		$_POST['chk_5'] = 'false';


	$_POST['price'] = 0;
	$_POST['quantity'] = 0;
	$_POST['min_buyer'] = 0;
	$_POST['max_buyer'] = 0;

	$groupBuyPrice = $_POST['groupbuy_price_1'];
	$savePer = $_POST['cus_saving_1'];
}
else
{
	$_POST['chk_1'] = 'false';
	$_POST['chk_2'] = 'false';
	$_POST['chk_3'] = 'false';
	$_POST['chk_4'] = 'false';
	$_POST['chk_5'] = 'false';

	$_POST['min_buyer_1'] = 0;
	$_POST['max_buyer_1'] = 0;
	$_POST['groupbuy_price_1'] = 0;
	$_POST['cus_saving_1'] = 0;
	$_POST['min_buyer_2'] = 0;
	$_POST['max_buyer_2'] = 0;
	$_POST['groupbuy_price_2'] = 0;
	$_POST['cus_saving_2'] = 0;
	$_POST['min_buyer_3'] = 0;
	$_POST['max_buyer_3'] = 0;
	$_POST['groupbuy_price_3'] = 0;
	$_POST['cus_saving_3'] = 0;
	$_POST['min_buyer_4'] = 0;
	$_POST['max_buyer_4'] = 0;
	$_POST['groupbuy_price_4'] = 0;
	$_POST['cus_saving_4'] = 0;
	$_POST['min_buyer_5'] = 0;
	$_POST['max_buyer_5'] = 0;
	$_POST['groupbuy_price_5'] = 0;
	$_POST['cus_saving_5'] = '';

	$groupBuyPrice = $_POST['price'];
	$savePer = trim($_POST['quantity']);
}

	$field_array = array(
		"seller_id"=>1,
		"admin_userid"=>$_SESSION['duAdmId'],
		"is_national"=>$is_national,
		"deal_cat"=>$_POST['maincategory'],//$cat_id,
		"deal_subcat"=>$_POST['subcategory'],//$subcat_id,
		"deal_subsubcat"=>$_POST['subsubcategory'],//$subsubcat_id,
		"deal_subsubsubcat"=>$_POST['subsubsubcategory'],//$subsubsubsubcat_id,
		"deal_city"=>"", //$_POST['dealcity'],
		"title"=>$_POST['title1'],
		"subtitle"=>$_POST['subtitle'],
		"slogan"=>$_POST['slogan'],
		"url_title"=>$title2,
		"description"=>$_POST['description'],
		"highlight"=>$_POST['highlight'],
		"fineprint"=>$_POST['fineprint'],
		"sub_delivery_cost"=>trim($_POST['delivery_cost']),
		"payment_method"=>$_POST['payment_method'],
		"vedio_link"=>trim($_POST['videolink']),
		"groupbuy_price"=>$groupBuyPrice,
		"orignal_price"=>$_POST['originalprice'],
		"quantity"=>$savePer,
		"min_buyer"=>$_POST['min_buyer'],
		"max_buyer"=>$_POST['max_buyer'],
		"start_date"=>$_POST['dob1']." ".$_POST['start_hour'].":".$_POST['start_min'].":00",
		"end_date"=>$_POST['dob2']." ".$_POST['end_hour'].":".$_POST['end_min'].":00",
		"final_value"=>$_POST['final_value'],
		"listing_value"=>$_POST['listing'],
		"option_selected"=>$_POST['option_selected'],
		"small_image"=>$small_picture,
		"medium_image"=>$medium_picture,
		"big_image"=>$big_picture,
		"admin_approve"=>"no",
		"admin_review"=>1,
		"company_type"=>$_POST['sellertype'],
		"comments"=>$_POST['comments'],
		"qr_code_link"=>$_POST['qr_code_link'],
		"qr_code_image"=>$original_1,
		"sub_delivery_cost"=>$_POST['sub_delivery_cost'],
		"seller_support_email"=>$_POST['seller_support_email'],
		"trackURL"=>$_POST['trackURL'],
		"delivered_tracking_url_code"=>$_POST['delivered_tracking_url_code'],
		"refund_policy"=>$_POST['refund_policy'],
		"otherproductURL"=>$_POST['otherproductURL'],
		"videolink"=>$_POST['videolink'],
		"retailerwebURL"=>$_POST['retailerwebURL'],
		"retailer_website_affiliate_link"=>$_POST['retailer_website_affiliate_link'],
		"retailer_website_affiliate_code"=>$_POST['retailer_website_affiliate_code'],
		"addressandlocation"=>$_POST['addressandlocation'],
		"deal_address"=>$_POST['shop_addr'],
		"deal_status"=>1,
		"featured"=>$featured,
		"featured_page"=>$page_featured,
		"news_subscribe"=>$news_subscribe,
		"validfrom"=>$_POST['validfrom'],
		"validto"=>$_POST['validto'],
		"notes"=>"Thanks for paying",
		"howitwork"=>$howitwork,
		"deal_main_type"=>$_POST['dealmaintype'],
		"deal_currency"=>$_POST['deal_currency'],
		"seller_account_no"=>$_POST['seller_account_no'],
		"deal_from_seller_name_other"=>$_POST['deal_from_seller_name_other'],
		"seller_zipcode"=>$_POST['zipcode'],
		"min_buyer_1"=>$_POST['min_buyer_1'],
		"max_buyer_1"=>$_POST['max_buyer_1'],
		"buy_price_1"=>$_POST['groupbuy_price_1'],
		"discount_1"=>$_POST['cus_saving_1'],
		"min_buyer_2"=>$_POST['min_buyer_2'],
		"max_buyer_2"=>$_POST['max_buyer_2'],
		"buy_price_2"=>$_POST['groupbuy_price_2'],
		"discount_2"=>$_POST['cus_saving_2'],
		"min_buyer_3"=>$_POST['min_buyer_3'],
		"max_buyer_3"=>$_POST['max_buyer_3'],
		"buy_price_3"=>$_POST['groupbuy_price_3'],
		"discount_3"=>$_POST['cus_saving_3'],
		"min_buyer_4"=>$_POST['min_buyer_4'],
		"max_buyer_4"=>$_POST['max_buyer_4'],
		"buy_price_4"=>$_POST['groupbuy_price_4'],
		"discount_4"=>$_POST['cus_saving_4'],
		"min_buyer_5"=>$_POST['min_buyer_5'],
		"max_buyer_5"=>$_POST['max_buyer_5'],
		"buy_price_5"=>$_POST['groupbuy_price_5'],
		"discount_5"=>$_POST['cus_saving_5'],
		"range_1"=>$_POST['chk_1'],
		"range_2"=>$_POST['chk_2'],
		"range_3"=>$_POST['chk_3'],
		"range_4"=>$_POST['chk_4'],
		"range_5"=>$_POST['chk_5'],
		"voucher_text"=>$_POST['free_voucher_text']
			);
//print_r($field_array);exit;
		if($_POST['website'] != "")
		{
			$field_array = array_merge($field_array,array("option_website"=>$_POST['website']));
		}
		if($_POST['shop_addr'] != "")
		{
			$field_array = array_merge($field_array,array("shop_location"=>$_POST['shop_addr']));
		}
		//echo "<pre>"; print_r($field_array); echo "</pre>"; exit;
		$insertedId = $dbObj->cgii("tbl_deal",$field_array,"");


		if($insertedId > 0)
		{
			//Insert newly selected citites for products
			if(count($_POST['dealcity'])>0)
			{
				for($c=0; $c < count($_POST['dealcity']); $c++)
				{
					$deal_cities_array = array(
										"deal_id"    => $insertedId,
										"city_id"       => $_POST['dealcity'][$c]
										);
					$dbObj->cgii("tbl_deal_city",$deal_cities_array,"");
				}
			}

			//Insert newly selected States for products
			if(count($_POST['dealstate'])>0)
			{
				for($c=0; $c < count($_POST['dealstate']); $c++)
				{
					$deal_states_array = array(
										"deal_id"		=> $insertedId,
										"state_id"	=> $_POST['dealstate'][$c]
										);
					$dbObj->cgii("tbl_deal_state",$deal_states_array,"");
				}
			}

			//Insert newly selected Counties for products
			if(count($_POST['dealcountry'])>0)
			{
				for($c=0; $c < count($_POST['dealcountry']); $c++)
				{
					$deal_countries_array = array(
										"deal_id"		=> $insertedId,
										"country_id"	=> $_POST['dealcountry'][$c]
										);
					$dbObj->cgii("tbl_deal_country",$deal_countries_array,"");
				}
			}
		}

//////////START Inserting Records in tbl_delivery_service_charges////////////

		for($i=1; $i<=5;$i++)
		{
			$field_del_ser_chr = array(
								"user_id"=>$insertedId, // deal_id
								"delivery_service_option"=>$_POST['delivery_service_option_'.$i],
								"delivery_charges_pound"=>$_POST['delivery_charges_pound_'.$i],
								"delivery_charges_euro"=>$_POST['delivery_charges_euro_'.$i],
								"delivery_charges_dollar"=>$_POST['delivery_charges_dollar_'.$i],
								"delivery_service_option"=>"opt".$i,
								"is_selected"=>($_POST['delivery_service_option_chk_'.$i] == 'on'?'yes':'no'),
								"set_for"=>'deal'
								);

			$dbObj->cgii("tbl_delivery_service_charges",$field_del_ser_chr,"");
		}

///////////END Inserting Records in tbl_delivery_service_charges/////////////


	$s=$msobj->showmessage(149);
	$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";

	//header("Location:".SITEROOT."/admin/seller/deal/manage_deal.php");
	//exit;
	header("Location:".SITEROOT."/admin/seller/deal/pending-deal.php");
	exit;

}
#----------- -Add Deal-------------------#

$_SESSION['selectedimage']="";

#--------------Get seller type--------------#
$rs1=mysql_query("select * from tbl_seller_type where Active=1");
while($row1=@mysql_fetch_array($rs1))
{
   $seller1[]=$row1;
}
$smarty->assign("seller1",$seller1);
#--------------Get Deal city in mast_city table and display add new deal--------------#
// $cityresult=mysql_query("SELECT * FROM mast_city ORDER BY city_name");
// while($cityrow=@mysql_fetch_array($cityresult))
// {
//    $dealcity[]=$cityrow;
// }
// $smarty->assign("seller1",$seller1);


#-----------------Get Country START--------------------#
$row_country = array();
$rs1 = $dbObj->customqry("select * from mast_country where countryid = 225","");
$row1 = @mysql_fetch_assoc($rs1);
$row_country[]=$row1;
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

#-----------------Get State START--------------------#
$sqlstate="SELECT * FROM mast_state ms , mast_country mcou WHERE ms.country_id = mcou.countryid and mcou.status = 'Active'";
$sqlstrow=mysql_query($sqlstate)or die (mysql_error());
//$res_state = $dbObj->cgs("mast_state","*","active","1","state_name","ASC","");
$num_state = @mysql_num_rows($sqlstrow);
$row_state = array();
while($row_sta = @mysql_fetch_assoc($sqlstrow))
{
	$row_state[] = $row_sta;
}
$smarty->assign("state",$row_state);
#-----------------Get State END--------------------#

#-----------------Get city--------------------#
//$_re1 = $dbObj->cgs("mast_city","",array("status"),array("Active"),"city_name","ASC","");
$sqlcity="SELECT * FROM mast_city mc , mast_country mcou WHERE mc.country_id = mcou.countryid and mcou.status = 'Active'";
$cityrow=mysql_query($sqlcity)or die (mysql_error());
//$_re1 = $dbObj->cgs("mast_city","*","Status","Active","city_name","ASC","");
$num = @mysql_num_rows($cityrow);
$_arr = array();
while($_row2 = @mysql_fetch_assoc($cityrow))
{
	$_arr2[] = $_row2;
}
$smarty->assign("city",$_arr2);
#-----------------Get city--------------------#

//OR Code value Get Setting
   $qr_rs = $dbObj->gj("sitesetting", "*", "id=51","","", "", "", "");
   $qrcode_rs=@mysql_fetch_array($qr_rs);
   $smarty->assign("qrcode",$qrcode_rs);


#---------get category--------------------#
/*$selectCategory = $dbObj->gj("mast_deal_category as c", "c.*" , "1", "", "", "",  "", "");
while($row=@mysql_fetch_array($selectCategory))
{
    $dealcategory[]=$row;
}
$smarty->assign("dealcategory",$dealcategory);*/
#---------get category--------------------#



#------------Display Message----------------#
if($_SESSION['msg'])
{
	$smarty->assign("msg", $_SESSION['msg']);
	$_SESSION['msg']=NULL;
	unset($_SESSION['msg']);
}
#----------------get Deal type----------------------------#
	$dealsql="select * from tbl_dealtype";
	$dealresult = mysql_query($dealsql) or die('Error, query failed');
	$i = 0;
	$dealprice_option = "";
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

	$smarty->assign("dealresults",$dealresults);
	$smarty->assign("dealprice_option",$dealprice_option);

#----------------get Main category----------------------------#
//$rs=$dbObj->cgs("mast_countryname","*","0","","","","");
/*$sql="select * from mast_deal_category where parent_id=0";
$rs=mysql_query($sql)or die(mysql_error());
	while($row=@mysql_fetch_assoc($rs)){
		$category[]= $row['category'];
	}*/
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
// 	$SITEROOT=SITEROOT."/js";
// 	$smarty->assign("siteroot",$SITEROOT);
#----------------get sub category----------------------------#


#---------------START checking subscription deal allowed-------------------#
$seller_current_subscription_deal_count = 0;
if(is_resource($res_seller_deals))
	$seller_current_subscription_deal_count = mysql_num_rows($res_seller_deals);

$res_seller_subdet = $dbObj->customqry("
select
	* 
from 
	tbl_user_subscription_details as subdet, 
	tbl_users as u 
where 
	u.last_subs_id = subdet.subs_id and 
	u.userid = ".$_SESSION['duAdmId']."
","");

$seller_current_subscription_no_of_deal_allowed = 0;
if(is_resource($res_seller_subdet))
{
	$row_seller_subdet = @mysql_fetch_assoc($res_seller_subdet);
	$seller_current_subscription_no_of_deal_allowed = $row_seller_subdet['subs_pack_allow_deals_per_month'];
}
if($seller_current_subscription_deal_count >= $seller_current_subscription_no_of_deal_allowed)
{
	$smarty->assign("msg","<span class='error'>Please subscribe package for adding deal</span>");
	$smarty->assign("sub","over");
}else
	$smarty->assign("sub","notover");
#-----------------End checking subscription deal allowed-------------------#

#-----------------Get Max Seller Id / Account Number--------------------#
$res_maxSellAccNo = $dbObj->cgs("tbl_users","MAX(userid) as sellerAccNo","","","","","");
$num_maxSellAccNo = @mysql_num_rows($res_maxSellAccNo);
$row_maxSellAccNo = @mysql_fetch_assoc($res_maxSellAccNo);
$smarty->assign("sellerAccNo",(($row_maxSellAccNo['sellerAccNo'] > 0) ? $row_maxSellAccNo['sellerAccNo'] : 1));
#-----------------Get Max Seller Id / Account Number END--------------------#

#-----------------START to fetching delivery charges label--------------------#
$res_delivery_chr = $dbObj->customqry("SELECT * FROM sitesetting WHERE id IN(52,53,54,55,56)","");
while($row_delivery_chr = @mysql_fetch_assoc($res_delivery_chr))
	$data_delivery_chr[] = $row_delivery_chr;

$smarty->assign("data_delivery_chr", $data_delivery_chr);

$res_delivery_service_chr = $dbObj->customqry("SELECT * FROM tbl_delivery_service_charges WHERE set_for = 'user' AND user_id = ".$_SESSION['duAdmId'],"");
while($row_delivery_service_chr = @mysql_fetch_assoc($res_delivery_service_chr))
	$data_delivery_service_chr[] = $row_delivery_service_chr;

$smarty->assign("data_delivery_service_chr", $data_delivery_service_chr);
#-----------------END to fetching delivery charges label--------------------#

$smarty->assign("inmenu","deal_management");
$smarty->display(TEMPLATEDIR . '/admin/seller/deal/add_product.tpl');
$dbObj->Close();
?>
