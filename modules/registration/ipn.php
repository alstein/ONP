<?php
include_once("../../include.php");

//variable passed to IPN notify URL
$get_email = urldecode($_GET['email']);
$get_fname = urldecode($_GET['fname']);
$get_lname = urldecode($_GET['lname']);
$get_pwd = urldecode(base64_decode($_GET['pwd']));
$get_buss_name = urldecode($_GET['buss_name']);
$get_addr = urldecode($_GET['addr']);
$get_city = urldecode($_GET['city']);
$get_stateid = urldecode($_GET['state']);
$get_countryid = urldecode($_GET['country']);
$get_postcode = urldecode($_GET['postcode']);
$get_weburl = urldecode($_GET['weburl']);
$get_phno = urldecode($_GET['phno']);
$get_subpack = urldecode($_GET['subpack']);

$get_payment_currency = urldecode($_GET['pay_curr']);
$get_payment_amount = urldecode($_GET['pay_amt']);
$get_receiver_email = urldecode($_GET['receiver_email']);

/*
Simple IPN processing script
based on code from the "PHP Toolkit" provided by PayPal
*/

//$url = 'https://www.paypal.com/cgi-bin/webscr';
//$url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';

//Get Merchant Account details for to set dynamic Paypal URL
//Get payment setting details
$query_paySett = "select * from tbl_payment_setting where id=1";
$res_paySett = mysql_query($query_paySett);
$row_paySett = mysql_fetch_assoc($res_paySett);
$numRows_paySett = @mysql_num_rows($res_paySett);

$merch_paypal_account = trim($row_paySett['paypal_account']);

$url = "";
if($row_paySett['paymentmode'] == 0)
{
	$url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
}else
{
	$url = 'https://www.paypal.com/cgi-bin/webscr';
}

$postdata = '';
foreach($_POST as $i => $v) {
   $postdata .= $i.'='.urlencode($v).'&';
}
$postdata .= 'cmd=_notify-validate';


$web = parse_url($url);
if ($web['scheme'] == 'https') { 
   $web['port'] = 443;  
   $ssl = 'ssl://'; 
} else { 
   $web['port'] = 80;
   $ssl = ''; 
}
$fp = @fsockopen($ssl.$web['host'], $web['port'], $errnum, $errstr, 30);

