<?php
include_once('../../../../includes/SiteSetting.php');
include_once("../../../../includes/common.lib.php");
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

if($_GET['id'])
{
	$res1 = $dbObj->cgs("tbl_deal_affiliate d","d.*","deal_unique_id",$_GET['id'],"","","");
	
	if($res1 != 'n')
	{
            	$row3 = @mysql_fetch_assoc($res1);
            	$dValidFrom=(($row3['dValidFrom'] != "0000-00-00 00:00:00")?date(DATE_FORMAT." H:i:s",strtotime($row3['dValidFrom'])):"------");
	    	$row3['dValidFrom']=$dValidFrom;

	    	$dValidTo=(($row3['dValidTo'] != "0000-00-00 00:00:00")?date(DATE_FORMAT." H:i:s",strtotime($row3['dValidTo'])):"------");
	    	$row3['dValidTo']=$dValidTo;

	    	$added_date=(($row3['added_date'] != "0000-00-00 00:00:00")?date(DATE_FORMAT." H:i:s",strtotime($row3['added_date'])):"------");
	    	$row3['added_date']=$added_date;


	  	if($row3['sCurrency'] == 'euro')
			$curr_type = '&#8364;';
		else
			$curr_type = (($row3['sCurrency'] == 'GBP') ? '&#163; ' : '$ ');

		$row3['deal_currency_type'] = $curr_type;

		//get affiliate merchant name
		$seller_name = "------";
		if($row3['iMerchantId'] > 0)
		{
			$sellerData = getDataFromTable('tbl_deal_affiliate_marchant',"*","marchant_id = '".$row3['iMerchantId']."'");
			$seller_name = $sellerData['marchant_name'];
		}
		$row3['deal_from_seller_name']=$seller_name;

		//get affiliate category name
		$cat_name = "------";
		if($row3['iCategoryId'] > 0)
		{
			$catData = getDataFromTable('mast_deal_category_affiliate',"*","iId = '".$row3['iCategoryId']."'");
			$cat_name = $catData['sName'];
		}
		$row3['category_name']=$cat_name;

		//get deal main type name through deal_main_type
		$sql_dlMainType = "Select dt.* from tbl_dealtype dt where typeid =".$row3['deal_main_type'];
		$res_dlMainType = $dbObj->customqry($sql_dlMainType,0);
		$row_dlMainType = @mysql_fetch_assoc($res_dlMainType);
		$row3['deal_main_type'] = $row_dlMainType['dealtype'];

		//total click count
		$totalClicks = 0;

            	$smarty->assign("deal_info",$row3);
	}
}

#------------Display Message----------------#
if($_SESSION['msg'])
{
	$smarty->assign("msg", $_SESSION['msg']);
	$_SESSION['msg']=NULL;
	unset($_SESSION['msg']);
}
#--------------------------------------------#

$smarty->display(TEMPLATEDIR.'/admin/modules/affiliate-marchant/deal/view_deal.tpl'); 
$dbObj->Close();
?>
