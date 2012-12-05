<?php
include_once("../../../includes/common.lib.php");
include_once('../../../includes/SiteSetting.php');

if(!$_SESSION['duAdmId'])
{
        header("location:".SITEROOT . "/admin/login/home.php");
		  exit();
}

extract($_POST);
extract($_GET);
// print_r($_POST);
/*fetch banner content*/
if(isset($_POST['submit']))
{
	extract($_POST);
	if($_GET['album_id']!="")
	{
		$set_field = array("album_title", "added_date");
		$set_values = array($album_title,date("Y-m-d H:i:s"));
		$dbres = $dbObj->cupdt('tbl_album', $set_field , $set_values, 'album_id' , $_GET['album_id'] , "");//exit;
		$_SESSION['msg']="<span class='success'>Album Updated Successfully.</span>";
	}
	else
	{		
		$url_title = $dbObj->url_title($album_title,"tbl_album");
		$fields = array("user_id","acc_id","album_title", "added_date", "url_title");
		$values = array($_SESSION['duAdmId'],$_GET['acc_id'],$album_title,date("Y-m-d H:i:s"), $url_title);
		$idres = $dbObj->cgi('tbl_album', $fields , $values , "");//exit;
		$_SESSION['msg']="<span class='success'>Album Added Successfully.</span>";
	}
	
	header("location:".SITEROOT."/admin/sitemodules/post_accomplish/view_award.php?id=".$_GET['acc_id']);
	exit();
}

if($_GET['album_id']!="")
{
	$dbres = $dbObj->cgs('tbl_album', "*" ,array("acc_id","album_id"),array($_GET['acc_id'],$_GET['album_id']), "","", "");
	$row_result = @mysql_fetch_assoc($dbres);
}
$smarty->assign("category",$row_result);

if($_SESSION['msg'])
{
	$smarty->assign("msg",$_SESSION['msg']);	
	$_SESSION['msg']=NULL;
	unset($_SESSION['msg']);
}

$smarty->assign("inmenu","sitemodules");
$smarty->assign("leftadminmenu","post_acc");
$smarty->display(TEMPLATEDIR . '/admin/sitemodules/post_accomplish/add-album.tpl');

$dbObj->Close();
?>