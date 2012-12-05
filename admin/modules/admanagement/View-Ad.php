<?
include_once("../../../includes/paging.php");
include_once('../../../includes/SiteSetting.php');

if(!$_SESSION['duAdmId'])
	header("location:".SITEROOT . "/admin/login/index.php");
	
	extract($_POST);
	extract($_GET);

if($_GET['ad_id'])
{
	$tbl="tbl_ads";
	$sf="";
	$cnd="ad_id=".$_GET['ad_id'];
	$rs=$dbObj->gj($tbl, $sf, $cnd, "", "", "", "", "");
	$ad=@mysql_fetch_assoc($rs);
}

$smarty->assign("ad",$ad);
$smarty->assign("inmenu","gsetting");
$smarty->display( TEMPLATEDIR . '/admin/modules/admanagement/View_Ad.tpl');
$dbObj->Close(); 
?>
