<?
	include_once("../../include.php");

if(!isset($_SESSION['duAdmId']))
	exit;
	
if(isset($_POST['states']))
{
	if($_POST['stateid']){

		$rs=$dbObj->cupdt("mast_state",array("country_id", "state_name", "active"),array($_POST['countries'],$_POST['states'], $_POST['status']), "id",$_POST['stateid'],"");
		$_SESSION['msg'] = "<span class='success'>".getErrorMessage(93)."</span>";
	}
	else
	{
		$rs=$dbObj->cgi("mast_state",array("country_id", "state_name", "active"),array($_POST['countries'],$_POST['states'], $_POST['status']),"");
		$_SESSION['msg'] = "<span class='success'>".getErrorMessage(92)."</span>";
	}
	?><script type="text/javascript">window.setTimeout('parent.location.reload();', 10);</script><?
	exit;
}

/* Get all countrys*/

	$rs=$dbObj->cgs("mast_countryname","*","","","","","");
	while($row=@mysql_fetch_assoc($rs))
	{
		$country[] = $row;
	}
	$smarty->assign("country",$country);

/* Get state*/

$rs1=$dbObj->cgs("mast_state","*","id",$_GET['stateid'],"","","");
$state=@mysql_fetch_assoc($rs1);
$smarty->assign("state",$state);


$smarty->display(TEMPLATEDIR.'/admin/mastermanagement/edit_state.tpl');

$dbObj->Close();
?>