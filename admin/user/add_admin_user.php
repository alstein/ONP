<?php
include_once('../../includes/SiteSetting.php');
require_once("../../includes/classes/class.registration.php");
require_once("../../includes/common.lib.php");

if(!isset($_SESSION['duAdmId'])){ header("location:".SITEROOT . "/admin/login/index.php"); }
if(!isset($_POST['Submit'])){
	$_SESSION['cities_name'] = array();
	$_SESSION['states_ids'] = array();
}



if(isset($_POST['username'])){
  extract($_POST);
  $flag = true;

  if($flag){
    $fl = array("first_name",'username','password','usertypeid',"signup_date",'status','access_level','note','added_by');
    $vl = array($first_name,$username,md5($password),1,date("Y-m-d H:i:s"),$status,$access_level,$note, $_SESSION['duAdmId'] );
    $rs = $dbObj->cgi('tbl_users',$fl,$vl,'');

    $_SESSION['msg']="<span class='success'>Admin User Added Successfully</span>";
    header("Location:".SITEROOT."/admin/user/admin_users_list.php");
    exit;
   }
}


if(isset($_SESSION['msg'])){ $smarty->assign("msg", $_SESSION['msg']); unset($_SESSION['msg']);}

$smarty->assign("inmenu","user");
$smarty->display(TEMPLATEDIR . '/admin/user/add_admin_user.tpl');
$dbObj->Close();
?>
