<?php
date_default_timezone_set('Europe/London');
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

#-----------Delete Articles--------------#
	if($_GET['id'] !='')
	{
	 $sel1= $dbObj->customqry("SELECT * FROM tbl_deal WHERE deal_unique_id IN (".$_GET['id'].")","");
	
           $id1=array();
            if($sel !='n')
		{

			if($_GET['agree']=='yes')
				{
				$temp1 = $dbObj->customqry("update tbl_deal set featured = '0' where deal_unique_id IN (".$_GET['id'].")","");//exit;
               			$_SESSION['msg']="<span class='success'>Deal has been unset featured deal </span>";
 				header("Location:".SITEROOT."/admin/seller/deal/manage_deal.php");
 				exit;	
				}	
			while($rest1=@mysql_fetch_assoc($sel1))
			{
				//Start
				//new work
				//I should not be able to set two deals as featured for the same category i.e. "Daily Deals"
				if($_GET['typid'] != '')
				{
					$setOthUnFeat = $dbObj->customqry("update tbl_deal set featured = '0' where deal_main_type='".$_GET['typid']."'","");
				}
				//End

				$sel2= $dbObj->customqry("SELECT * FROM tbl_deal WHERE featured ='1'","");
				$munrs2=@mysql_num_rows($sel2);
				$smarty->assign("number",$munrs2);
					
				if($rest1['featured']==0)
				{	
				$temp1 = $dbObj->customqry("update tbl_deal set featured = '1' where deal_unique_id IN (".$_GET['id'].")","");
               			$_SESSION['msg']="<span class='success'>Deal has been set featured deal </span>";
				header("Location:".SITEROOT."/admin/seller/deal/manage_deal.php");
				exit;
				}
				else
				{
				$temp1 = $dbObj->customqry("update tbl_deal set featured = '0' where deal_unique_id IN (".$_GET['id'].")","");//exit;
               			$_SESSION['msg']="<span class='success'>Deal has been unset featured deal </span>";
				header("Location:".SITEROOT."/admin/seller/deal/manage_deal.php");
				exit;
				}
			
					
// 			$sel2= $dbObj->customqry("SELECT * FROM tbl_deal WHERE featured ='1'","");
//                         $munrs2=mysql_num_rows($sel2);
// 			if($munrs2<4)
// 			{			
//  				$temp1 = $dbObj->customqry("update tbl_deal set featured = '1' where deal_unique_id IN (".$_GET['id'].")","");
//  				header("Location:".SITEROOT."/admin/seller/deal/manage_deal.php");
//  				exit;
//  			}
// 				
// 			else
// 			{	
// // 				$temp1 = $dbObj->customqry("update tbl_deal set featured = '0' where deal_unique_id IN (".$_GET['id'].")","");//exit;
// 				$_SESSION['msg']="<span class='success'>Please you are not set this feture deal more than limit.If you want set feture deal so please other deal unset.</span>";
//  				header("Location:".SITEROOT."/admin/seller/deal/manage_deal.php");
//  				exit;
// 				
// 			}
//  			
// 			
			
				
			}


	}
}
/*		}
// 		else
// 		{
// 		$_SESSION['msg']="<span class='success'>Deal has been Published </span>";
// 		}
	}*/	


   if($_POST['action'])
   {
      extract($_POST);
      $deal_ids = @implode(", ", $deal_id);
      if($deal_ids)
      {
         if($_POST['action'] == "delete")
         {
		$sel= $dbObj->customqry("SELECT * FROM tbl_deal WHERE deal_unique_id IN (".$deal_ids.")","");
		$munrs=mysql_num_rows($sel);
		if($munrs>0)
		{
			while($rest=mysql_fetch_assoc($sel))
			{
				$imgcrop1="../../../uploads/product/thumb76X64/".$rest['samll_image'];
				if($rest['samll_image']!="")
				@unlink($imgcrop1);
		
				$imgcrop2="../../../uploads/product/thumb588X288/".$rest['big_image'];
				if($rest['big_image']!="")
				@unlink($imgcrop2);
		
				$imgcrop3="../../../uploads/product/thumb332X290/".$rest['medium_image'];
				if($rest['medium_image']!="")
				@unlink($imgcrop3);
			}
		}
		
		//delete all deal cities from reference table
		$delDlCities = $dbObj->customqry("delete from tbl_deal_city where deal_id IN (".$deal_ids.")","");

		  $temp = $dbObj->customqry("delete from tbl_deal where deal_unique_id IN (".$deal_ids.")","");
                  $_SESSION['msg']="<span class='success'>Deal deleted successfully</span>";

         }
       /*  elseif($_POST['action'] == "active")
         {
               $temp = $dbObj->customqry("update tbl_deal set admin_approve = 'yes' where deal_unique_id IN (".$deal_ids.")","");
               $_SESSION['msg']="<span class='success'>Deal has been Published </span>";
         }
         else
	if($_POST['action'] == "delete")
         {
               $temp = $dbObj->customqry("delete from  tbl_deal where deal_unique_id IN (".$deal_ids.")","");
               $_SESSION['msg']="<span class='success'>Deal has been deleted successfully. </span>";
         }*/
	else if($_POST['action'] == "unrecommended")
         {
               $temp = $dbObj->customqry("update tbl_deal set recommend = '0' where deal_unique_id IN (".$deal_ids.")","");
               $_SESSION['msg']="<span class='success'>Deal has been Unrecommended deal </span>";
         }
         elseif($_POST['action'] == "recommended")
         {
               $temp = $dbObj->customqry("update tbl_deal set recommend = '1' where deal_unique_id IN (".$deal_ids.")","");
               $_SESSION['msg']="<span class='success'>Deal has been recommended deal </span>";
         }
	elseif($_POST['action'] == "active")
         {
               $temp = $dbObj->customqry("update tbl_deal set status = 'Active' where deal_unique_id IN (".$deal_ids.")","");
               $_SESSION['msg']="<span class='success'>Deal activated successfullly </span>";
         }
	elseif($_POST['action'] == "inactivate")
         {
               $temp = $dbObj->customqry("update tbl_deal set status = 'Inactive' where deal_unique_id IN (".$deal_ids.")","");
               $_SESSION['msg']="<span class='success'>Deal inactivated successfullly </span>";
         }
      }
      else
      {
         $_SESSION["msg"] = "<span class='success'>Please select atleast one record.</span>";
      }
      header("location:".$_SERVER['HTTP_REFERER']);
      exit;
   }
   #--------------End-----------------------#



