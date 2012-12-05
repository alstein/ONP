<?php
include_once('../../include.php');
include_once('../../includes/classes/class.deals.php');
include_once('../../includes/classes/class.frontregister.php');
include_once('../../includes/classes/payment_paypal_model.php');


if(!isset($_SESSION['csUserId']))
{
	$_SESSION['previous_page'] = SITEROOT.'/deal/buynow/'.$_GET['dealid'];
	header("location:".SITEROOT."/signin"); exit;
}

$userData = getUserData($_SESSION['csUserId']);
if(($userData->userid > 0) && ($userData->from_register_or_subscriber == "subscriber"))
{
	$_SESSION['previous_page'] = SITEROOT.'/deal/buynow/'.$_GET['dealid'];
	$_SESSION['msg'] = "Please fill up the form with all required information, to proceed!!!";
	header("location:".SITEROOT."/my-account-update");
	exit;
}


$objregister = new frontregister();


//START=====================Clearing session msg=================//
if($_SESSION['msg'])
{
	$smarty->assign("msg", $_SESSION['msg']);
	$_SESSION['msg'] = NULL;
	unset($_SESSION['msg']);
}
//END=======================Clearing session msg=================//


//START==============Get meta tags of the page as per id=========//
$call_meta=$dbObj->meta_SEO(20);
$smarty->assign("row_meta",$call_meta);
//END================Get meta tags of the page as per id=========//


//START=================Getting State Details====================//
$rs = $dbObj->customqry("select ms.* from mast_state ms LEFT JOIN mast_country mc ON ms.country_id=mc.countryid where mc.status='Active' AND active='1' order by state_name","");
if($rs != 'n')
{
	$state = array();
	while($row = @mysql_fetch_assoc($rs))
		$state[]=$row;
}
$smarty->assign("state", $state);
//END===================Getting State Details====================//

//START=================Getting City Details====================//
$rs = $dbObj->customqry("select mcity.* from mast_city mcity LEFT JOIN mast_state ms ON ms.id = mcity.state_id LEFT JOIN mast_country mc ON ms.country_id=mc.countryid where mcity.status = 'Active' and mc.status='Active' AND active='1' order by city_name","");

if($rs != 'n')
{
	$city = array();
	while($row = @mysql_fetch_assoc($rs))
		$city[]=$row;
}
$smarty->assign("city", $city);
//END===================Getting City Details====================//


//START=================Getting Deal Details=====================//
$dealId = ($_GET['dealid']?$_GET['dealid']:0);
$dealData = $dealsObj->getDealById($dealId);

if(!(count($dealData) > 0))
{
	header("location:".SITEROOT); exit;
}

//START=================Calculating Deal Quantity Remaining=====================//
$sql = "select sum(deal_quantity) as totalQty from tbl_deal_payment where deal_id = ".$dealData['deal_unique_id'];
$qry = @mysql_query($sql);
$ar = @mysql_fetch_assoc($qry);

$totalQty = ($ar['totalQty']?$ar['totalQty']:0);

if($dealData['range_1'] == 'true'){
	if(intval($totalQty) >= intval($dealData['min_buyer_1']))$dealData['groupbuy_price'] = $dealData['buy_price_1'];
	if($dealData['range_2'] == 'true'){
		if(intval($totalQty) >= intval($dealData['max_buyer_1']))$dealData['groupbuy_price'] = $dealData['buy_price_2'];
		if($dealData['range_3'] == 'true'){
			if(intval($totalQty) >= intval($dealData['max_buyer_2']))$dealData['groupbuy_price'] = $dealData['buy_price_3'];
			if($dealData['range_4'] == 'true'){
				if(intval($totalQty) >= intval($dealData['max_buyer_3']))$dealData['groupbuy_price'] = $dealData['buy_price_4'];
				if($dealData['range_5'] == 'true'){
					if(intval($totalQty) >= intval($dealData['max_buyer_4']))$dealData['groupbuy_price'] = $dealData['buy_price_5'];
					$max_buyer = $dealData['max_buyer_5'];
				}else
					$max_buyer = $dealData['max_buyer_4'];
			}else
				$max_buyer = $dealData['max_buyer_3'];
		}else
			$max_buyer = $dealData['max_buyer_2'];
	}else
		$max_buyer = $dealData['max_buyer_1'];
}else
	$max_buyer = $dealData['max_buyer'];


