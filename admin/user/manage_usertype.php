<?
include_once("../../includes/paging.php");
include_once('../../includes/SiteSetting.php');

if(!isset($_SESSION['duAdmId']))
	header("location:".SITEROOT . "/admin/login/index.php");

#--------Action-----------#
if(isset($_POST['action']))
{
	extract($_POST);
	$typeid = @implode(",",$typeid);
	
	if($action == "delete")
	{
		$temp = $dbObj->customqry("delete from mast_usertype where typeid in (".$typeid.")","");
		$_SESSION['succMsg']="<span class='success'>Page(s) Deleted Successfully.</span>";
	}
	header("Location:".$_SERVER['HTTP_REFERER']);
	exit;
}
#---------END-----------#

$rs = $dbObj->cgs("mast_usertype", "", "", "", "", "", "");
while($row = mysql_fetch_assoc($rs))
{
 	$type[] = $row;
}
$smarty->assign("type",$type);

if(isset($_SESSION['msg'])){
	$smarty->assign("msg", $_SESSION['msg']);
	unset($_SESSION['msg']);
}

$smarty->assign("inmenu","user");
$smarty->display(TEMPLATEDIR.'/admin/user/manage_usertype.tpl');

$dbObj->Close();
?>