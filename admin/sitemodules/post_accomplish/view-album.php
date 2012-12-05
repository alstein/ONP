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

#--------Action-----------#
if(isset($_POST['action']))
{
  extract($_POST);
  if($photoid!='')
  {     $photoid_arr = $photoid;
	$photoid = implode(",", $photoid);
	if($action == "active")
	{
		$temp = $dbObj->customqry("UPDATE tbl_accomplishment_photo SET status = 'Active' where photoid in (".$photoid.")","");
		$_SESSION['msg']="<span class='success'>Photo activated Successfully.</span>";
	}
	elseif($action == "inactive")
	{
		$temp = $dbObj->customqry("UPDATE tbl_accomplishment_photo SET status = 'Inactive' where photoid in (".$photoid.")","");
		$_SESSION['msg']="<span class='success'>Photo Inactivated Successfully.</span>";
	}
	elseif($action == "delete")
	{
		foreach($photoid_arr as $k=>$v)
		{
			$res = $dbObj->gj("tbl_accomplishment_photo","image" , "photoid = '".$v."'", "", "", "", "", "");
			$img = @mysql_fetch_assoc($res);
			@unlink('../../../uploads/post_accomplish/52X52/'.$image[$v]);
			@unlink('../../../uploads/post_accomplish/90X90/'.$image[$v]);
			@unlink('../../../uploads/post_accomplish/145X145/'.$image[$v]);
			@unlink('../../../uploads/post_accomplish/400X400/'.$image[$v]);
			@unlink('../../../uploads/post_accomplish/600X600/'.$image[$v]);
			@unlink('../../../uploads/post_accomplish/thumbnail/'.$image[$v]);
		}
		$temp = $dbObj->customqry("delete from tbl_accomplishment_photo where photoid in (".$photoid.")","");
		$_SESSION['msg']="<span class='success'>Photo Deleted Successfully.</span>";
	}
	
	header("Location:".$_SERVER['HTTP_REFERER']);
	exit();
  }
}
#---------END-------------#
/*------------Pagination Part-1------------*/
$page=$_GET['page'];
if(!isset($_GET['page']))
	$page =1;
else
	$page = $page;						
$adsperpage =5;							
$StartRow = $adsperpage * ($page-1);			
$l =  $StartRow.','.$adsperpage;
/*-----------------------------------*/

$tbl = "tbl_album";
$sf = "*";
// if($_GET['search'] != '')
// {
//    $cnd="acc_id ='".$_GET['acc_id']."' AND album_id = '".$_GET['album_id']."'OR photoid Like '%".$_GET['search']."%'";
//    $_GET['search']='';
// }
$cnd = "acc_id = '".$_GET['acc_id']."' AND album_id = '".$_GET['album_id']."'";
$album = array();

$rs = $dbObj->gj($tbl, $sf , $cnd, "", "", "", "", "");
while($row = @mysql_fetch_assoc($rs))
{
	$album[] = $row;
}
$smarty->assign("album", $album);

#---------------------------- For album -------------------------------------
extract($_GET);

$tbl = "tbl_accomplishment_photo ";
$sf = "*";

if($_GET['search'] != '')
{
   $cnd= "photoid Like '%".$_GET['search']."%' AND (acc_id ='".$_GET['acc_id']."' AND album_id = '".$_GET['album_id']."')";
   $_GET['search']='';
}
else
{
 $cnd = "acc_id = '".$_GET['acc_id']."' AND album_id = '".$_GET['album_id']."'";
}

$rs = $dbObj->gj($tbl, $sf , $cnd, "", "", "", $l, "");
while($row = @mysql_fetch_assoc($rs))
{
	$photo[] = $row;
}
$smarty->assign("rows", $photo);

/*----------Pagination Part-2--------------*/
$rs=$dbObj->gj($tbl,$sf,$cnd, "", "", "", "", "");
$nums = @mysql_num_rows($rs);
$show = 5;		
$total_pages = ceil($nums / $adsperpage);
if($total_pages > 1)
	$smarty -> assign("showpgnation","yes");
$showing   = !isset($_GET["page"]) ? 1 : $page;
$firstlink = "view-album.php?acc_id=".$_GET['acc_id']."&album_id=".$_GET['album_id']."&search=".$_GET['search'];
$seperator = '&page=';
$baselink  = $firstlink; 
$pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);
$smarty -> assign("pgnation",$pgnation);
/*-----------------------------------*/

if($_SESSION['msg'])
{
	$smarty->assign("msg",$_SESSION['msg']);	
	$_SESSION['msg']=NULL;
	unset($_SESSION['msg']);
}

$smarty->assign("inmenu","sitemodules");
$smarty->assign("leftadminmenu","post_acc");
$smarty->display(TEMPLATEDIR . '/admin/sitemodules/post_accomplish/view-album.tpl');

$dbObj->Close();
?>