if($_POST['city']!="")
{
   $res_u = $dbObj->cgs("tbl_users","",array("city","usertypeid"),array($city,3),"first_name","","");
   $array1 = array();
   while($row_u = @mysql_fetch_assoc($res_u))
   {
      $array1[] = $row_u;
   }
   $smarty->assign("merchant",$array1);
}else
{
        $res_u = $dbObj->cgs("tbl_users","",array("usertypeid"),array("3"),"first_name asc","","");
   $array1 = array();
   while($row_u = @mysql_fetch_assoc($res_u))
   {
      $array1[] = $row_u;
   }
   $smarty->assign("merchant",$array1);

}
   //Merchant


   //city for user
   $res_c = $dbObj->cgs("tbl_users","city",array("userid"),array($_GET['userid']),"userid asc","","");
   $row_c = @mysql_fetch_assoc($res_c);
   $smarty->assign("merchantcity",$row_c['city']);

//country
   $res1 = $dbObj->cgs("mast_country","",array("status"),array("active"),"country asc","","");
   $array = array();
   while($row1 = @mysql_fetch_assoc($res1))
   {
      $array[] = $row1;
   }
   $smarty->assign("country",$array);
   extract($_POST);

//    if($_POST['country'])
//    {
//       $res2 = $dbObj->cgs("mast_city","city_name,city_id",'','',"","","");
//       while($row2 = @mysql_fetch_assoc($res2))  
//       {
//          $arr_city[] = $row2;
//       }
//       $smarty->assign("city_arr",$arr_city);
//    }

   #------------ Display All Citites ---------------#
//gj($tbl, $sf , $cd, $ob, $gb, $ad, $l, $prn)
   $cnd_city = "status='Active'";
   $rs_city = $dbObj->gj("mast_city", "*", $cnd_city, "city_name", "", "ASC", "", "");

   while($row_city = @mysql_fetch_assoc($rs_city))
   {
      $arr_city[]=$row_city;
   }
   //$num = @mysql_num_rows($rs_city);
   //echo $num;
   //print_r($arr_city);
   $smarty->assign("city_arr", $arr_city);
   #------------------------------------------------#
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


#-----------------Get sellar  Types--------------------#

