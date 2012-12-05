<?php
date_default_timezone_set('Europe/London');
include_once('../../../includes/SiteSetting.php');
include_once("../../../includes/paging.php");
include_once('../../../includes/class.message.php');
include_once('../../../includes/function.php');
include_once('../../../includes/classes/payment_paypal_model.php');
include_once('../../../includes/classes/SMS/class.sendsms_via_api.php');

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

	//Get deal details
	$deal_rs = $dbObj->gj("tbl_deal","*","deal_unique_id = '{$_GET['deal_id']}'","","","","","");
	$deal_row = @mysql_fetch_assoc($deal_rs);
	$deal_num_row = @mysql_num_rows($deal_rs);
	if($deal_num_row  > 0)
	{
		$dealInfo = $deal_row;
		$dealInfo['end_date']=date(DATE_FORMAT." H:i:s",strtotime($deal_row['end_date']));
		$dealInfo['start_date']=date(DATE_FORMAT." H:i:s",strtotime($deal_row['start_date']));

		if($row['$deal_row'] == 'euro')
			$curr_type = '&#8364;';
		else
			$curr_type = (($deal_row['deal_currency'] == 'pound') ? '&#163; ' : '$ ');

		$dealInfo['deal_currency_type'] = $curr_type;

		///////////////////////////////////////////
		//START Get multiple cities as per product id
		$dealInfo['city_name'] = $dbObj->getDealMultiCities($deal_row['deal_unique_id']);
		//END Get multiple cities as per product id

         	$dealInfo['deal_main_type_id'] = $deal_row['deal_main_type'];

		//get deal main type name through deal_main_type
		$sql_dlMainType = "Select dt.* from tbl_dealtype dt where typeid =".$deal_row['deal_main_type'];
		$res_dlMainType = $dbObj->customqry($sql_dlMainType,0);
		$row_dlMainType = @mysql_fetch_assoc($res_dlMainType);
		$dealInfo['deal_main_type'] = $row_dlMainType['dealtype'];

	////////////////////////////////////////////////////
		//START get SMS/EMAIL cost details
		$rs_sms = $dbObj->gj("sitesetting", "*", "id=34","","", "", "", "");
		$row_sms = @mysql_fetch_array($rs_sms);
		$perSmsCost = $row_sms['value'];
		
		$rs_email = $dbObj->gj("sitesetting", "*", "id=35","","", "", "", "");
		$row_email = @mysql_fetch_array($rs_email);
		$perEmailCost = $row_email['value'];

		//START get Email Subscriber details.
		$sql_subcriber = "SELECT tn.nemail,nid FROM tbl_newsletter tn, tbl_deal_city tdc, mast_city mc WHERE tn.nemail != '' AND tn.city = mc.city_id AND tdc.city_id = mc.city_id AND tdc.deal_id = ".$deal_row['deal_unique_id'];
		$res_subcriber = $dbObj->customqry($sql_subcriber,"");
		$subcriberDetails = array();
		while($row_subcriber = @mysql_fetch_assoc($res_subcriber))
			$subcriberDetails[] = $row_subcriber;
		//END get Email Subscriber details.

		//START get Sms Subscriber details.
		$sql_smsSubcriber = "SELECT tn.contact_detail FROM tbl_newsletter tn, tbl_deal_city tdc, mast_city mc WHERE tn.contact_detail != '' AND tn.city = mc.city_id AND tdc.city_id = mc.city_id AND tdc.deal_id = ".$deal_row['deal_unique_id'];
		$res_smsSubcriber = $dbObj->customqry($sql_smsSubcriber,"");
		$smsSubcriberDetails = array();
		while($row_smsSubcriber = @mysql_fetch_assoc($res_smsSubcriber))
			$smsSubcriberDetails[] = $row_smsSubcriber['contact_detail'];
		//END get Sms Subscriber details.

		//START Calculating and assigning values.
		$totEmailSub = count($subcriberDetails);
		$costPerEmail = $perEmailCost;
		$totEmailAmt = (count($subcriberDetails)*$perEmailCost);

		$totSmsSub = count($smsSubcriberDetails);
		$costPerSms = $perSmsCost;
		$totSmsAmt = (count($smsSubcriberDetails)*$perSmsCost);

		$totBothSub = ($totEmailSub + $totSmsSub);
		$totBothAmt = ($totEmailAmt + $totSmsAmt);

		$smarty->assign("totEmailSub", $totEmailSub);
		$smarty->assign("costPerEmail", $costPerEmail);
		$smarty->assign("totEmailAmt", $totEmailAmt);

		$smarty->assign("totSmsSub", $totSmsSub);
		$smarty->assign("costPerSms", $costPerSms);
		$smarty->assign("totSmsAmt", $totSmsAmt);

		$smarty->assign("totBothSub", $totBothSub);
		$smarty->assign("totBothAmt", $totBothAmt);
		//END Calculating and assigning values.
	///////////////////////////////////////////////////////

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

	}
	$smarty->assign("dealInfo", $dealInfo);


