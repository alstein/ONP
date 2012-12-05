<?php
include_once('../../../includes/SiteSetting.php');
include_once("../../../includes/paging.php");
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

#slider
if($_GET['slider'])
{

	//@mysql_query("update tbl_slider set slider=".$_GET['slider']." where id='1'");
   $dbres = $dbObj->cupdt('tbl_slider', "slider" , $_GET['slider'] ,'id',"1","");
header("location:".SITEROOT."/admin/seller/deal/featured_deal.php");
 exit;


}
   $res_slid = $dbObj->cgs("tbl_slider","slider","id","1","","","");
   $row_slid = @mysql_fetch_assoc($res_slid );
   $smarty->assign("slid",$row_slid['slider']);


extract($_POST);
extract($_GET);

if($_POST['submit']=='update')
{
	$cd = "featured ='1'";
	$dbres = $dbObj->gj('tbl_deal', "*" , $cd, "", "","", "", "");	
	
	while($row_results = @mysql_fetch_assoc($dbres))
	{
		@mysql_query("update tbl_deal set sizeorder=".$_POST[$row_results['deal_unique_id']]." where deal_unique_id=".$row_results['deal_unique_id'] );
		//$dbres = $dbObj->cupdt('tbl_product_property', "sizeorder" , $_POST[$row_results['property_id']] ,'property_id',$row_results['property_id'],"0");
	}
	

        $_SESSION['msg']="<span class='success'>Featured deals order has been updated successfully</span>";

	$url_param = "";
	$get_dlType = (($_GET['dltype']) ? $_GET['dltype'] : "");
   	if($get_dlType) { $url_param = "?dltype=".$get_dlType; }
	header("Location:".SITEROOT."/admin/seller/deal/featured_deal.php".$url_param);
	exit;
}


#-----------------Get Deal Types--------------------#
$_reDlType = $dbObj->cgs("tbl_dealtype","","","","dealtype","ASC","");
$num = @mysql_num_rows($_reDlType);
$dltype_arr = array();
$i = 0;
$defDlTypeId = "0";
while($_row = @mysql_fetch_assoc($_reDlType))
{
	if($i == 0)
	{
		$defDlTypeId = $_row['typeid'];
	}
	$dltype_arr[] = $_row;
	$i++;
}
$smarty->assign("dltypes",$dltype_arr);
#-----------------Get Deal Types--------------------#


#--------Action-----------#


#---------END-------------#

  #--------Pagination1-------------------------#
   $getpage=$_GET['page'];
   if(!isset($getpage))
      $page =1;
      else
      $page = $getpage;
      $adsperpage =20;
      $StartRow = $adsperpage * ($page-1);         
      $l =  $StartRow.','.$adsperpage;
   #----------------------------------------#
   
   #-------- Show Testimonails -------------------#

   $date = date("Y-m-d H:i:s");	

   //$tbl = "tbl_deal as p left Join tbl_users u on u.userid = p.seller_id";
   $tbl = "tbl_deal as p , tbl_users as tu, tbl_dealtype dt";
   $sf = "p.*";
   $cnd = "p.admin_approve = 'yes' and admin_review = '1' and deal_status = '1' and (start_date <= '$date' and end_date >= '$date') and featured ='1' and admin_userid = ".$_SESSION['duAdmId']." ";

   $get_dlType = (($_GET['dltype']) ? $_GET['dltype'] : "");
   if($get_dlType)
   {
	if($get_dlType != 'all')
		$cnd .= "and p.deal_main_type ='".$get_dlType."'";
   }else
   {
	if($defDlTypeId > 0)
	{
		$cnd .= "and p.deal_main_type ='".$defDlTypeId."'";
	}
   }

if(isset($_GET['search']))
{
	$cnd .= " AND (p.title LIKE '%".$_GET['search']."%' OR tu.first_name LIKE '%".$_GET['search']."%' OR tu.last_name LIKE '%".$_GET['search']."%' OR tu.fullname LIKE '%".$_GET['search']."%' OR dt.dealtype LIKE '%".$_GET['search']."%' OR p.groupbuy_price LIKE '%".$_GET['search']."%' OR p.orignal_price LIKE '%".$_GET['search']."%' OR p.deal_from_seller_name_other LIKE '%".$_GET['search']."%')";
}

   	$res = $dbObj->customqry("SELECT ".$sf." FROM tbl_deal as p LEFT JOIN tbl_users as tu ON p.deal_from_seller_name=tu.userid LEFT JOIN tbl_dealtype dt ON dt.typeid=p.deal_main_type WHERE ".$cnd." ORDER BY deal_unique_id DESC LIMIT ".$l, "");

