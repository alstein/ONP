<?php
include_once('../../include.php');
include_once('../../includes/paging.php');

//Get meta tags of the page as per id
$call_meta=$dbObj->meta_SEO(17);
$smarty->assign("row_meta",$call_meta);

if(!isset($_SESSION['csUserId']))
{
	header("location:".SITEROOT."/"); exit;
}


function greaterDate($start_date,$end_date)
{
	$start = strtotime($start_date);
	$end = strtotime($end_date);
	if ($start-$end > 0)
		return 1;
	else
		return 0;
}

/*------------Pagination Part-1------------*/

	if(!isset($_GET['page']))
		$page =1;
	else
		$page = $_GET['page'];
	$adsperpage = 50;
	$StartRow = $adsperpage * ($page-1);
	$l = $StartRow.','.$adsperpage;
	/*-----------------------------------*/

	if($_GET['sort']=="3"){
		$pay_done = "no";
	}else{
		$pay_done = "yes";
	}

	// get the deals from whose payment is done.
	$currentTime = date("Y-m-d H-i-s");
	
	$cnd1 = " and p.validto >= '".$currentTime."' ";
	if($_GET['sort']=='all' || $_GET['sort']==''){
		$cnd1 = '';
		$pay_done = "yes' or payment_done = 'no";
	}else
	{
		if($_GET['sort']==2){
			$cnd1 = " and p.validto < '".$currentTime."' ";
			$pay_done = "yes' or payment_done = 'no";
		}else{
			$cnd1 = " and p.validto >= '".$currentTime."' ";
		}
	}

	$_query = "select * from tbl_deal as p,tbl_deal_payment as dp where p.deal_unique_id=dp.deal_id and dp.deal_type='self' and dp.user_id=".$_SESSION['csUserId']." and (payment_done = '".$pay_done."') ".$cnd1." group by dp.deal_id";

	$res = mysql_query($_query);
// 	print_r($res);exit;
	$nu = @mysql_num_rows($res);

	$i=0;
	$array = array();
	$dealInfoCount = 0;
	$count = 0;
	while($row = @mysql_fetch_object($res)){
		$arr = $row;

		if(strtotime($arr->end_date) < date("Y:m:d H:i:s")){
			$array[$i]['dealislive'] = 0;
		}else{
			$array[$i]['dealislive'] = 1;
		}

		//$array[$i]['deal'] = $arr->business_name;
		
		$array[$i]['description'] = $arr->description;
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
		$array[$i]['product_city'] = str_replace(" ","-",strtolower($arr->deal_city));
		//$array[$i]['redeem_method'] = $arr->redeem_method;
		//$array[$i]['redeem_method_title'] = $arr->redeem_method_title;
		//$array[$i]['redeem_method_details'] = $arr->redeem_method_details;
		$array[$i]['product_slogan'] = $arr->slogan;
		$array[$i]['payment_done'] = $arr->payment_done;

		//echo "<pre>"; print_r($array);exit;

		if($arr->validto<$currentTime){
			$expire_date=1;
		}else{
			$expire_date=0;
		}
		$array[$i]['expire_deal'] = $expire_date;

		$re22 = $dbObj->customqry("SELECT * FROM tbl_deal_payment WHERE deal_id=".$row->deal_id." and user_id=".$_SESSION['csUserId']." and deal_type='self' and (payment_done = '".$pay_done."')","");

//$re22=$dbObj->cgs("tbl_deal_payment","",array("deal_id","user_id","deal_type","payment_done"),array($row->deal_id,$_SESSION['csUserId'],"self",$pay_done),"","","1");

		$nu11 = @mysql_num_rows($re22);
		$kl = 0;
		while($row33 = @mysql_fetch_object($re22)){
			
			if($_GET['sort']=="" || $_GET['sort']=="all" || $_GET['sort']=="2"){
				$re11 = $dbObj->cgs("tbl_deal_payment_unique","",array("pay_id"),array($row33->pay_id),"","","");//exit;
				$rownum = @mysql_num_rows($re11);
			}else if($_GET['sort']=="0" || $_GET['sort']=="1"){
				$re11 = $dbObj->cgs("tbl_deal_payment_unique","",array("pay_id","used"),array($row33->pay_id,$_GET['sort']),"","","");//exit;
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
					$array[$i]['dealinfo'][$kl][$j]["coupon_id"] = $row22['coupon_id'];
					$array[$i]['dealinfo'][$kl][$j]["used"] = $row22['used'];
					//$array[$i]['dealinfo'][$kl][$j]["print_on"] = $arr->print_on;
					$array[$i]['dealinfo'][$kl][$j]["expire_date"] = $arr->validto;
					$printdate=$arr->print_on;

					if($printdate<=$currentTime)
					{
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
//echo "<pre>";print_r($array);die();
//echo count($array);exit;

	$smarty->assign("deal_array",$array);

	/*----------Pagination Part-2--------------*/
	//$rs=$dbObj->gj("tbl_deal_payment",$sf,$cnd, "", $gb, "", "", "");

// 	$_query = "select * from tbl_deal as p,tbl_deal_payment as dp where p.deal_unique_id=dp.deal_id and dp.deal_type='self' and dp.user_id=".$_SESSION['csUserId']." and dp.payment_done = 'yes' ".$cnd1." group by dp.deal_id ";
// 
// 	$rs = mysql_query($_query);
// 
// 	$nums = @mysql_num_rows($rs);

	$nums = $dealInfoCount;

	$show = 20;
	$total_pages = ceil($nums / $adsperpage);
	
	if($total_pages > 1){
		$showing   = !isset($_GET["page"]) ? 1 : $page;
		if($_GET['sort'] != '')
		{
			$firstlink = SITEROOT."/my-deals/".$_GET['sort'];
		}else
		{
			$firstlink = SITEROOT."/my-deals/all";
		}
		$seperator = '/';
		$baselink  = $firstlink;
		$pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);
		$smarty -> assign("pgnation",$pgnation);
	}
	
	#-----------------------------------#
	
	








$smarty->display(TEMPLATEDIR . '/modules/my-account/my-deals.tpl');
$dbObj->Close();
?>