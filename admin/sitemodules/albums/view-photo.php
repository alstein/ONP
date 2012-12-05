<?php
include_once("../../../includes/paging.php");
include_once('../../../includes/SiteSetting.php');
if(!$_SESSION['duAdmId'])
{
	header("location:".SITEROOT . "/admin/login/home.php");
	exit();
}

// if($_POST['submit'] == "Go" and $_POST['comid'] != '')
// {
// // echo "in if";
// 	$comids = implode(",", $_POST['comid']);
// 
// 	$delcom = $dbObj->customqry("delete from tbl_comments where id in (".$comids.")","");
// // 	$id = $dbObj->gdel('tbl_comments', "id", $_GET['comid'], ""); 
// 	header("location:".SITEROOT."/admin/sitemodules/albums/view-photo.php?vid=".$_GET['vid']);
// 	exit();
// }
extract($_GET);

// $cnd = "photoid=".$_GET['vid'];
// $rs = $dbObj->gj("tbl_accomplishment_photo", "*", $cnd, "", "", "", $l, "");//exit;
// $cat = @mysql_fetch_assoc($rs);

// echo "<pre>";print_r($cat);exit;	




$tbl="tbl_accomplishment_photo b ";
		$sf="b.*";
		$cnd = "b.photoid = ".$_GET['vid'] ."";
		$rs = $dbObj->gj($tbl, $sf, $cnd, "", "", "", $l, "");
		if(is_resource($rs))
{
	$cat = mysql_fetch_assoc($rs);
}
 

$smarty->assign("cat", $cat);


//   echo "<pre>";
//   print_r($cat);
// exit;









#------Getting comment Info--------------

// 	$tbl1 = "tbl_comments as c, users as u";
// 	 $sf1 = "c.*,u.*";
//  	$ob1 = "c.date_added desc";
// 	$cnd1 = "c.moduleid=3 and c.userid =u.userid and c.itemid = ".$cat['photo_id'];
// 
//  	$cmt1 = $dbObj->gj($tbl1, $sf1, $cnd1, $ob1, "", "", "", "");
// 	$i=0;
//  while($row = @mysql_fetch_assoc($cmt1))
// 	{
// 		$comm[$i] = $row;
// 		$i++;
// 	}


#----------------- add comment --------------------------------#
// if($_POST['submit'])
// {
// 	
//        $_f = array('moduleid', 'itemid', 'userid', 'comment', 'date_added','status');
//        $_v = array(3,$_GET['vid'], $_SESSION['duAdmId'], $_POST['comment'], date('Y-m-d H:i:s'),'Active');
//        $id = $dbObj->cgi('tbl_comments', $_f, $_v, "");//exit;
// 
//        $_SESSION['msg']="<span class='success'>Comment(s) Posted Successfully </span>";
//        header("location:".SITEROOT."/admin/sitemodules/albums/view-photo.php?vid=".$_GET['vid']);
//        exit();
// }
#------------ end ---------------------------------------------#
// $smarty->assign("photocomments",$comm);

if($_SESSION['msg'])
{
	$smarty->assign("msg",$_SESSION['msg']);	
	$_SESSION['msg']=NULL;
	unset($_SESSION['msg']);
}


$smarty->assign("inmenu","sitemodules");
$smarty->assign("leftadminmenu","albums");
$smarty->display(TEMPLATEDIR . '/admin/sitemodules/albums/view-photo.tpl');

$dbObj->Close();
?>