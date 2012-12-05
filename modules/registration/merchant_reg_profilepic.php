<?php

$PATH_PREFIX = "../";
include_once('../../include.php');
include_once('../../includes/SiteSetting.php');
include_once('../../includes/class.message.php');
include_once("../../includes/common.lib.php");
if($_SESSION['merchantemail']=="")
{
    @header("Location:".SITEROOT."/registration/merchant_reg_profileinfo");
}

#----------------get Main category----------------------------#
$sql="select * from mast_deal_category where parent_id=0 AND active=1 order by category";
$result = mysql_query($sql) or die('Error, query failed');
$i = 0;
while($row = mysql_fetch_array($result))
{
    $tmp = array('id'=>$row['id'], 'category'=>$row['category']);
    $results[$i++] = $tmp;
}
$smarty->assign("category",$results);
#----------------get Main category----------------------------#



#--------------Get Time--------------------#
$i = 0;
$hr = array();	
for($hh = 0; $hh <=23; $hh++) 
{
    if($hh<10)
        $hh = "0$hh"; 
    else
        $hh = $hh;
    $hr[$i] = $hh;
    $i++;
}
$rev_hr = array_reverse($hr);
$smarty->assign("rev_hr",$rev_hr);
$smarty->assign("hr",$hr);
$smarty->assign("delivery_hrs",$hr);

$i = 0;
$min = array();	
for($mm = 0; $mm <=59; $mm++) 
{
    if($mm<10)
        $mm = "0$mm"; 
    else
        $mm = $mm;
    $min[$i] = $mm;
    $i++;
}
$min=array("00","15","30","45");
$rev_min = array_reverse($min);
$smarty->assign("rev_min",$rev_min);
$smarty->assign("min",$min);
$smarty->assign("delivery_mins",$min);

$days = range(2,30);
$smarty->assign("days",$days);
$hours = range(0,23);
$smarty->assign("hours",$hours);

if($_FILES['price_menu_list'])
{
    $original_1 = newgeneralfileupload($_FILES['price_menu_list'], "../../uploads/menu_price_list/", true); 
}
if($_FILES['upload_photo'])
{
    $original_2 = newgeneralfileupload($_FILES['upload_photo'], "../../uploads/user/", true); 
}
#---------------End Time-------------------#
// print_r($_SESSION);
if($_POST['maincategory']!="" && $_POST['subcategory']!="" && $_POST['speciality']!="" )
{
    $starthour=$_POST['start_hour'].":".$_POST['start_min'].":00";
    $endhour=$_POST['end_hour'].":".$_POST['end_min'].":00";
    $starthour1=$_POST['start_hour1'].":".$_POST['start_min1'].":00";
    $endhour1=$_POST['end_hour1'].":".$_POST['end_min1'].":00";
    $_SESSION['merchantabout_business']=$_POST['about_business'];
    $_SESSION['merchantmaincategory']=$_POST['maincategory'];
    $_SESSION['merchantsubcategory']=$_POST['subcategory'];
    $_SESSION['merchantspeciality']=$_POST['speciality'];
    $_SESSION['merchantstarthour']=$starthour;
    $_SESSION['merchantendhour']=$endhour;
    $_SESSION['merchantstarthour1']=$starthour1;
    $_SESSION['merchantendhour1']=$endhour1;
    $_SESSION['merchantmenuprice']=$original_1;
    $_SESSION['merchantphoto']=$original_2;

    @header("Location:".SITEROOT."/registration/merchant_reg_deal_eligibility");
    exit;
}

$smarty->display(TEMPLATEDIR.'/modules/registration/merchant_reg_profilepic.tpl');

$dbObj->Close();
?>