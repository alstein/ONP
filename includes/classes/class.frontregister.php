<?php
class frontregister {

	function addNewUser($array)
	{
		global $dbObj;
	
		if((strlen(trim($array["email"])) > 0) && (strlen(trim($array["password"])) > 0) && (strlen(trim($array["first_name"])) > 0) && (strlen(trim($array["last_name"])) > 0))
		{
			//check is email id is already exist or not
			$cnd = "email='".trim($array["email"])."' and fb_user_id = 0 and twitter_uid = 0 and usertypeid = 2";
			$rs = $dbObj->gj("tbl_users","email", $cnd, "", "", "", "", "");
			if($rs == 'n')
			{
				$fullname = $array["first_name"]." ".$array["last_name"];
				$username = $array["first_name"]."_".$array["last_name"];
				
				$fields = array("first_name","last_name","username","fullname",'password','email','usertypeid','signup_date','countryid','state_id','city', 'address1','postalcode','status','ip', 'contact_detail');
				$values = array($array["first_name"],$array["last_name"],$username,$fullname,md5($array["password"]),$array["email"],2,date("Y-m-d H:i:s"),$array["countryid"],$array["state"],$array["city"],$array["address"],$array["postalcode"],"active",$_SERVER['REMOTE_ADDR'],$array["contact_detail"]);
	
				$resIns = $dbObj->cgi('tbl_users',$fields,$values,'');
	
	// 			$_SESSION['csUserLgn'] 		= "TRUE";
	// 			$_SESSION['csUserId']		= $resIns;
	// 			$_SESSION['csFullName']		= $fullname;
	// 			$_SESSION['csUserEmail']		= $array["email"];
	// 			$_SESSION['csUserTypeId'] 	= 2;

				/////////////////////////////////////////////////////////////
				//START subscribe to newsletter as well
				//check is email id is already exist or not
				$cnd = "nemail='".trim($array["email"])."' and city='".trim($array["city"])."'";
				$rs = $dbObj->gj("tbl_newsletter","nemail", $cnd, "", "", "", "", "");
				if($rs == 'n')
				{
					$fields = array("name", "nemail", "city", "ndate", "contact_detail", "status" );
					$values = array( $fullname, $array["email"], $array["city"], date("Y-m-d H:i:s"), $array["contact_detail"], '1' );
					$prn = "";
					$result = $dbObj ->cgi('tbl_newsletter' , $fields , $values , $prn);
				}/*else
				{
					$_SESSION['msg'] = "You have already subscribed using ".$array["email"]." email id";
					return "error";
				}*/
				//End subscribe to newsletter as well
				/////////////////////////////////////////////////////////////
	
				//send email to user after registration
	
				$verifycode=md5($resIns * 32767);
				$rs=$dbObj->cupdt("tbl_users", "activationcode", $verifycode, "userid", $resIns, "");
				$rs=$dbObj->cgs("tbl_users", "", "userid", $resIns, "", "", "");
				$user = @mysql_fetch_assoc($rs);
	
				$email_query = "select * from mast_emails where emailid=16";
	
				$email_rs = @mysql_query($email_query);
				$email_row = @mysql_fetch_object($email_rs);
				$email_subject = str_replace("[[SITETITLE]]", SITETITLE, $email_row->subject);
				$email_subject = str_replace("[[name]]",$fullname,$email_subject);
	
				$email_message = file_get_contents(ABSPATH."/email/email.html");
	
				$attach = SITEROOT."/registration/conformation/".$user['activationcode']."/".$resIns;
				$link = "<a href='{$attach}'>{$attach}</a>";
	
				$email_message = str_replace("[[SITEROOT]]", SITEROOT, $email_message);
				$email_message = str_replace("[[EMAIL_HEADING]]",$email_subject,$email_message);
				$email_message = str_replace("[[EMAIL_CONTENT]]",html_entity_decode($email_row->message),$email_message);
				
				$date1 = date("d-m-Y");
				$email_message = str_replace("[[TODAYS_DATE]]",$date1, $email_message);
	
				$email_message = str_replace("[[SITETITLE]]", SITETITLE, $email_message);
				$email_message = str_replace("[[SITEROOT]]",SITEROOT,$email_message);
				$email_message = str_replace("[[name]]",$fullname,$email_message);
				$email_message = str_replace("[[fname]]",$array["first_name"],$email_message);
				$email_message = str_replace("[[lname]]",$array["last_name"],$email_message);
				$email_message = str_replace("[[email]]",$array["email"],$email_message);
				$email_message = str_replace("[[password]]",$array["password"],$email_message);
				$email_message = str_replace("[[phone_no]]",$array["contact_detail"],$email_message);
				$email_message = str_replace("[[TODAYS_DATE]]",date("d-m-Y"), $email_message);
				$email_message = str_replace("[[link]]",$link, $email_message);
	
				$from = SITE_EMAIL;
				@mail($array["email"],$email_subject,$email_message,"From: $from\nContent-Type: text/html; charset=iso-8859-1");
				//echo "<pre>To ==".$array["email"]."<br>From ==".$from."<br>Sub ==".$email_subject."<br>Msg ==".$email_message."<br></pre>"; exit;
	
				$_SESSION['msg_succ'] = "You have successfully registered, please check your email and verify your account!!!!";
				header("Location:".SITEROOT."/buyer_regsuccess");
				exit;
			}else
			{
				$_SESSION['msg'] = "This email address is already exists!!!!";
				return "error";
			}
		}else
		{
			$_SESSION['msg'] = "Please provide required information like email, password, first name and last name!!!!";
			return "error";
		}

	} // end function

