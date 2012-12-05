<?php
include_once("../../includes/paging.php");
include_once('../../includes/SiteSetting.php');

if(!isset($_SESSION['duAdmId']))
	header("location:".SITEROOT . "/admin/login/index.php");

#--------Action-----------#
if(isset($_POST['action']))
{
	extract($_POST);
	$pageid = implode(", ", $pageid);
	if($action == "active")
        {
             $id = $dbObj->customqry("update tbl_pages set status = 'Active' where pageid in (".$pageid.")","");
             //$_SESSION['msg'] = "record actived.";
             $_SESSION['msg']="<span class='success'>Page(s) Activate Successfully.</span>";
        }
        elseif($action == "inactivate")
        {
             $id = $dbObj->customqry("update tbl_pages set status = 'Inactive' where pageid in (".$pageid.")","");
	     //$_SESSION['msg'] = "record inactived.";
            $_SESSION['msg']="<span class='success'>Page(s) Inactivate Successfully.</span>";
        }	
	elseif($action == "delete")
	{
		$temp = $dbObj->customqry("delete from tbl_pages where pageid in (".$pageid.")","");
		$_SESSION['msg']="<span class='success'>Page(s) Deleted Successfully.</span>";
	}
	header("Location:".$_SERVER['HTTP_REFERER']);
	exit;
}
#---------END-----------#

$rs = $dbObj->cgs("tbl_pages p LEFT JOIN tbl_page_category c ON p.page_cat = c.id", "p.*,c.title as page_category", "", "", "pageid", "DESC", "");
while($row = mysql_fetch_assoc($rs))
{
 	$pages[] = $row;
}
$smarty->assign("pages",$pages);

if(isset($_SESSION['msg'])){
	$smarty->assign("msg", $_SESSION['msg']);
	unset($_SESSION['msg']);
}

$smarty->assign("inmenu","content");
$smarty->display(TEMPLATEDIR.'/admin/contentpages/page_list.tpl');

$dbObj->Close();
?>