$sql="SELECT  DISTINCT deal_from_seller_name FROM tbl_deal WHERE deal_from_seller_name IS NOT NULL AND deal_from_seller_name != ''";
$_reDlType=mysql_query($sql)or die(mysql_error());
$num = @mysql_num_rows($_reDlType);
$dltype_arr = array();
$i = 0;
$defDlTypeId = "0";
while($_row = @mysql_fetch_assoc($_reDlType))
{
	if($i == 0)
	{
		$defDlTypeId = $_row['seller_id'];
	}
	$dltype_arr[] = $_row;
	$i++;
}
$smarty->assign("deal_from_seller_names",$dltype_arr);
#-----------------Get Deal Types--------------------#

   

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
   
	if($_GET['view'] == 'excel')
	{
	$out ="Deal Report";		
	$out .="\n";
	$out .="\n";
	$out .='Deal Name,Added By,Seller Name,Start Date,End Date,Deal Type,Cities,Price,Orignal Price,% Saved,Sold,Viewed,Currency Type,Deal Unique URL';
	$out .="\n";
	$out .="\n";
	$l="";
	
			
	
	}


$date = date("Y-m-d H:i:s");	

   //$tbl = "tbl_deal as p left Join tbl_users u on u.userid = p.seller_id";
   $tbl = "tbl_deal as p , tbl_users as tu, tbl_dealtype dt";
   $sf = "p.*";
   
   
   if($_POST['submit']) 
   {
                if($_POST['city']  && $_POST['merchant_id'])
      {
         $cnd = "p.admin_approve = 'yes'  AND p.deal_city = '".$_POST['city']."' AND admin_userid = ".$_SESSION['duAdmId']." and p.seller_id = '".$_POST['merchant_id']."'";
      }
      elseif($_POST['city'])
      {
         $cnd = "p.admin_approve = 'yes' and admin_review = '1' and deal_status = '1' AND admin_userid = ".$_SESSION['duAdmId']." and  p.deal_city = '".$_POST['city']."'";
      }
      elseif($_POST['merchant_id'])
      {
         $cnd = "p.admin_approve = 'yes' and admin_review = '1' and deal_status = '1' and admin_userid = ".$_SESSION['duAdmId']." AND p.seller_id = '".$_POST['merchant_id']."'";
      }
      else
      {
         $cnd = "p.admin_approve = 'yes' and admin_review = '1' and deal_status = '1' and admin_userid = ".$_SESSION['duAdmId'];
      }
   }
   elseif($_GET['dealtype']=='seller')
   {
	
	$cnd ="seller_id !=".$_SESSION['duAdmId']." and deal_type ='service' and p.admin_approve = 'yes' and deal_status = '1' and (start_date <= '$date' and end_date >= '$date') and admin_userid = ".$_SESSION['duAdmId'];
    }
   elseif($_GET['dealtype']=='product')
   {
	
	$cnd ="seller_id !=".$_SESSION['duAdmId']." and deal_type ='product' and p.admin_approve = 'yes' and deal_status = '1' and (start_date <= '$date' and end_date >= '$date') and admin_userid = ".$_SESSION['duAdmId'];
    }
	elseif($_GET['dealtype']=='admin')
   {
	
	$cnd ="seller_id =".$_SESSION['duAdmId']." and p.admin_approve = 'yes' and deal_status = '1' and (start_date <= '$date' and end_date >= '$date') and admin_userid = ".$_SESSION['duAdmId'];
    }
	else
   {
      $cnd = "p.admin_approve = 'yes' and admin_review = '1' and deal_status = '1' and (start_date <= '$date' and end_date >= '$date') and admin_userid = ".$_SESSION['duAdmId']." ";
      //$cnd="1";
   }

if($_GET['exel_id'] != "")
{
    $cnd.= " and p.deal_unique_id='".$_GET['exel_id']."'";
}
		
if($_GET['dltype'])
{
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
}
if($_GET['deal_from_seller_name']){

   $getdeal_from_seller_name = (($_GET['deal_from_seller_name']) ? $_GET['deal_from_seller_name'] : "");
   if($getdeal_from_seller_name)
   {
	if($getdeal_from_seller_name != 'all')
		$cnd .= "and p.deal_from_seller_name ='".$getdeal_from_seller_name."'";
   }else
   {
	if($defDlTypeId > 0)
	{
		$cnd .= "and p.deal_from_seller_name ='".$defDlTypeId."'";
	}
   }

}
if(isset($_GET['search']))
{
	$cnd .= " AND (p.title LIKE '%".$_GET['search']."%' OR tu.first_name LIKE '%".$_GET['search']."%' OR tu.last_name LIKE '%".$_GET['search']."%' OR tu.fullname LIKE '%".$_GET['search']."%' OR dt.dealtype LIKE '%".$_GET['search']."%' OR p.groupbuy_price LIKE '%".$_GET['search']."%' OR p.orignal_price LIKE '%".$_GET['search']."%' OR p.deal_from_seller_name_other LIKE '%".$_GET['search']."%')";
}
	
