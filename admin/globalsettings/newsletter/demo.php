<?
include_once('../../../includes/SiteSetting.php');
include_once("../../../includes/paging.php");
include_once('../../../includes/class.message.php');
$msobj= new message();

//print_r($_SESSION["demorec"]);exit;

$demorec=$_SESSION["demorec"];
$smarty->assign("demorec",$demorec);

$cityid = $_SESSION["demorec"]['city_id'];
//echo $cityid;exit;

if($cityid)
{
	$cd="city_id = ".$cityid;
	$dbres = $dbObj->gj('mast_city', "*" , $cd, "", "","", "", "");
	$row = @mysql_fetch_assoc($dbres);
	//print_r($row);exit;
	$smarty->assign("row",$row['city_name']);
}

#------------------------------------------------------------------------------------------------------------
$smarty->display(TEMPLATEDIR . '/admin/globalsettings/newsletter/demo.tpl');

$dbObj->Close();
?>