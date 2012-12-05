<?php
include_once("../../../includes/paging.php");
include_once('../../../includes/SiteSetting.php');
include_once('../../../includes/classes/class.profile.php');
include_once('../../../includes/classes/class.security.php');
include_once('../../../includes/classes/class.general.php');

if(!$_SESSION['duAdmId'])
{
	header("location:".SITEROOT . "/admin/login/home.php");
	exit();
}

if(strlen($_POST['submit'])> 0)
{
	extract($_POST);

	$field = array("description", "tag", "album_cover", "trophy_case");

	if($delete == $_GET['photoid'])
	{
		@unlink('../../../uploads/post_accomplish/90X90/'.$image);
		@unlink('../../../uploads/post_accomplish/145X145/'.$image);
		@unlink('../../../uploads/post_accomplish/400X400/'.$image);
		$del = $dbObj->customqry("DELETE FROM tbl_accomplishment_photo where photoid = '".$_GET['photoid']."'", "");
	}
	
	if($album_cover == $_GET['photoid']) 
	{
		$set = $dbObj->customqry("UPDATE tbl_accomplishment_photo SET album_cover='0' WHERE album_id='".$_GET['album_id']."'", "");
		$al = '1';
	}
	else $al ='0';
	if($trophy_case == $_GET['photoid'])
	{
		$set = $dbObj->customqry("UPDATE tbl_accomplishment_photo SET trophy_case='0' WHERE acc_id='".$_GET['acc_id']."'", "");
		$tr = '1';
	}
	else $tr = '0';

	$value = array($description, $tag, $al, $tr);
	$updtid = $dbObj->cupdt('tbl_accomplishment_photo', $field , $value, 'photoid' , $_GET['photoid'], "");

	$_SESSION['msg']="Photos Updated successfully";
	header("location:".SITEROOT."/admin/sitemodules/post_accomplish/view-album.php?acc_id=".$_GET['acc_id']."&album_id=".$_GET['album_id']);
	exit;
}

$album = $generalObj->getAlbum($_GET['acc_id'],$_GET['album_id']);
$smarty->assign("album", $album);

//if($_SESSION['insert_id'] !="")
print_r($_SESSION['insert_id']);
# ----------- fetch Awards -----------
$tbl = "tbl_accomplishment_photo p LEFT JOIN tbl_accomplishment a ON p.acc_id = a.acc_id
	LEFT JOIN users u ON a.userid = u.userid";
$sf = "p.*, u.userid";
$cnd = "p.acc_id = '".$_GET['acc_id']."' AND p.album_id = '".$_GET['album_id']."' AND photoid = '".$_GET['photoid']."'";

$rs = $dbObj->gj($tbl, $sf , $cnd, "", "", "", "", "");
$record = @mysql_fetch_assoc($rs);
$smarty->assign("record", $record);


# ----------- END fetch awards ---------
if($_SESSION['msg'])
{
	$smarty->assign("msg",$_SESSION['msg']);	
	$_SESSION['msg']=NULL;
	unset($_SESSION['msg']);
}

$smarty->assign("inmenu","sitemodules");
$smarty->assign("leftadminmenu","post_acc");
$smarty->display(TEMPLATEDIR . '/admin/sitemodules/post_accomplish/edit_photo_details.tpl');

$dbObj->Close();
?>