$maxQty = $max_buyer;

if($maxQty <= $totalQty)
{
	$dealRemQty = 0;
	header("location:".SITEROOT); exit;
}else
{
	$dealRemQty = intval($maxQty-$totalQty);
}
$smarty->assign("totalQty",$totalQty);
$smarty->assign("remQty",$dealRemQty);

//END===================Calculating Deal Quantity Remaining=====================//

$smarty->assign("dealData",$dealData);
$smarty->assign("dealGBy",$dealData); //This is only for page title and meta tags ([[deal_title]]) in header_start.tpl
//END===================Getting Deal Details=====================//


//START=================Getting User Details=====================//
$userData = $objregister->getUserDetails($_SESSION['csUserId']);
$smarty->assign("userData", $userData);
//END===================Getting User Details=====================//

//START==============After Order/Subminting Form=================//

if(strlen(trim($_POST['quantity'])) > 0 && strlen(trim($_POST['dealAmt'])) > 0)
{
// 	$fullName = $_POST['ccfname']." ".$_POST['cclname'];
// 	$_POST['ccname'] = $fullName;
// 	$fullName = explode(" ",$fullName);
// 
// 	$firstName = $fullName[0];
// 	$lastName = $fullName[1];

	$dealQty = $_POST['quantity'];
	$dealAmt = ((((double)$_POST['dealAmt']) + ((double)$_POST['delCharHID'])) * (integer)$dealQty);
	$prmoPrice = $_POST['prmoPriceHID'];

	//// START Updating records of promotion code////
	if($_POST['prmo_chk'] == 1)
	{
		$dbObj->customqry("update tbl_users set credit_account = (credit_account+".$prmoPrice.") where userid = ".$_SESSION['csUserId'],'');
		$dbObj->cupdt("tbl_coupon_master_uniqueids","used","1","coupon_unique_id",trim($_POST['prmoCode']),'');
	}
	//// END Updating records of promotion code////

	$userData = $objregister->getUserDetails($_SESSION['csUserId']);
	$userCreditAccount = $userData['credit_account'];
	if($userCreditAccount <= $dealAmt)
	{
		$totalAmt = $dealAmt - $userCreditAccount;
		$dealRewardsAppliedAmount = $userCreditAccount;
		$userCreditAccount = 0;
	}else{
		$totalAmt = 0;
		$userCreditAccount = $userCreditAccount - $dealAmt;
		$dealRewardsAppliedAmount = $dealAmt;
	}


	if($_POST['currencyType'] == 'pound')$currencyCode = 'GBP'; else if ($_POST['currencyType'] == 'euro')$currencyCode = 'EUR'; else $currencyCode = 'USD';

	if($totalAmt > 0)
	{
		//$PaymentModel = new Payment_Paypal_Model();
		//$result=$PaymentModel->payPaymentByCreditCard($firstName,$lastName,$_POST['cctype'],$_POST['ccnumber'],$_POST['ccexpmonth'],$_POST['ccexpyear'],$_POST['cccode'],$_POST['address1'],$_POST['address2'],$_POST['city'],$_POST['state'],$_POST['postcode'],$totalAmt,$x_email="",$paymentType="Authorization",$currencyCode);

		//print_r($result);exit;
		$result['TRANSACTIONID'] = 1;
		if($result['TRANSACTIONID']=="")
		{
			if($_POST['prmo_chk'] == 1)
			{
				$dbObj->customqry("update tbl_users set credit_account = (credit_account-".$prmoPrice.") where userid = ".$_SESSION['csUserId'],'');
				$dbObj->cupdt("tbl_coupon_master_uniqueids","used","0","coupon_unique_id",trim($_POST['prmoCode']),'');
			}
			$_SESSION['msg'] = "Please enter correct credit card information !!!!";
			//$_SESSION['msg'] = $result['L_LONGMESSAGE0'];
		
			header("location:".SITEROOT."/deal/buynow/".$dealId);
			exit;
		}else
		{
			////START Updating user credit_account after using credit_account balance////
			$dbObj->customqry("update tbl_users set credit_account = ".$userCreditAccount." where userid = ".$_SESSION['csUserId'],'');
			/////END Updating user credit_account after using credit_account balance////

			//// START Inserting records in tbl_credit_card ////
			/*
			$field3 = array(
				"userid"=>$_SESSION['csUserId'],
				"card_type"=>$_POST['cctype'],
				"card_holder_name"=>$_POST['ccname'],
				"card_holder_email"=>$userData['email'],
				"card_number"=>base64_encode($_POST['ccnumber']),
				"cvv_code"=>base64_encode($_POST['cccode']),
				"card_expire_month"=>$_POST['ccexpmonth'],
				"card_expire_year"=>$_POST['ccexpyear'],
				"added_date"=>date('Y-m-d')
			);
			$cardid = $dbObj->cgii("tbl_credit_card",$field3,"");
			*/
			$cardid = 0;
			//// END Inserting records in tbl_credit_card ////


			//// START Inserting records in tbl_deal_payment ////


/*
				//// START Checking deal purchasing limit ////
			$re1 = $dbObj->cgs("tbl_deal_payment","sum(deal_quantity) as deals",array("deal_id","cancel_order"),array($dealData['deal_unique_id'],"no"),"","group by deal_id","");
			$_row1 = @mysql_fetch_assoc($re1);

			$finalsum = $_row1['deals'];

			if($finalsum>0 && $dealData['max_buyer'] != 0)
			{
				if($finalsum == $dealData['max_buyer'])
				{
					$_SESSION['msg'] = "You can not order more than the limit";
					header("location:".SITEROOT."/deal/buynow/".$dealData['deal_unique_id']);
					exit;
				}
			}
				//// END Checking deal purchasing limit ////
*/

			$pay_unique = "US".time();
			//$pay_unique1 = "US1".time();
			
			$field_array  = array("deal_id" => $dealData['deal_unique_id'],
						"transaction_id" => $result['TRANSACTIONID'],
						"pay_unique_id" => $pay_unique,
						"encrypt_unique_id" => md5($pay_unique),
						"user_id" => $_SESSION['csUserId'],
						"card_id" => $cardid,
						"deal_quantity" => $dealQty,
						"deal_price" => $dealAmt,
						"delivery_charges" => (double)$_POST['delCharHID'],
						"rewardsApplied" => $dealRewardsAppliedAmount,
						"pay_by" => 'credit_card',
						"order_date" => date('Y-m-d'),
						"redemption_code" => ($_POST['gft_chk']?uniqid():0)
					);

			if($_POST['gft_chk'] == 1)
			{
				$field_array_gift = array("deal_id" => $dealData['deal_unique_id'],
						"transaction_id" => $result['TRANSACTIONID'],
						"pay_unique_id" => $pay_unique,
						"encrypt_unique_id" => md5($pay_unique),
						"user_id" => $_SESSION['csUserId'],
						"card_id" => $cardid,
						"deal_quantity" => $dealQty,
						"deal_price" => $dealAmt,
						"delivery_charges" => (double)$_POST['delCharHID'],
						"rewardsApplied" => $dealRewardsAppliedAmount,
						"pay_by" => 'credit_card',
						"order_date" => date('Y-m-d'),
						"deal_type" => 'gift',
						"gift_to_name" => $_POST['gft_to'],
						"gift_to_email" => $_POST['gft_frndEmail'],
						"gift_message" => $_POST['gft_msg'],
						"gift_from" => $_POST['gft_from'],
						"redemption_code" => ($_POST['gft_chk']?uniqid():0)
				);

				$tbl_deal_payment_id_gift = $dbObj->cgii("tbl_deal_payment",$field_array_gift,"");

			$select_offer_deal=$dbObj->customqry("select * from tbl_deals where deal_unique_id='".$dealData['deal_unique_id']."'","");
			$res_offer_deal=@mysql_fetch_assoc($select_offer_deal);
			$dealname=$res_offer_deal['deal_title'];
			
			$select_user=$dbObj->customqry("select u.fullname,u.userid from tbl_users u  where userid='".$_SESSION['csUserId']."'","");
			$res_user=@mysql_fetch_assoc($select_user);
			$fullname1=$res_user['fullname'];
			
			$select_merchant=$dbObj->customqry("select u.business_name,u.userid from tbl_users u   where userid='".$res_offer_deal['merchant_id']."'","");
			$res_merchant=@mysql_fetch_assoc($select_merchant);
			$business_name=$res_merchant['business_name'];
			$link_deal=SITEROOT."/buy/".$dealData['deal_unique_id'];
			$msg=ucfirst($fullname1)." bought a "."<a href=$link_deal>".ucfirst($dealname)."</a>";
			$insert_thinking=$dbObj->customqry("insert into tbl_activity(msg,vault_t,vault,timestamp,wall,uid,fid,parent_id,deal_id)values('".$msg."','deal','".$res_offer_deal['deal_image']."',Now(),'0','".$res_user['userid']."','".$res_merchant['userid']."','','') ","");
			}
			else
			{
				//if(strlen(trim($_POST['ccname'])) > 0 && strlen(trim($_POST['ccnumber'])))
				{
					$tbl_deal_payment_id = $dbObj->cgii("tbl_deal_payment",$field_array,"");
					$select_offer_deal=$dbObj->customqry("select * from tbl_deals where deal_unique_id='".$dealData['deal_unique_id']."'","");
					$res_offer_deal=@mysql_fetch_assoc($select_offer_deal);
					$dealname=$res_offer_deal['deal_title'];
					
					$select_user=$dbObj->customqry("select u.fullname,u.userid from tbl_users u  where userid='".$_SESSION['csUserId']."'","");
					$res_user=@mysql_fetch_assoc($select_user);
					$fullname1=$res_user['fullname'];
					
					$select_merchant=$dbObj->customqry("select u.business_name,u.userid from tbl_users u   where userid='".$res_offer_deal['merchant_id']."'","");
					$res_merchant=@mysql_fetch_assoc($select_merchant);
					$business_name=$res_merchant['business_name'];
					$link_deal=SITEROOT."/buy/".$dealData['deal_unique_id'];
					$msg=ucfirst($fullname1)." bought a "."<a href=$link_deal>".ucfirst($dealname)."</a>";
					$insert_thinking=$dbObj->customqry("insert into tbl_activity(msg,vault_t,vault,timestamp,wall,uid,fid,parent_id,deal_id)values('".$msg."','deal','".$res_offer_deal['deal_image']."',Now(),'0','".$res_user['userid']."','".$res_merchant['userid']."','','') ","");
				}
			}

			//// END Inserting records in tbl_deal_payment ////


			//// START Inserting records in tbl_deal_payment_unique ////

			if($tbl_deal_payment_id > 0)
			{
				for($l = 0;$l < $_POST['quantity'];$l++)
				{
					$kl = $l+1;
					$uniquebar = rand(1, 10000000);
					$uniqueid = "#".$uniquebar;
					$ins_array = array("deal_id"=>$dealData['deal_unique_id'],
								"user_id"=>$_SESSION['csUserId'],
								"pay_id"=>$tbl_deal_payment_id,
								"pay_unique_id"=>$pay_unique,
								"coupon_id"=>$pay_unique."-".$kl,
								"barcode_id"=>$uniqueid,
								"bar_code"=>$uniquebar
							);
					$dbObj->cgii("tbl_deal_payment_unique",$ins_array,"");
				}
			}
			
			if($tbl_deal_payment_id_gift > 0)
			{
				for($l = 0;$l < $_POST['quantity'];$l++)
				{
					$kl = $l+1;
					$uniquebar = rand(1, 10000000);
					$uniqueid = "#".$uniquebar;
					$ins_array = array("deal_id"=>$dealData['deal_unique_id'],
								"user_id"=>$_SESSION['csUserId'],
								"pay_id"=>$tbl_deal_payment_id_gift,
								"pay_unique_id"=>$pay_unique,
								"coupon_id"=>$pay_unique."-".$kl,
								"barcode_id"=>$uniqueid,
								"bar_code"=>$uniquebar
							);
					$dbObj->cgii("tbl_deal_payment_unique",$ins_array,"");
				}
			}

			//// END Inserting records in tbl_deal_payment_unique ////

			//// START Updating users credit_spent value ////

			if($dealRewardsAppliedAmount > 0)
			{
				$dbObj->customqry("update tbl_users set credit_spent = (credit_spent + ".$dealRewardsAppliedAmount.") where userid = ".$_SESSION['csUserId'],'');
			}

			//// END Updating users credit_spent value ////

			//// START affiliate code ////

			if(isset($_SESSION['affiliate_unique_id']))
			{
				$res_affiliate = $dbObj->customqry("select * from tbl_deal_affiliate_tosend_users where unique_id = '".$_SESSION['affiliate_unique_id']."' and used = 'no' and user_id != '' and to_email = '".$_SESSION['csUserEmail']."'","");
				if(is_resource($res_affiliate))
				{
					$row_affiliate = @mysql_fetch_assoc($res_affiliate);

					if($_POST['currencyType'] == 'pound')$currId = '39'; else if ($_POST['currencyType'] == 'euro')$currId = '40'; else $currId = '41';

					$res_affiAmt = $dbObj->customqry("select * from sitesetting where id=".$currId,"");
					$row_affiAmt = @mysql_fetch_assoc($res_affiAmt);
					
					$dbObj->customqry("update tbl_users set credit_account = (credit_account+".$row_affiAmt['value'].") where userid = ".$row_affiliate['user_id'],'');

					$dbObj->customqry("update tbl_deal_affiliate_tosend_users set used = 'yes', affiliate_amt = ".$row_affiAmt['value']." where unique_id = '".$_SESSION['affiliate_unique_id']."'","");
				}
				unset($_SESSION['affiliate_unique_id']);
			}

			//// END affiliate code ////

			//// START Updating record(deal_on_date) in tbl_deal When deal is on////

			if($maxQty <= $totalQty){
				$dbObj->cupdt("tbl_deal","deal_on_date",date("Y:m:d H:i:s"),"deal_unique_id",$dealData['deal_unique_id'],'');
				$dbObj->cupdt("tbl_deal","deal_status","3","deal_unique_id",$dealData['deal_unique_id'],""); // deal_status = 3 means deal is on.
			}

			//// END Updating record(deal_on_date) in tbl_deal When deal is on ////

// 			$_SESSION['msg'] = 'Thank you for Dealing with us';
// 			header("location:".SITEROOT."/deal/buynow/".$dealId);

			header("location:".SITEROOT."/deal/success");
			exit;
		}
	}else
	{
		////START Updating user credit_account after using credit_account balance////
		$dbObj->customqry("update tbl_users set credit_account = ".$userCreditAccount." where userid = ".$_SESSION['csUserId'],'');
		/////END Updating user credit_account after using credit_account balance////

		$cardid = 0;
/*
			//// START Checking deal purchasing limit ////
		$re1 = $dbObj->cgs("tbl_deal_payment","sum(deal_quantity) as deals",array("deal_id","cancel_order"),array($dealData['deal_unique_id'],"no"),"","group by deal_id","");
		$_row1 = @mysql_fetch_assoc($re1);

		$finalsum = $_row1['deals'];

		if($finalsum>0 && $dealData['max_buyer'] != 0)
		{
			if($finalsum == $dealData['max_buyer'])
			{
				$_SESSION['msg'] = "You can not order more than the limit";
				header("location:".SITEROOT."/deal/buynow/".$dealData['deal_unique_id']);
				exit;
			}
		}
			//// END Checking deal purchasing limit ////
*/

		$pay_unique = "US".time();
		//$pay_unique1 = "US1".time();

		if($_POST['gft_chk'] == 1)
		{
			$field_array_gift = array("deal_id" => $dealData['deal_unique_id'],
				"transaction_id" => '',
				"pay_unique_id" => $pay_unique,
				"encrypt_unique_id" => md5($pay_unique),
				"user_id" => $_SESSION['csUserId'],
				"card_id" => $cardid,
				"deal_quantity" => $dealQty,
				"deal_price" => $dealAmt,
				"delivery_charges" => (double)$_POST['delCharHID'],
				"rewardsApplied" => $dealRewardsAppliedAmount,
				"pay_by" => 'credit',
				"order_date" => date('Y-m-d'),
				"deal_type" => 'gift',
				"gift_to_name" => $_POST['gft_to'],
				"gift_to_email" => $_POST['gft_frndEmail'],
				"gift_message" => $_POST['gft_msg'],
				"gift_from" => $_POST['gft_from'],
				"redemption_code" => ($_POST['gft_chk']?uniqid():0)
			);

			$tbl_deal_payment_id_gift = $dbObj->cgii("tbl_deal_payment",$field_array_gift,"");
		}
		else
		{
			$field_array  = array("deal_id" => $dealData['deal_unique_id'],
				"transaction_id" => '',
				"pay_unique_id" => $pay_unique,
				"encrypt_unique_id" => md5($pay_unique),
				"user_id" => $_SESSION['csUserId'],
				"card_id" => $cardid,
				"deal_quantity" => $dealQty,
				"deal_price" => $dealAmt,
				"delivery_charges" => (double)$_POST['delCharHID'],
				"rewardsApplied" => $dealRewardsAppliedAmount,
				"pay_by" => 'credit',
				"order_date" => date('Y-m-d'),
				"redemption_code" => ($_POST['gft_chk']?uniqid():0)
			);
			$tbl_deal_payment_id = $dbObj->cgii("tbl_deal_payment",$field_array,"");
		}

		//// END Inserting records in tbl_deal_payment ////


		//// START Inserting records in tbl_deal_payment_unique ////

		if($tbl_deal_payment_id > 0)
		{
			for($l = 0;$l < $_POST['quantity'];$l++)
			{
				$kl = $l+1;
				$uniquebar = rand(1, 10000000);
				$uniqueid = "#".$uniquebar;
				$ins_array = array("deal_id"=>$dealData['deal_unique_id'],
							"user_id"=>$_SESSION['csUserId'],
							"pay_id"=>$tbl_deal_payment_id,
							"pay_unique_id"=>$pay_unique,
							"coupon_id"=>$pay_unique."-".$kl,
							"barcode_id"=>$uniqueid,
							"bar_code"=>$uniquebar
						);
				$dbObj->cgii("tbl_deal_payment_unique",$ins_array,"");
			}
		}
		
		if($tbl_deal_payment_id_gift > 0)
		{
			for($l = 0;$l < $_POST['quantity'];$l++)
			{
				$kl = $l+1;
				$uniquebar = rand(1, 10000000);
				$uniqueid = "#".$uniquebar;
				$ins_array = array("deal_id"=>$dealData['deal_unique_id'],
							"user_id"=>$_SESSION['csUserId'],
							"pay_id"=>$tbl_deal_payment_id_gift,
							"pay_unique_id"=>$pay_unique,
							"coupon_id"=>$pay_unique."-".$kl,
							"barcode_id"=>$uniqueid,
							"bar_code"=>$uniquebar
						);
				$dbObj->cgii("tbl_deal_payment_unique",$ins_array,"");
			}
		}

		//// END Inserting records in tbl_deal_payment_unique ////

		//// START Updating users credit_spent value ////

		if($dealRewardsAppliedAmount > 0)
		{
			$dbObj->customqry("update tbl_users set credit_spent = (credit_spent + ".$dealRewardsAppliedAmount.") where userid = ".$_SESSION['csUserId'],'');
		}

		//// END Updating users credit_spent value ////

		//// START affiliate code ////

		if(isset($_SESSION['affiliate_unique_id']))
		{
			$res_affiliate = $dbObj->customqry("select * from tbl_deal_affiliate_tosend_users where unique_id = '".$_SESSION['affiliate_unique_id']."' and used = 'no' and user_id != '' and to_email = '".$_SESSION['csUserEmail']."'","");
			if(is_resource($res_affiliate))
			{
				$row_affiliate = @mysql_fetch_assoc($res_affiliate);

				if($_POST['currencyType'] == 'pound')$currId = '39'; else if ($_POST['currencyType'] == 'euro')$currId = '40'; else $currId = '41';

				$res_affiAmt = $dbObj->customqry("select * from sitesetting where id=".$currId,"");
				$row_affiAmt = @mysql_fetch_assoc($res_affiAmt);
				
				$dbObj->customqry("update tbl_users set credit_account = (credit_account+".$row_affiAmt['value'].") where userid = ".$row_affiliate['user_id'],'');

				$dbObj->customqry("update tbl_deal_affiliate_tosend_users set used = 'yes' where unique_id = '".$_SESSION['affiliate_unique_id']."'","");
			}
			unset($_SESSION['affiliate_unique_id']);
		}

		//// END affiliate code ////

		//// START Updating record(deal_on_date) in tbl_deal When deal is on////

		if($maxQty <= $totalQty){
			$dbObj->cupdt("tbl_deal","deal_on_date",date("Y:m:d H:i:s"),"deal_unique_id",$dealData['deal_unique_id'],'');
			$dbObj->cupdt("tbl_deal","deal_status","3","deal_unique_id",$dealData['deal_unique_id'],""); // deal_status = 3 means deal is on.
		}

		//// END Updating record(deal_on_date) in tbl_deal When deal is on ////

// 		$_SESSION['msg'] = 'Thank you for Dealing with us';
// 		header("location:".SITEROOT."/deal/buynow/".$dealId);

		header("location:".SITEROOT."/deal/success");
		exit;
	}
}
//END===============After Order/Subminting Form==================//

