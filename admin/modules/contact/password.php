<?php
include_once('../../../includes/SiteSetting.php');
include_once('../../../includes/class.message.php');
$msobj= new message();

   if(isset($_SESSION['msg'])){
      $smarty->assign("msg", $_SESSION['msg']);
      unset($_SESSION['msg']);
   }


   if(!isset($_SESSION['duAdmId']))
   header("location:".SITEROOT . "/admin/login/index.php");

	$rs=$dbObj->customqry("select * from beta_password where id=1","");
	$row=@mysql_fetch_assoc($rs);
	$smarty->assign("password",$row['password']);

	if($_POST['Update']){

		$dbObj->customqry("update beta_password set password='".$_POST['password']."'","");
		$_SESSION['msg']="Password updated successfully";
		header("location:password.php");
	}
  
  $smarty->display(TEMPLATEDIR . '/admin/modules/contact/password.tpl');

   $dbObj->Close();
?>