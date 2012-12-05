<?php
date_default_timezone_set('Europe/London');
include_once('../../../../includes/SiteSetting.php');
include_once("../../../../includes/paging.php");
include_once('../../../../includes/class.message.php');
include_once('../../../../includes/function.php');

if(!$_SESSION['duAdmId'])
{
    header("location:".SITEROOT . "/admin/login/index.php");
    exit;
}

#------------Check For access----------#
if(!(in_array("84", $arr_modules_permit)))
{
      unset($_SESSION['duAdmId']);
      $s=$msobj->showmessage(166);
      $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";

      header("location:".SITEROOT . "/admin/login/index.php");
      exit;
}
#----------End Check For access----------#


 if($_POST['action'])
   {
      extract($_POST);
      $deal_ids = @implode(", ", $deal_id);
      if($deal_ids)
      {
         if($_POST['action'] == "delete")
         {
		  $temp = $dbObj->customqry("delete from tbl_deal_affiliate where deal_unique_id IN (".$deal_ids.")","");
                  $_SESSION['msg']="<span class='success'>Aggregate deal deleted successfully</span>";
         }
	elseif($_POST['action'] == "active")
         {
               $temp = $dbObj->customqry("update tbl_deal_affiliate set status = 'Active' where deal_unique_id IN (".$deal_ids.")","");
               $_SESSION['msg']="<span class='success'>Aggregate deal activated successfullly </span>";
         }
	elseif($_POST['action'] == "inactivate")
         {
               $temp = $dbObj->customqry("update tbl_deal_affiliate set status = 'Inactive' where deal_unique_id IN (".$deal_ids.")","");
               $_SESSION['msg']="<span class='success'>Aggregate deal inactivated successfullly </span>";
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

if($_GET['act'] == "setFeatured" && $_GET['id'])
{
	$temp = $dbObj->customqry("update tbl_deal_affiliate set featured = '1' where deal_unique_id=".$_GET['id'],"");
	$_SESSION['msg']="<span class='success'>Aggregate deal set featured successfully</span>";

	header("location:".SITEROOT."/admin/modules/affiliate-marchant/deal/manage_deal.php");
	exit;
}

if($_GET['act'] == "setUnFeatured" && $_GET['id'])
{
	$temp = $dbObj->customqry("update tbl_deal_affiliate set featured = '0' where deal_unique_id=".$_GET['id'],"");
	$_SESSION['msg']="<span class='success'>Aggregate deal set unfeatured successfully</span>";

	header("location:".SITEROOT."/admin/modules/affiliate-marchant/deal/manage_deal.php");
	exit;
}

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
		$out ="Aggregate Deal Report";		
		$out .="\n";
		$out .="\n";
		$out .='Deal Name,Deal Id,Merchant Name,Start Date,End Date,Deal Type,fPrice,fRrpPrice,Currency Type,Total Click';
		$out .="\n";
		$out .="\n";
		$l="";
	}


   $date = date("Y-m-d H:i:s");

   $tbl = "tbl_deal_affiliate as p";
   $sf = "p.*";
   $cnd = "p.dValidFrom <= '$date' and p.dValidTo >= '$date'";

	if($_GET['exel_id'] != "")
	{
		$cnd.= " and p.deal_unique_id='".$_GET['exel_id']."'";
	}

	if($_GET['iMerchantId'])
	{
		$getiMerchantId = (($_GET['iMerchantId']) ? $_GET['iMerchantId'] : 0);
		if($getiMerchantId)
		{
			if($getiMerchantId != 'all')
			{
				if(intval($getiMerchantId))
				{
					$cnd .= " and p.iMerchantId ='".$getiMerchantId."'";
				}else
				{
					$cnd .= " and p.iMerchantId ='".$getiMerchantId."'";
				}
			}
		}
	}
	
	$res = $dbObj->gj($tbl,$sf,$cnd,"deal_unique_id","","DESC",$l, "");
	
	$i=0;
	while($row = @mysql_fetch_assoc($res))
	{
		$feed[] = $row;
		$dValidTo=(($row['dValidTo'] != "0000-00-00 00:00:00")?date(DATE_FORMAT." H:i:s",strtotime($row['dValidTo'])):"------");
		$feed[$i]['end_date']=$dValidTo;

		$dValidFrom=(($row['dValidFrom'] != "0000-00-00 00:00:00")?date(DATE_FORMAT." H:i:s",strtotime($row['dValidFrom'])):"------");
		$feed[$i]['start_date']=$dValidFrom;

		if($row['sCurrency'] == 'euro')
			$curr_type = '&#8364;';
		else
			$curr_type = (($row['sCurrency'] == 'GBP') ? '&#163; ' : '$ ');

		$feed[$i]['deal_currency_type'] = $curr_type;

		//get affiliate merchant name
		$seller_name = "------";
		if($row['iMerchantId'] > 0)
		{
			$sellerData = getDataFromTable('tbl_deal_affiliate_marchant',"*","marchant_id = '".$row['iMerchantId']."'");
			$seller_name = $sellerData['marchant_name'];
		}
		$feed[$i]['deal_from_seller_name']=$seller_name;
		
		$feed[$i]['deal_main_type_id'] = $row['deal_main_type'];
	
		//get deal main type name through deal_main_type
		$sql_dlMainType = "Select dt.* from tbl_dealtype dt where typeid =".$row['deal_main_type'];
		$res_dlMainType = $dbObj->customqry($sql_dlMainType,0);
		$row_dlMainType = @mysql_fetch_assoc($res_dlMainType);
		$feed[$i]['deal_main_type'] = $row_dlMainType['dealtype'];
	
		//total click count
		$totalClicks = 0;
		
		//$title =strip_tags(html_entity_decode($row['sName']));
		$title = str_replace("&pound;","£",strip_tags(html_entity_decode($row['sName'])));
		
		if($_GET['view'] == 'excel')
		{
			#---code for csv report-----#
			$out .= '"'.$title.'","'.$row['iId'].'","'.$seller_name.'","'.$dValidFrom.'","'.$dValidTo.'","'.$row_dlMainType['dealtype'].'","'.$row['fPrice'].'","'.$row['fRrpPrice'].'","'.$row['sCurrency'].'","'.$totalClicks.'"';
			$out .= "\n";
			#----code end---#	
		}
      	$i++;
   } 

//    echo "<pre>";print_r($feed);exit;


   $smarty->assign("deal",$feed);
   #-------------End------------------------#
   
   #------------Pagination2-----------------#   
   $res = $dbObj->gj($tbl,$sf,$cnd,"","","","", "");
   $nums = @mysql_num_rows($res);
   $show = 10;    
   $total_pages = ceil($nums / $adsperpage);
   if($total_pages > 1)
      $smarty->assign("showpaging", "yes");
      
   $showing = !($getpage)? 1 : $getpage;
   if($_GET['iMerchantId'] > 0)
   {
      $firstlink = "manage_deal.php?iMerchantId=".$_GET['iMerchantId'];
      $seperator = '&page=';
   }else
   {
      $firstlink = "manage_deal.php";
      $seperator = '?page=';
   }
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


$sql="SELECT  * FROM tbl_deal_affiliate_marchant WHERE 1";
$_reMerch=mysql_query($sql)or die(mysql_error());
$num = @mysql_num_rows($_reMerch);
$merch_arr = array();
$i = 0;
while($_row = @mysql_fetch_assoc($_reMerch))
{
	$merch_arr[] = $_row;
}
$smarty->assign("deal_from_seller_names",$merch_arr);

$smarty->display(TEMPLATEDIR.'/admin/modules/affiliate-marchant/deal/manage_deal.tpl'); 
?>
