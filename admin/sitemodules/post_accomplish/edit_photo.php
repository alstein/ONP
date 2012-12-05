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

	if(sizeof($delete)>0)
	{
		foreach($delete as $k=>$v)
		{
			@unlink('../../../uploads/post_accomplish/52X52/'.$image[$v]);
			@unlink('../../../uploads/post_accomplish/90X90/'.$image[$v]);
			@unlink('../../../uploads/post_accomplish/145X145/'.$image[$v]);
			@unlink('../../../uploads/post_accomplish/400X400/'.$image[$v]);
			@unlink('../../../uploads/post_accomplish/600X600/'.$image[$v]);
			@unlink('../../../uploads/post_accomplish/thumbnail/'.$image[$v]);
			$del = $dbObj->customqry("DELETE FROM tbl_accomplishment_photo where photoid = '".$v."'", "");
		}
	}
	foreach($photoid as $k =>$v)
	{ 
		if($album_cover[0] == $v) $al = 1; else $al =0;
		if($trophy_case == $v)
		{
			$set = $dbObj->customqry("UPDATE tbl_accomplishment_photo SET trophy_case='0' WHERE acc_id='".$_GET['acc_id']."'", "");
			$tr = 1;
		}
		else
		{
			$tr = 0;
		}
		$value = array($description[$k], $tag[$k], $al, $tr);
		$updtid = $dbObj->cupdt('tbl_accomplishment_photo', $field , $value, 'photoid' , $v, "");

	}

	/*if($trophy_case != "")
	{
		$rs = $dbObj->gj("tbl_trophy", "trophy_id,thumbnail", "userid = '".$_POST['userid']."'", "", "", "", "", "");
		if(is_resource($rs))
		{
		  $trophy = @mysql_fetch_assoc($rs);
		  @unlink("../../../uploads/trophy/400X400/".$trophy['thumbnail']);
		  @unlink("../../../uploads/trophy/145X145/".$trophy['thumbnail']);
		  @unlink("../../../uploads/trophy/90X90/".$trophy['thumbnail']);
		  $cpy = copy( "../../../uploads/post_accomplish/400X400/".$image[$trophy_case],"../../../uploads/trophy/400X400/".$image[$trophy_case]);
		  $cpy = copy( "../../../uploads/post_accomplish/145X145/".$image[$trophy_case],"../../../uploads/trophy/145X145/".$image[$trophy_case]);
		  $cpy = copy("../../../uploads/post_accomplish/90X90/".$image[$trophy_case],"../../../uploads/trophy/90X90/".$image[$trophy_case]);
	
		  $dbres = $dbObj->cupdt('tbl_trophy', array("thumbnail") , array($image[$trophy_case]), 'userid' , $_POST['userid'], "");
		}
	}
	else
	{
		$rs = $dbObj->gj("tbl_trophy", "trophy_id, thumbnail", "userid = '".$_POST['userid']."'", "", "", "", "", "");
		if(is_resource($rs))
		{
		  $trophy = @mysql_fetch_assoc($rs);
		  @unlink("../../../uploads/trophy/400X400/".$trophy['thumbnail']);
		  @unlink("../../../uploads/trophy/145X145/".$trophy['thumbnail']);
		  @unlink("../../../uploads/trophy/90X90/".$trophy['thumbnail']);
		  $dbres = $dbObj->cupdt('tbl_trophy', array("thumbnail") , array(""), 'userid' , $_POST['userid'], "");
		}
	}*/
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
$cnd = "p.acc_id = '".$_GET['acc_id']."' AND p.album_id = '".$_GET['album_id']."'";

$rs = $dbObj->gj($tbl, $sf , $cnd, "", "", "", "", "");
while($row = @mysql_fetch_assoc($rs))
	$record[] = $row;
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
$smarty->display(TEMPLATEDIR . '/admin/sitemodules/post_accomplish/edit_photo.tpl');

$dbObj->Close();
?>