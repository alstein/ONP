<?php
include_once('../../includes/SiteSetting.php');
include_once("../../includes/paging.php");
include_once('../../includes/class.message.php');
$msobj= new message();

if(!isset($_SESSION['duAdmId']))
{
   header("location:".SITEROOT . "/admin/login/index.php");
}
	
if(isset($_POST['states']))
{
	if($_POST['stateid']){

		$rs=$dbObj->cupdt("mast_state",array("country_id", "state_name"),array($_POST['countryid'],$_POST['states']), "id",$_POST['stateid'],"");
		$_SESSION['msg'] = "<span class='success'>State updated successfully</span>";
	}
	else
	{
		$rs=$dbObj->cgi("mast_state",array("country_id", "state_name", "active"),array($_POST['countryid'],$_POST['states'], "1"),"");
		$_SESSION['msg'] = "<span class='success'>State added successfully</span>";
	}
	
	header("location:".SITEROOT."/admin/state/state_list.php?contryid=".$_POST['countryid']);
	exit;
}

/* Get all countrys*/

        $rs=$dbObj->cgs("mast_country","*","countryid",$_GET['countryid'],"country","","");
	//$rs=$dbObj->cgs("mast_country","*","status","Active","","","");
	while($row=@mysql_fetch_assoc($rs))
	{
		$country = $row;
	}
	
	$smarty->assign("country",$country);

/* Get state*/

$rs1=$dbObj->cgs("mast_state","*","id",$_GET['stateid'],"","","");
$state=@mysql_fetch_assoc($rs1);
$smarty->assign("state",$state);


$smarty->display(TEMPLATEDIR.'/admin/state/edit_state.tpl');

$dbObj->Close();
?>