<?php
include_once('../../include.php');

if(isset($_SESSION['csUserId']))
{
    header("location:".SITEROOT . "/my-account-view");
}
//Get meta tags of the page as per id
$call_meta=$dbObj->meta_SEO(23);
$smarty->assign("row_meta",$call_meta);

$row_meta=$dbObj->getseodetails(28);
$smarty->assign("row_meta",$row_meta);

$today = date("j F, Y");  

if(isset($_POST['email']))
{

	extract($_POST);

	$rs1 = $dbObj->cgs("tbl_users", "*",array("email", "isDeleted"),array($email, "0" ), "", "","");
	$user1 = @mysql_fetch_assoc($rs1);
	
	if($user1['isverified']=='no')
	{

		$_SESSION['msg'] = "Still your account is not verified.So can't use this facility. ";
	}
	else if(@mysql_num_rows($rs1)==0)
	{
			
			
				$_SESSION['msg'] = "No account exists for that email address, please create an account below.";
			

	}
	else
	{
			for ($i = 0, $z = strlen($a = 'abcdefghijklmnopqrstuvwxyz1234567890')-1, $s = $a{rand(0,$z)}, $i = 1; $i != 10; $x = rand(0,$z), $s .= $a{$x}, $s = ($s{$i} == $s{$i-1} ? substr($s,0,-1) : $s), $i=strlen($s));
			//print_r('ff');//exit;
			$pass = $s;
			$mast_id = $dbObj->cgs("mast_emails","*","emailid","55","","","");
			$mast_mail = @mysql_fetch_object($mast_id);
			$fpupdate = $dbObj->cupdt("tbl_users","password",md5($pass),array("email", "fb_user_id", "twitter_uid"),array($email, "0", "0"),"");

			$email_subject = str_replace("[[SITETITLE]]", SITETITLE, $mast_mail->subject);

			$email_message = file_get_contents(ABSPATH."/email/email.html");
			$email_message = str_replace("[[SITEROOT]]", SITEROOT, $email_message);
			$email_message = str_replace("[[EMAIL_HEADING]]",$email_subject,$email_message);
			$email_message  = str_replace("[[EMAIL_CONTENT]]",html_entity_decode($mast_mail->message),$email_message);
			
			$email_message = str_replace("[[SITEROOT]]",SITEROOT,$email_message);
			$email_message = str_replace("[[TODAYS_DATE]]",$today,$email_message);
			
			$email_message = str_replace("[[fname]]",$user1['first_name'],$email_message);
			$email_message = str_replace("[[email]]",$user1['email'],$email_message);
			$email_message = str_replace("[[password]]",$pass,$email_message);
			//echo $email_message;exit;

			$email = $user1['email'];
			$from = SITE_EMAIL;
			@mail($email,$email_subject,$email_message,"From: $from\nContent-Type: text/html; charset=iso-8859-1");		
			$_SESSION['msg_succ']="Your password has been sent to the email account. You will receive it shortly.";
// 		echo "email=".$email;
// 			echo "<br>subject=".$email_subject;
// 			echo "<br>message=".$email_message;
			
// 			header("Location:".SITEROOT."/login");
// 			exit;
		}
}
    if(isset($_SESSION['msg']))
    {
        $smarty->assign("msg", $_SESSION['msg']);
        unset($_SESSION['msg']);
    }
    
    if(isset($_SESSION['msg_succ']))
    {
        $smarty->assign("msg_succ", $_SESSION['msg_succ']);
        unset($_SESSION['msg_succ']);
    }

$smarty->display(TEMPLATEDIR . '/modules/signin/forgotpassword.tpl');
$dbObj->Close();
?>