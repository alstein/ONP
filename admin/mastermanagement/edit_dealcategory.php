<?
include_once("../../include.php");

if(!isset($_SESSION['duAdmId']))
	exit;
	
if(isset($_POST['category']))
{

	if($_POST['categoryid'])
	{
		
		$rs=$dbObj->cupdt("mast_deal_category",array("category",date),array($_POST['category']
	,date("Y-m-d")), "id",$_POST['categoryid'],"");
		//print_r($rs);
		$_SESSION['msg'] = "<span class='success'>".getErrorMessage(72)."</span>";
	}
	else
	{
		$rs=$dbObj->cgi("mast_deal_category",array("category",date),array($_POST['category'], date("Y-m-d")),"");
		$_SESSION['msg'] = "<span class='success'>".getErrorMessage(71)."</span>";
	}
	?><script type="text/javascript">window.setTimeout('parent.location.reload();', 10);</script><?
	exit;
}


$rs=$dbObj->cgs("mast_deal_category","*","id",$_GET['categoryid'],"","","");
$category=@mysql_fetch_assoc($rs);
//print_r($rs);
$smarty->assign("category",$category);


$smarty->assign("header", TEMPLATEDIR."/admin/lightBoxHeader.tpl");
$smarty->assign("footer",TEMPLATEDIR."/admin/lightBoxFooter.tpl");
$smarty->display(TEMPLATEDIR.'/admin/mastermanagement/edit_dealcategory.tpl');

$dbObj->Close();
?>