// 	$res = $dbObj->gj($tbl,$sf,$cnd,"deal_unique_id","","DESC","", "");
	$i=0;
	while($row = @mysql_fetch_assoc($res))
	{
		$feed[] = $row;
		//$feed[$i]['end_date']=date("F j, Y, g:i a",strtotime($row['end_date']));
		// $feed[$i]['start_date']=date("F j, Y, g:i a",strtotime($row['start_date']));
	
		$feed[$i]['end_date']=date(DATE_FORMAT." H:i:s",strtotime($row['end_date']));
		$feed[$i]['start_date']=date(DATE_FORMAT." H:i:s",strtotime($row['start_date']));
	
		if($row['deal_currency'] == 'euro')
			$curr_type = '&#8364;';
		else
			$curr_type = (($row['deal_currency'] == 'pound') ? '&#163; ' : '$ ');
	
		$feed[$i]['deal_currency_type'] = $curr_type;

         $sql_s = "Select u.first_name as s_firstname, u.last_name as s_lastname from tbl_users u where userid =".$feed[$i]['seller_id'];
         $res_s = $dbObj->customqry($sql_s,0);
         $row_s = @mysql_fetch_assoc($res_s);
         $feed[$i]['s_firstname'] = $row_s['s_firstname'];
         $feed[$i]['s_lastname'] = $row_s['s_lastname'];
	
		  /*//get seller user first_name and last_name as per selected seller id*/
	if(($row['deal_from_seller_name'] != "") && ($row['deal_from_seller_name'] != "other_seller") && ($row['deal_from_seller_name'] > 0))
	{
		$sellerData = getDataFromTable('tbl_users',"userid, fullname, first_name, last_name","userid = '".$row['deal_from_seller_name']."'");
		$seller_name = $sellerData['first_name']." ".$sellerData['last_name'];
	}else
	{
		$seller_name = $row['deal_from_seller_name_other'];
	}
        $feed[$i]['deal_from_seller_name']=$seller_name;
	
	//get city name through city id
         /*$sql_city = "Select c.* from mast_city c where city_id =".$row['deal_city'];
         $res_city = $dbObj->customqry($sql_city,0);
         $row_city = @mysql_fetch_assoc($res_city);
         $feed[$i]['city_name'] = $row_city['city_name'];*/
	
	 ///////////////////////////////////////////
         //START Get multiple cities as per product id
	 $feed[$i]['city_name'] = $dbObj->getDealMultiCities($row['deal_unique_id']);
         //END Get multiple cities as per product id

	//get deal main type name through deal_main_type
         $sql_dlMainType = "Select dt.* from tbl_dealtype dt where typeid =".$row['deal_main_type'];
         $res_dlMainType = $dbObj->customqry($sql_dlMainType,0);
         $row_dlMainType = @mysql_fetch_assoc($res_dlMainType);
         $feed[$i]['deal_main_type'] = $row_dlMainType['dealtype'];
     
      $i++;
   }
//    echo "<pre>";
//    echo "<pre>";print_R($feed);exit;

   $smarty->assign("deal",$feed);
   #-------------End------------------------#
   
   #------------Pagination2-----------------#   
//    $res = $dbObj->gj($tbl,$sf,$cnd,"","","","", "");
   $res = $dbObj->customqry("SELECT ".$sf." FROM tbl_deal as p LEFT JOIN tbl_users as tu ON p.deal_from_seller_name=tu.userid LEFT JOIN tbl_dealtype dt ON dt.typeid=p.deal_main_type WHERE ".$cnd." ORDER BY deal_unique_id DESC", "");
   $nums = @mysql_num_rows($res);
   $show = 10;    
   $total_pages = ceil($nums / $adsperpage);
   if($total_pages > 1)
      $smarty->assign("showpaging", "yes");
      
   $showing = !($getpage)? 1 : $getpage;
   if($search)
      $firstlink = "manage_deal.php?deal_from_seller_name=ssdf&uname={$_GET['uname']}&dltype=".$_GET['dltype'];
   else
      $firstlink = "manage_deal.php?deal_from_seller_name=".$_GET['deal_from_seller_name']."&dltype=".$_GET['dltype'];
   $seperator = '&page=';
   $baselink = $firstlink;
   $pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);
   
   $smarty->assign("pgnation",$pgnation);
   
   #----------------------------------------#
   #----------Success message=--------------#
   if($_SESSION['msg'])
   {
   $smarty->assign("msg", $_SESSION['msg']);
   $_SESSION['msg'] = NULL;
   unset($_SESSION['msg']);
   }
   #--------------End-----------------------#


$smarty->assign("inmenu","deal_management");
$smarty->display(TEMPLATEDIR . '/admin/seller/deal/feture-deal.tpl');

$dbObj->Close();
?>