if (!$fp) { 
   echo $errnum.': '.$errstr;
} else {
   fputs($fp, "POST ".$web['path']." HTTP/1.1\r\n");
   fputs($fp, "Host: ".$web['host']."\r\n");
   fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
   fputs($fp, "Content-length: ".strlen($postdata)."\r\n");
   fputs($fp, "Connection: close\r\n\r\n");
   fputs($fp, $postdata . "\r\n\r\n");

   while(!feof($fp)) { 
      $info[] = @fgets($fp, 1024); 
   }
   fclose($fp);
   $info = implode(',', $info);
   if (eregi('VERIFIED', $info)) { 
      // yes valid, f.e. change payment status  

      // assign posted variables to local variables
      $item_name = $_POST['item_name'];
      $item_number = $_POST['item_number'];
      $payment_status = $_POST['payment_status'];
      $payment_amount = $_POST['mc_gross'];
      $payment_currency = $_POST['mc_currency'];
      $txn_id = $_POST['txn_id'];
      $receiver_email = $_POST['receiver_email'];
      $payer_email = $_POST['payer_email'];
      
      //payer billing address
      $address_street = $_POST['address_street'];
      $address_zip = $_POST['address_zip'];
      $first_name = $_POST['first_name'];
      $last_name = $_POST['last_name'];
      $address_country_code = $_POST['address_country_code'];
      $address_name = $_POST['address_name'];
      $address_country = $_POST['address_country'];
      $address_city = $_POST['address_city'];
      $address_state = $_POST['address_state'];

   // check the payment_status is Completed
   // check that txn_id has not been previously processed
   // check that receiver_email is your Primary PayPal email
   // check that payment_amount/payment_currency are correct
   // process payment

   //if(($payment_status == "Completed") && ($get_receiver_email == $receiver_email) && ($get_payment_amount == $payment_amount) && ($get_payment_currency == $payment_currency))
   if($_POST['txn_type']=="subscr_payment")
   {

	// check if transaction id(subscriber id) in databse $row	
	$chkres=$dbObj->customqry("select userid, paypal_subscr_id, subscription_pack_id from tbl_users where paypal_subscr_id=".$_POST['subscr_id'],"");
	$numrows=@mysql_num_rows($chkres);
	if($numrows==0) //user subscribe at first time
	{
		//insert data into user table as a seller OR usertypeid = 3
			$fullname = $get_fname." ".$get_lname;
			$username = $get_fname." ".$get_lname;

			$subsDate = date("Y-m-d H:i:s");

			//get selected package details using post field "subscription"
			$query_subsPack = "select * from tbl_subscription_package where id='".$get_subpack."'";
			$res_subsPack = mysql_query($query_subsPack);
			$row_subsPack = mysql_fetch_assoc($res_subsPack);
			$numRows_subsPack = @mysql_num_rows($res_subsPack);

			$expDate = date("Y-m-d H:i:s",strtotime('+'.$row_subsPack['pack_duration'].' day'));
			
			$fields = array("first_name","last_name","username","fullname",'password','email','usertypeid','signup_date','countryid','state_id','city', 'address1','postalcode','status','ip','business_name','business_webURL','contact_detail','subscription_pack_id','payment_verification','paypal_subscr_id','paypal_txn_id','last_subscription_date','last_expiration_date','subscribe_status');
			$values = array($get_fname,$get_lname,$username,$fullname,md5($get_pwd),$get_email,3,date("Y-m-d H:i:s"),$get_countryid,$get_stateid,$get_city,$get_addr,$get_postcode,"active",$_SERVER['REMOTE_ADDR'],$get_buss_name,$get_weburl,$get_phno,$get_subpack,'1',$_POST['subscr_id'],$txn_id,$subsDate,$expDate,'Subscribed');

			$resIns = $dbObj->cgi('tbl_users',$fields,$values,'');

			//Insert subscription details record
				$fields_subsDet = array("userid","subs_pack_id","subs_pack_name","subs_pack_allow_deals_per_month",'subs_pack_price','subs_pack_cost_per_success_deal','subs_pack_cost_per_success_deal_percent_doller','subs_pack_cost_sms_deal','subs_pack_duration','paypal_subscr_id', 'paypal_txn_id','subscription_date','expiration_date','response_data','payer_first_name','payer_last_name','payer_address_name','payer_address_street','payer_address_zip','payer_address_country_code','payer_address_country','payer_address_state','payer_address_city');
				$values_subsDet = array($resIns,$get_subpack,$row_subsPack['pack_name'],$row_subsPack['allow_deals_per_month'],$row_subsPack['pack_price'],$row_subsPack['cost_per_success_deal'],$row_subsPack['cost_per_success_deal_percent_doller'],$row_subsPack['cost_sms_deal'],$row_subsPack['pack_duration'],$_POST['subscr_id'],$txn_id,$subsDate,$expDate,$postdata,$first_name,$last_name,$address_name,$address_street,$address_zip,$address_country_code,$address_country,$address_state,$address_city);
	
				$resSubsDetIns = $dbObj->cgi('tbl_user_subscription_details',$fields_subsDet,$values_subsDet,'');
			
			//update last_subs_id of user table
				@mysql_query("update tbl_users set last_subs_id='".$resSubsDetIns."', added_by='".$resIns."' where userid=".$resIns."");


			//send email to user after registration

			$verifycode=md5($resIns * 32767);
			$rs=$dbObj->cupdt("tbl_users", "activationcode", $verifycode, "userid", $resIns, "");
			$rs=$dbObj->cgs("tbl_users", "", "userid", $resIns, "", "", "");
			$user = @mysql_fetch_assoc($rs);

			$email_query = "select * from mast_emails where emailid=56";

			$email_rs = @mysql_query($email_query);
			$email_row = @mysql_fetch_object($email_rs);
			$email_subject = str_replace("[[SITETITLE]]", SITETITLE, $email_row->subject);
			$email_subject = str_replace("[[name]]",$fullname,$email_subject);

			$email_message = file_get_contents(ABSPATH."/email/email.html");

			$attach = SITEROOT."/registration/conformation/".$user['activationcode']."/".$resIns;
			$link = "<a href='{$attach}' target='_blank'>{$attach}</a>";

			$email_message = str_replace("[[SITEROOT]]", SITEROOT, $email_message);
			$email_message = str_replace("[[EMAIL_HEADING]]",$email_subject,$email_message);
			$email_message = str_replace("[[EMAIL_CONTENT]]",html_entity_decode($email_row->message),$email_message);

			$email_message = str_replace("[[SITETITLE]]", SITETITLE, $email_message);
			$email_message = str_replace("[[SITEROOT]]",SITEROOT,$email_message);
			$email_message = str_replace("[[name]]",$fullname,$email_message);
			$email_message = str_replace("[[fname]]",$get_fname,$email_message);
			$email_message = str_replace("[[lname]]",$get_lname,$email_message);
			$email_message = str_replace("[[email]]",$get_email,$email_message);
			$email_message = str_replace("[[password]]",$get_pwd,$email_message);
			$email_message = str_replace("[[phone_no]]",$get_phno,$email_message);
			$email_message = str_replace("[[TODAY]]", date("F dS, Y",time()), $email_message);
			$email_message = str_replace("[[link]]",$link, $email_message);

			$from = SITE_EMAIL;
			@mail($get_email,$email_subject,$email_message,"From: $from\nContent-Type: text/html; charset=iso-8859-1");
			//echo "<pre>To ==".$get_email."<br>From ==".$from."<br>Sub ==".$email_subject."<br>Msg ==".$email_message."<br></pre>"; exit;

			//"You have successfully registered, please check your email and verify your account!!!!";

	}else //user subscribe at recurring time
	{
		 $row_Usrdata = mysql_fetch_assoc($chkres);

		//Update data into user table as a seller OR usertypeid = 3

			$subsDate = date("Y-m-d H:i:s");

			//get selected package details using post field "subscription"
			$query_subsPack = "select * from tbl_subscription_package where id='".$row_Usrdata['subscription_pack_id']."'";
			$res_subsPack = mysql_query($query_subsPack);
			$row_subsPack = mysql_fetch_assoc($res_subsPack);
			$numRows_subsPack = @mysql_num_rows($res_subsPack);

			$expDate = date("Y-m-d H:i:s",strtotime('+'.$row_subsPack['pack_duration'].' day'));

			//Insert subscription details record
				$fields_subsDet = array("userid","subs_pack_id","subs_pack_name","subs_pack_allow_deals_per_month",'subs_pack_price','subs_pack_cost_per_success_deal','subs_pack_cost_per_success_deal_percent_doller','subs_pack_cost_sms_deal','subs_pack_duration','paypal_subscr_id', 'paypal_txn_id','subscription_date','expiration_date','response_data','payer_first_name','payer_last_name','payer_address_name','payer_address_street','payer_address_zip','payer_address_country_code','payer_address_country','payer_address_state','payer_address_city');
				$values_subsDet = array($row_Usrdata['userid'],$get_subpack,$row_subsPack['pack_name'],$row_subsPack['allow_deals_per_month'],$row_subsPack['pack_price'],$row_subsPack['cost_per_success_deal'],$row_subsPack['cost_per_success_deal_percent_doller'],$row_subsPack['cost_sms_deal'],$row_subsPack['pack_duration'],$_POST['subscr_id'],$txn_id,$subsDate,$expDate,$postdata,$first_name,$last_name,$address_name,$address_street,$address_zip,$address_country_code,$address_country,$address_state,$address_city);
	
				$resSubsDetIns = $dbObj->cgi('tbl_user_subscription_details',$fields_subsDet,$values_subsDet,'');
			
			//update last_subs_id, last_exp_date, etc.... of user table
				@mysql_query("update tbl_users set last_subs_id='".$resSubsDetIns."', paypal_txn_id='".$txn_id."', last_subscription_date='".$subsDate."', last_expiration_date='".$expDate."' where userid=".$row_Usrdata['userid']."");

	} //end else of if($numrows==0)
    } //end if($_POST['txn_type']=="subscr_payment")

	$from="testteam.testmail@gmail.com";
	// log for manual investigation
	@mail("g.sandeep@agiletechnosys.com","Seller payment IPN status of transaction is done",$postdata,"From: $from\nContent-Type: text/html; charset=iso-8859-1");

   } else {
      // invalid, log error or something
      // log for manual investigation

	//user subscription package is expired then send mail to him.
	if($_POST['txn_type']=="subscr_payment")
	{
		// check if transaction id(subscriber id) in databse $row	
		$chkres=$dbObj->customqry("select userid, fullname,first_name,last_name, paypal_subscr_id, subscription_pack_id from tbl_users where paypal_subscr_id=".$_POST['subscr_id'],"");
		$numrows=@mysql_num_rows($chkres);
		if($numrows==0) //user subscribe at first time
		{

		}else
		{

		 	$row_Usrdata = mysql_fetch_assoc($chkres);

			//Update data into user table as a seller OR usertypeid = 3

			$expDate = date("Y-m-d H:i:s");

			//update subscribe_status='Expired', last_exp_date, etc.... of user table
			@mysql_query("update tbl_users set subscribe_status='Expired', paypal_txn_id='".$txn_id."', last_expiration_date='".$expDate."' where userid=".$row_Usrdata['userid']."");


			$email_query = "select * from mast_emails where emailid=59";

			$email_rs = @mysql_query($email_query);
			$email_row = @mysql_fetch_object($email_rs);
			$email_subject = str_replace("[[SITETITLE]]", SITETITLE, $email_row->subject);
			$email_subject = str_replace("[[name]]",$fullname,$email_subject);

			$email_message = file_get_contents(ABSPATH."/email/email.html");

			$attach = SITEROOT."/signin?st=seller";
			$link = "<a href='{$attach}' target='_blank'>{$attach}</a>";

			$email_message = str_replace("[[SITEROOT]]", SITEROOT, $email_message);
			$email_message = str_replace("[[EMAIL_HEADING]]",$email_subject,$email_message);
			$email_message = str_replace("[[EMAIL_CONTENT]]",html_entity_decode($email_row->message),$email_message);

			$email_message = str_replace("[[SITETITLE]]", SITETITLE, $email_message);
			$email_message = str_replace("[[SITEROOT]]",SITEROOT,$email_message);
			$email_message = str_replace("[[name]]",$row_Usrdata['fullname'],$email_message);
			$email_message = str_replace("[[fname]]",$row_Usrdata['first_name'],$email_message);
			$email_message = str_replace("[[lname]]",$row_Usrdata['last_name'],$email_message);
			$email_message = str_replace("[[TODAY]]", date("F dS, Y",time()), $email_message);
			$email_message = str_replace("[[link]]",$link, $email_message);

			$from = SITE_EMAIL;
			@mail($row_Usrdata['email'],$email_subject,$email_message,"From: $from\nContent-Type: text/html; charset=iso-8859-1");
			//echo "<pre>To ==".$row_Usrdata['email']."<br>From ==".$from."<br>Sub ==".$email_subject."<br>Msg ==".$email_message."<br></pre>"; exit;

		}
	}


	$from="testteam.testmail@gmail.com";
	// log for manual investigation
	@mail("g.sandeep@agiletechnosys.com","Seller payment IPN status of transaction is failed",$postdata,"From: $from\nContent-Type: text/html; charset=iso-8859-1");
   }
}
?>