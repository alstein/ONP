<?php
include_once('../../../includes/SiteSetting.php');
include_once('../../../includes/paging.php');
include_once('../../../includes/classes/class.forum.php');
include_once('../../../includes/class.message.php');
$forumObj = new Forum();

if(!isset($_SESSION['duAdmId']))
{
      header("location:".SITEROOT . "/admin/login/index.php");
      exit;
}
#------------Check For access----------#
/*if(!(in_array("32", $arr_modules_permit)))
{
      unset($_SESSION['duAdmId']);
      $s=$msobj->showmessage(166);
      $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";

      header("location:".SITEROOT . "/admin/login/index.php");
      exit;
}*/
#----------End Check For access----------#

/*-----------------------------------Message section-----------------------------------*/
if($_POST['action'])
{
	extract($_POST);
	$forumid = implode(", ", $forumid);
	if($action == 'approve')
	{
		$rs = $dbObj->customqry("update tbl_forum set verification='yes', status='Active' where forumid in (".$forumid.")", "");
		$_SESSION['msg']="<span class='success'>Discussion approved successfully.</span>";
	}
	elseif($action == "active")
	{
		$id = $dbObj->customqry("update tbl_forum set status = 'Active' where forumid in (".$forumid.")","");
		$_SESSION['msg']="<span class='success'>Discussion activated successfully</span>";
	}
	elseif($action == "inactive")
	{
		$id = $dbObj->customqry("update tbl_forum set status = 'Inactive' where forumid in (".$forumid.")","");
		$_SESSION['msg']="<span class='success'>Discussion inactivated successfully</span>";
	}
	elseif($action == "delete")
	{
	    $fids = $_POST['forumid'];
		foreach($fids as $id)
		{ 
			$threads = $forumObj->getThreads('', $id);
                        // echo "<pre>";print_r($threads);exit;
			//$threads = $threads['threads'];
         
			if(is_array($threads))
			{
				foreach($threads as $x)
					$tids[]= $x['threadid'];
				$tids = implode(", ", $tids);
				
				$temp = $dbObj->customqry("delete from tbl_forum_reply where threadid in (".$tids.")","");
				$temp = $dbObj->customqry("delete from tbl_forum_thread where threadid in (".$tids.")","");			
			}
		}
 
		$temp = $dbObj->customqry("delete from tbl_forum where forumid in (".$forumid.")","");
		 
		$_SESSION['msg']="<span class='success'>Discussion(s) deleted successfully.</span>";
	}
	header("Location:".$_SERVER['HTTP_REFERER']);
	exit;
}


#--------GEtting Forum List-------------
$categories = $forumObj->getCategoriesByAdmin(true);
$i=0;
foreach($categories as $category)
{
        if($_GET['uname'])
            $uname= $_GET['uname'];
        else
            $uname= "";

        if($_GET['search'])
            $srch= $_GET['search'];
        else
            $srch= "";

	$forums = $forumObj->getForumsByAdmin( $uname ,$srch , $category['categoryid'], true);
	$ForumArray[$i] =  $category;
	$ForumArray[$i]['forums'] = $forums;
	$i++;
}
$smarty->assign("forumarray", $ForumArray);
#-----------END-----------------

#---------------Get all username-------------#
$user_list = $forumObj->getAllUserName();
$smarty->assign("user_list", $user_list);
#---------------Get all username-------------#

if($_SESSION['msg'])
{
	$smarty->assign("msg",$_SESSION['msg']);	
	$_SESSION['msg']=NULL;
	unset($_SESSION['msg']);
}

$smarty->assign("inmenu", "sitemodules");
$smarty->assign("siteimg", SITEIMG);
$smarty->display(TEMPLATEDIR . '/admin/modules/forum/index.tpl');

$dbObj->Close();
?>
