<?php
include_once('../../../includes/SiteSetting.php');
include_once('../../../includes/class.message.php');
$msobj= new message();

   if(!isset($_SESSION['duAdmId']))
   header("location:".SITEROOT . "/admin/login/index.php");


 	$select=$dbObj->customqry("select * from tbl_company_contact where id=1","");
	$fetch_select=mysql_fetch_assoc($select);
	$phone=$fetch_select['phone'];
	//$fax=$fetch_select['fax'];
	$general_enquiry=$fetch_select['general_enquiry'];
	$sales_enquiry=$fetch_select['sales_enquiry'];
	$smarty->assign("phone",$phone);
//	$smarty->assign("fax",$fax);
	$smarty->assign("general_enquiry",$general_enquiry);
	$smarty->assign("sales_enquiry",$sales_enquiry);
	$count=mysql_num_rows($select);


   if($_POST['Update'])
   {

	//echo "<pre>"; print_r($_POST);

	$phone = $_POST['phone'];
	$fax = $_POST['fax'];

	extract($_POST);
	if($count>0)
	{

	$update=$dbObj->customqry("UPDATE tbl_company_contact SET phone='".$phone."',fax='".$fax."',general_enquiry='".$general_enquiry."', sales_enquiry='".$sales_enquiry."' WHERE id = 1","");
	}
	else
	{
	$insert=$dbObj->customqry("insert into tbl_company_contact(phone,general_enquiry,sales_enquiry)values('".$phone."','".$general_enquiry."' ,'".$sales_enquiry."')","");
	}
	$_SESSION['msg']="Record updated successfully";
	@header("location:".SITEROOT."/admin/modules/contact/company_contact.php"); exit;
   }
   if(isset($_SESSION['msg'])){
      $smarty->assign("msg", $_SESSION['msg']);
      unset($_SESSION['msg']);
   }
  
  $smarty->display(TEMPLATEDIR . '/admin/modules/contact/company_contact.tpl');

   $dbObj->Close();
?>