// 	$res = $dbObj->gj($tbl,$sf,$cnd,"deal_unique_id","","DESC",$l, "");
   $res = $dbObj->customqry("SELECT ".$sf." FROM tbl_deal as p LEFT JOIN tbl_users as tu ON p.deal_from_seller_name=tu.userid LEFT JOIN tbl_dealtype dt ON dt.typeid=p.deal_main_type WHERE ".$cnd." ORDER BY deal_unique_id DESC LIMIT ".$l, "");

	
	$i=0;
	while($row = @mysql_fetch_assoc($res))
	{
		$feed[] = $row;
		//$feed[$i]['end_date']=date("F j, Y, g:i a",strtotime($row['end_date']));
		//$feed[$i]['start_date']=date("F j, Y, g:i a",strtotime($row['start_date']));
		$feed[$i]['end_date']=date(DATE_FORMAT." H:i:s",strtotime($row['end_date']));
		$feed[$i]['start_date']=date(DATE_FORMAT." H:i:s",strtotime($row['start_date']));
		$feed[$i]['deal_unique_url'] = SITEROOT."/deal/".$row['deal_unique_id'];

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
        $fullname=$row_s['s_firstname']." ".$row_s['s_lastname'];
       		
        if($row['admin_userid'] != 0 )
        {

         $sql_ad = "Select u.first_name as ad_firstname, u.last_name as ad_lastname,username from tbl_users u where userid =".$row['admin_userid'];
         $res_ad = $dbObj->customqry($sql_ad,0);
         $row_ad = @mysql_fetch_assoc($res_ad);
         $feed[$i]['ad_name'] = $row_ad['ad_firstname']." ".$row_ad['ad_lastname'];
          
        }
        
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
	 $excelCities = $dbObj->getDealMultiCitiesForExcel($row['deal_unique_id']);
         //END Get multiple cities as per product id
	
         $feed[$i]['deal_main_type_id'] = $row['deal_main_type'];

	//get deal main type name through deal_main_type
         $sql_dlMainType = "Select dt.* from tbl_dealtype dt where typeid =".$row['deal_main_type'];
         $res_dlMainType = $dbObj->customqry($sql_dlMainType,0);
         $row_dlMainType = @mysql_fetch_assoc($res_dlMainType);
         $feed[$i]['deal_main_type'] = $row_dlMainType['dealtype'];

	//sold count	
        $sql = "select sum(deal_quantity) as qty1 from tbl_deal_payment where deal_id = '".$row['deal_unique_id']."' group by deal_id";
    	$paynum_rs = $dbObj->customqry($sql,"");
   	$paynum = mysql_fetch_assoc($paynum_rs);
	
	if($paynum['qty1'] == "")
	{
		$paynum['qty1']=0;
	}
  $title =strip_tags(html_entity_decode($row['title']));
        if($_GET['view'] == 'excel')
	{
	#---code for csv report-----#
	$out .= '"'.$title.'","'.$fullname.'","'.$seller_name.'","'.date(DATE_FORMAT." H:i:s",strtotime($row['start_date'])).'","'.date(DATE_FORMAT." H:i:s",strtotime($row['end_date'])).'","'.$row_dlMainType['dealtype'].'","'.$excelCities.'","'.$row['groupbuy_price'].'","'.$row['orignal_price'].'","'.$row['quantity'].' %","'.$paynum['qty1'].'","'.$row['view_count'].'","'.ucfirst($row['deal_currency']).'","'.$feed[$i]['deal_unique_url'].'"';
	$out .= "\n";
	#----code end---#	
	}
	

      $i++;
   } 
//    print_r($feed);die();
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
   
    $autho_rs = $dbObj->gj("tbl_deal_autho","deal_id","1","","","","","");
    while($row = @mysql_fetch_assoc($autho_rs))
    {
        $autho[] = $row['deal_id'];
    }
    //echo "<pre>"; print_r($autho); echo "</pre>";
    $smarty->assign("autho",$autho);	


   #----------Success message=--------------#
	
	#----code for csv report-------#
	if($_GET['view'] == 'excel')
	{
	header("Content-type: text/x-csv");
	header("Content-type: application/csv");
	header("Content-Disposition: attachment; filename=Deal-details.csv");	
	echo $out;
	exit;
	}
	#----code end------#

   $smarty->assign("inmenu","deal_management");
   $smarty->display(TEMPLATEDIR.'/admin/seller/deal/manage_deal.tpl'); 
?>