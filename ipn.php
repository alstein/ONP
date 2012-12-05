<?php
session_start();
include_once("include.php");

// assign posted variables to local variables
$item_name = $_POST['item_name'];
$item_number = $_POST['item_number'];
$get_payment_amount = $_GET['payment_amount'];
$get_payment_currency = $_GET['payment_currency'];
$get_receiver_email = $_POST['receiver_email'];
// assign posted variables to local variables

$pay_result = $dbObj->customqry("select * from tbl_payment_setting","");

$pay_row = @mysql_fetch_assoc($pay_result);


//Get Merchant Account details for to set dynamic Paypal URL


if($pay_row['paypal_account']=="s.sank_1332229646_biz@agiletechnosys.com")
{
   $url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
}else{
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

	while (!feof($fp)) {
	$info[] = @fgets($fp, 1024); 
	}

 	 fclose($fp);
	 $info = implode(',', $info);
	$pay_unique = "US".time();
	if (eregi('VERIFIED', $info)) {

				// check the payment_status is Completed
				// check that txn_id has not been previously processed
				// check that receiver_email is your Primary PayPal email
				// check that payment_amount/payment_currency are correct
				// process payment
				$receiver_email = $_POST['receiver_email'];
				$payment_amount = $_POST['mc_gross'];
				$payment_currency = $_POST['mc_currency'];
				$payment_status = $_POST['payment_status'];

				$str=$payment_status."<br>".$get_receiver_email."<br>".$receiver_email."<br>".$get_payment_amount."<br>".$payment_amount."<br>".$get_payment_currency."<br>".$payment_currency;

				//@mail("testing2012.testing2012@gmail.com","IPN status of transaction string",$str,"From: $from\nContent-Type: text/html; charset=iso-8859-1");

				/*********************** Start of second loop *******************************************/
				if($_POST['txn_type']=="web_accept" && ($payment_status == "Completed") && ($get_receiver_email == $receiver_email) && ($get_payment_amount == $payment_amount) && ($get_payment_currency == $payment_currency))
				{									
							$c=$_POST['custom'];
							$cust=str_replace("+","",$c);
							$custom1=explode("|",$cust);
									
										$deal_unique_id=$custom1[0];
										$buyer_user_id=$custom1[1];
										$merchant_user_id=$custom1[2];			
										$coupan_id="NE-".time();
										//insert in order table
											
										//$fl=array("deal_id","merchant_id","buyer_id","transaction_id","txn_type","payment_type","deal_price","payment_done","buy_date","coupan_id");
										//$vl=array($deal_unique_id,$merchant_user_id,$buyer_user_id,$_POST['txn_id'],$_POST['txn_type'],"paypal",$payment_amount,"yes",date("Y-m-d H:i:s"),$coupan_id);
										

										$fl=array("pay_unique_id","encrypt_unique_id","deal_id","user_id","transaction_id","deal_quantity","deal_price","payment_done","TxType","paymethod","buy_date");
										$vl=array($pay_unique,md5($pay_unique),$deal_unique_id,$buyer_user_id,$_POST['txn_id'],$_POST['quantity'],$payment_amount,"yes",$_POST['txn_type'],"paypal",date("Y-m-d H:i:s"));
										$tbl_deal_payment_id=$dbObj->cgi("tbl_deal_payment", $fl, $vl, $prn);

										

										if($tbl_deal_payment_id > 0)

										{

											for($l = 0;$l < $_POST['quantity'];$l++)

											{

												$kl = $l+1;

												$uniquebar = rand(1, 10000000);

												$uniqueid = "#".$uniquebar;

												$ins_array = array("deal_id"=>$deal_unique_id,

															"user_id"=>$buyer_user_id,

															"pay_id"=>$tbl_deal_payment_id,

															"pay_unique_id"=>$pay_unique,

															"coupon_id"=>$pay_unique."-".$kl,

															"barcode_id"=>$uniqueid,

															"bar_code"=>$uniquebar

														);

												$dbObj->cgii("tbl_deal_payment_unique",$ins_array,"");

											}

										}

	//merchant name
										$sf1=array("first_name","last_name","email");	
										$wf1=array("userid");
										$wv1=array($merchant_user_id);				
										$mer_res=$dbObj->cgs("tbl_users", $sf1, $wf1, $wv1, $ob, $ot, $prn);
										$mer_row=mysql_fetch_assoc($mer_res);
										$mer_name=$mer_row['first_name']." ".$mer_row['last_name'];
	//merchant name
	
//deal name
										$sf2=array("deal_title","deal_image");	
										$wf2=array("deal_unique_id");
										$wv2=array($deal_unique_id);				
										$deal_res=$dbObj->cgs("tbl_deals", $sf2, $wf2, $wv2, $ob, $ot, $prn);
										$deal_row=mysql_fetch_assoc($deal_res);
										$deal_name=$deal_row['deal_title'];

//deal name

	//buyer name
										$sf3=array("first_name","last_name","email");	
										$wf3=array("userid");
										$wv3=array($buyer_user_id);				
										$buy_res=$dbObj->cgs("tbl_users", $sf3, $wf3, $wv3, $ob, $ot, $prn);
										$buy_row=mysql_fetch_assoc($buy_res);
										$buy_name=$buy_row['first_name']." ".$buy_row['last_name'];
	//buyer name


//insert into tbl_activity
// 										$activity_message=$deal_name."<br />". $buy_name ."bought this deal <br/>";
// 										$fl=array("msg","vault","timestamp","uid","fid");
// 										$vl=array($activity_message,$deal_row['deal_image'],date("Y-m-d H:i:s"),$buyer_user_id,$merchant_user_id);
// 										$dbObj->cgi("tbl_activity", $fl, $vl, $prn);
//insert into tbl_activity


	//send mail to merchant
										/*$email_query = "select * from mast_emails where emailid=74";
										$email_rs = mysql_query($email_query);
										$email_row = mysql_fetch_object($email_rs);
										$email_message = file_get_contents(ABSPATH."/email/email.html");
										$email_subject=str_replace('[[BUYER_NAME]]',$buy_name, $email_row->subject);
					
										$email_message = str_replace("[[EMAIL_CONTENT]]",html_entity_decode($email_row->message), $email_message);
										$email_message = str_replace("[[BUYER_NAME]]",ucfirst($buy_name),$email_message);
										$email_message = str_replace("[[MERCHANT_NAME]]",ucfirst($mer_name),$email_message);
										$email_message = str_replace("[[DEAL_NAME]]",ucfirst($deal_name),$email_message);
										$email_message = str_replace("[[EMAIL_HEADING]]", $email_subject,$email_message);
										//$email_message  = ($email_row->message);
										$email_message = str_replace("[[SITETITLE]]", SITETITLE, $email_message);
										$email_message = str_replace("[[TODAYS_DATE]]", date("Y-m-d H:i:s"), $email_message);
										$email_message = str_replace("[[SITEROOT]]", SITEROOT, $email_message);


										$from = SITE_EMAIL;
										$ssmail = @mail($mer_row['email'],$email_subject,$email_message,"From: $from\nContent-Type: text/html; charset=iso-8859-1");*/
	
	//send mail to merchant
						

	//send mail to customer
										$email_query = "select * from mast_emails where emailid=75";
										$email_rs = mysql_query($email_query);
										$email_row = mysql_fetch_object($email_rs);
										$email_message = file_get_contents(ABSPATH."/email/email.html");
										$email_subject=str_replace('[[BUYER_NAME]]',$buy_name, $email_row->subject);
					
										$email_message = str_replace("[[EMAIL_CONTENT]]",html_entity_decode($email_row->message), $email_message);
										$email_message = str_replace("[[BUYER_NAME]]",ucfirst($buy_name),$email_message);
										$email_message = str_replace("[[MERCHANT_NAME]]",ucfirst($mer_name),$email_message);
										$email_message = str_replace("[[DEAL_NAME]]",ucfirst($deal_name),$email_message);
										
										$email_message = str_replace("[[EMAIL_HEADING]]", $email_subject,$email_message);
										//$email_message  = ($email_row->message);
										$email_message = str_replace("[[SITETITLE]]", SITETITLE, $email_message);
										$email_message = str_replace("[[TODAYS_DATE]]", date("Y-m-d H:i:s"), $email_message);
										$email_message = str_replace("[[SITEROOT]]", SITEROOT, $email_message);



										$from = SITE_EMAIL;
										$ssmail = @mail($buy_row['email'],$email_subject,$email_message,"From: $from\nContent-Type: text/html; charset=iso-8859-1");


	
	//send mail to customer



				
				}else{
										
										$c=$_POST['custom'];
										$cust=str_replace("+","",$c);
										$custom1=explode("|",$cust);
									
										$deal_unique_id=$custom1[0];
										$buyer_user_id=$custom1[1];
										$merchant_user_id=$custom1[2];			
										//insert in order table
											
										//$fl=array("deal_id","merchant_id","buyer_id","transaction_id","txn_type","payment_type","deal_price","payment_done","buy_date","coupan_id");
										//$vl=array($deal_unique_id,$merchant_user_id,$buyer_user_id,$_POST['txn_id'],$_POST['txn_type'],"paypal",$payment_amount,"no",date("Y-m-d H:i:s"),$coupan_id);
										//$dbObj->cgi("tbl_deal_payments", $fl, $vl, $prn);


										$fl=array("pay_unique_id","encrypt_unique_id","deal_id","user_id","transaction_id","deal_quantity","deal_price","payment_done","TxType","paymethod","buy_date");
										$vl=array($pay_unique,md5($pay_unique),$deal_unique_id,$buyer_user_id,$_POST['txn_id'],$_POST['quantity'],$payment_amount,"no",$_POST['txn_type'],"paypal",date("Y-m-d H:i:s"));
										$tbl_deal_payment_id=$dbObj->cgi("tbl_deal_payment", $fl, $vl, $prn);

					$select_offer_deal=$dbObj->customqry("select * from tbl_deals where deal_unique_id='".$deal_unique_id."'","");
					$res_offer_deal=@mysql_fetch_assoc($select_offer_deal);
					$dealname=$res_offer_deal['deal_title'];
					$discount=$res_offer_deal['discount_in_per'];
					$select_user=$dbObj->customqry("select u.fullname,u.userid from tbl_users u  where userid='".$buyer_user_id."'","");
					$res_user=@mysql_fetch_assoc($select_user);
					$fullname1=$res_user['fullname'];
					
					$select_merchant=$dbObj->customqry("select u.business_name,u.userid from tbl_users u   where userid='".$res_offer_deal['merchant_id']."'","");
					$res_merchant=@mysql_fetch_assoc($select_merchant);
					$business_name=$res_merchant['business_name'];
					$link_deal=SITEROOT."/buy/".$deal_unique_id;
					$msg=ucfirst($fullname1)." bought an offer"."<div style='margin-top:6px;text-align:left;color:#044EA2'><br />$discount% Off On <a href=$link_deal style='color:#044EA2'>".ucfirst($dealname)."</a></div>";
					$insert_thinking=$dbObj->customqry("insert into tbl_activity(msg,vault_t,vault,timestamp,wall,uid,fid,parent_id,deal_id)values('".$msg."','buy_deal','".$res_offer_deal['deal_image']."',Now(),'1','".$res_user['userid']."','".$res_merchant['userid']."','','') ","");
										

										if($tbl_deal_payment_id > 0)

										{

											for($l = 0;$l < $_POST['quantity'];$l++)

											{

												$kl = $l+1;

												$uniquebar = rand(1, 10000000);

												$uniqueid = "#".$uniquebar;

												$ins_array = array("deal_id"=>$deal_unique_id,

															"user_id"=>$buyer_user_id,

															"pay_id"=>$tbl_deal_payment_id,

															"pay_unique_id"=>$pay_unique,

															"coupon_id"=>$pay_unique."-".$kl,

															"barcode_id"=>$uniqueid,

															"bar_code"=>$uniquebar

														);

												$dbObj->cgii("tbl_deal_payment_unique",$ins_array,"");

											}

										}





	//merchant name
										$sf1=array("first_name","last_name","email");	
										$wf1=array("userid");
										$wv1=array($merchant_user_id);				
										$mer_res=$dbObj->cgs("tbl_users", $sf1, $wf1, $wv1, $ob, $ot, $prn);
										$mer_row=@mysql_fetch_assoc($mer_res);
										$mer_name=$mer_row['first_name']." ".$mer_row['last_name'];
										$mer_email=$mer_row['email'];
	//merchant name
	

//deal name
										$sf2=array("deal_title");	
										$wf2=array("deal_unique_id");
										$wv2=array($deal_unique_id);				
										$deal_res=$dbObj->cgs("tbl_deals", $sf2, $wf2, $wv2, $ob, $ot, $prn);
										$deal_row=mysql_fetch_assoc($deal_res);
										$deal_name=$deal_row['deal_title'];
//deal name



	//buyer name
										$sf3=array("first_name","last_name","email");	
										$wf3=array("userid");
										$wv3=array($buyer_user_id);				
										$buy_res=$dbObj->cgs("tbl_users", $sf3, $wf3, $wv3, $ob, $ot, $prn);
										$buy_row=mysql_fetch_assoc($buy_res);
										$buy_name=$buy_row['first_name']." ".$buy_row['last_name'];
	//buyer name

//insert into tbl_activity
// 										$activity_message=$deal_name."<br />". $buy_name ."bought this deal <br/>";
// 										$fl=array("msg","vault","timestamp","uid","fid");
// 										$vl=array($activity_message,$deal_row['deal_image'],date("Y-m-d H:i:s"),$buyer_user_id,$merchant_user_id);
// 										$dbObj->cgi("tbl_activity", $fl, $vl, $prn);
//insert into tbl_activity


	//send mail to merchant
										/*$email_query = "select * from mast_emails where emailid=74";
										$email_rs = mysql_query($email_query);
										$email_row = mysql_fetch_object($email_rs);
										$email_message = file_get_contents(ABSPATH."/email/email.html");
										$email_subject=str_replace('[[BUYER_NAME]]',$buy_name, $email_row->subject);
					
										$email_message = str_replace("[[EMAIL_CONTENT]]",html_entity_decode($email_row->message), $email_message);
										$email_message = str_replace("[[BUYER_NAME]]",ucfirst($buy_name),$email_message);
										$email_message = str_replace("[[MERCHANT_NAME]]",ucfirst($mer_name),$email_message);
										$email_message = str_replace("[[DEAL_NAME]]",ucfirst($deal_name),$email_message);
										
										$email_message = str_replace("[[EMAIL_HEADING]]", $email_subject,$email_message);
										//$email_message  = ($email_row->message);
										$email_message = str_replace("[[SITETITLE]]", SITETITLE, $email_message);
										$email_message = str_replace("[[TODAYS_DATE]]", date("Y-m-d H:i:s"), $email_message);
										$email_message = str_replace("[[SITEROOT]]", SITEROOT, $email_message);



										$from = SITE_EMAIL;
										$ssmail = @mail($mer_row['email'],$email_subject,$email_message,"From: $from\nContent-Type: text/html; charset=iso-8859-1");*/


	
	//send mail to merchant




	//send mail to customer
										$email_query = "select * from mast_emails where emailid=75";
										$email_rs = mysql_query($email_query);
										$email_row = mysql_fetch_object($email_rs);
										$email_message = file_get_contents(ABSPATH."/email/email.html");
										$email_subject=str_replace('[[BUYER_NAME]]',$buy_name, $email_row->subject);
					
										$email_message = str_replace("[[EMAIL_CONTENT]]",html_entity_decode($email_row->message), $email_message);
										$email_message = str_replace("[[BUYER_NAME]]",ucfirst($buy_name),$email_message);
										$email_message = str_replace("[[MERCHANT_NAME]]",ucfirst($mer_name),$email_message);
										$email_message = str_replace("[[DEAL_NAME]]",ucfirst($deal_name),$email_message);
										
										$email_message = str_replace("[[EMAIL_HEADING]]", $email_subject,$email_message);
										//$email_message  = ($email_row->message);
										$email_message = str_replace("[[SITETITLE]]", SITETITLE, $email_message);
										$email_message = str_replace("[[TODAYS_DATE]]", date("Y-m-d H:i:s"), $email_message);
										$email_message = str_replace("[[SITEROOT]]", SITEROOT, $email_message);



										$from = SITE_EMAIL;
										$ssmail = @mail($buy_row['email'],$email_subject,$email_message,"From: $from\nContent-Type: text/html; charset=iso-8859-1");


	
	//send mail to customer








				}
				
				/*********************** End of second loop *******************************************/
				
				
	}
	else {
			
			//$from="testing2012.testing2012@gmail.com";
			// log for manual investigation
			//@mail("d.ravindra@agiletechnosys.com","IPN status of transaction failed4",$req,"From: $from\nContent-Type: text/html; charset=iso-8859-1");
	}
}

?>
