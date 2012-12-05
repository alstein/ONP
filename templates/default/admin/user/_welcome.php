<?php

$PATH_PREFIX = "../";
include_once('include.php');

if(isset($_POST['submit']))
{
$_SESSION['csname']=$_POST['name'];
$_SESSION['cslname']=$_POST['lname'];
$_SESSION['csemail']=$_POST['email'];
$_SESSION['csreenter_email']=$_POST['reenter_email'];
$_SESSION['cspassword']=$_POST['password'];
$_SESSION['cssel_gender']=$_POST['sel_gender'];
$_SESSION['csbdate']=$_POST['sel_dd']."-".$_POST['sel_mm']."-".$_POST['sel_yy'];
header("Location:".SITEROOT."/myaccount");
exit;
}
$smarty->display(TEMPLATEDIR.'/index.tpl');

$dbObj->Close();
?>