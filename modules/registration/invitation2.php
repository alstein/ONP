<?php

$PATH_PREFIX = "../";
include_once('../../include.php');

if(($_POST['txt_hidden'])!="" || $_GET['id']==1)
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
$intrested_in=$_SESSION['profile_intrested_in'];
$category_preferance=$_SESSION['profile_category'];
$photo=$_SESSION['profile_photo'];
$signup_date=date("Y-m-d H:i:s");
$insert-$dbObj->customqry("insert into tbl_users(first_name,last_name,email,password,gender,birthdate,city,rel_status,grad_college,under_grad_college,music,activities,intrested_in ,category_preferance,photo 	,signup_date,usertypeid)values('".$fname."','".$lname."','".$email."','".$password."','".$gender."','".$bdate."','".$city."','".$rel_status."','".$grad_collage."','".$under_grad_collage."','".$music."','".$activities."','".$intrested_in."','".$category_preferance."','".$photo."','".$signup_date."','2')","1");

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
unset($_SESSION);

}
header("Location:".SITEROOT);
exit;
}
$smarty->display(TEMPLATEDIR.'/modules/registration/invite_friend.tpl');

$dbObj->Close();
	?>