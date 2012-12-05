<?php

$PATH_PREFIX = "../";
include_once('../../include.php');
include_once("../../includes/common.lib.php");
//if($_SESSION['profile_intrested_in']=="")
if($_SESSION['profile_category']=="")
{
@header("Location:".SITEROOT."/profilestep");
}
if($_FILES['photo']['name']!="")
{
  if($_FILES['photo'])
    {

                       $original_1 = newgeneralfileupload($_FILES["photo"], "../../uploads/user", true); 
    }
$_SESSION['profile_photo']=$original_1;
@header("Location:".SITEROOT."/invitation");
exit;
}
$smarty->display(TEMPLATEDIR.'/modules/registration/profile_picture.tpl');

$dbObj->Close();
?>
