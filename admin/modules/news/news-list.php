<?php
include_once("../../../includes/paging.php");
include_once('../../../includes/SiteSetting.php');

if(!isset($_SESSION['duAdmId']))
	header("location:".SITEROOT . "/admin/login/index.php");

#--------Action-----------#
if(isset($_POST['action']))
{
	extract($_POST);
	$news_id = implode(", ", $news_id);
	
	if($action == "delete")
	{
		$temp = $dbObj->customqry("delete from tbl_news where news_id in (".$news_id.")","");
		$_SESSION['succMsg']="<span class='success'>News Deleted Successfully.</span>";
	}
	header("Location:".$_SERVER['HTTP_REFERER']);
	exit;
}
#---------END-----------#

$rs = $dbObj->cgs("tbl_news", "*", "", "", "news_id", "DESC", "");
if($rs!='n')
{
    while($row = mysql_fetch_assoc($rs))
    {
	    $news[] = $row;
    }
    $smarty->assign("news",$news);
}

if(isset($_SESSION['msg'])){
	$smarty->assign("msg", $_SESSION['msg']);
	unset($_SESSION['msg']);
}

$smarty->assign("inmenu","content");
$smarty->display(TEMPLATEDIR.'/admin/modules/news/news-list.tpl');

$dbObj->Close();
?>