<?php
include_once('../../../includes/SiteSetting.php');
include_once("../../../includes/paging.php");

if(!$_SESSION['duAdmId'])
{
	@header("location:".SITEROOT . "/admin/login/home.php");
	exit();
}

#--------Action-----------#
if(isset($_POST['action']))
{
	extract($_POST);
if($album_id!='')
{
	$album_id = @implode(", ", $album_id);
	if($action == "active")
	{
		$temp = $dbObj->customqry("UPDATE tbl_album SET status = 'Active' where album_id in (".$album_id.")","");
		$_SESSION['msg']="<span class='successMsg'>Album activated Successfully.</span>";
	}
	elseif($action == "inactive")
	{
		$temp = $dbObj->customqry("UPDATE tbl_album SET status = 'Inactive' where album_id in (".$album_id.")","");
		$_SESSION['msg']="<span class='successMsg'>Album Inactivated Successfully.</span>";
	}
	elseif($action == "delete")
	{
		$res = $dbObj->gj("tbl_accomplishment_photo", "image", "album_id in (".$album_id.")","","","","","");
		while($row = @mysql_fetch_assoc($res))
		{
			@unlink('../../../uploads/post_accomplish/52X52/'.$row['image']);
			@unlink('../../../uploads/post_accomplish/90X90/'.$row['image']);
			@unlink('../../../uploads/post_accomplish/145X145/'.$row['image']);
			@unlink('../../../uploads/post_accomplish/400X400/'.$row['image']);
			@unlink('../../../uploads/post_accomplish/600X600/'.$row['image']);
			@unlink('../../../uploads/post_accomplish/thumbnail/'.$row['image']);
			@unlink('../../../uploads/post_accomplish/413X270/'.$row['image']);
			$del = $dbObj->customqry("DELETE FROM tbl_accomplishment_photo where photoid IN (".$row['photoid'].")", "");
			$del = $dbObj->customqry("DELETE FROM tbl_reports where itemid IN (".$row['photoid'].") AND moduleid='3'", "");
			$del = $dbObj->customqry("DELETE FROM tbl_comments where itemid IN (".$row['photoid'].") AND moduleid='1'", "");
			$del = $dbObj->customqry("DELETE FROM tbl_photo_tag where photoid IN (".$row['photoid'].")", "");
			$cupdt = $dbObj->customqry("UPDATE tbl_accomplishment SET trophy_case=0 WHERE trophy_case = IN (".$row['photoid'].")","");
			$cupdt = $dbObj->customqry("UPDATE tbl_accomplishment SET accomplishment_cover=0 WHERE accomplishment_cover IN (".$row['photoid'].")","");

		}
		$temp = $dbObj->customqry("delete from tbl_album where album_id in (".$album_id.")","");
		$temp = $dbObj->customqry("delete from tbl_accomplishment_photo where album_id in (".$album_id.")","");
		$_SESSION['msg']="<span class='successMsg'>Album Deleted Successfully.</span>";
	}
	@header("Location:".$_SERVER['HTTP_REFERER']);
	exit();
}
}
#---------END-------------#


$tbl = "tbl_album as a,tbl_users as u";
$sf = "a.*,u.first_name,u.last_name,u.first_name as fname,u.last_name as lname,u.userid";
$cnd = "a.user_id=u.userid and a.album_title like '%".$_GET['search']."%'";

$rs = $dbObj->gj($tbl, $sf , $cnd, "", "", "", $l, "1");//exit;
$i=0;
while($row = @mysql_fetch_assoc($rs))
{
	$cat[$i] = $row;
	$i++;
}
if($_SESSION['msg'])
{
	$smarty->assign("msg",$_SESSION['msg']);	
	$_SESSION['msg']=NULL;
	unset($_SESSION['msg']);
}

//echo "<pre>";print_r($cat);exit;	
$smarty->assign("cat", $cat);


$smarty->assign("inmenu","sitemodules");
$smarty->assign("leftadminmenu","albums");
$smarty->display(TEMPLATEDIR . '/admin/sitemodules/albums/album.tpl');

$dbObj->Close();
?>