	function addNewSeller($array)
	{
		global $dbObj;
	
		if((strlen(trim($array["email"])) > 0) && (strlen(trim($array["password"])) > 0) && (strlen(trim($array["first_name"])) > 0) && (strlen(trim($array["last_name"])) > 0))
		{
			//check is email id is already exist or not
			$cnd = "email='".trim($array["email"])."' and fb_user_id = 0 and twitter_uid = 0 and usertypeid = 3"; //usertypeid = 3 indicates seller user.
			$rs = $dbObj->gj("tbl_users","email", $cnd, "", "", "", "", "");
			if($rs == 'n')
			{
				/*$fullname = $array["first_name"]." ".$array["last_name"];
				$username = $array["first_name"]."_".$array["last_name"];
				
				$fields = array("first_name","last_name","username","fullname",'password','email','usertypeid','signup_date','countryid','city', 'address1','postalcode','status','ip','business_name','business_webURL','contact_detail','subscription_pack_id','payment_verification');
				$values = array($array["first_name"],$array["last_name"],$username,$fullname,md5($array["password"]),$array["email"],3,date("Y-m-d H:i:s"),$array["countryid"],$array["city"],$array["address"],$array["postalcode"],"active",$_SERVER['REMOTE_ADDR'],$array["business_name"],$array["business_webURL"],$array["contact_detail"],$array['subscription'],'1');

				$resIns = $dbObj->cgi('tbl_users',$fields,$values,'');

	// 			$_SESSION['csUserLgn'] 		= "TRUE";
	// 			$_SESSION['csUserId']		= $resIns;
	// 			$_SESSION['csFullName']		= $fullname;
	// 			$_SESSION['csUserEmail']		= $array["email"];
	// 			$_SESSION['csUserTypeId'] 	= 2;
	
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
				$email_message = str_replace("[[fname]]",$array["first_name"],$email_message);
				$email_message = str_replace("[[lname]]",$array["last_name"],$email_message);
				$email_message = str_replace("[[email]]",$array["email"],$email_message);
				$email_message = str_replace("[[password]]",$array["password"],$email_message);
				$email_message = str_replace("[[phone_no]]",$array["phone_no"],$email_message);
				$email_message = str_replace("[[TODAY]]", date("F dS, Y",time()), $email_message);
				$email_message = str_replace("[[link]]",$link, $email_message);
	
				$from = SITE_EMAIL;
				@mail($array["email"],$email_subject,$email_message,"From: $from\nContent-Type: text/html; charset=iso-8859-1");
				//echo "<pre>To ==".$array["email"]."<br>From ==".$from."<br>Sub ==".$email_subject."<br>Msg ==".$email_message."<br></pre>"; exit;
	
				$_SESSION['msg_succ'] = "You have successfully registered, please check your email and verify your account!!!!";
				header("Location:".SITEROOT."/seller_regsuccess");
				exit;*/
	
				////////////////////////////////////////////////////////
				//START code for Paypal with recursive payment method

				//Get payment setting details
			        $query_paySett = "select * from tbl_payment_setting where id=1";
                                $res_paySett = @mysql_query($query_paySett);
                                $row_paySett = @mysql_fetch_assoc($res_paySett);
                                $numRows_paySett = @mysql_num_rows($res_paySett);
				
                                $merch_paypal_account = trim($row_paySett['paypal_account']);

				$form_action = "";
				if($row_paySett['paymentmode'] == 0)
				{
					$form_action = "https://www.sandbox.paypal.com/cgi-bin/webscr";
				}else
				{
					$form_action = "https://www.paypal.com/cgi-bin/webscr";
				}

				//Seller information
				$fullname = $array["first_name"]." ".$array["last_name"];

				//get selected package details using post field "subscription"
			        $query_subsPack = "select * from tbl_subscription_package where id='".$array['subscription']."'";
                                $res_subsPack = mysql_query($query_subsPack);
                                $row_subsPack = mysql_fetch_assoc($res_subsPack);
                                $numRows_subsPack = @mysql_num_rows($res_subsPack);
				
		?>
				<form action="<?php echo $form_action; ?>" method="post" id="payPalForm" name="payPalForm">
			
					<input type="hidden" name="cmd" value="_xclick-subscriptions">
			
					<input type="hidden" name="a3" value="<?php echo $row_subsPack['pack_price']; ?>"> <!-- pack price --> 
					<input type="hidden" name="p3" value="<?php echo $row_subsPack['pack_duration']; ?>"> <!-- pack length / duration (def 1 month)--> 
					<input type="hidden" name="t3" value="M">
					<input type="hidden" name="src" value="1">
					<input type="hidden" name="sra" value="1">
			
					<input type="hidden" name="item_number" id="item_number" value="">
				
					<input type="hidden" name="quantity" value="1" />
			
					<input type="hidden" name="item_name" value="Seller Subscription via Paypal on Usortd">
			
					<input type="hidden" name="shipping" value="0.00" />
			
					<input type="hidden" name="shipping2" value="0.00" />
			
					<input type="hidden" name="handling" value="0.00" />					
			
					<input type="hidden" name="business" value="<?php echo $merch_paypal_account; ?>" />
			
					<input type="hidden" name="currency_code" value="GBP" />
			
					<input type="hidden" name="custom" value="<?php echo $fullname ."|". $array["first_name"] ."|". $array["last_name"] ."|".   $array["email"]; ?>" />
			
					<input type="hidden" name="no_shipping" value="1" />
			
					<input type="hidden" name="no_note" value="0" />
			
					<input type="hidden" name="return" value="<?php echo SITEROOT;?>/seller_regsuccess" />
			
					<input type="hidden" name="notify_url" value="<?php echo SITEROOT;?>/modules/registration/ipn.php?email=<?php echo urlencode($array["email"]);?>&fname=<?php echo urlencode($array["first_name"]);?>&lname=<?php echo urlencode($array["last_name"]);?>&pwd=<?php echo urlencode(base64_encode($array["password"]));?>&buss_name=<?php echo urlencode($array["business_name"]);?>&addr=<?php echo urlencode($array["address"]);?>&city=<?php echo urlencode($array["city"]);?>&state=<?php echo urlencode($array["state"]);?>&country=<?php echo urlencode($array["countryid"]);?>&postcode=<?php echo urlencode($array["postalcode"]);?>&weburl=<?php echo urlencode($array["business_webURL"]);?>&phno=<?php echo urlencode($array["contact_detail"]);?>&subpack=<?php echo urlencode($array["subscription"]);?>&pay_curr=GBP&pay_amt=<?php echo $row_subsPack['pack_price'];?>&receiver_email=<?php echo $merch_paypal_account;?>" />
			
					<input type="hidden" name="rm" value="2" />
			
					<input type="hidden" name="cancel_return" value="<?php echo SITEROOT;?>/seller_regfailure" />
			
				</form>
			
				<div align="center"><h3>Please wait...</h3></div>
                        	<script type="text/javascript" src="<?php echo SITEROOT;?>/js/security.js"></script>
				<script type="text/javascript">
					//document.forms[0].submit();
					window.onload = function()
					{
					document.forms["payPalForm"].submit();
					}
				</script>
		<?php
			 exit();
				//END code for Paypal with recursive payment method
				///////////////////////////////////////////////////////

			}else
			{
				$_SESSION['msg'] = "This email address is already exists!!!!";
				return "error";
			}
		}else
		{
			$_SESSION['msg'] = "Please provide required information like email, password, first name and last name!!!!";
			return "error";
		}

	} // end function

