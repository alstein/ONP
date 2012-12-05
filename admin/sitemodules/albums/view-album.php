<?php
include_once("../../../includes/paging.php");
include_once('../../../includes/SiteSetting.php');
// include_once('../../../includes/class.message.php');
// 
// $msobj= new message();
// $smarty->assign("msobj",$msobj);



if(!$_SESSION['duAdmId'])
	{
		header("location:".SITEROOT . "/admin/login/home.php");
		exit();
	}

// if(!$_SESSION['duAdmId'])
// 	header("location:". SITEROOT . "/admin/login/index.php");

#--------Action-----------#
if(isset($_POST['action']))
{
	extract($_POST);
if($photo_id!='')
{
	$photo_id = implode(", ", $photo_id);
	
	if($action == "active")
	{
		$temp = $dbObj->customqry("UPDATE tbl_accomplishment_photo SET status = 'Active' where photoid in (".$photo_id.")","");
		$_SESSION['msg']="<span class='success'>Photo activated Successfully.</span>";
	}
	elseif($action == "inactive")
	{
		$temp = $dbObj->customqry("UPDATE tbl_accomplishment_photo SET status = 'Inactive' where photoid in (".$photo_id.")","");
		$_SESSION['msg']="<span class='success'>Photo Inactivated Successfully.</span>";
	}
	elseif($action == "delete")
	{
		$temp = $dbObj->customqry("SELECT * from tbl_accomplishment_photo where photoid in (".$photo_id.")","");
		while($image = @mysql_fetch_assoc($temp))
		{
			@unlink('../../uploads/post_accomplish/52X52/'.$image['image']);
			@unlink('../../uploads/post_accomplish/90X90/'.$image['image']);
			@unlink('../../uploads/post_accomplish/145X145/'.$image['image']);
			@unlink('../../uploads/post_accomplish/400X400/'.$image['image']);
			@unlink('../../uploads/post_accomplish/600X600/'.$image['image']);
			@unlink('../../uploads/post_accomplish/413X270/'.$image['image']);
			@unlink('../../uploads/post_accomplish/thumbnail/'.$image['image']);
		}
		$del = $dbObj->customqry("DELETE FROM tbl_accomplishment_photo where photoid IN (".$photo_id.")", "");
		$del = $dbObj->customqry("DELETE FROM tbl_reports where itemid IN (".$photo_id.") AND moduleid='3'", "");
		$del = $dbObj->customqry("DELETE FROM tbl_comments where itemid IN (".$photo_id.") AND moduleid='1'", "");
		$del = $dbObj->customqry("DELETE FROM tbl_photo_tag where photoid IN (".$photo_id.")", "");
		$cupdt = $dbObj->customqry("UPDATE tbl_accomplishment SET trophy_case=0 WHERE trophy_case = IN (".$photo_id.")","");
		$cupdt = $dbObj->customqry("UPDATE tbl_accomplishment SET accomplishment_cover=0 WHERE accomplishment_cover IN (".$photo_id.")","");

		$_SESSION['msg']="<span class='success'>Photo Deleted Successfully.</span>";
	}
	
	header("Location:".$_SERVER['HTTP_REFERER']);
	exit();
}
}
#---------END-------------#


//to fetch album title
$tbl = "tbl_album a LEFT JOIN tbl_users u ON a.user_id = u.userid";
$sf = "a.*, u.first_name";
$cnd = "album_id='".$_GET['id']."'";
$rs = $dbObj->gj($tbl, $sf , $cnd, "", "", "", $l, "");

$cat = @mysql_fetch_assoc($rs);
//echo "<pre>";print_r($cat);exit;	
$smarty->assign("cat", $cat);

//-----END-----------------------

		
/*********/
// $tbl = "tbl_albumphotos as p";
// $sf = "p.*";
// $cnd = "p.album_id=".$_GET['id'];

$tbl = "tbl_accomplishment_photo as p";
$sf = "p.*";
	$cnd = "p.album_id = ".$_GET['id']."";



//----------------------------------------------------------------
if($_GET['search']!="")
{
$cnd .=" and p.photo_title like '%".$_GET['search']."%'";
}

$rs = $dbObj->gj($tbl, $sf , $cnd, "", "", "", $l, "");//exit;

while($row = @mysql_fetch_assoc($rs))
{
	$rows[] = $row;
}
//------------------
if($_SESSION['msg'])
{
	$smarty->assign("msg",$_SESSION['msg']);	
	$_SESSION['msg']=NULL;
	unset($_SESSION['msg']);
}

$smarty->assign("rows", $rows);
$smarty->assign("inmenu","sitemodules");
$smarty->assign("leftadminmenu","albums");
$smarty->display(TEMPLATEDIR . '/admin/sitemodules/albums/view-album.tpl');

$dbObj->Close();
?>