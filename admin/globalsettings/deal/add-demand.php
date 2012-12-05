<?php
include_once('../../../includes/SiteSetting.php');
include_once('../../../includes/class.message.php');

if(!$_SESSION['duAdmId'])
{
    header("location:".SITEROOT . "/admin/login/index.php");
    exit;
}

#------------Check For access----------#
if(!(in_array("14", $arr_modules_permit)))
{
      unset($_SESSION['duAdmId']);
      $s=$msobj->showmessage(166);
      $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";

      header("location:".SITEROOT . "/admin/login/index.php");
      exit;
}
#----------End Check For access----------#


if(isset($_GET['status']))
{
	if($_GET['status']=="Active")
		$id=$dbObj->cupdt("tbl_deal_demand", "status", "Inactive", "pageid", $_GET['pageid'], "");
	else
		$id=$dbObj->cupdt("tbl_deal_demand", "status", "Active", "pageid", $_GET['pageid'], "");
	$_SESSION['msg']="<span class='success'>Status changed successfully.</span>";
	header("Location: page_list.php");
	exit;
}

//To Save Data
if(isset($_POST['product_name']))
{
	extract($_POST);
	$description = addslashes($description);
	if($id != "")
		$id=$dbObj->cupdt("tbl_deal_demand", array("product_name", "description", "status"), array($product_name, $description, $status), "id", $id, "");
	else
		$id=$dbObj->cgi("tbl_deal_demand", array("product_name", "description","status"), array($product_name, $description,$status), "");
	$_SESSION['msg']="<span class='success'>Deal demand saved successfully.</span>";
	header("Location: In-demand.php");
	exit;
}

if(isset($_GET['id'])!="")
{
$rs = $dbObj->cgs("tbl_deal_demand", "*", "id", $_GET['id'], "", "", "");
$dem=mysql_fetch_assoc($rs);
$smarty->assign("dem", $dem);
}
include("../../../editor/fckeditor.php");
$oFCKeditor = new FCKeditor('description') ;
$oFCKeditor->BasePath = '../../../editor/';
$oFCKeditor->Value = stripslashes(html_entity_decode($dem['description']));
$oFCKeditor->Width  = '100%';
$oFCKeditor->Height = '500';
$smarty->register_object("oFCKeditor", $oFCKeditor);

$smarty->assign("inmenu","content");

$smarty->display(TEMPLATEDIR . '/admin/globalsettings/deal/add-demand.tpl');

$dbObj->Close();
?>