<?php
include_once('../../includes/SiteSetting.php');
include_once('../../includes/class.message.php');
include_once("../../includes/common.lib.php");
$msobj= new message();

if(!isset($_SESSION['duAdmId']))
	header("location:".SITEROOT . "/admin/login/index.php");
	


if(isset($_POST['password']))
{

        extract($_POST);
	$fl = array("category_name","description","status");
	$vl = array($category_name,$description,'Active');
// 	print_r($vl);
// 	exit;
	$resIns = $dbObj->cgi('tbl_seller_category',$fl,$vl,'');


	
}




if(isset($_SESSION['msg'])){ $smarty->assign("msg", $_SESSION['msg']); unset($_SESSION['msg']);}

$smarty->assign("inmenu","user");
$smarty->display(TEMPLATEDIR . '/admin/user/add_seller_category.tpl');
$dbObj->Close();
?>