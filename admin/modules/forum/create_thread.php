<?
include_once('../../../includes/SiteSetting.php');
include_once('../../../includes/classes/class.forum.php');
$forumObj = new Forum();


if(!$_SESSION['duAdmId'])
	header("location:".SITEROOT . "/admin/login/index.php");

/*--------------------Create Forum Topic------------------------*/
if(isset($_POST['title']))
{
	if($_POST['threadid'])
		$forumObj->updateThread();
	else
		$forumObj->addThreadByAdmin();
	header("Location: thread_list.php?forumid=".$_GET['forumid']);
	exit;
}

$forum = $forumObj->getForumTopic($_GET['forumid'], true);
$smarty->assign("forum",$forum);

if($_GET['threadid'])
{
	$thread = $forumObj->getThread($_GET['threadid'], true);
	$smarty->assign("thread",$thread);
}

if($_SESSION['msg'])
{
	$smarty->assign("msg", $_SESSION['msg']);
	$_SESSION['msg']=NULL;
	unset($_SESSION['msg']);
}

$smarty->assign("inmenu", "sitemodules");
$smarty->display(TEMPLATEDIR . '/admin/modules/forum/create_thread.tpl');

$dbObj->Close();
?>