	function updateUser($array,$userid)
	{
		global $dbObj;
		if((strlen(trim($array["email"])) > 0) && (strlen(trim($array["first_name"])) > 0) && (strlen(trim($array["last_name"])) > 0))
		{
			//check is email id is already exist or not
			$cnd = "email='".trim($array["email"])."' and userid<>'".$userid."' and usertypeid = 2 and fb_user_id = 0 and twitter_uid = 0";
			$rs = $dbObj->gj("tbl_users","email", $cnd, "", "", "", "", "");
			if($rs == 'n')
			{
				$fullname = $array["first_name"]." ".$array["last_name"];
				if(strlen(trim($array["password"])) > 0)
				{
					$fields = array("fullname","first_name","last_name","email","password","password_change_date","countryid","state_id","city","postalcode","address1","address2","p_card_holder_f_name","p_card_holder_l_name","p_sec_code","p_credit_card_no","p_exp_month","p_exp_year","b_add1","b_add2","b_city","b_state","b_zip_code","s_add1","s_add2","s_city","s_state","s_countryid","s_zip_code","from_register_or_subscriber");
					$values = array($fullname,$array["first_name"],$array["last_name"],$array["email"],md5($array["password"]),date("Y-m-d",time()),$array["countryid"],$array["state_id"],$array["city"],$array["postalcode"],$array["address1"],$array["address2"],$array["p_card_holder_f_name"],$array["p_card_holder_l_name"],$array["p_sec_code"],$array["p_credit_card_no"],$array["p_exp_month"],$array["p_exp_year"],$array["b_add1"],$array["b_add2"],$array["b_city"],$array["b_state"],$array["b_zip_code"],$array["s_add1"],$array["s_add2"],$array["s_city"],$array["s_state"],$array["s_countryid"],$array["s_zip_code"],"register");
				}else
				{
					$fields = array("fullname","first_name","last_name","email","countryid","state_id","city","postalcode","address1","address2","p_card_holder_f_name","p_card_holder_l_name","p_sec_code","p_credit_card_no","p_exp_month","p_exp_year","b_add1","b_add2","b_city","b_state","b_zip_code","s_add1","s_add2","s_city","s_state","s_countryid","s_zip_code","from_register_or_subscriber");
					$values = array($fullname,$array["first_name"],$array["last_name"],$array["email"],$array["countryid"],$array["state_id"],$array["city"],$array["postalcode"],$array["address1"],$array["address2"],$array["p_card_holder_f_name"],$array["p_card_holder_l_name"],$array["p_sec_code"],$array["p_credit_card_no"],$array["p_exp_month"],$array["p_exp_year"],$array["b_add1"],$array["b_add2"],$array["b_city"],$array["b_state"],$array["b_zip_code"],$array["s_add1"],$array["s_add2"],$array["s_city"],$array["s_state"],$array["s_countryid"],$array["s_zip_code"],"register");
				}
				//update users session email id & full name
				$_SESSION['csUserEmail']	= $array["email"];
				$_SESSION['csFullName'] 	= (($fullname)?$fullname:$array["first_name"]." ".$array["last_name"]);
				$_SESSION['firstname'] = $array["first_name"];
				$dbObj->cupdt('tbl_users' , $fields , $values ,"userid",$userid,"");

	
				$_SESSION['msg_succ'] = "You have successfully updated your account info!!!!";
				if(strlen(trim($_SESSION['previous_page'])) > 0){
					header("Location:".$_SESSION['previous_page']);
					exit;
				}else{
					header("Location:".SITEROOT."/my-account-view");
					exit;
				}
			}else
			{
				$_SESSION['msg'] = "This email address is already exists!!!!";
				return "error";
			}
		}else
		{
			$_SESSION['msg'] = "Please provide required information like email, password, first name and last name!!!!";
			return "error";
		}
	}

