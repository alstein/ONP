<?php
include_once('../../include.php');
include_once('../../includes/classes/class.frontregister.php');
include_once('../../includes/paging.php');

//Get meta tags of the page as per id
$call_meta=$dbObj->meta_SEO(17);
$smarty->assign("row_meta",$call_meta);

if(!isset($_SESSION['csUserId']))
{
	header("location:".SITEROOT."/"); exit;
}





//------------------------------------------------------------------
if($_SESSION['errormessage']){
	$smarty->assign("errormessage",$_SESSION['errormessage']);
	$_SESSION['errormessage']=NULL;
}

if($_SESSION['message']){
	$smarty->assign("message",$_SESSION['message']);
	$_SESSION['message']=NULL;
}
//------------------------------------------------------------------
function greaterDate($start_date,$end_date)
{
	$start = strtotime($start_date);
	$end = strtotime($end_date);
	if ($start-$end > 0)
		return 1;
	else
		return 0;
}

////////////////////////////////////////////// Get the redempt code/////////////////////////////////////////////////////

if(isset($_POST['submit']))
{
	$giftDealAccepted = 0;
	$re = $dbObj->cgs("tbl_deal_payment","",array("redemption_code","accepted","gift_to_email"),array($_POST['redempt'],"no",$_SESSION['csUserEmail']),"","","");
	// print($re);exit;

	if($re != 'n')
	{
		$row = @mysql_fetch_assoc($re);

		$resRedump = $dbObj->customqry("select * from tbl_deal where deal_unique_id = ".$row['deal_id'],"");
		if($resRedump != 'n')
		{
			$dbObj->cupdt("tbl_deal_payment","accepted","yes","redemption_code",$_POST['redempt'],"");
			$giftDealAccepted = 1;
		}else
		{
			$giftDealAccepted = 0;
		}
	}else{
		$giftDealAccepted = 0;
	}

	if($giftDealAccepted == 1){
		$_SESSION['message'] = "Gift Deal is successfully accepted.";
		$_SESSION['errormessage'] = "";
	}

	if($giftDealAccepted == 0){
		//$_SESSION['message']="";
		$_SESSION['errormessage'] = "<span class='success'>To redeem a gift, please enter the valid Redemption Code</span>";//exit;
	}
	header("location:".SITEROOT."/my-gifts");
}

/*------------Pagination Part-1------------*/

if(!isset($_GET['page']))
	$page =1;
else
	$page = $_GET['page'];
$adsperpage =50;
$StartRow = $adsperpage * ($page-1);
$l= $StartRow.','.$adsperpage;

/*-----------------------------------*/

// get the deals from whose payment is done.

$cnd1 = "";
if($_GET['sort']==2){
	$cnd1 = " and p.validto < '".$currentTime."' ";
	$pay_done = "yes' or payment_done = 'no";
}

if($_GET['sort']=="3"){
	$pay_done = "no";
}else{
	$pay_done = "yes' OR payment_done = 'no";
}

if($_GET['gift']=='sen')
{
	$_query = "select * from tbl_deal as p, tbl_deal_payment as dp where p.deal_unique_id=dp.deal_id and dp.gift_to_email!='' and dp.user_id='".$_SESSION['csUserId']."' ".$cnd1." ORDER BY dp.order_date DESC";
}else{
	$_query = "select * from tbl_deal as p, tbl_deal_payment as dp where dp.accepted='yes' and p.deal_unique_id=dp.deal_id and dp.gift_to_email!='' and dp.gift_to_email='".$_SESSION['csUserEmail']."' ".$cnd1." ORDER BY dp.order_date DESC";
}

