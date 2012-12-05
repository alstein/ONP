<?
include_once("../../../includes/paging.php");
include_once('../../../includes/SiteSetting.php');
include_once('../../../includes/classes/class.forum.php');
$forumObj = new Forum();

if(!$_SESSION['duAdmId'])
	header("location:".SITEROOT . "/admin/login/index.php");

if($_POST['action'])
{
	extract($_POST);
	$threadid = implode(", ", $threadid);
		
	if($action == "delete")
	{	
		$temp = $dbObj->customqry("delete from tbl_forum_reply where threadid in (".$threadid.")","");
		$temp = $dbObj->customqry("delete from tbl_forum_thread where threadid in (".$threadid.")","");			
		$_SESSION['msg']="<span class='success'>Thread(s) deleted successfully.</span>";
	}
	header("Location:".$_SERVER['HTTP_REFERER']);
	exit;
}

#-------GEtting Forum Details-------------
if($_GET['forumid'])
{
  $forumidc=$_GET['forumid']; 
  $forumid=$forumObj->clean_url($forumidc);	
  $forum = $forumObj->getForumTopic($forumid);
}
$smarty->assign("forum", $forum);
	
if($_GET['forumid'])
{
    $forumidc=$_GET['forumid']; 
    $forumid=$forumObj->clean_url($forumidc);	
    $threadArray = $forumObj->getAdminThreads("thread_list.php",$page,$_GET['search'], $forumid,$forums_per_page = 10,1);
}
$smarty->assign("threads", $threadArray['threads']);
$smarty->assign("paging", $threadArray['showpaging']);
$smarty->assign("pagination", $threadArray['paging']);
#---------END--------------

if($_SESSION['msg'])
{
	$smarty->assign("msg",$_SESSION['msg']);
	unset($_SESSION['msg']);
}
$smarty->assign("inmenu", "sitemodules");
$smarty->assign("siteimg", SITEIMG);
$smarty->display(TEMPLATEDIR . '/admin/modules/forum/thread_list.tpl');

$dbObj->Close();
?>