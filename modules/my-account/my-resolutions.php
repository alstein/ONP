<?php
include_once('../../include.php');
include_once('../../includes/classes/class.frontregister.php');

//Get meta tags of the page as per id
$call_meta=$dbObj->meta_SEO(17);
$smarty->assign("row_meta",$call_meta);

if(!isset($_SESSION['csUserId']))
{
	header("location:".SITEROOT."/"); exit;
}

///////////////Fetching User Records START/////////////////////
$objregister = new frontregister();
$userData = $objregister->getUserDetails($_SESSION['csUserId']);
$smarty->assign("userData", $userData);
/////////////Fetching User Records END///////////////////////

///////////////Sending Email Start///////////////////////////

if(strlen(trim($_POST['submit'])) > 0)
{
	$email_subject = "My Resolution : ".$_POST['subject'];

	$email_message = file_get_contents(ABSPATH."/email/email.html");

	$email_message = str_replace("[[SITEROOT]]", SITEROOT, $email_message);
	$email_message = str_replace("[[EMAIL_HEADING]]",$email_subject,$email_message);
	$_POST['body'] = "Hi ".$_POST['usr_name']."<br><br>Deal Id / URL : ".$_POST['deal_id']."<br><br>".$_POST['body'];
	$email_message = str_replace("[[EMAIL_CONTENT]]",$_POST['body'],$email_message);
	
	$date1 = date("d-m-Y");
	$email_message = str_replace("[[TODAYS_DATE]]",$date1, $email_message);
	$email_message = str_replace("[[SITETITLE]]", SITETITLE, $email_message);
	$email_message = str_replace("[[SITEROOT]]",SITEROOT,$email_message);
	
	$from = $_POST['from'];
	@mail(SITE_EMAIL,$email_subject,$email_message,"From: $from\nContent-Type: text/html; charset=iso-8859-1");
	//echo "<pre>To ==".SITE_EMAIL."<br>From ==".$from."<br>Sub ==".$email_subject."<br>Msg ==".$email_message."<br></pre>"; exit;

	$_SESSION['msg_succ'] = "You have successfully sent your Resolution to Usortd.";
	header("location:".SITEROOT."/my-resolutions"); exit;
}

///////////////Sending Email End///////////////////////////

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

$smarty->display(TEMPLATEDIR . '/modules/my-account/my-resolutions.tpl');
$dbObj->Close();
?>