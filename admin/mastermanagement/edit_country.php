<?
	include_once("../../include.php");

if(!isset($_SESSION['duAdmId']))
	header("location:".SITEROOT . "/admin/login/index.php");

if(isset($_SESSION['msg'])){
	$smarty->assign("msg", $_SESSION['msg']);
	unset($_SESSION['msg']);
}

if(isset($_POST['country']))
{

	if($_POST['countryid']){

		$rs=$dbObj->cupdt("mast_countryname",array("country", "active"),array($_POST['country'], $_POST['status']), "id",$_POST['countryid'],"");
		$_SESSION['msg'] = "<span class='success'>".getErrorMessage(78)."</span>";
	}
	else
	{
		$rs=$dbObj->cgi("mast_countryname",array("country", "active"),array($_POST['country'], $_POST['status']),"");
		$_SESSION['msg'] = "<span class='success'>".getErrorMessage(77)."</span>";
	}
		?><script type="text/javascript">window.setTimeout('parent.location.reload();', 10);</script><?
	exit;
}


$rs=$dbObj->cgs("mast_countryname","*","id",$_GET['countryid'],"","","");
$country=@mysql_fetch_assoc($rs);
$smarty->assign("country",$country);


$smarty->display(TEMPLATEDIR.'/admin/mastermanagement/edit_country.tpl');

$dbObj->Close();
?>