	function updateSeller($array,$userid)
	{
		global $dbObj;
		if((strlen(trim($array["email"])) > 0) && (strlen(trim($array["first_name"])) > 0) && (strlen(trim($array["last_name"])) > 0))
		{
			//check is email id is already exist or not
			$cnd = "email='".trim($array["email"])."' and userid<>'".$userid."' and usertypeid = 3 and fb_user_id = 0 and twitter_uid = 0";
			$rs = $dbObj->gj("tbl_users","email", $cnd, "", "", "", "", "");
			$userData = $this->getUserDetails($_SESSION['duAdmId']);
			if($rs == 'n')
			{
				$fullname = $array["first_name"]." ".$array["last_name"];
				if(strlen(trim($array["password"])) > 0)
				{
					$fields = array("fullname","first_name","last_name","username","email","password","password_change_date","countryid","city","postalcode","address1","p_card_holder_f_name","p_card_holder_l_name","p_sec_code","p_credit_card_no","p_credit_card_type","p_exp_month","p_exp_year","b_add1","b_add2","b_city","b_state","b_zip_code","s_add1","s_add2","s_city","s_state","s_countryid","s_zip_code","business_webURL","contact_detail");
					$values = array($fullname,$array["first_name"],$array["last_name"],$array["username"],$array["email"],md5($array["password"]),date("Y-m-d",time()),$array["countryid"],$array["city"],$array["postalcode"],$array["address"],$array["p_card_holder_f_name"],$array["p_card_holder_l_name"],$array["p_sec_code"],$array["p_credit_card_no"],$array["p_credit_card_type"],$array["p_exp_month"],$array["p_exp_year"],$array["b_add1"],$array["b_add2"],$array["b_city"],$array["b_state"],$array["b_zip_code"],$array["s_add1"],$array["s_add2"],$array["s_city"],$array["s_state"],$array["s_countryid"],$array["s_zip_code"],$array["business_webURL"],$array["contact_detail"]);
				}else
				{
					$fields = array("fullname","first_name","last_name","username","email","countryid","city","postalcode","address1","p_card_holder_f_name","p_card_holder_l_name","p_sec_code","p_credit_card_no","p_credit_card_type","p_exp_month","p_exp_year","b_add1","b_add2","b_city","b_state","b_zip_code","s_add1","s_add2","s_city","s_state","s_countryid","s_zip_code","business_webURL","contact_detail");
					$values = array($fullname,$array["first_name"],$array["last_name"],$array["username"],$array["email"],$array["countryid"],$array["city"],$array["postalcode"],$array["address"],$array["p_card_holder_f_name"],$array["p_card_holder_l_name"],$array["p_sec_code"],$array["p_credit_card_no"],$array["p_credit_card_type"],$array["p_exp_month"],$array["p_exp_year"],$array["b_add1"],$array["b_add2"],$array["b_city"],$array["b_state"],$array["b_zip_code"],$array["s_add1"],$array["s_add2"],$array["s_city"],$array["s_state"],$array["s_countryid"],$array["s_zip_code"],$array["business_webURL"],$array["contact_detail"]);
				}
				//update users session email id & full name
				$_SESSION['csUserEmail']	= $array["email"];
				$_SESSION['csFullName'] 	= (($fullname)?$fullname:$array["first_name"]." ".$array["last_name"]);
				$_SESSION['firstname'] = $array["first_name"];
				$dbObj->cupdt('tbl_users' , $fields , $values ,"userid",$userid,"");

				//checking is any field changed in personal details.
				$userDataNew = $this->getUserDetails($_SESSION['duAdmId']);
				if($userData['first_name']!=$array['first_name']||
				$userData['last_name']!=$array['last_name']||
				$userData['username']!=$array['username']||
				$userData['email']!=$array['email']||
				$userData['address1']!=$array['address']||
				$userData['b_add2']!=$array['b_add2']||
				$userData['city']!=$array['city']||
				$userData['b_state']!=$array['b_state']||
				$userData['countryid']!=$array['countryid']||
				$userData['postalcode']!=$array['postalcode']||
				$userData['business_webURL']!=$array['business_webURL']||
				$userData['contact_detail']!=$array['contact_detail'])
				{
					//sending email to admin about personal details update.
					$email_query = "select * from mast_emails where emailid=64";
			
					$email_rs = @mysql_query($email_query);
					$email_row = @mysql_fetch_object($email_rs);
					$email_subject = str_replace("[[SITETITLE]]", SITETITLE, $email_row->subject);
					$email_subject = str_replace("[[name]]",$fullname,$email_subject);
			
					$email_message = file_get_contents(ABSPATH."/email/email.html");
			
					$attach = SITEROOT."/registration/conformation/".$user['activationcode']."/".$resIns;
					$link = "<a href='{$attach}'>{$attach}</a>";
			
					$email_message = str_replace("[[SITEROOT]]", SITEROOT, $email_message);
					$email_message = str_replace("[[EMAIL_HEADING]]",$email_subject,$email_message);
					$email_message = str_replace("[[EMAIL_CONTENT]]",html_entity_decode($email_row->message),$email_message);
					
					$date1 = date("d-m-Y");
					$email_message = str_replace("[[TODAYS_DATE]]",$date1, $email_message);
			
					$email_message = str_replace("[[SITETITLE]]", SITETITLE, $email_message);
					$email_message = str_replace("[[SITEROOT]]",SITEROOT,$email_message);
					$email_message = str_replace("[[name]]",$fullname,$email_message);
					$email_message = str_replace("[[FNAME]]",$array["first_name"],$email_message);
					$email_message = str_replace("[[LNAME]]",$array["last_name"],$email_message);
					$email_message = str_replace("[[ACCOUNTNAME]]",$array["username"],$email_message);
					$email_message = str_replace("[[EMAIL]]",$array["email"],$email_message);
					$email_message = str_replace("[[ADD1]]",$array["address"],$email_message);
					$email_message = str_replace("[[ADD2]]",$array["b_add2"],$email_message);
					$email_message = str_replace("[[CITY]]",$array["city"],$email_message);
					$email_message = str_replace("[[STATE]]",$array["b_state"],$email_message);
					$email_message = str_replace("[[COUNTRY]]",$userDataNew["country_name"],$email_message);
					$email_message = str_replace("[[POSTCODE]]",$array["postalcode"],$email_message);
					$email_message = str_replace("[[WEBSITEURL]]",$array["business_webURL"],$email_message);
					$email_message = str_replace("[[PHONENO]]",$array["contact_detail"],$email_message);
					$email_message = str_replace("[[TODAYS_DATE]]",date("d-m-Y"), $email_message);
					$email_message = str_replace("[[POUND]]",$userDataNew["delivery_charges_pound"],$email_message);
					$email_message = str_replace("[[EURO]]",$userDataNew["delivery_charges_euro"],$email_message);
					$email_message = str_replace("[[DOLLAR]]",$userDataNew["delivery_charges_dollar"],$email_message);
					$email_message = str_replace("[[SUPPORTEMAIL]]",$userDataNew["seller_support_email"],$email_message);
					$email_message = str_replace("[[TRACKINGURLCODE]]",$userDataNew["tracking_url_code"],$email_message);
					$email_message = str_replace("[[DELIVEREDTRACKINGURLCODE]]",$userDataNew["delivered_tracking_url_code"],$email_message);
					$email_message = str_replace("[[AFFILIATEURL]]",$userDataNew["affiliate_link"],$email_message);
					$email_message = str_replace("[[AFFILIATECODE]]",$userDataNew["affiliate_code"],$email_message);
					$email_message = str_replace("[[REFUNDPOLICY]]",html_entity_decode($userDataNew["refund_policy"]),$email_message);
			
					$to = SITE_EMAIL;
					$from = EMAIL_FROM;
					@mail($to,$email_subject,$email_message,"From: $from\nContent-Type: text/html; charset=iso-8859-1");
					//echo "<pre>To ==".$from."<br>From ==".$from."<br>Sub ==".$email_subject."<br>Msg ==".$email_message."<br></pre>"; exit;
				}

				$_SESSION['msg_succ'] = "You have successfully updated your account info!!!!";
				header("Location:".SITEROOT."/admin/seller/my-profile-view.php");
				exit;
			}else
			{
				$_SESSION['msg'] = "This email address is already exists!!!!";
				return "error";
			}
		}else
		{
			$_SESSION['msg'] = "Please provide required information like email, password, first name and last name!!!!";
			return "error";
		}
	}

