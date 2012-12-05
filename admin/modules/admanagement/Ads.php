<?php
//ini_set("session.save_path", "/home/usortd/tmp");
session_start();
include_once("../../../includes/paging.php");
include_once('../../../includes/SiteSetting.php');
include_once('../../../includes/class.message.php');
include_once("../../../includes/common.lib.php");

if(!$_SESSION['duAdmId'])
header("location:".SITEROOT . "/admin/login/index.php");
	
extract($_POST);
extract($_GET);

if($_POST['action'])
{
	$ad_ids = @implode(", ", $ad_id);
	if($ad_ids)
	{
	    if($_POST['action'] == "delete")
	    {
		$id = $dbObj->customqry("delete from tbl_ads where ad_id in (".$ad_ids.")","");
	
		$s=$msobj->showmessage(188);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
	    }
	    if($_POST['action'] == "active")
	    {
		$id = $dbObj->customqry("update tbl_ads set status='active' where ad_id in (".$ad_ids.")","");
  
		$s=$msobj->showmessage(555);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
	    }
	    if($_POST['action'] == "inactive")
	    {
		$id = $dbObj->customqry("update tbl_ads set status='inactive' where ad_id in (".$ad_ids.")","");

		$s=$msobj->showmessage(556);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
	    }
	}
	else
	{
	    $s = $msobj->showmessage(55);
	    $_SESSION['msg'] = "<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
	}
	header("location:".$_SERVER['HTTP_REFERER']);
	exit;
}

/* code by gajanand */
$page=$_GET['page'];
if(!isset($_GET['page']))
	$page =1;
else
	$page = $page;
$adsperpage = 20;							
$StartRow = $adsperpage * ($page-1);			
$l =  $StartRow.','.$adsperpage;

$rs = $dbObj->gj("tbl_ads", "*", "1","ad_id", "", "DESC", $l, "");
while($myrow = @mysql_fetch_assoc($rs))
{
 	$ads[] = $myrow;
//         if($myrow['ad_image'])
//           {
//               echo "image=".$myrow['ad_image']."<br>";
//               echo $p1=generalfileupload($myrow['ad_image'], "../../../uploads/press",1);
//               list($width, $height)= getimagesize("../../uploads/press/". $p1);
// //                list($width, $height)= getimagesize($myrow['ad_image']);
// //               echo $width." and".$height;
// 	  }
//           @unlink("../../../uploads/press/".$myrow['ad_image']);
}
// exit;

$rs1 = $dbObj->gj("tbl_ads","","1", "", "", "", "", "");
$nums = @mysql_num_rows($rs1);
$show = 5;		
$total_pages = ceil($nums / $adsperpage);
if($total_pages > 1)
	$smarty -> assign("showpgnation","yes");
$showing   = !isset($_GET["page"]) ? 1 : $page;
	$firstlink = SITEROOT."/admin/modules/admanagement/Ads.php";
$seperator = '?page=';
$baselink  = $firstlink; 
$pagination = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator);

$smarty -> assign("pagination",$pagination);
$smarty->assign("nums",$nums);
$smarty->assign("ads",$ads);

if($_SESSION['msg']!="")
{
	$smarty->assign("msg", $_SESSION['msg']);
	$_SESSION['msg']=NULL;
	unset($_SESSION['msg']);
}

$smarty->assign("inmenu","gsetting");
$smarty->display(TEMPLATEDIR.'/admin/modules/admanagement/Manage_Ads.tpl');

$dbObj->Close();
?>
