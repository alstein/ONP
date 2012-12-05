<?
include_once('../../../includes/SiteSetting.php');
include_once("../../../includes/paging.php");
include_once('../../../includes/class.message.php');
$msobj= new message();



$demorec=$_SESSION["demorec"];
$smarty->assign("demorec",$demorec);



#------------------------------------------------------------------------------------------------------------
$smarty->display(TEMPLATEDIR . '/admin/globalsettings/newsletter/demo.tpl');

$dbObj->Close();
?>