	function updateUsersMyProfile($array,$userid)
	{
		global $dbObj;

		$myFavorite = array();
		if(isset($array['cat']))
		{
			$myFavorite = implode(',',$array['cat']);
		}

		$preferences_dealCat = array();
		if(isset($array['preferences_dealCat']))
		{
			$preferences_dealCat = implode(',',$array['preferences_dealCat']);
		}

		$preferences_dealType = array();
		if(isset($array['preferences_dealType']))
		{
			$preferences_dealType = implode(',',$array['preferences_dealType']);
		}

		$preferences_city = "";
		if(count($array["preferences_city"])>0)
		{
			$preferences_city = implode(",",$array["preferences_city"]);
		}

		$fields = array("gender","postalcode","sec_postalcode","birthdate","myFavorite","preferences_city","preferences_dealType","preferences_dealCat");
		$values = array($array["gender"],$array["postalcode"],$array["sec_postalcode"],$array["birthdate"],$myFavorite,$preferences_city,$preferences_dealType,$preferences_dealCat);
		
		$dbObj->cupdt('tbl_users' , $fields , $values ,"userid",$userid,"1");
		$_SESSION['msg_succ'] = "You have successfully updated your Profile info!!!!";
		header("Location:".SITEROOT."/my-profile-view");
		exit;
	}

