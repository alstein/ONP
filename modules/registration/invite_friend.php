<?php

$PATH_PREFIX = "../";
include_once('../../include.php');

if($_GET['id']==1)
{

$arr=explode("-",$_SESSION['profilebdate']);
$bdate=$arr[2]."-".$arr[1]."-".$arr[0];
$fname=$_SESSION['profilename'];
$lname=$_SESSION['profilelname'];
$email=$_SESSION['profileemail'];
$password=md5($_SESSION['profilepassword']);
$gender=$_SESSION['profilesel_gender'];
$city=$_SESSION['profilecity'];
$rel_status=$_SESSION['profilel_relstatus'];
$grad_collage=$_SESSION['profile_grad_collage'];
$under_grad_collage=$_SESSION['profile_under_grad_collage'];
$music=$_SESSION['profile_music'];
$activities=$_SESSION['profile_activity'];
//$intrested_in=$_SESSION['profile_intrested_in'];
$category_preferance=$_SESSION['profile_category'];
$photo=$_SESSION['profile_photo'];
$signup_date=date("Y-m-d H:i:s");
$username = str_replace(" ","_",$fname)."_".str_replace(" ","_",$lname).rand();
$fullname=$fname." ".$lname;
$deal_thr_email=$_SESSION['deal_by_email'];

//$insert=$dbObj->customqry("insert into tbl_users(first_name,last_name,	fullname,username,email,password,gender,birthdate,city,rel_status,grad_college,under_grad_college,music,activities,intrested_in ,category_preferance,photo,signup_date,usertypeid,deal_by_email)values('".$fname."','".$lname."','".$fullname."','".$username."','".$email."','".$password."','".$gender."','".$bdate."','".$city."','".$rel_status."','".$grad_collage."','".$under_grad_collage."','".$music."','".$activities."','".$intrested_in."','".$category_preferance."','".$photo."','".$signup_date."','2','".$deal_thr_email."')","");


$insert=$dbObj->customqry("insert into tbl_users(first_name,last_name,	fullname,username,email,password,gender,birthdate,city,rel_status,grad_college,under_grad_college,music,activities ,category_preferance,photo,signup_date,usertypeid,deal_by_email)values('".$fname."','".$lname."','".$fullname."','".$username."','".$email."','".$password."','".$gender."','".$bdate."','".$city."','".$rel_status."','".$grad_collage."','".$under_grad_collage."','".$music."','".$activities."','".$category_preferance."','".$photo."','".$signup_date."','2','".$deal_thr_email."')","");

 $ses_userid=mysql_insert_id();

	$verifycode=md5($ses_userid * 32767);
	$rs=$dbObj->cupdt("tbl_users", "activationcode", $verifycode, "userid", $ses_userid, "1");
	$rs=$dbObj->cgs("tbl_users", "", "userid", $ses_userid, "", "", "");
	$user = @mysql_fetch_assoc($rs);
	$email_query = "select * from mast_emails where emailid=16";

	$email_rs = @mysql_query($email_query);
	$email_row = @mysql_fetch_object($email_rs);
	$email_subject = str_replace("[[SITETITLE]]", SITETITLE, $email_row->subject);
	$email_subject = str_replace("[[name]]",$fullname,$email_subject);

	$email_message = file_get_contents(ABSPATH."/email/email.html");

	$attach = SITEROOT."/registration/conformation/".$user['activationcode']."/".$ses_userid;
	$link = "<a href='{$attach}'>{$attach}</a>";

	$email_message = str_replace("[[SITEROOT]]", SITEROOT, $email_message);
	$email_message = str_replace("[[EMAIL_HEADING]]",$email_subject,$email_message);
	$email_message = str_replace("[[EMAIL_CONTENT]]",html_entity_decode($email_row->message),$email_message);

	$email_message = str_replace("[[SITETITLE]]", SITETITLE, $email_message);
	$email_message = str_replace("[[SITEROOT]]",SITEROOT,$email_message);
	$email_message = str_replace("[[name]]",$fullname,$email_message);
	$email_message = str_replace("[[fname]]",$fname,$email_message);
	$email_message = str_replace("[[lname]]",$lname,$email_message);
	$email_message = str_replace("[[email]]",$email,$email_message);
	$email_message = str_replace("[[password]]",$_SESSION['profilepassword'],$email_message);
	
	$date1 = date("d-m-Y");
	$email_message = str_replace("[[TODAYS_DATE]]",$date1, $email_message);
	$email_message = str_replace("[[link]]",$link, $email_message);

	$from = SITE_EMAIL;
	@mail($email,$email_subject,$email_message,"From: $from\nContent-Type: text/html; charset=iso-8859-1");
	$_SESSION['msg1']="You Are Registered Successfully.To Login click on verification link provided by you through email";
// 		echo $email;
// 	echo $email_message;
// 	echo $email_subject;exit;
if($_SESSION!="")
{

$_SESSION['profilebdate']="";
$_SESSION['profilename']="";
$_SESSION['profilelname']="";
$_SESSION['profileemail']="";
$_SESSION['profilepassword']="";
$_SESSION['profilesel_gender']="";
$_SESSION['profilecity']="";
$_SESSION['profilel_relstatus']="";
$_SESSION['profile_grad_collage']="";
$_SESSION['profile_under_grad_collage']="";
$_SESSION['profile_music']="";
$_SESSION['profile_activity']="";
$_SESSION['profile_intrested_in']="";
$_SESSION['profile_category']="";
$_SESSION['profile_photo']="";
$_SESSION['deal_by_email']="";
unset($_SESSION);

}
@header("Location:".SITEROOT."/success/success/");
 		



}

if($_SESSION['msg']!="")
{
$msg=$_SESSION['msg'];
$smarty->assign("msg",$msg);
unset($_SESSION['msg']);
}
// $smarty->display(TEMPLATEDIR.'/modules/registration/invite_friend.tpl');

$dbObj->Close();
?>
