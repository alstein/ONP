<?php
include_once('../../../includes/SiteSetting.php');
include_once('../../../includes/classes/class.forum.php');
$forumObj = new Forum();

if(!$_SESSION['duAdmId'])
	header("location:".SITEROOT . "/admin/login/index.php");

if($_POST['title'])
{
	if($_POST['forumid'])
		$forumObj->updateForum();
	else
		$forumObj->addForumByAdmin();
	header("Location: index.php");
	exit;
}

#--------------------Create Forum Topic----------------------#
if($_GET['forumid'])
{
	$rs = $dbObj ->cgs('tbl_forum' ,"", "forumid", $_GET['forumid'], "" , "" , "");
	$forum = @mysql_fetch_assoc($rs);
	$smarty->assign("forum",$forum);
}
#-------------------------END---------------------------#

$smarty->assign("categories", $forumObj->getCategories());


#---------------Get Deal name and Title start----------------#
$date = date("Y-m-d H:i:s");
$cnd = "admin_approve = 'yes' and admin_review = '1' and deal_status = '1' and (start_date <= '$date' and end_date >= '$date')";


$rs = $dbObj->gj("tbl_deal", "deal_unique_id,title", $cnd, "", "", "", "", "");
		while($deal = @mysql_fetch_assoc($rs))
		{
		$dealreturn[]=$deal;
		}
		
		$smarty->assign("deal", $dealreturn);
// 		echo "<pre>";
// 		print_r($dealreturn);
// 		exit;
#---------------Get Deal name and Title End----------------#

if($_SESSION['msg'])
{
	$smarty->assign("msg", $_SESSION['msg']);
	unset($_SESSION['msg']);
}
$smarty->assign("inmenu", "sitemodules");
$smarty->display(TEMPLATEDIR . '/admin/modules/forum/create_forum.tpl');

$dbObj->Close();
?>