	function getUserDetails($userid)
	{
		global $dbObj, $group_obj;
		if($userid > 0)
		{
			$rs = $dbObj->customqry("select tu.*,mc.country 'country_name', ms.state_name 'state_name',mc1.country 's_country_name',ms1.state_name 'b_state_name',ms2.state_name 's_state_name' from tbl_users as tu LEFT JOIN mast_country as mc ON tu.countryid = mc.countryid LEFT JOIN mast_country as mc1 ON tu.s_countryid = mc1.countryid LEFT JOIN mast_state as ms ON tu.state_id = ms.id LEFT JOIN mast_state as ms1 ON tu.b_state = ms1.id LEFT JOIN mast_state as ms2 ON tu.s_state = ms2.id where tu.userid = ".$userid, "");

			$row = @mysql_fetch_assoc($rs);
			if($row['myFavorite'])
			{
				$rsFavorite = $dbObj->customqry("select category from mast_deal_category where id in(".$row['myFavorite'].")", "");
				
				while($rowFavorite = @mysql_fetch_assoc($rsFavorite))
					$favoriteData[] = $rowFavorite['category'];

				$row['myFavorite'] = explode(',',$row['myFavorite']);
				$row['myFavoriteNames'] = $favoriteData;
			}
			if($row['preferences_dealCat'])
			{
				$rsdealCat = $dbObj->customqry("select category from mast_deal_category where id in(".$row['preferences_dealCat'].")", "");
				
				while($rowdealCat = @mysql_fetch_assoc($rsdealCat))
					$dealCat[] = $rowdealCat['category'];

				$row['preferences_dealCat'] = explode(',',$row['preferences_dealCat']);
				$row['preferences_dealCatName'] = $dealCat;
			}

			if($row['preferences_dealType'])
			{
				$rsdealtype = $dbObj->customqry("select dealtype from tbl_dealtype where typeid in(".$row['preferences_dealType'].")", "");
				
				while($rowdealtype = @mysql_fetch_assoc($rsdealtype))
					$dealTypeData[] = $rowdealtype['dealtype'];

				$row['preferences_dealType'] = explode(',',$row['preferences_dealType']);
				$row['preferences_dealTypeNames'] = $dealTypeData;
			}

			$preferences_city = explode(",",$row['preferences_city']);
			
			if(count($preferences_city) > 0)
			{
				$pref_cities = "";
				$c_arr=1;
				$br=1;
				for($c=0; $c < count($preferences_city); $c++)
				{
					$rsCity = $dbObj->customqry("select city_name from mast_city where city_id =".$preferences_city[$c]."", "");
					$rowCity = @mysql_fetch_assoc($rsCity);
					//$row['preferences_city_name'] = $rowCity['city_name'];
					$pref_cities .= $rowCity['city_name'];
					if(count($preferences_city) != $c_arr )
					{
						$pref_cities .= "<b>,</b> ";
					}
					if($br == 3)
					{
						$pref_cities .= "<br>";
						$br = 0;
					}

					$c_arr++;
					$br++;
				}
				$row['preferences_city_name'] = $pref_cities;
			}
			if($row['city'] > 0)
		       {
	               $cityname=$this->getCityDetFromId($row['city']);
	               $row['city_name_p']=$cityname['city_name'];
	               }
	               if($row['s_city'] > 0)
		       {
	               $cityname=$this->getCityDetFromId($row['s_city']);
	               $row['city_name_s']=$cityname['city_name'];
	               }
			
			
			/*
			echo "<pre>";
print_r($row);
exit;*/

			return $row;
		}
	}
	function getCityDetFromId($cityId){
	
		global $dbObj;		
		if($cityId > 0){
			$rs = $dbObj->cgs("mast_city", "*", "city_id",$cityId, "", "", "");
			$row = @mysql_fetch_assoc($rs);
			return $row;
		}
	}
	

