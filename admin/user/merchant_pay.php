<?php
include_once('../../includes/SiteSetting.php');
include_once('../../includes/class.message.php');
$msobj= new message();

   if(!isset($_SESSION['duAdmId']))
   header("location:".SITEROOT . "/admin/login/index.php");


 	$select=$dbObj->customqry("select * from tbl_merchant_pay where id=1","");
	$fetch_select=mysql_fetch_assoc($select);
	$merchant_pay=$fetch_select['merchant_pay'];
	$smarty->assign("merchant_pay",$merchant_pay);

	$customer_pay=$fetch_select['customer_pay'];
	$smarty->assign("customer_pay",$customer_pay);

	$select_pay=$dbObj->customqry("select * from tbl_merchant_pay","");
	$count=@mysql_num_rows($select_pay);
   if($_POST['Update'])
   {
	extract($_POST);
		
	if($count>0)
	{
	$update=$dbObj->customqry("update tbl_merchant_pay set 	merchant_pay ='".$merchant_pay ."',customer_pay ='".$customer_pay."' where id=1","");
	}
	else
	{
	$insert=$dbObj->customqry("insert into tbl_merchant_pay(merchant_pay)values('".$merchant_pay."')","");
	}
	$_SESSION['msg']="Record updated successfully";
	@header("location:".SITEROOT."/admin/user/merchant_pay.php"); exit;
   }
   if(isset($_SESSION['msg'])){
      $smarty->assign("msg", $_SESSION['msg']);
      unset($_SESSION['msg']);
   }
  
  $smarty->display(TEMPLATEDIR . '/admin/user/merchant_pay.tpl');

   $dbObj->Close();
?>