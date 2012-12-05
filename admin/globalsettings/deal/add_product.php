<?php
include_once('../../../includes/SiteSetting.php');
include_once("../../../includes/common.lib.php");
include_once('../../../includes/class.message.php');

if(!isset($_SESSION['duAdmId']))
{
   header("location:".SITEROOT ."/admin/login/index.php");
   exit;
}

$msobj= new message();
#------------Check For access----------#
if(!(in_array("3", $arr_modules_permit)))
{
      unset($_SESSION['duAdmId']);
      $s=$msobj->showmessage(166);
      $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";

      header("location:".SITEROOT . "/admin/login/index.php");
      exit;
}
#----------End Check For access----------#

$_SESSION['deal_type'] = "service";

include_once '../../../ckeditor/ckeditor.php';
require_once '../../../ckfinder/ckfinder.php';

$ckeditor = new CKEditor('description');
$ckeditor->basePath	= '../../../ckeditor/';
CKFinder::SetupCKEditor($ckeditor, '../../../');


//$config['toolbar'] = array(
//array( 'Source', '-', 'Bold', 'Italic', 'Underline', 'Strike' ),
//array( 'NumberedList','BulletedList','-','Image','Format','FontSize','TextColor','BGColor'));


/*
$initialValue = '';
$editorcontentTitle= $ckeditor->editor("title1", $initialValue, $config);
$smarty->assign("oFCKeditorTitle", $editorcontentTitle);*/

// $initialValue = '';
// $editorcontentSubtitle= $ckeditor->editor("keyfuture", $initialValue, $config);
// $smarty->assign("oFCKeditorkeyfuture", $editorcontentSubtitle);

// $initialValue = '';
// $editorcontentSlogan= $ckeditor->editor("slogan", $initialValue, $config);
// $smarty->assign("oFCKeditorSlogan", $editorcontentSlogan);

$initialValue = '';
$editorcontent= $ckeditor->editor("description", $initialValue, $config);
//print_r($editorcontent);
$smarty->assign("oFCKeditor", $editorcontent);

$initialValue = '';
$editorcontent1= $ckeditor->editor("terms", $initialValue, $config);
$smarty->assign("oFCKeditor1", $editorcontent1);

$initialValue = '';
$editorcontent2= $ckeditor->editor("fineprint", $initialValue, $config);
$smarty->assign("oFCKeditor2", $editorcontent2);

$initialValue = '';
$editorcontentRefundPolicy= $ckeditor->editor("refund_policy", $initialValue, $config);
$smarty->assign("oFCKeditorRefundPolicy", $editorcontentRefundPolicy);

$initialValue = '';
$editorcontentHowItWork= $ckeditor->editor("howitwork", $initialValue, $config);
$smarty->assign("oFCKeditorHowItWork", $editorcontentHowItWork);