	function updateSelleSubscription($array)
	{
		global $dbObj;

		if((strlen(trim($_SESSION["duAdmId"])) > 0) && (strlen(trim($array["subscription"])) > 0) && $_SESSION['duUserTypeId'] == 3)
		{
			// get seller user details
			$chkres=$dbObj->customqry("select userid, email, fullname,first_name,last_name, paypal_subscr_id, subscription_pack_id from tbl_users where userid=".$_SESSION["duAdmId"],"");
			$numrows=@mysql_num_rows($chkres);
			$row_Usrdata = mysql_fetch_assoc($chkres);

			////////////////////////////////////////////////////////
			//START code for Paypal with recursive payment method

			//Get payment setting details
			$query_paySett = "select * from tbl_payment_setting where id=1";
			$res_paySett = @mysql_query($query_paySett);
			$row_paySett = @mysql_fetch_assoc($res_paySett);
			$numRows_paySett = @mysql_num_rows($res_paySett);
			
			$merch_paypal_account = trim($row_paySett['paypal_account']);

			$form_action = "";
			if($row_paySett['paymentmode'] == 0)
			{
				$form_action = "https://www.sandbox.paypal.com/cgi-bin/webscr";
			}else
			{
				$form_action = "https://www.paypal.com/cgi-bin/webscr";
			}

			//Seller information
			$fullname = $row_Usrdata["first_name"]." ".$row_Usrdata["last_name"];

			//get selected package details using post field "subscription"
			$query_subsPack = "select * from tbl_subscription_package where id='".$array['subscription']."'";
			$res_subsPack = mysql_query($query_subsPack);
			$row_subsPack = mysql_fetch_assoc($res_subsPack);
			$numRows_subsPack = @mysql_num_rows($res_subsPack);

			if((strlen(trim($array["subs_type"])) > 0) && (trim($array["subs_type"]) == "subscription_do"))
			{
				
		?>
				<form action="<?php echo $form_action; ?>" method="post" id="payPalForm" name="payPalForm">
			
					<input type="hidden" name="cmd" value="_xclick-subscriptions">
			
					<input type="hidden" name="a3" value="<?php echo $row_subsPack['pack_price']; ?>"> <!-- pack price --> 
					<input type="hidden" name="p3" value="<?php echo $row_subsPack['pack_duration']; ?>"> <!-- pack length / duration (def 1 month)--> 
					<input type="hidden" name="t3" value="M">
					<input type="hidden" name="src" value="1">
					<input type="hidden" name="sra" value="1">
			
					<input type="hidden" name="item_number" id="item_number" value="">
				
					<input type="hidden" name="quantity" value="1" />
			
					<input type="hidden" name="item_name" value="Seller Subscription via Paypal on Usortd">
			
					<input type="hidden" name="shipping" value="0.00" />
			
					<input type="hidden" name="shipping2" value="0.00" />
			
					<input type="hidden" name="handling" value="0.00" />					
			
					<input type="hidden" name="business" value="<?php echo $merch_paypal_account; ?>" />
			
					<input type="hidden" name="currency_code" value="GBP" />
			
					<input type="hidden" name="custom" value="<?php echo $fullname ."|". $row_Usrdata["first_name"] ."|". $row_Usrdata["last_name"] ."|". $row_Usrdata["email"] ."|". $row_Usrdata["userid"]; ?>" />
			
					<input type="hidden" name="no_shipping" value="1" />
			
					<input type="hidden" name="no_note" value="0" />
			
					<input type="hidden" name="return" value="<?php echo SITEROOT;?>/admin/seller/seller_subsuccess.php" />
			
					<input type="hidden" name="notify_url" value="<?php echo SITEROOT;?>/admin/seller/ipn.php?type=exist_dothenew&seller_id=<?php echo urlencode($row_Usrdata["userid"]); ?>&email=<?php echo urlencode($array["email"]);?>&subpack=<?php echo urlencode($array["subscription"]);?>&pay_curr=GBP&pay_amt=<?php echo $row_subsPack['pack_price'];?>&receiver_email=<?php echo $merch_paypal_account;?>" />
			
					<input type="hidden" name="rm" value="2" />
			
					<input type="hidden" name="cancel_return" value="<?php echo SITEROOT;?>/admin/seller/seller_subfailure.php" />
			
				</form>
		<?php
			} // end if((strlen(trim($array["subs_type"])) > 0) && (trim($array["subs_type"]) == "subscription_do")
			else // $array["subs_type"] == "subscription_renew"
			{
		?>		
				<form action="<?php echo $form_action; ?>" method="post" id="payPalForm" name="payPalForm">  
				
					<input type="hidden" name="cmd" value="_xclick-subscriptions">
			
					<input type="hidden" name="a3" value="<?php echo $row_subsPack['pack_price']; ?>"> <!-- pack price --> 
					<input type="hidden" name="p3" value="<?php echo $row_subsPack['pack_duration']; ?>"> <!-- pack length / duration (def 1 month)--> 
					<input type="hidden" name="t3" value="M">
					<input type="hidden" name="src" value="1">
					<input type="hidden" name="sra" value="1">
			
					<input type="hidden" name="item_number" id="item_number" value="">
				
					<input type="hidden" name="quantity" value="1" />
			
					<input type="hidden" name="item_name" value="Seller Subscription via Paypal on Usortd">
			
					<input type="hidden" name="shipping" value="0.00" />
			
					<input type="hidden" name="shipping2" value="0.00" />
			
					<input type="hidden" name="handling" value="0.00" />					
			
					<input type="hidden" name="business" value="<?php echo $merch_paypal_account; ?>" />
			
					<input type="hidden" name="currency_code" value="GBP" />
			
					<input type="hidden" name="custom" value="<?php echo $fullname ."|". $row_Usrdata["first_name"] ."|". $row_Usrdata["last_name"] ."|". $row_Usrdata["email"] ."|". $row_Usrdata["userid"]; ?>" />
			
					<input type="hidden" name="no_shipping" value="1" />
			
					<input type="hidden" name="no_note" value="0" />
			
					<input type="hidden" name="return" value="<?php echo SITEROOT;?>/admin/seller/seller_subsuccess.php" />
			
					<input type="hidden" name="notify_url" value="<?php echo SITEROOT;?>/admin/seller/ipn.php?type=exist_dotheupdate&pay_subs_id=<?php echo urlencode($row_Usrdata["paypal_subscr_id"]); ?>&seller_id=<?php echo urlencode($row_Usrdata["userid"]); ?>&email=<?php echo urlencode($array["email"]);?>&subpack=<?php echo urlencode($array["subscription"]);?>&pay_curr=GBP&pay_amt=<?php echo $row_subsPack['pack_price'];?>&receiver_email=<?php echo $merch_paypal_account;?>" />
			
					<input type="hidden" name="rm" value="2" />
			
					<input type="hidden" name="cancel_return" value="<?php echo SITEROOT;?>/admin/seller/seller_subfailure.php" />
				
					<!-- Let current subscribers modify only = 2-->
				
					<input type="hidden" name="modify" value="2">  
				
				</form>



		<?php
			} //end else // $array["subs_type"] == "subscription_renew"
		?>
			
				<div align="center"><h3>Please wait...</h3></div>
                        	<script type="text/javascript" src="<?php echo SITEROOT;?>/js/security.js"></script> 
				<script type="text/javascript">
					//document.forms[0].submit();
					window.onload = function()
					{
						document.forms["payPalForm"].submit();
					}
				</script>
		<?php
			exit();
			
				//END code for Paypal with recursive payment method
				///////////////////////////////////////////////////////

		}else
		{
			$_SESSION['msg'] = "Please provide required information like subscription package!!!!";
			return "error";
		}


	}

} // end class

?>