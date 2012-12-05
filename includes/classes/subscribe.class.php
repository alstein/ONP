<?php
class Subscribe 
{

    function __construct()
    {

    } // end function
    
    function addNewSubscribe_OLD($array){
         global $dbObj;
	
	if((strlen(trim($array["email"])) > 0) && (strlen(trim($array["password"])) > 0) && (strlen(trim($array["fullName"])) > 0) && (strlen(trim($array["location"])) > 0))
	{

		//check is email id is already exist or not
		$cnd = "email='".trim($array["email"])."' and fb_user_id = 0 and twitter_uid = 0 and usertypeid = 2";
		$rs = $dbObj->gj("tbl_users","email", $cnd, "", "", "", "", "");
		if($rs == 'n')
		{
				$username = $array["first_name"]."_".$array["last_name"];
				
				$fields = array("first_name","last_name","username","fullname",'password','email','usertypeid','signup_date','countryid','city', 'address1','postalcode','status','ip', 'contact_detail', 'from_register_or_subscriber');
				$values = array($array["first_name"],$array["last_name"],$username,$array["fullName"],md5($array["password"]),$array["email"],2,date("Y-m-d H:i:s"),"",$array["location"],"","","active",$_SERVER['REMOTE_ADDR'],$array["contact_detail"],'subscriber');
	
				$resIns = $dbObj->cgi('tbl_users',$fields,$values,'');
	
	// 			$_SESSION['csUserLgn'] 		= "TRUE";
	// 			$_SESSION['csUserId']		= $resIns;
	// 			$_SESSION['csFullName']		= $fullname;
	// 			$_SESSION['csUserEmail']		= $array["email"];
	// 			$_SESSION['csUserTypeId'] 	= 2;
	

				//city name
				$citynameDet = getCityDetFromId($array["location"]);
				$cityname = $citynameDet['city_name'];

				/////////////////////////////////////////////////////////////
				//START subscribe to newsletter as well
				//check is email id is already exist or not
				$cnd = "nemail='".trim($array["email"])."' and city='".trim($array["location"])."'";
				$rs = $dbObj->gj("tbl_newsletter","nemail", $cnd, "", "", "", "", "");
				if($rs == 'n')
				{
					$fields = array("name", "nemail", "city", "contact_detail", "ndate", "status" );
					$values = array( $array["fullName"], $array["email"], $array["location"], $array["contact_detail"], $array["added_date"] , '1' );
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
	
				$email_message = str_replace("[[SITETITLE]]", SITETITLE, $email_message);
				$email_message = str_replace("[[SITEROOT]]",SITEROOT,$email_message);
				$email_message = str_replace("[[name]]",$fullname,$email_message);
				$email_message = str_replace("[[fname]]",$array["first_name"],$email_message);
				$email_message = str_replace("[[lname]]",$array["last_name"],$email_message);
				$email_message = str_replace("[[email]]",$array["email"],$email_message);
				$email_message = str_replace("[[password]]",$array["password"],$email_message);
				$email_message = str_replace("[[phone_no]]",$array["contact_detail"],$email_message);
				$email_message = str_replace("[[TODAY]]", date("F dS, Y",time()), $email_message);
				$email_message = str_replace("[[link]]",$link, $email_message);
	
				$from = SITE_EMAIL;
				@mail($array["email"],$email_subject,$email_message,"From: $from\nContent-Type: text/html; charset=iso-8859-1");
				//echo "<pre>To ==".$array["email"]."<br>From ==".$from."<br>Sub ==".$email_subject."<br>Msg ==".$email_message."<br></pre>"; exit;
	
				//$_SESSION['msg_succ'] = "You have successfully registered, please check your email and verify your account!!!!";
				return "success";
				//header("Location:".SITEROOT."/buyer_regsuccess");
				//exit;

		}else
		{
			$_SESSION['msg'] = $array["email"]." : this email address is already exists!!!!";
			return "error";
		}
	}else
	{
		$_SESSION['msg'] = "Please enter required information";
		return "error";
	}
    } // end function

	function addNewSubscribe($array)
	{
		global $dbObj;
		if((strlen(trim($array["email"])) > 0) && (strlen(trim($array["location"])) > 0))
		{
			//city name
			$citynameDet = getCityDetFromId($array["location"]);
			$cityname = $citynameDet['city_name'];

			/////////////////////////////////////////////////////////////
			//START subscribe to newsletter as well
			//check is email id is already exist or not
			$cnd = "nemail='".trim($array["email"])."' and city='".trim($array["location"])."'";
			$rs = $dbObj->gj("tbl_newsletter","nemail", $cnd, "", "", "", "", "");
			if($rs == 'n')
			{
				$fields = array("nemail", "city", "contact_detail", "ndate", "status" );
				$values = array( $array["email"], $array["location"], $array["contact_detail"], $array["added_date"] , '1' );
				$prn = "";
				$result = $dbObj ->cgi('tbl_newsletter' , $fields , $values , $prn);
			}else
			{
				$_SESSION['msg'] = "You have already subscribed using ".$array["email"]." email id";
				return "error";
			}
			//End subscribe to newsletter as well
			/////////////////////////////////////////////////////////////
	
	
			//send email to user after Subscribe
	
			$email_query = "select * from mast_emails where emailid=63";
	
			$email_rs = @mysql_query($email_query);
			$email_row = @mysql_fetch_object($email_rs);
			$email_subject = str_replace("[[SITETITLE]]", SITETITLE, $email_row->subject);
			$email_subject = str_replace("[[name]]",$fullname,$email_subject);
	
			$email_message = file_get_contents(ABSPATH."/email/email.html");
	
			//$attach = SITEROOT."/unsubscribe/".base64_encode($array['email'])."/".base64_encode($array["location"]);
			$attach = SITEROOT."/confirm-unsubscribe/".base64_encode(base64_encode($array['email']))."/".$array["location"];
			$link = "<a target='_blank' href='{$attach}'>Unsubscribe</a>";

	
			$email_message = str_replace("[[SITEROOT]]", SITEROOT, $email_message);
			$email_message = str_replace("[[EMAIL_HEADING]]",$email_subject,$email_message);
			$email_message = str_replace("[[EMAIL_CONTENT]]",html_entity_decode($email_row->message),$email_message);
	
			$email_message = str_replace("[[SITETITLE]]", SITETITLE, $email_message);
			$email_message = str_replace("[[SITEROOT]]",SITEROOT,$email_message);
			$email_message = str_replace("[[CITY_NAME]]",$cityname,$email_message);
			$email_message = str_replace("[[EMAIL]]",$array["email"],$email_message);
			$email_message = str_replace("[[PHONE_NO]]",$array["contact_detail"],$email_message);
			$email_message = str_replace("[[TODAYS_DATE]]", date("Y-m-d",time()), $email_message);
			$email_message = str_replace("[[UNSUBSCRIBE]]",$link, $email_message);

			$from = SITE_EMAIL;
			@mail($array["email"],$email_subject,$email_message,"From: $from\nContent-Type: text/html; charset=iso-8859-1");
			//echo "<pre>To ==".$array["email"]."<br>From ==".$from."<br>Sub ==".$email_subject."<br>Msg ==".$email_message."<br></pre>"; exit;
	
			//$_SESSION['msg_succ'] = "You have successfully registered, please check your email and verify your account!!!!";
			return "success";
			//header("Location:".SITEROOT."/buyer_regsuccess");
			//exit;
		}else
		{
			$_SESSION['msg'] = "Please enter required information";
			return "error";
		}
	} // end function


     function getSubscribeById($id){

         global $dbObj;
         $row = array(); 
         $fields = array( "nid" , "name" , "nemail" , "city" , "zipcode" , "ndate" , "status" );
         $wf = array( "id");
         $wv = array( $id);
         $ob = "id";
         $ot = 'asc';
         $prn = "";
         $result = $dbObj ->cgs('tbl_newsletter' , $fields , $wf , $wv , $ob , $ot , $prn);
        
        if(is_resource($result)){
            $row = mysql_fetch_assoc($result);
        } // if
        
        return $row;
    } // end function 

    function deleteSubscribe($ids){
    global $dbObj;
        if(is_array($ids) && (sizeof($ids) > 0)){
            $ids = implode(",", $ids);
        }
        if(strlen($ids) > 0){            
            $sql_update = "delete from tbl_newsletter where nid in (".$ids.")";
            $dbObj->customqry($sql_update,'');
        }

    } // end function

} // end class

?>