$initialValue = '';
$editorcontentSubtitle= $ckeditor->editor("whybuy", $initialValue, $config);
$smarty->assign("oFCKeditorwhybuy", $editorcontentSubtitle);


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
    
    ////////////////////////Qr Code image Code Here start/////////////////
    
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


	$groupBuyPrice = $_POST['price'];
	$savePer = trim($_POST['quantity']);

	$field_array = array(
		"seller_id"=>1,
		"admin_userid"=>$_SESSION['duAdmId'],
		"deal_city"=>"", //$_POST['dealcity'],
		"title"=>$_POST['title1'],
		"slogan"=>$_POST['slogan'],
		"url_title"=>$title2,	
		"description"=>$_POST['description'],
		"termsandconditions"=>$_POST['terms'],
		"fineprint"=>$_POST['fineprint'],
		"payment_method"=>$_POST['payment_method'],
		"groupbuy_price"=>$_POST['price'],
		"whybuy"=>$_POST['whybuy'],

		"orignal_price"=>$_POST['originalprice'],
		"quantity"=>$savePer,
		"min_buyer"=>$_POST['min_buyer'],
		"max_buyer"=>$_POST['max_buyer'],
		"start_date"=>$_POST['dob1']." ".$_POST['start_hour'].":".$_POST['start_min'].":00",
		"end_date"=>$_POST['dob2']." ".$_POST['end_hour'].":".$_POST['end_min'].":00",
		"final_value"=>$_POST['final_value'],
		"listing_value"=>$_POST['listing'],

		"small_image"=>$small_picture,
		"medium_image"=>$medium_picture,
		"big_image"=>$big_picture,
		"admin_approve"=>"no",
		"admin_review"=>1,
		"company_type"=>$_POST['sellertype'],
		"seller_support_email"=>$_POST['seller_support_email'],
		"trackURL"=>$_POST['trackURL'],
		"delivered_tracking_url_code"=>$_POST['delivered_tracking_url_code'],
		"refund_policy"=>$_POST['refund_policy'],
		"otherproductURL"=>$_POST['otherproductURL'],
		
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
		"redeemfrom"=>$_POST['redeemfrom'],
		"redeemto"=>$_POST['redeemto'],
		"senddealto"=>$_POST['only_fans'].",".$_POST['all_who_choose_category'],
		"deal_currency"=>$_POST['deal_currency'],
		"seller_account_no"=>$_POST['seller_account_no'],
		"deal_from_seller_name"=>$_POST['deal_from_seller_name'],
		
		"seller_zipcode"=>$_POST['zipcode'],
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

$loc_country=$_POST['dealcountry'];
$loc_state=$_POST['dealstate'];
$loc_city=$_POST['dealcity'];
$loc_discount=$_POST['deal_discount'];
$country_array=array("country" => $loc_country, "state" => $loc_state, "city" => $loc_city , "discount"=>$loc_discount);
// print_r($country_array);
// echo "<br><br>";
// print_r($loc_country);
$count=count($loc_country);

for($cc=0;$cc<$count;$cc++)
{
$deal_discount_array = array("deal_id" => $insertedId,
			     "country_id"  => $loc_country[$cc],
			     "state_id"    => $loc_state[$cc],
			     "city_id"       => $loc_city[$cc],
			     "discount"    => $loc_discount[$cc]
			    );
	$dbObj->cgii("tbl_deal_discount",$deal_discount_array,"");
}

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


///////////END Inserting Records in tbl_delivery_service_charges/////////////


	$s=$msobj->showmessage(149);
	$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";

	//header("Location:".SITEROOT."/admin/globalsettings/deal/manage_deal.php");
	//exit;
	header("Location:".SITEROOT."/admin/globalsettings/deal/pending-deal.php");
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

while($row_con = @mysql_fetch_assoc($res_country))
{
	$row_country[] = $row_con;
}
// echo "<pre>";
// print_r($row_country);
// exit;

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

#---------get category--------------------#
/*$selectCategory = $dbObj->gj("mast_deal_category as c", "c.*" , "1", "", "", "",  "", "");
while($row=@mysql_fetch_array($selectCategory))
{
    $dealcategory[]=$row;
}
$smarty->assign("dealcategory",$dealcategory);*/
#---------get category--------------------#


#-----------------Get Max Seller Id / Account Number--------------------#
$res_maxSellAccNo = $dbObj->cgs("tbl_users","MAX(userid) as sellerAccNo","","","","","");
$num_maxSellAccNo = @mysql_num_rows($res_maxSellAccNo);
$row_maxSellAccNo = @mysql_fetch_assoc($res_maxSellAccNo);
$smarty->assign("sellerAccNo",(($row_maxSellAccNo['sellerAccNo'] > 0) ? $row_maxSellAccNo['sellerAccNo'] : 1));
#-----------------Get Max Seller Id / Account Number END--------------------#
//OR Code value Get Setting
   $qr_rs = $dbObj->gj("sitesetting", "*", "id=51","","", "", "", "");
   $qrcode_rs=@mysql_fetch_array($qr_rs);
   $smarty->assign("qrcode",$qrcode_rs);

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

#----------------START setting deal existing images count------------------#
$_SESSION['imgCount'] = 0;
#----------------END setting deal existing images count--------------------#

#-----------------START to fetching delivery charges label------------------#
$res_delivery_chr = $dbObj->customqry("SELECT * FROM sitesetting WHERE id IN(52,53,54,55,56)","");
while($row_delivery_chr = @mysql_fetch_assoc($res_delivery_chr))
	$data_delivery_chr[] = $row_delivery_chr;

$smarty->assign("data_delivery_chr", $data_delivery_chr);

$res_delivery_service_chr = $dbObj->customqry("SELECT * FROM tbl_delivery_service_charges WHERE set_for = 'user' AND user_id = ".$_SESSION['duAdmId'],"");
while($row_delivery_service_chr = @mysql_fetch_assoc($res_delivery_service_chr))
	$data_delivery_service_chr[] = $row_delivery_service_chr;

$smarty->assign("data_delivery_service_chr", $data_delivery_service_chr);
#-----------------END to fetching delivery charges label--------------------#

$smarty->display(TEMPLATEDIR . '/admin/globalsettings/deal/add_product.tpl');
$dbObj->Close();
?>