//echo $_query;exit;
$res = mysql_query($_query);
$nu = @mysql_num_rows($res);
$i=0;
$array = array();
$dealInfoCount = 0;
$count = 0;
while($row = @mysql_fetch_object($res))
{
	$arr = $row;

	if(strtotime($arr->end_date) < time()){
		$array[$i]['dealislive'] = 0;
	}else{
		$array[$i]['dealislive'] = 1;
	}

	//$array[$i]['deal'] = $arr->business_name;
	$array[$i]['description'] = $arr->description;
	$array[$i]['product_image'] = $arr->medium_image;
	$array[$i]['product_name'] = $arr->title;
	//$array[$i]['discount_price'] = round(($arr->product_act_price)*($arr->product_disc_price)/100);
	$array[$i]['prodcut_price'] = round(($arr->groupbuy_price));
	$array[$i]['deal_image'] = $arr->medium_image;
	$array[$i]['product_id'] = $arr->deal_unique_id;
	//$array[$i]['print_on'] = $arr->print_on;
	//$array[$i]['product_url'] = $arr->product_url;
	$array[$i]['end_date'] = $arr->end_date;
	$array[$i]['expire_date'] = $arr->validto;
	$array[$i]['accepted'] = $arr->accepted;
	$array[$i]['giftemailid'] = $arr->gift_to_email;
	$array[$i]['giftRecipientsFullName'] = $arr->gift_to_name;
	$array[$i]['product_city'] = str_replace(" ","-",strtolower($arr->deal_city));
	//$array[$i]['redeem_method'] = $arr->redeem_method;
	//$array[$i]['redeem_method_title'] = $arr->redeem_method_title;
	//$array[$i]['redeem_method_details'] = $arr->redeem_method_details;
	$array[$i]['product_slogan'] = $arr->slogan;
	$array[$i]['payment_done'] = $arr->payment_done;

	$dealCatRes = $dbObj->cgs("mast_deal_category","",array("id","active"),array($arr->deal_cat,1),"","","");
	$dealCatRow = @mysql_fetch_assoc($dealCatRes);
	$array[$i]['deal_category'] = $dealCatRow['category'];
		
	//$bsql = $dbObj->cgs("tbl_business","",array("bid"),array($arr->business_name),"","","");//exit;
	//$busrow =  @mysql_fetch_assoc($bsql);
	//$array[$i]['deal'] = $busrow['bname'];

 
	//$re22 = $dbObj->cgs("tbl_deal_payment","",array("deal_id","user_id","giftemailid"),array($row->deal_id,$_SESSION['csUserId'],0),"","","1");exit;
	if($_GET['gift']=='sen')
	{
		$hsql="SELECT * FROM tbl_deal_payment WHERE deal_id=".$row->deal_unique_id." and user_id='".$_SESSION['csUserId']."' and gift_to_email!='' and (payment_done='".$pay_done."')";
	}else{
		$hsql="SELECT * FROM tbl_deal_payment WHERE deal_id=".$row->deal_unique_id." and gift_to_email='".$_SESSION['csUserEmail']."' and gift_to_email!='' and (payment_done='".$pay_done."')";
	}

	//echo $hsql;exit;
	$re22 = mysql_query($hsql);
	$nu11 = @mysql_num_rows($re22);
	$kl = 0;

	while($row33 = @mysql_fetch_object($re22))
	{
		$rsname=$dbObj->cgs("tbl_users", "*", "userid",$row33->user_id, "", "", "");

		$username=@mysql_fetch_assoc($rsname);

		if($_GET['sort']=="" || $_GET['sort']=="all" || $_GET['sort']=="2"){
			$re11 = $dbObj->cgs("tbl_deal_payment_unique","",array("pay_id"),array($row33->pay_id),"","","");//exit;
			$rownum = @mysql_num_rows($re11);
		}else if($_GET['sort']=="0" || $_GET['sort']=="1"){
			$re11 = $dbObj->cgs("tbl_deal_payment_unique","",array("pay_id","used"),array($row33->pay_id,$_GET['sort']),"","","");
			$rownum = @mysql_num_rows($re11);
		}else if($_GET['sort']=="3"){
			$re11 = $dbObj->cgs("tbl_deal_payment_unique","",array("pay_id"),array($row33->pay_id),"","","");//exit;
			$rownum = @mysql_num_rows($re11);
		}
		$j=0;
		while($row22 = @mysql_fetch_assoc($re11))
		{
			$dealInfoCount++;
			if($dealInfoCount > $StartRow && $adsperpage > $count)
			{
				$count++;
				$k = $j+1;
				$array[$i]['dealinfo'][$kl][$j]["pay_id"] = $row33->pay_id;
				$array[$i]['dealinfo'][$kl][$j]["purchase_on"] = $row33->order_date;
				$array[$i]['dealinfo'][$kl][$j]["uniqueid"] = $row22['uniqueid'];
				$array[$i]['dealinfo'][$kl][$j]["payid"] = $row22['pay_unique_id']."-".$k;
				$array[$i]['dealinfo'][$kl][$j]["used"] = $row22['used'];
				//$array[$i]['dealinfo'][$kl][$j]["print_on"] = $arr->print_on;
				$array[$i]['dealinfo'][$kl][$j]["expire_date"] = $arr->validto;
				$array[$i]['dealinfo'][$kl][$j]["fullname"] = $username['fullname'];
				$array[$i]['dealinfo'][$kl][$j]["gift_receiver_fullname"] = $arr->gift_to_name;
				$array[$i]['dealinfo'][$kl][$j]["gift_receiver_email"] = $arr->gift_to_email;
	
				$printdate=$arr->print_on;
	
				if($printdate<=$currentTime){
					$printv=1;
				}else{
					$printv=0;
				}
		
				$array[$i]['dealinfo'][$kl][$j]["printv"] = $printv;
		
				$currentTimeArray = explode(" ",$currentTime);
				$currentTimeArray = explode("-",$currentTimeArray[0]);
				$currentTimeYear = $currentTimeArray[0];
				$currentTimeMonth = $currentTimeArray[1];
				$currentTimeDay = $currentTimeArray[2];
		
				$printOnTimeArray = explode(" ",$arr->print_on);
				$printOnTimeArray = explode("-",$printOnTimeArray[0]);
				$printOnTimeYear = $printOnTimeArray[0];
				$printOnTimeMonth = $printOnTimeArray[1];
				$printOnTimeDay = $printOnTimeArray[2];
		
				$expireTimeArray = explode(" ",$arr->validto);
				$expireTimeArray = explode("-",$expireTimeArray[0]);
				$expireTimeYear = $expireTimeArray[0];
				$expireTimeMonth = $expireTimeArray[1];
				$expireTimeDay = $expireTimeArray[2];
		
				/*
				if(strtotime($arr->print_on) <= strtotime($currentTime) && strtotime($arr->expire_date) >= strtotime($currentTime)){
					$array[$i]['dealinfo'][$kl][$j]['print'] = 0;
				}else{
					$array[$i]['dealinfo'][$kl][$j]['print'] = 1;
				}
				*/
		
				if(greaterDate($arr->print_on,$currentTime) && greaterDate($arr->validto,$currentTime))
					$array[$i]['dealinfo'][$kl][$j]['print'] = 1;
				else
					$array[$i]['dealinfo'][$kl][$j]['print'] = 0;
		
				$j++;
			}else
			{
				$rownum = 0;
			}
		}
		if($rownum>0)
			$kl++;
	}
	$i++;
}
//echo"<pre>";
//print_r($array);die();

