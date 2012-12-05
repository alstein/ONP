<?php
//include_once("../../twitter.php");	
include_once("../../includes/SiteSetting.php");

$_SESSION['emailverfiye']='twitter';

	if($_POST['btnLogin']=='Submit')
	{
		if($_POST['emailname'] !='')
		{
			$query = "select * from tbl_users where email='".trim($_POST['emailname'])."' and twitter_uid != 0 and usertypeid NOT IN (1,3)";
			$rs = mysql_query($query);
			$num = @mysql_num_rows($rs);
			if($num > 0)
			{
				$_SESSION['twittmsg'] = "This email address is already registered as a twitter user, please try another one!";
				header("Location:".SITEROOT."/signin");
				exit;
			}else
			{
				if($_SESSION['screen_name'] && $_SESSION['twitter_id'])
				{
					$name=$_SESSION['name'];
					$explode_name=explode(" ",$name);
					$screen_name= $_SESSION['screen_name'];
					$twitter_id=$_SESSION['twitter_id'];
					$location=$_SESSION['location'];
					$password=$_SESSION['password'];      
					$field = array					("username","first_name","last_name","password","email","signup_date","usertypeid","isverified","verified_date","twitter_uid","address1","ip","fullname");
					$value = array($screen_name,$explode_name[0],$explode_name[1],md5($password),$_POST['emailname'],date("Y-m-d H:i:s"),"2","yes",date("Y-m-d H:i:s"),$twitter_id,$location,$_SERVER['REMOTE_ADDR'],$explode_name[0]." ".$explode_name[1]);
			
					$dbObj->cgi("tbl_users",$field,$value,"");//exit;
				
					$usId  = mysql_insert_id(); 
					/*set and assign session value */
					$_SESSION['csLogin']          = "Yes";
					$_SESSION['csUserId']         = $usId;
					$_SESSION['csTwitterUserId'] = $twitter_id;
					$_SESSION['csLoginName']      = $screen_name;
					$_SESSION['csFullName']    =  $explode_name[0]." ".$explode_name[1];
					$_SESSION['csFirstName']    =  $explode_name[0];
					
					$f = array("userid", "login_date", "ipaddress");
					$v = array($_SESSION['csUserId'], date("Y-m-d H:i:s"), $_SERVER['REMOTE_ADDR']);
					$id = $dbObj->cgi("tbl_login_log", $f, $v, "");
		
					$emailid=$_POST['emailname'];	
	
					unset($_SESSION['name']);
					unset($_SESSION['screen_name']);
					unset($_SESSION['twitter_id']);
					unset($_SESSION['location']);
					unset($_SESSION['password']);
					unset($_SESSION['emailverfiye']);
					//@mail($emailid,$email_subject,$email_message,"From: $from\nContent-Type: text/html; charset=iso-8859-1");
		
					#--------------Send Welcome Email --------------#
					$email_query = "select * from mast_emails where emailid=22";
					$email_rs = mysql_query($email_query);
					$email_row = mysql_fetch_object($email_rs);
	
					$email_subject = str_replace("[[SITETITLE]]", SITETITLE, $email_row->subject);
					$email_subject = str_replace("[[name]]",$fullname,$email_subject);
		
					$email_message = file_get_contents(ABSPATH."/email/email.html");
	
					$email_message = str_replace("[[SITEROOT]]", SITEROOT, $email_message);
					$email_message  = str_replace("[[EMAIL_HEADING]]",$email_subject,$email_message);
					$email_message  = str_replace("[[EMAIL_CONTENT]]",html_entity_decode($email_row->message),$email_message);
					$email_message = str_replace("[SITEROOT]", SITEROOT, $email_message);
					$email_message = str_replace("[[SITETITLE]]", SITETITLE, $email_message);
					$email_message = str_replace("[[FIRSTNAME]]", $explode_name[0], $email_message);
					$from = SITE_EMAIL;
					@mail($_POST['emailname'],$email_subject,$email_message,"From: $from\nContent-Type: text/html; charset=iso-8859-1");
					#-------------End Welcome Email --------------#
					//echo "<pre>To ==".$_POST['emailname']."<br>From ==".$from."<br>Sub ==".$email_subject."<br>Msg ==".$email_message."<br></pre>"; exit;
	
					header("Location:".SITEROOT."/my-account-view");
					exit;
				}else
				{
					if(!isset($_SESSION['csUserId']))
					{
						header("Location:".SITEROOT."/");
						exit;
					}else
					{
						header("Location:".SITEROOT."/my-account-view");
						exit;
					}
				}
			}
		}
	}



    if(isset($_SESSION['twittmsg']))
    {
        $smarty->assign("twittmsg", $_SESSION['twittmsg']);
        unset($_SESSION['twittmsg']);
    }

	$smarty->display(TEMPLATEDIR . '/modules/email-twitter.tpl');

	$dbObj->Close();
?>