#-----------------START to fetching delivery charges label--------------------#
$res_delivery_chr = $dbObj->customqry("SELECT * FROM sitesetting WHERE id IN(52,53,54,55,56)","");
$row_delivery_chr = array();
while($row_delivery_chr = @mysql_fetch_assoc($res_delivery_chr))
	$data_delivery_chr[] = $row_delivery_chr;

$res_delivery_service_chr = $dbObj->customqry("SELECT * FROM tbl_delivery_service_charges WHERE set_for = 'deal' AND user_id = ".$dealId,"");
$data_delivery_service_chr = array();
while($row_delivery_service_chr = @mysql_fetch_assoc($res_delivery_service_chr))
	$data_delivery_service_chr[] = $row_delivery_service_chr;

$i = 1;
$arr = array();
foreach($data_delivery_service_chr as $key=>$val)
{
	if ($val['delivery_service_option'] == 'opt'.$i && $val['is_selected'] == 'yes')
	{
		foreach($data_delivery_chr as $key1=>&$val1)
		{
			if($val1['type'] == 'DELIVERY_SERVICE_OPTION_'.$i)
			{
				$arr[] = $i;
				$val1['charge'] = $val['delivery_charges_'.$dealData['deal_currency']];
				$val1['delivery_serv_chrg_id'] = $val['id'];
			}
		}
	}
	$i++;
}

foreach($data_delivery_chr as $key=>$val)
{
	if(in_array("".(intval($key)+intval(1)),$arr))
	{
		$data_delivery_chr_updated[] = $val;
	}
}

$smarty->assign("data_delivery_chr_updated", $data_delivery_chr_updated);
#-----------------END to fetching delivery charges label--------------------#

$smarty->assign("pgName","deals");
$smarty->display(TEMPLATEDIR . '/modules/deal/buynow.tpl');
$dbObj->Close();
?>