//echo count($array);exit;
$smarty->assign("gift_deal_receive",$array);
//echo "<pre>"; print_r($array);exit;


/*----------Pagination Part-2--------------*/
//$rs=$dbObj->gj("tbl_deal_payment",$sf,$cnd, "", $gb, "", "", "");


// 	$_query = "select 
// 				* 
// 			from 
// 				tbl_deal as p,tbl_deal_payment as dp 
// 			where 
// 				p.deal_unique_id=dp.deal_id 
// 				and dp.gift_to_email='' 
// 				and dp.user_id=".$_SESSION['csUserId']." group by dp.deal_id".$cnd1;
// 
//    $rs = mysql_query($_query);
//
//    $nums = @mysql_num_rows($rs);

$nums = $dealInfoCount;
$show = 20;
$total_pages = ceil($nums / $adsperpage);

if($total_pages > 1)
{
	$showing   = !isset($_GET["page"]) ? 1 : $page;
	if($_GET['gift'] != '')
	{
		if($_GET['sort'] != '')
		{
			$firstlink = SITEROOT."/my-gifts/".$_GET['gift']."/".$_GET['sort'];
		}else
		{
			$firstlink = SITEROOT."/my-gifts/".$_GET['gift']."/all";
		}
	}else
	{
		if($_GET['sort'] != '')
		{
			$firstlink = SITEROOT."/my-gifts/".$_GET['gift']."/".$_GET['sort'];
		}else
		{
			$firstlink = SITEROOT."/my-gifts/rec/all";
		}
	}
	$seperator = '/';
	$baselink  = $firstlink;
	$pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);
	$smarty -> assign("pgnation",$pgnation);
}
#-----------------------------------#



$smarty->display(TEMPLATEDIR . '/modules/my-account/my-gifts.tpl');
$dbObj->Close();
?>