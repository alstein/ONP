<?php
include_once("../../include.php");
// include_once("../../includes/paging.php");
include_once('../../includes/SiteSetting.php');
include_once('../../includes/classes/class.forum.php');

$dbObj->not_login();
$fmObj = new Forum();

#----For display sub tool-------#
$subtool = "yes";
$smarty->assign("subtool",$subtool);
#---End of display sub tool-----------#

if($_POST['title'])
{
	$fmObj->addThread();
	header("Location: ".SITEROOT."/forum/thread-list/?forumid=".$_POST['forumid']."");
	exit;
}

/*--------------------Create Forum Topic------------------------*/
if($_GET['forumid'])
{
   $forumidc=$_GET['forumid']; 
  echo  $forumid=$dbObj->sanitize($forumidc);

	$forum = $fmObj->getForumTopic($forumid);
	$smarty->assign("forum",$forum);
}
//Get meta tags of the page as per id

$call_meta=$dbObj->meta_SEO(24);
$smarty->assign("row_meta",$call_meta);

if($_SESSION['msg'])
{
	$smarty->assign("msg", $_SESSION['msg']);
	$_SESSION['msg']=NULL;
	unset($_SESSION['msg']);
}
#----------For Captcha (See code in sitesetting.php)---------
$smarty->assign('ShowCaptcha', $CapchaObj->record['Captcha_Forum']);
include("../../editor/fckeditor.php");
$oFCKeditor = new FCKeditor('description') ;
$oFCKeditor->BasePath = SITEROOT . '/editor/';
$oFCKeditor->Value = stripslashes($page['description']);
$oFCKeditor->Width  = '100%';
$oFCKeditor->Height = '300';
$smarty->register_object("oFCKeditor", $oFCKeditor);
#-------------END-------------------

$smarty->assign("tpid",$tpid);


$smarty->display(TEMPLATEDIR . '/modules/forums/create_thread.tpl');
$dbObj->Close();
?>