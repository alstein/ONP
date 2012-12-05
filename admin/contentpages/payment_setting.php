<?php
include_once('../../includes/SiteSetting.php');

if(!isset($_SESSION['duAdmId']))
	header("location:".SITEROOT . "/admin/login/index.php");


	
$rs = $dbObj->gj("tbl_payment_setting", "*", "1","","", "", "", "");
$array=@mysql_fetch_array($rs);
$smarty->assign("array",$array);

if($_POST['submit'])
{
extract($_POST);
$dbObj->cupdt("tbl_payment_setting",array("paymentmode","paypal_account","autho_login","password","signature"),array($paymentmode,$paypal_account,$autho_login,$password,$signature),"id","1","");
$_SESSION['msg']="<span class='success'>Paypal Information Updated Successfully.</span>";
header("Location:".$_SERVER['HTTP_REFERER']);
exit;
}
#--------Messaging----------------
if($_SESSION['msg'])
	{
	$smarty->assign("msg", $_SESSION['msg']);
	$_SESSION['msg'] = NULL;
	unset($_SESSION['msg']);
	}
#----------END---------------

$smarty->display(TEMPLATEDIR .'/admin/contentpages/payment_setting.tpl');
$dbObj->Close();
?>