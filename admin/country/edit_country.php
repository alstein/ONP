<?php
include_once('../../includes/SiteSetting.php');
include_once("../../includes/paging.php");
include_once('../../includes/class.message.php');
$msobj= new message();

if(!isset($_SESSION['duAdmId']))
{
   header("location:".SITEROOT . "/admin/login/index.php");
}

if(isset($_SESSION['msg'])){
	$smarty->assign("msg", $_SESSION['msg']);
	unset($_SESSION['msg']);
}

if(isset($_POST['country']))
{

	if($_POST['countryid']){

		$rs=$dbObj->cupdt("mast_country",array("country","vat"),array($_POST['country'],$_POST['vat']), "countryid",$_POST['countryid'],"");
		$_SESSION['msg'] = "<span class='success'>Country updated successfully</span>";
	}
	else
	{
		$rs=$dbObj->cgi("mast_country",array("country","vat", "status"),array($_POST['country'],$_POST['vat'], "Active"),"");
		$_SESSION['msg'] = "<span class='success'>Country added successfully</span>";
	}
	header("location:".SITEROOT."/admin/country/country_list.php");
	exit;
}

$rs=$dbObj->cgs("mast_country","*","countryid",$_GET['countryid'],"","","");
$country=@mysql_fetch_assoc($rs);
$smarty->assign("country",$country);

if(isset($_SESSION['msg'])){
	$smarty->assign("msg", $_SESSION['msg']);
	unset($_SESSION['msg']);
}

$smarty->display(TEMPLATEDIR.'/admin/country/edit_country.tpl');

$dbObj->Close();
?>