#-----------START As per GET info send Mail / SMS to users--------------#
	if(isset($_POST['submit']))
	{
		////START Fetching state name using stateId////
		$stateid= ($_POST['state']?$_POST['state']:0);
		$state_rs = $dbObj->customqry("select * from mast_state ms where ms.id = ".$stateid,"");
		if($state_row = @mysql_fetch_assoc($state_rs))
		{
			$stateName = $state_row['state_name'];
		}
		////END Fetching state name using stateId////

		////START Fetching state name using stateId////
		$cityid= ($_POST['city']?$_POST['city']:0);
		$city_rs = $dbObj->customqry("select * from mast_city ms where ms.city_id = ".$cityid,"");
		if($city_row = @mysql_fetch_assoc($city_rs))
		{
			$cityName = $city_row['city_name'];
		}
		////END Fetching state name using stateId////

		$PaymentModel = new Payment_Paypal_Model();
		$response=$PaymentModel->payPaymentByCreditCard($_POST['fname'],$_POST['lname'],$_POST['cctype']="visa",$_POST['ccnumber'],$_POST['ccexpmonth'],$_POST['ccexpyear'],$_POST['cccode'],$_POST['address1'],$_POST['address2']='',$cityName,$stateName,$_POST['postcode'],$_POST['final_value'],$x_email="",$paymentType="Sale",$currencyCode="GBP");

// 		print_r($response);
// 		die();
		if($response['TRANSACTIONID']=="")
		{
			//$_SESSION['msg'] = "Please enter correct credit card information !!!!";
			$_SESSION['msg'] = "<span style='color:red;'>".$response['L_LONGMESSAGE0']."</span>";
			header("location:".SITEROOT."/admin/seller/deal/send_sms_email.php?deal_id=".$_GET['deal_id']);exit;
		}else
		{
			if($_POST['send_as'] == 'SMS' || $_POST['send_as'] == 'BOTH')
			{
				foreach($smsSubcriberDetails as $val)
					$smsContent = sendDealSms($val); //this method defined in "include/function.php"
			}
			if($_POST['send_as'] == 'EMAIL' || $_POST['send_as'] == 'BOTH')
			{
				foreach($subcriberDetails as $key=>$val)
					$emailContent = sendDealEmail($_GET['deal_id'],$val['nemail'],$val['nid']); //this method defined in "include/function.php"
			}

			$field_array = array(
			"seller_id"		=> $_SESSION['duAdmId'],
			"deal_id"			=> $_GET['deal_id'],
			"`option`"		=> $_POST['send_as'],
			"smsCount"		=> $totSmsSub,
			"emailCount"		=> $totEmailSub,
			"cost_per_sms"		=> $costPerSms,
			"cost_per_email"	=> $costPerEmail,
			"totalAmt"		=> $_POST['final_value'],
			"transaction_id"	=> $response['TRANSACTIONID'],
			"smsContent"		=> $smsContent,
			"emailContent"		=> $emailContent
			);

			$insertedId = $dbObj->cgii("tbl_sms_email_header",$field_array,"");

			if($_POST['send_as'] == 'SMS' || $_POST['send_as'] == 'BOTH')
			{
				foreach($smsSubcriberDetails as $val)
					$insertedId_sms = $dbObj->cgii("tbl_sms_details",array('sms_email_id'=>$insertedId,'contact_no'=>$val),"");
			}
			if($_POST['send_as'] == 'EMAIL' || $_POST['send_as'] == 'BOTH')
			{
				foreach($subcriberDetails as $key=>$val)
					$insertedId_email = $dbObj->cgii("tbl_email_details",array('sms_email_id'=>$insertedId,'email_id'=>$val['nemail']),"");
			}

			$_SESSION['msg'] = "<span style='color:green;'>Transaction Successfully Done!!!!</span>";
			header("location:".SITEROOT."/admin/seller/deal/manage_deal.php");exit;
		}
	}
#-----------END As per GET info send Mail / SMS to users--------------#


#----------Success message=--------------#
	if($_SESSION['msg'])
	{
		$smarty->assign("msg", $_SESSION['msg']);
		$_SESSION['msg'] = NULL;
		unset($_SESSION['msg']);
	}
#--------------End-----------------------#

	$smarty->assign("inmenu","deal_management");
	$smarty->display(TEMPLATEDIR.'/admin/seller/deal/send_sms_email.tpl');
?>
